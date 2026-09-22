<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;

class ExportController extends Controller
{
    public function exportCsv()
    {
        $registrations = PpdbRegistration::with('user')->get();

        $filename = 'data_ppdb_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, [
                'No', 'Nomor Peserta', 'Nama Akun', 'Telepon', 'Nama Lengkap',
                'Tempat Lahir', 'Tanggal Lahir', 'Asal Sekolah', 'NISN',
                'Hafal Quran', 'Jumlah Hafalan', 'Anak Ke', 'Jml Saudara',
                'Nama Ayah', 'Pekerjaan Ayah', 'Nama Ibu', 'Pekerjaan Ibu',
                'Alamat', 'No HP Ayah', 'No HP Ibu',
                'Status Pembayaran', 'Status Data Diri', 'Status Kontak',
                'Status Berkas', 'Status Verifikasi', 'Progress %',
                'Tanggal Daftar', 'Tanggal Finalisasi',
            ]);

            foreach ($registrations as $i => $reg) {
                fputcsv($file, [
                    $i + 1,
                    $reg->nomor_peserta ?? '-',
                    $reg->user->name ?? '-',
                    $reg->user->phone ?? '-',
                    $reg->nama_lengkap ?? '-',
                    $reg->tempat_lahir ?? '-',
                    $reg->tanggal_lahir?->format('d/m/Y') ?? '-',
                    $reg->asal_sekolah ?? '-',
                    $reg->nisn ?? '-',
                    $reg->pernah_hafal_quran ? 'Ya' : 'Tidak',
                    $reg->jumlah_hafalan ?? '-',
                    $reg->anak_ke ?? '-',
                    $reg->jumlah_saudara ?? '-',
                    $reg->nama_ayah ?? '-',
                    $reg->pekerjaan_ayah ?? '-',
                    $reg->nama_ibu ?? '-',
                    $reg->pekerjaan_ibu ?? '-',
                    $reg->alamat_rumah ?? '-',
                    $reg->no_hp_ayah ?? '-',
                    $reg->no_hp_ibu ?? '-',
                    $reg->status_pembayaran,
                    $reg->status_data_diri,
                    $reg->status_kontak,
                    $reg->status_berkas,
                    $reg->status_verifikasi,
                    $reg->getProgressPercentage() . '%',
                    $reg->created_at?->format('d/m/Y H:i'),
                    $reg->finalisasi_at?->format('d/m/Y H:i') ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
