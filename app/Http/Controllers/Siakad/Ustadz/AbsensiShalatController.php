<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PrayerAttendance;
use App\Models\Santri;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiShalatController extends Controller
{
    public function index(Request $request)
    {
        $tanggal    = $request->get('tanggal', now()->format('Y-m-d'));
        $waktuShalat = $request->get('waktu_shalat', $this->detectCurrentPrayer());

        // Get all active santri
        $santris = Santri::where('status', 'aktif')->orderBy('nama_lengkap')->get();

        // Get today's attendances for selected prayer
        $attendances = PrayerAttendance::with('santri.dormitory')
            ->where('tanggal', $tanggal)
            ->where('waktu_shalat', $waktuShalat)
            ->latest()
            ->get();

        // Summary per waktu shalat for today
        $summary = [];
        foreach (['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $wk) {
            $summary[$wk] = PrayerAttendance::where('tanggal', $tanggal)
                ->where('waktu_shalat', $wk)
                ->count();
        }

        $totalAktif = $santris->count();

        return view('siakad.ustadz.absensi-shalat.index', compact(
            'tanggal', 'waktuShalat', 'santris', 'attendances',
            'summary', 'totalAktif'
        ));
    }

    /**
     * Process RFID scan — called via AJAX from the scan page
     */
    public function scan(Request $request)
    {
        $request->validate([
            'rfid_uid'     => 'required|string',
            'waktu_shalat' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'tanggal'      => 'required|date',
        ]);

        $santri = Santri::where('rfid_uid', $request->rfid_uid)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu RFID tidak terdaftar.',
            ], 404);
        }

        if ($santri->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Santri tidak aktif: ' . $santri->nama_lengkap,
            ], 422);
        }

        // Check if already recorded
        $existing = PrayerAttendance::where('santri_id', $santri->id)
            ->where('waktu_shalat', $request->waktu_shalat)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existing) {
            return response()->json([
                'success'  => false,
                'message'  => $santri->nama_lengkap . ' sudah tercatat pada shalat ' . ucfirst($request->waktu_shalat),
                'santri'   => [
                    'nama'  => $santri->nama_lengkap,
                    'nis'   => $santri->nis,
                    'foto'  => $santri->foto,
                ],
                'duplicate' => true,
            ]);
        }

        // Record attendance
        $attendance = PrayerAttendance::create([
            'santri_id'    => $santri->id,
            'waktu_shalat' => $request->waktu_shalat,
            'tanggal'      => $request->tanggal,
            'status'       => 'hadir',
            'metode'       => 'rfid',
            'recorded_by'  => auth()->id(),
        ]);

        $count = PrayerAttendance::where('tanggal', $request->tanggal)
            ->where('waktu_shalat', $request->waktu_shalat)
            ->count();

        return response()->json([
            'success' => true,
            'message' => '✅ ' . $santri->nama_lengkap . ' — Shalat ' . ucfirst($request->waktu_shalat),
            'santri'  => [
                'id'    => $santri->id,
                'nama'  => $santri->nama_lengkap,
                'nis'   => $santri->nis,
                'foto'  => $santri->foto,
                'asrama' => $santri->dormitory->nama ?? '-',
            ],
            'attendance' => [
                'id'     => $attendance->id,
                'status' => $attendance->status,
                'waktu'  => $attendance->created_at->format('H:i:s'),
            ],
            'total_hadir' => $count,
        ]);
    }

    /**
     * Manual attendance (for santri without RFID card)
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'santri_id'    => 'required|exists:santris,id',
            'waktu_shalat' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
            'tanggal'      => 'required|date',
            'status'       => 'required|in:hadir,terlambat',
        ]);

        PrayerAttendance::updateOrCreate(
            [
                'santri_id'    => $request->santri_id,
                'waktu_shalat' => $request->waktu_shalat,
                'tanggal'      => $request->tanggal,
            ],
            [
                'status'      => $request->status,
                'metode'      => 'manual',
                'recorded_by' => auth()->id(),
            ]
        );

        return back()->with('success', 'Absensi manual berhasil disimpan.');
    }

    /**
     * Rekap absensi shalat
     */
    public function rekap(Request $request)
    {
        $tanggalMulai  = $request->get('dari', now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir  = $request->get('sampai', now()->format('Y-m-d'));
        $waktuShalat   = $request->get('waktu_shalat', '');

        $query = PrayerAttendance::with('santri')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);

        if ($waktuShalat) {
            $query->where('waktu_shalat', $waktuShalat);
        }

        $attendances = $query->orderByDesc('tanggal')->orderByDesc('created_at')->paginate(50)->withQueryString();

        // Stats
        $totalHari   = Carbon::parse($tanggalMulai)->diffInDays(Carbon::parse($tanggalAkhir)) + 1;
        $totalRecord = PrayerAttendance::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])->count();

        return view('siakad.ustadz.absensi-shalat.rekap', compact(
            'attendances', 'tanggalMulai', 'tanggalAkhir', 'waktuShalat',
            'totalHari', 'totalRecord'
        ));
    }

    /**
     * Detect current prayer time based on rough time estimates
     */
    private function detectCurrentPrayer(): string
    {
        $hour = (int) now()->format('H');

        return match (true) {
            $hour >= 3 && $hour < 6   => 'subuh',
            $hour >= 11 && $hour < 14 => 'dzuhur',
            $hour >= 14 && $hour < 17 => 'ashar',
            $hour >= 17 && $hour < 19 => 'maghrib',
            default                   => 'isya',
        };
    }
}
