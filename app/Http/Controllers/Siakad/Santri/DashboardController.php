<?php

namespace App\Http\Controllers\Siakad\Santri;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\HafalanJournal;
use App\Models\Santri;
use App\Models\SantriPermission;
use Illuminate\Http\Request;

class DashboardController extends Controller
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

    public function index()
    {
        $santri = $this->getSantri();

        // Recent attendance (last 7 records)
        $recentAttendances = Attendance::where('santri_id', $santri->id)
            ->orderByDesc('tanggal')
            ->take(7)
            ->get();

        // Attendance stats this month
        $monthAttendances = Attendance::where('santri_id', $santri->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $attendanceStats = [
            'hadir' => $monthAttendances->where('status', 'hadir')->count(),
            'sakit' => $monthAttendances->where('status', 'sakit')->count(),
            'izin' => $monthAttendances->where('status', 'izin')->count(),
            'alpha' => $monthAttendances->where('status', 'alpha')->count(),
            'total' => $monthAttendances->count(),
        ];

        // Recent hafalan
        $recentHafalan = HafalanJournal::where('santri_id', $santri->id)
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        // Announcements
        $announcements = Announcement::published()
            ->where(function ($q) {
                $q->where('target', 'semua')->orWhere('target', 'santri');
            })
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        // === Active Permissions ===
        $activePermissions = SantriPermission::where('santri_id', $santri->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->latest()
            ->take(3)
            ->get();

        // Stage info
        $stageInfo = $santri->stage_info;
        $stageMap = Santri::STAGE_MAP;

        return view('siakad.santri.dashboard', compact(
            'santri', 'recentAttendances', 'attendanceStats',
            'recentHafalan', 'announcements', 'activePermissions',
            'stageInfo', 'stageMap'
        ));
    }


    /**
     * Halaman Perizinan Santri (read-only)
     */
    public function perizinan(Request $request)
    {
        $santri = $this->getSantri();

        $status = $request->get('status', '');

        $query = SantriPermission::where('santri_id', $santri->id)->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $permissions = $query->paginate(15)->withQueryString();

        $stats = [
            'diajukan'  => SantriPermission::where('santri_id', $santri->id)->where('status', 'diajukan')->count(),
            'disetujui' => SantriPermission::where('santri_id', $santri->id)->where('status', 'disetujui')->count(),
            'ditolak'   => SantriPermission::where('santri_id', $santri->id)->where('status', 'ditolak')->count(),
            'selesai'   => SantriPermission::where('santri_id', $santri->id)->where('status', 'selesai')->count(),
        ];

        return view('siakad.santri.perizinan', compact('santri', 'permissions', 'stats', 'status'));
    }
}
