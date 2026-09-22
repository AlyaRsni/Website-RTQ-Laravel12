<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Step5Controller extends Controller
{
    public function show()
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(5)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi semua berkas terlebih dahulu.');
        }

        return view('ppdb.steps.step5', [
            'registration' => $registration,
            'user' => Auth::user(),
        ]);
    }

    public function finalize(Request $request)
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(5)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi semua berkas terlebih dahulu.');
        }

        // Allow finalization if never finalized OR if needs revision (re-submit)
        if ($registration->isFinalized()) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Data sudah dikirim sebelumnya.');
        }

        $request->validate([
            'konfirmasi' => 'accepted',
        ], [
            'konfirmasi.accepted' => 'Anda harus mencentang kotak konfirmasi.',
        ]);

        $registration->update([
            'finalisasi_at' => now(),
            'status_verifikasi' => 'menunggu_verifikasi_berkas',
            'catatan_perbaikan' => null, // Clear previous revision notes
        ]);

        $isResub = $registration->wasEverFinalized();
        $msg = $isResub
            ? '🔄 Data berhasil dikirim ulang! Silakan tunggu verifikasi kembali.'
            : '🎉 Data pendaftaran berhasil dikirim! Silakan tunggu verifikasi dari Ustadz PPDB.';

        return redirect()->route('ppdb.dashboard')->with('success', $msg);
    }
}
