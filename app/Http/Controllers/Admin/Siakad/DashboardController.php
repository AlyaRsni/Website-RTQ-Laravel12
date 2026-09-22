<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Halaqah;
use App\Models\UstadzHalaqah;
use App\Models\Dormitory;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\HafalanJournal;
use App\Models\DisciplineNote;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Core Counts ──────────────────────────
        $totalSantri       = Santri::count();
        $santriAktif       = Santri::where('status', 'aktif')->count();
        $santriNonaktif    = Santri::where('status', 'nonaktif')->count();
        $santriLulus       = Santri::where('status', 'lulus')->count();
        $santriPindah      = Santri::where('status', 'pindah')->count();

        $totalUstadz       = UstadzHalaqah::count();
        $ustadzAktif       = UstadzHalaqah::where('status', 'aktif')->count();
        $totalHalaqah      = Halaqah::count();
        $totalAsrama       = Dormitory::count();
        $totalMapel        = Subject::count();

        // ── Academic Info ────────────────────────
        $activeSemester    = Semester::with('academicYear')->active()->first();
        $activeYear        = AcademicYear::active()->first();

        // ── Gender Breakdown ─────────────────────
        $genderBreakdown = [
            'Laki-laki'  => Santri::where('jenis_kelamin', 'laki-laki')->count(),
            'Perempuan'  => Santri::where('jenis_kelamin', 'perempuan')->count(),
        ];

        // ── Status Santri Breakdown ──────────────
        $statusBreakdown = [
            'Aktif'    => $santriAktif,
            'Nonaktif' => $santriNonaktif,
            'Lulus'    => $santriLulus,
            'Pindah'   => $santriPindah,
        ];

        // ── Asrama Occupancy ─────────────────────
        $asramaData = Dormitory::withCount(['santris' => function ($q) {
            $q->where('status', 'aktif');
        }])->get();

        // ── Attendance Stats (30 hari terakhir) ──
        $thirtyDaysAgo   = Carbon::now()->subDays(30);
        $totalAbsensi     = Attendance::where('tanggal', '>=', $thirtyDaysAgo)->count();
        $absensiHadir     = Attendance::where('tanggal', '>=', $thirtyDaysAgo)->where('status', 'hadir')->count();
        $absensiSakit     = Attendance::where('tanggal', '>=', $thirtyDaysAgo)->where('status', 'sakit')->count();
        $absensiIzin      = Attendance::where('tanggal', '>=', $thirtyDaysAgo)->where('status', 'izin')->count();
        $absensiAlpha     = Attendance::where('tanggal', '>=', $thirtyDaysAgo)->where('status', 'alpha')->count();
        $rataKehadiran    = $totalAbsensi > 0 ? round(($absensiHadir / $totalAbsensi) * 100) : 0;

        $attendanceBreakdown = [
            'Hadir' => $absensiHadir,
            'Sakit' => $absensiSakit,
            'Izin'  => $absensiIzin,
            'Alpha' => $absensiAlpha,
        ];

        // ── Attendance trend 7 hari ──────────────
        $attendanceTrend = Attendance::select(
            DB::raw('DATE(tanggal) as date'),
            DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir'),
            DB::raw('SUM(CASE WHEN status != "hadir" THEN 1 ELSE 0 END) as tidak_hadir')
        )
            ->where('tanggal', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // ── Hafalan Stats ────────────────────────
        $totalHafalan     = HafalanJournal::count();
        $hafalanBulanIni  = HafalanJournal::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        $hafalanQuality = [
            'Mumtaz'          => HafalanJournal::where('kualitas', 'mumtaz')->count(),
            'Jayyid Jiddan'   => HafalanJournal::where('kualitas', 'jayyid_jiddan')->count(),
            'Jayyid'          => HafalanJournal::where('kualitas', 'jayyid')->count(),
            'Maqbul'          => HafalanJournal::where('kualitas', 'maqbul')->count(),
            'Perlu Perbaikan' => HafalanJournal::where('kualitas', 'perlu_perbaikan')->count(),
        ];

        // ── Grades Stats ─────────────────────────
        $avgNilai         = Grade::avg('nilai') ? round(Grade::avg('nilai'), 1) : 0;
        $totalNilai       = Grade::count();

        // ── Discipline Stats ─────────────────────
        $totalPelanggaran = DisciplineNote::where('tipe', 'pelanggaran')->count();
        $totalPrestasi    = DisciplineNote::where('tipe', 'prestasi')->count();

        $disiplinBulanIni = DisciplineNote::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        // ── Recent Activity (gabung semua 10 terbaru) ──
        $recentHafalan = HafalanJournal::with('santri')
            ->latest('tanggal')
            ->take(5)
            ->get()
            ->map(fn($h) => [
                'type'    => 'hafalan',
                'icon'    => '📖',
                'title'   => ($h->santri->nama_lengkap ?? '-') . ' — ' . ($h->surat ?? 'Hafalan'),
                'desc'    => ucfirst($h->jenis) . ' | ' . $h->kualitas_label,
                'time'    => $h->tanggal,
                'color'   => 'emerald',
            ]);

        $recentDiscipline = DisciplineNote::with('santri')
            ->latest('tanggal')
            ->take(5)
            ->get()
            ->map(fn($d) => [
                'type'    => 'disiplin',
                'icon'    => $d->tipe === 'prestasi' ? '⭐' : '⚠️',
                'title'   => ($d->santri->nama_lengkap ?? '-') . ' — ' . $d->judul,
                'desc'    => ucfirst($d->tipe) . ' (' . $d->poin . ' poin)',
                'time'    => $d->tanggal,
                'color'   => $d->tipe === 'prestasi' ? 'amber' : 'red',
            ]);

        $recentActivity = $recentHafalan->merge($recentDiscipline)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        // ── Latest Announcements ─────────────────
        $announcements = Announcement::with('author')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        // ── Santri Terbaru ───────────────────────
        $santriTerbaru = Santri::with('dormitory')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.siakad.dashboard', compact(
            'totalSantri', 'santriAktif', 'santriNonaktif', 'santriLulus', 'santriPindah',
            'totalUstadz', 'ustadzAktif', 'totalHalaqah', 'totalAsrama', 'totalMapel',
            'activeSemester', 'activeYear',
            'genderBreakdown', 'statusBreakdown',
            'asramaData',
            'totalAbsensi', 'rataKehadiran', 'attendanceBreakdown', 'attendanceTrend',
            'totalHafalan', 'hafalanBulanIni', 'hafalanQuality',
            'avgNilai', 'totalNilai',
            'totalPelanggaran', 'totalPrestasi', 'disiplinBulanIni',
            'recentActivity', 'announcements', 'santriTerbaru'
        ));
    }
}
