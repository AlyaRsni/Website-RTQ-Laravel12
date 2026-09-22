<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HasilSeleksiController extends Controller
{
    public function index()
    {
        $registrations = PpdbRegistration::with('user')
            ->whereNotNull('nomor_peserta')
            ->latest()
            ->get();

        // Global toggle status — check if ANY are set to tersedia
        $globalToggle = PpdbRegistration::where('hasil_seleksi_status', 'tersedia')->exists();

        return view('admin.hasil-seleksi', compact('registrations', 'globalToggle'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'hasil_pdf' => 'required|file|mimes:pdf|max:5120',
        ], [
            'hasil_pdf.required' => 'File PDF wajib dipilih.',
            'hasil_pdf.mimes' => 'File harus berformat PDF.',
            'hasil_pdf.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $registration = PpdbRegistration::findOrFail($id);

        // Delete old file
        if ($registration->hasil_seleksi_pdf) {
            Storage::disk('ppdb')->delete($registration->hasil_seleksi_pdf);
        }

        $path = $request->file('hasil_pdf')->storeAs(
            $registration->user_id,
            'hasil_seleksi.pdf',
            'ppdb'
        );

        $registration->update([
            'hasil_seleksi_pdf' => $path,
        ]);

        return redirect()->route('admin.hasil-seleksi.index')
            ->with('success', 'File hasil seleksi berhasil diupload untuk ' . ($registration->nama_lengkap ?? $registration->user->name));
    }

    public function toggleDownload(Request $request)
    {
        $enable = $request->boolean('enable');
        $status = $enable ? 'tersedia' : 'belum_tersedia';

        // Update all registrations that have PDF
        PpdbRegistration::whereNotNull('hasil_seleksi_pdf')
            ->update(['hasil_seleksi_status' => $status]);

        $msg = $enable
            ? 'Download hasil seleksi telah DIAKTIFKAN untuk semua calon santri.'
            : 'Download hasil seleksi telah DINONAKTIFKAN.';

        return redirect()->route('admin.hasil-seleksi.index')
            ->with('success', $msg);
    }

    public function deleteFile($id)
    {
        $registration = PpdbRegistration::findOrFail($id);

        if ($registration->hasil_seleksi_pdf) {
            Storage::disk('ppdb')->delete($registration->hasil_seleksi_pdf);
            $registration->update([
                'hasil_seleksi_pdf' => null,
                'hasil_seleksi_status' => 'belum_tersedia',
            ]);
        }

        return redirect()->route('admin.hasil-seleksi.index')
            ->with('success', 'File hasil seleksi berhasil dihapus.');
    }
}
