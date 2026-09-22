<?php

namespace App\Filament\Exports;

use App\Models\PpdbRegistration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PpdbRegistrationExporter extends Exporter
{
    protected static ?string $model = PpdbRegistration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('user_id'),
            ExportColumn::make('tahun_ajaran'),
            ExportColumn::make('bukti_pembayaran'),
            ExportColumn::make('status_pembayaran'),
            ExportColumn::make('alasan_tolak_pembayaran'),
            ExportColumn::make('nama_lengkap'),
            ExportColumn::make('tempat_lahir'),
            ExportColumn::make('tanggal_lahir'),
            ExportColumn::make('asal_sekolah'),
            ExportColumn::make('nisn'),
            ExportColumn::make('pernah_hafal_quran'),
            ExportColumn::make('jumlah_hafalan'),
            ExportColumn::make('anak_ke'),
            ExportColumn::make('jumlah_saudara'),
            ExportColumn::make('nama_ayah'),
            ExportColumn::make('pekerjaan_ayah'),
            ExportColumn::make('nama_ibu'),
            ExportColumn::make('pekerjaan_ibu'),
            ExportColumn::make('alamat_rumah'),
            ExportColumn::make('status_data_diri'),
            ExportColumn::make('no_hp_ayah'),
            ExportColumn::make('no_hp_ibu'),
            ExportColumn::make('status_kontak'),
            ExportColumn::make('kartu_keluarga'),
            ExportColumn::make('foto_3x4'),
            ExportColumn::make('ijazah_raport'),
            ExportColumn::make('status_berkas'),
            ExportColumn::make('finalisasi_at'),
            ExportColumn::make('status_verifikasi'),
            ExportColumn::make('hasil_seleksi_pdf'),
            ExportColumn::make('status_seleksi'),
            ExportColumn::make('catatan_perbaikan'),
            ExportColumn::make('nomor_peserta'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ppdb registration export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
