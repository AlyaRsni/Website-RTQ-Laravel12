<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Step1Controller extends Controller
{
    public function show()
    {
        $registration = Auth::user()->ppdbRegistration;

        return view('ppdb.steps.step1', [
            'registration' => $registration,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:pdf|max:1024',
        ], [
            'bukti_pembayaran.required' => 'File bukti pembayaran wajib diupload.',
            'bukti_pembayaran.mimes' => 'File harus berformat PDF.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 1MB.',
        ]);

        $registration = Auth::user()->ppdbRegistration;

        // Delete old file if exists
        if ($registration->bukti_pembayaran) {
            Storage::disk('ppdb')->delete($registration->bukti_pembayaran);
        }

        // Store new file
        $path = $request->file('bukti_pembayaran')->storeAs(
            Auth::id(),
            'bukti_pembayaran.pdf',
            'ppdb'
        );

        // Langsung diterima (tanpa verifikasi admin di step ini)
        // Verifikasi pembayaran digabung di Step 6 oleh Ustadz PPDB
        $registration->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'diterima',
        ]);

        return redirect()->route('ppdb.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload! Silakan lanjutkan ke langkah berikutnya.');
    }
}
