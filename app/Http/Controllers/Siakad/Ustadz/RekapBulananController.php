<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\DisciplineNote;
use App\Models\HafalanJournal;
use App\Models\Grade;
use App\Models\Halaqah;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapBulananController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();

        $selectedHalaqah = null;
        $santriSummaries = collect();
        $bulan = $request->get('bulan', now()->format('Y-m'));

        // Parse bulan
        $tanggalAwal = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
        $tanggalAkhir = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();

        if ($request->filled('halaqah_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            if ($selectedHalaqah) {
                $halaqahId = $selectedHalaqah->id;

                // Preload all data for the month
                $attendances = Attendance::where('halaqah_id', $halaqahId)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->get()
                    ->groupBy('santri_id');

                $hafalanJournals = HafalanJournal::where('halaqah_id', $halaqahId)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->get()
                    ->groupBy('santri_id');

                $grades = Grade::where('halaqah_id', $halaqahId)
                    ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                    ->with('subject')
                    ->get()
                    ->groupBy('santri_id');

                $disciplineNotes = DisciplineNote::where('halaqah_id', $halaqahId)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->get()
                    ->groupBy('santri_id');

                // Build summary per santri
                $santriSummaries = $selectedHalaqah->santris->map(function ($santri) use (
                    $attendances, $hafalanJournals, $grades, $disciplineNotes
                ) {
                    $sid = $santri->id;

                    // Attendance
                    $att = $attendances->get($sid, collect());
                    $hadir = $att->where('status', 'hadir')->count();
                    $sakit = $att->where('status', 'sakit')->count();
                    $izin = $att->where('status', 'izin')->count();
                    $alpha = $att->where('status', 'alpha')->count();
                    $total = $att->count();
                    $santri->absensi = [
                        'hadir' => $hadir,
                        'sakit' => $sakit,
                        'izin' => $izin,
                        'alpha' => $alpha,
                        'total' => $total,
                        'persen_hadir' => $total > 0 ? round(($hadir / $total) * 100) : 0,
                    ];

                    // Hafalan
                    $haf = $hafalanJournals->get($sid, collect());
                    $santri->hafalan = [
                        'ziyadah' => $haf->where('jenis', 'ziyadah')->count(),
                        'murojaah' => $haf->where('jenis', 'murojaah')->count(),
                        'total' => $haf->count(),
                        'entries' => $haf->sortByDesc('tanggal')->take(5),
                    ];

                    // Grades
                    $grd = $grades->get($sid, collect());
                    $santri->nilai = [
                        'rata_rata' => $grd->count() > 0 ? round($grd->avg('nilai'), 1) : null,
                        'total_entri' => $grd->count(),
                        'entries' => $grd->sortByDesc('created_at')->take(5),
                    ];

                    // Discipline
                    $dis = $disciplineNotes->get($sid, collect());
                    $santri->disiplin = [
                        'pelanggaran' => $dis->where('tipe', 'pelanggaran')->count(),
                        'prestasi' => $dis->where('tipe', 'prestasi')->count(),
                        'poin_pelanggaran' => $dis->where('tipe', 'pelanggaran')->sum('poin'),
                        'poin_prestasi' => $dis->where('tipe', 'prestasi')->sum('poin'),
                        'entries' => $dis->sortByDesc('tanggal')->take(5),
                    ];

                    return $santri;
                });
            }
        }

        return view('siakad.ustadz.rekap.index', compact(
            'halaqahs', 'selectedHalaqah', 'santriSummaries', 'bulan',
            'tanggalAwal', 'tanggalAkhir'
        ));
    }
}
