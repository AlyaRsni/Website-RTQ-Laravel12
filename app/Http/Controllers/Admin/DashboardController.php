<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendaftar = User::where('role', 'calon_santri')->count();
        $totalUstadz = User::where('role', 'ustadz_ppdb')->count();

        $sudahFinalisasi = PpdbRegistration::whereNotNull('finalisasi_at')->count();
        $terverifikasi = PpdbRegistration::where('status_verifikasi', 'terverifikasi')->count();
        $menungguVerifikasi = PpdbRegistration::where('status_verifikasi', 'menunggu_verifikasi_berkas')->count();
        $perluPerbaikan = PpdbRegistration::where('status_verifikasi', 'perlu_perbaikan')->count();

        // Progress rata-rata
        $registrations = PpdbRegistration::all();
        $avgProgress = $registrations->count() > 0
            ? round($registrations->avg(fn($r) => $r->getProgressPercentage()))
            : 0;

        // Pendaftar per hari (30 hari terakhir)
        $dailyData = PpdbRegistration::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Status breakdown
        $statusBreakdown = [
            'Belum Lengkap' => PpdbRegistration::where('status_verifikasi', 'belum_diajukan')->count(),
            'Menunggu Verifikasi' => $menungguVerifikasi,
            'Perlu Perbaikan' => $perluPerbaikan,
            'Terverifikasi' => $terverifikasi,
        ];

        // Pendaftar terbaru
        $recentPendaftar = PpdbRegistration::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Has nomor peserta
        $sudahNomor = PpdbRegistration::whereNotNull('nomor_peserta')->count();

        // Hasil seleksi toggle status
        $hasilTersedia = PpdbRegistration::where('hasil_seleksi_status', 'tersedia')->count();
        $hasilTotal = PpdbRegistration::whereNotNull('hasil_seleksi_pdf')->count();

        return view('admin.dashboard', compact(
            'totalPendaftar', 'totalUstadz', 'sudahFinalisasi', 'terverifikasi',
            'menungguVerifikasi', 'perluPerbaikan', 'avgProgress', 'dailyData',
            'statusBreakdown', 'recentPendaftar', 'sudahNomor',
            'hasilTersedia', 'hasilTotal'
        ));
    }
}
