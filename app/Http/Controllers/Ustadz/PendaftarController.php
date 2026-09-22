<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::with('user')->whereNotNull('finalisasi_at');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"))
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nomor_peserta', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status_verifikasi', $status);
        }

        $pendaftar = $query->latest('finalisasi_at')->paginate(15)->appends($request->query());

        return view('ustadz.pendaftar.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $registration = PpdbRegistration::with('user')->findOrFail($id);
        return view('ustadz.pendaftar.show', compact('registration'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,perlu_perbaikan',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $registration = PpdbRegistration::findOrFail($id);

        $updates = [
            'status_verifikasi' => $request->status,
            'catatan_perbaikan' => $request->status === 'perlu_perbaikan' ? $request->catatan : null,
        ];

        // When perlu_perbaikan: reset finalisasi so santri can edit & re-submit
        if ($request->status === 'perlu_perbaikan') {
            $updates['finalisasi_at'] = null;
        }

        $registration->update($updates);

        // Generate nomor peserta jika terverifikasi
        if ($request->status === 'terverifikasi' && !$registration->nomor_peserta) {
            $registration->update([
                'nomor_peserta' => PpdbRegistration::generateNomorPeserta(),
            ]);
        }

        $msg = $request->status === 'terverifikasi'
            ? 'Pendaftar berhasil DIVERIFIKASI dan nomor peserta telah digenerate.'
            : 'Catatan perbaikan berhasil dikirim. Pendaftar dapat mengedit dan mengirim ulang.';

        return redirect()->route('ustadz.pendaftar.show', $id)
            ->with('success', $msg);
    }

    public function downloadFile($id, $type)
    {
        $registration = PpdbRegistration::findOrFail($id);

        $fieldMap = [
            'bukti_pembayaran' => 'bukti_pembayaran',
            'kartu_keluarga' => 'kartu_keluarga',
            'foto_3x4' => 'foto_3x4',
            'ijazah_raport' => 'ijazah_raport',
        ];

        if (!isset($fieldMap[$type]) || !$registration->{$fieldMap[$type]}) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = $registration->{$fieldMap[$type]};

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('ppdb');

        if (!$disk->exists($path)) {
            return back()->with('error', 'File tidak ditemukan di storage.');
        }

        $filename = ($registration->nama_lengkap ?? 'pendaftar') . '_' . $type . '.' . pathinfo($path, PATHINFO_EXTENSION);

        return $disk->download($path, str_replace(' ', '_', $filename));
    }

    public function previewFile($id, $type)
    {
        $registration = PpdbRegistration::findOrFail($id);

        $fieldMap = [
            'bukti_pembayaran' => 'bukti_pembayaran',
            'kartu_keluarga' => 'kartu_keluarga',
            'foto_3x4' => 'foto_3x4',
            'ijazah_raport' => 'ijazah_raport',
        ];

        if (!isset($fieldMap[$type]) || !$registration->{$fieldMap[$type]}) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = $registration->{$fieldMap[$type]};

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('ppdb');

        if (!$disk->exists($path)) {
            return back()->with('error', 'File tidak ditemukan di storage.');
        }

        return $disk->response($path);
    }
}
