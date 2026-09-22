<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriPermission;
use Illuminate\Http\Request;

class PerizinanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', '');

        $query = SantriPermission::with('santri', 'approver')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $permissions = $query->paginate(20)->withQueryString();

        // All active santri for manual form
        $santris = Santri::where('status', 'aktif')->orderBy('nama_lengkap')->get();

        // Stats
        $stats = [
            'diajukan'  => SantriPermission::where('status', 'diajukan')->count(),
            'disetujui' => SantriPermission::where('status', 'disetujui')->count(),
            'ditolak'   => SantriPermission::where('status', 'ditolak')->count(),
            'selesai'   => SantriPermission::where('status', 'selesai')->count(),
        ];

        return view('siakad.ustadz.perizinan.index', compact('permissions', 'santris', 'stats', 'status'));
    }

    /**
     * Process RFID scan for perizinan — returns santri data
     */
    public function scanRfid(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        $santri = Santri::with('dormitory')->where('rfid_uid', $request->rfid_uid)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu RFID tidak terdaftar.',
            ], 404);
        }

        // Also get active permissions for this santri
        $activePermissions = SantriPermission::where('santri_id', $santri->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->latest()
            ->take(3)
            ->get();

        return response()->json([
            'success' => true,
            'santri'  => [
                'id'     => $santri->id,
                'nama'   => $santri->nama_lengkap,
                'nis'    => $santri->nis,
                'foto'   => $santri->foto,
                'asrama' => $santri->dormitory->nama ?? '-',
                'status' => $santri->status,
            ],
            'active_permissions' => $activePermissions->map(fn($p) => [
                'jenis'  => $p->jenis_label,
                'status' => $p->status,
                'mulai'  => $p->tanggal_mulai->format('d M Y'),
                'selesai' => $p->tanggal_selesai->format('d M Y'),
                'mulai_raw'  => $p->tanggal_mulai->format('Y-m-d'),
                'selesai_raw' => $p->tanggal_selesai->format('Y-m-d'),
                'durasi' => $p->durasi,
                'jam_keluar'  => $p->jam_keluar ? substr($p->jam_keluar, 0, 5) : null,
                'jam_kembali' => $p->jam_kembali ? substr($p->jam_kembali, 0, 5) : null,
                'is_terlambat' => $p->is_terlambat,
                'keterlambatan' => $p->keterlambatan,
            ]),
        ]);
    }

    /**
     * Store new permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'santri_id'       => 'required|exists:santris,id',
            'jenis'           => 'required|in:pulang,sakit,kegiatan,lainnya',
            'alasan'          => 'required|string|max:500',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_keluar'      => 'nullable|date_format:H:i',
            'jam_kembali'     => 'nullable|date_format:H:i',
            'status'          => 'required|in:diajukan,disetujui',
            'catatan_ustadz'  => 'nullable|string|max:500',
        ]);

        SantriPermission::create([
            'santri_id'       => $request->santri_id,
            'jenis'           => $request->jenis,
            'alasan'          => $request->alasan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_keluar'      => $request->jam_keluar,
            'jam_kembali'     => $request->jam_kembali,
            'status'          => $request->status,
            'approved_by'     => $request->status === 'disetujui' ? auth()->id() : null,
            'catatan_ustadz'  => $request->catatan_ustadz,
        ]);

        return back()->with('success', 'Perizinan berhasil disimpan.');
    }

    /**
     * Update permission status (approve/reject/complete)
     */
    public function update(Request $request, $id)
    {
        $permission = SantriPermission::findOrFail($id);

        $request->validate([
            'status'         => 'required|in:disetujui,ditolak,selesai',
            'catatan_ustadz' => 'nullable|string|max:500',
        ]);

        $permission->update([
            'status'         => $request->status,
            'approved_by'    => auth()->id(),
            'catatan_ustadz' => $request->catatan_ustadz ?? $permission->catatan_ustadz,
        ]);

        $label = match ($request->status) {
            'disetujui' => 'disetujui',
            'ditolak'   => 'ditolak',
            'selesai'   => 'ditandai selesai',
        };

        return back()->with('success', 'Perizinan berhasil ' . $label . '.');
    }
}
