<?php

namespace App\Http\Controllers\Siakad\Santri;

use App\Http\Controllers\Controller;
use App\Models\HafalanExam;
use App\Models\HafalanJournal;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HafalanController extends Controller
{
    /**
     * Get the authenticated santri instance
     */
    private function getSantri()
    {
        return Santri::where('user_id', auth()->id())
            ->with(['dormitory', 'halaqahs.semester.academicYear', 'halaqahs.ustadz'])
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $santri = $this->getSantri();

        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        // === Hafalan Journals bulan ini ===
        $journals = HafalanJournal::where('santri_id', $santri->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderByDesc('tanggal')
            ->get();

        // Summary stats
        $totalZiyadah   = $journals->where('jenis', 'ziyadah')->count();
        $totalMurojaah  = $journals->where('jenis', 'murojaah')->count();

        // Kualitas breakdown
        $kualitasStats = $journals->groupBy('kualitas')->map->count();

        // === Hasil Ujian Hafalan ===
        $kategoriFilter = $request->get('kategori_ujian', '');

        $examQuery = HafalanExam::where('santri_id', $santri->id)
            ->orderByDesc('tanggal_ujian');

        if ($kategoriFilter) {
            $examQuery->where('kategori', $kategoriFilter);
        }

        $exams = $examQuery->take(20)->get();

        // Exam stats
        $examStats = [
            'total'    => HafalanExam::where('santri_id', $santri->id)->count(),
            'per_juz'  => HafalanExam::where('santri_id', $santri->id)->where('kategori', 'per_juz')->count(),
            'semester' => HafalanExam::where('santri_id', $santri->id)->where('kategori', 'semester')->count(),
            'bulanan'  => HafalanExam::where('santri_id', $santri->id)->where('kategori', 'bulanan')->count(),
        ];

        // Rata-rata nilai
        $avgBacaan  = HafalanExam::where('santri_id', $santri->id)->avg('nilai_bacaan');
        $avgHafalan = HafalanExam::where('santri_id', $santri->id)->avg('nilai_hafalan');

        return view('siakad.santri.hafalan', compact(
            'santri', 'journals', 'totalZiyadah', 'totalMurojaah',
            'kualitasStats', 'exams', 'examStats',
            'avgBacaan', 'avgHafalan',
            'bulan', 'tahun', 'kategoriFilter'
        ));
    }
}
