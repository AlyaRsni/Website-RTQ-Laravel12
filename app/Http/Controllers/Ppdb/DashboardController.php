<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Auto-create registration if not exists
        $registration = $user->ppdbRegistration;
        if (!$registration) {
            $registration = PpdbRegistration::create([
                'user_id' => $user->id,
                'tahun_ajaran' => '2026/2027',
            ]);
        }

        $steps = $this->buildSteps($registration);

        return view('ppdb.dashboard', [
            'user' => $user,
            'registration' => $registration,
            'steps' => $steps,
            'progress' => $registration->getProgressPercentage(),
            'currentStep' => $registration->getCurrentStep(),
        ]);
    }

    public function hasilSeleksi()
    {
        $user = Auth::user();
        $registration = $user->ppdbRegistration;
        
        return view('ppdb.pages.hasil-seleksi', [
            'registration' => $registration,
        ]);
    }

    public function tanggalPenting()
    {
        return view('ppdb.pages.tanggal-penting');
    }

    protected function buildSteps(PpdbRegistration $reg): array
    {
        return [
            1 => [
                'title' => 'Upload Pembayaran',
                'description' => 'Upload bukti transfer pendaftaran',
                'icon' => 'payment',
                'status' => $reg->getStepStatus(1),
                'completed' => $reg->isStepCompleted(1),
                'accessible' => $reg->isStepAccessible(1),
                'route' => 'ppdb.step.1',
                'color' => 'blue',
            ],
            2 => [
                'title' => 'Data Diri',
                'description' => 'Lengkapi data pribadi calon santri',
                'icon' => 'user',
                'status' => $reg->getStepStatus(2),
                'completed' => $reg->isStepCompleted(2),
                'accessible' => $reg->isStepAccessible(2),
                'route' => 'ppdb.step.2',
                'color' => 'indigo',
            ],
            3 => [
                'title' => 'Kontak Orang Tua',
                'description' => 'Nomor WhatsApp ayah dan ibu',
                'icon' => 'phone',
                'status' => $reg->getStepStatus(3),
                'completed' => $reg->isStepCompleted(3),
                'accessible' => $reg->isStepAccessible(3),
                'route' => 'ppdb.step.3',
                'color' => 'cyan',
            ],
            4 => [
                'title' => 'Upload Berkas',
                'description' => 'KK, Foto 3x4, dan Ijazah/Raport',
                'icon' => 'document',
                'status' => $reg->getStepStatus(4),
                'completed' => $reg->isStepCompleted(4),
                'accessible' => $reg->isStepAccessible(4),
                'route' => 'ppdb.step.4',
                'color' => 'emerald',
            ],
            5 => [
                'title' => 'Preview & Finalisasi',
                'description' => 'Review dan kirim data pendaftaran',
                'icon' => 'check',
                'status' => $reg->getStepStatus(5),
                'completed' => $reg->isStepCompleted(5),
                'accessible' => $reg->isStepAccessible(5),
                'route' => 'ppdb.step.5',
                'color' => 'purple',
            ],
            6 => [
                'title' => 'Verifikasi Ustadz',
                'description' => 'Pembayaran & berkas diverifikasi Ustadz PPDB',
                'icon' => 'shield',
                'status' => $reg->getStepStatus(6),
                'completed' => $reg->isStepCompleted(6),
                'accessible' => false, // No route for calon santri
                'route' => null,
                'color' => 'orange',
            ],
            7 => [
                'title' => 'Nomor Peserta',
                'description' => 'Nomor peserta ujian masuk',
                'icon' => 'ticket',
                'status' => $reg->getStepStatus(7),
                'completed' => $reg->isStepCompleted(7),
                'accessible' => false, // Auto-generated
                'route' => null,
                'color' => 'amber',
            ],
        ];
    }
}
