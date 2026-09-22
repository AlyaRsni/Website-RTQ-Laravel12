<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::with('user');

        // Search
        if ($search = $request->get('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%"))
                ->orWhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nomor_peserta', 'like', "%{$search}%");
        }

        // Filter status
        if ($status = $request->get('status')) {
            $query->where('status_verifikasi', $status);
        }

        $pendaftar = $query->latest()->paginate(15)->appends($request->query());

        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $registration = PpdbRegistration::with('user')->findOrFail($id);
        return view('admin.pendaftar.show', compact('registration'));
    }

    public function destroy($id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        $user = $registration->user;

        // Delete uploaded files
        if ($registration->bukti_pembayaran) Storage::disk('ppdb')->delete($registration->bukti_pembayaran);
        if ($registration->kartu_keluarga) Storage::disk('ppdb')->delete($registration->kartu_keluarga);
        if ($registration->foto_3x4) Storage::disk('ppdb')->delete($registration->foto_3x4);
        if ($registration->ijazah_raport) Storage::disk('ppdb')->delete($registration->ijazah_raport);
        if ($registration->hasil_seleksi_pdf) Storage::disk('ppdb')->delete($registration->hasil_seleksi_pdf);

        $user->delete(); // cascade deletes registration

        return redirect()->route('admin.pendaftar.index')
            ->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function override($id)
    {
        $registration = PpdbRegistration::findOrFail($id);

        $registration->update([
            'status_verifikasi' => 'terverifikasi',
            'catatan_perbaikan' => null,
        ]);

        // Generate nomor peserta jika belum ada
        if (!$registration->nomor_peserta) {
            $registration->update([
                'nomor_peserta' => PpdbRegistration::generateNomorPeserta(),
            ]);
        }

        return redirect()->route('admin.pendaftar.show', $id)
            ->with('success', 'Pendaftar berhasil diloloskan (override admin).');
    }

    public function resetPassword($id)
    {
        $registration = PpdbRegistration::with('user')->findOrFail($id);
        $user = $registration->user;

        // Default password = tanggal lahir (YYYYMMDD), fallback '12345678'
        $newPassword = $registration->tanggal_lahir ? $registration->tanggal_lahir->format('Ymd') : '12345678';

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()->route('admin.pendaftar.show', $id)
            ->with('success', 'Password berhasil direset. Password baru: ' . $newPassword);
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
