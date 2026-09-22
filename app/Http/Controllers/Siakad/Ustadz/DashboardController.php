<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Halaqah;
use App\Models\UstadzHalaqah;
use App\Models\Announcement;
use App\Models\Santri;
use App\Models\Attendance;
use App\Models\HafalanJournal;
use App\Models\HafalanExam;
use App\Models\DisciplineNote;

class DashboardController extends Controller
{
    public function index()
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();

        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)
            ->with(['semester.academicYear'])
            ->withCount('santris')
            ->orderByDesc('id')
            ->get();

        $totalSantri = $halaqahs->sum('santris_count');

        $announcements = Announcement::published()
            ->forTarget('ustadz')
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        // === Collect all santri IDs from ustadz's halaqahs ===
        $halaqahIds = $halaqahs->pluck('id');
        $santriIds = \DB::table('halaqah_santri')
            ->whereIn('halaqah_id', $halaqahIds)
            ->pluck('santri_id')
            ->unique();

        // Load santri with relationships
        $allSantri = Santri::whereIn('id', $santriIds)
            ->with('dormitory')
            ->get();

        // Build insight data for each santri
        $santriInsights = $allSantri->map(function ($santri) use ($halaqahIds) {
            $bulan = now()->month;
            $tahun = now()->year;

            // Attendance bulan ini
            $attendances = Attendance::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Hafalan bulan ini
            $hafalanBulanIni = HafalanJournal::where('santri_id', $santri->id)
                ->whereIn('halaqah_id', $halaqahIds)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            // Exam stats
            $examCount = HafalanExam::where('santri_id', $santri->id)
                ->whereIn('halaqah_id', $halaqahIds)
                ->count();

            $avgBacaan = HafalanExam::where('santri_id', $santri->id)
                ->whereIn('halaqah_id', $halaqahIds)
                ->avg('nilai_bacaan');

            $avgHafalan = HafalanExam::where('santri_id', $santri->id)
                ->whereIn('halaqah_id', $halaqahIds)
                ->avg('nilai_hafalan');

            // Discipline notes bulan ini
            $disiplinCount = DisciplineNote::where('santri_id', $santri->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->count();

            // Last hafalan
            $lastHafalan = HafalanJournal::where('santri_id', $santri->id)
                ->whereIn('halaqah_id', $halaqahIds)
                ->orderByDesc('tanggal')
                ->first();

            return (object) [
                'santri'          => $santri,
                'hadir'           => $attendances->where('status', 'hadir')->count(),
                'alpha'           => $attendances->where('status', 'alpha')->count(),
                'sakit'           => $attendances->where('status', 'sakit')->count(),
                'izin'            => $attendances->where('status', 'izin')->count(),
                'total_hafalan'   => $hafalanBulanIni->count(),
                'ziyadah'         => $hafalanBulanIni->where('jenis', 'ziyadah')->count(),
                'murojaah'        => $hafalanBulanIni->where('jenis', 'murojaah')->count(),
                'exam_count'      => $examCount,
                'avg_bacaan'      => $avgBacaan ? round($avgBacaan, 1) : null,
                'avg_hafalan'     => $avgHafalan ? round($avgHafalan, 1) : null,
                'disiplin_count'  => $disiplinCount,
                'last_hafalan'    => $lastHafalan,
            ];
        })->sortBy('santri.nama_lengkap')->values();

        return view('siakad.ustadz.dashboard', compact(
            'ustadz', 'halaqahs', 'totalSantri', 'announcements', 'santriInsights'
        ));
    }

    /**
     * Update stage hafalan santri (oleh ustadz pengampu)
     */
    public function updateStage(Request $request, $santriId)
    {
        $request->validate([
            'hafalan_stage' => 'nullable|integer|min:1|max:12',
        ]);

        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();

        // Pastikan santri ada di halaqah ustadz ini
        $halaqahIds = Halaqah::where('ustadz_id', $ustadz->id)->pluck('id');
        $santriInHalaqah = \DB::table('halaqah_santri')
            ->whereIn('halaqah_id', $halaqahIds)
            ->where('santri_id', $santriId)
            ->exists();

        if (!$santriInHalaqah) {
            return back()->with('error', 'Santri tidak ditemukan di halaqah Anda.');
        }

        $santri = Santri::findOrFail($santriId);
        $santri->update(['hafalan_stage' => $request->hafalan_stage]);

        $stageLabel = $request->hafalan_stage
            ? Santri::STAGE_MAP[$request->hafalan_stage]['label'] ?? "Stage {$request->hafalan_stage}"
            : 'Reset';

        return back()->with('success', "Stage {$santri->nama_lengkap} diperbarui ke {$stageLabel}.");
    }
}
