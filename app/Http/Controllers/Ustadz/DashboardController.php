<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $menungguVerifikasi = PpdbRegistration::where('status_verifikasi', 'menunggu_verifikasi_berkas')->count();
        $terverifikasi = PpdbRegistration::where('status_verifikasi', 'terverifikasi')->count();
        $perluPerbaikan = PpdbRegistration::where('status_verifikasi', 'perlu_perbaikan')->count();
        $sudahFinalisasi = PpdbRegistration::whereNotNull('finalisasi_at')->count();
        $totalPendaftar = User::where('role', 'calon_santri')->count();

        // Pending list (yang perlu diverifikasi)
        $pendingList = PpdbRegistration::with('user')
            ->where('status_verifikasi', 'menunggu_verifikasi_berkas')
            ->latest('finalisasi_at')
            ->take(10)
            ->get();

        // Recent terverifikasi
        $recentVerified = PpdbRegistration::with('user')
            ->where('status_verifikasi', 'terverifikasi')
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('ustadz.dashboard', compact(
            'menungguVerifikasi', 'terverifikasi', 'perluPerbaikan',
            'sudahFinalisasi', 'totalPendaftar', 'pendingList', 'recentVerified'
        ));
    }
}
