<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tahun_ajaran')
                    ->required()
                    ->default('2026/2027'),
                TextInput::make('bukti_pembayaran')
                    ->default(null),
                Select::make('status_pembayaran')
                    ->options([
            'belum_upload' => 'Belum upload',
            'menunggu_verifikasi' => 'Menunggu verifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ])
                    ->default('belum_upload')
                    ->required(),
                Textarea::make('alasan_tolak_pembayaran')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('nama_lengkap')
                    ->default(null),
                TextInput::make('tempat_lahir')
                    ->default(null),
                DatePicker::make('tanggal_lahir'),
                TextInput::make('asal_sekolah')
                    ->default(null),
                TextInput::make('nisn')
                    ->default(null),
                Toggle::make('pernah_hafal_quran')
                    ->required(),
                TextInput::make('jumlah_hafalan')
                    ->default(null),
                TextInput::make('anak_ke')
                    ->numeric()
                    ->default(null),
                TextInput::make('jumlah_saudara')
                    ->numeric()
                    ->default(null),
                TextInput::make('nama_ayah')
                    ->default(null),
                TextInput::make('pekerjaan_ayah')
                    ->default(null),
                TextInput::make('nama_ibu')
                    ->default(null),
                TextInput::make('pekerjaan_ibu')
                    ->default(null),
                Textarea::make('alamat_rumah')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status_data_diri')
                    ->options(['belum_isi' => 'Belum isi', 'draft' => 'Draft', 'selesai' => 'Selesai'])
                    ->default('belum_isi')
                    ->required(),
                TextInput::make('no_hp_ayah')
                    ->default(null),
                TextInput::make('no_hp_ibu')
                    ->default(null),
                Select::make('status_kontak')
                    ->options(['belum_isi' => 'Belum isi', 'selesai' => 'Selesai'])
                    ->default('belum_isi')
                    ->required(),
                TextInput::make('kartu_keluarga')
                    ->default(null),
                TextInput::make('foto_3x4')
                    ->default(null),
                TextInput::make('ijazah_raport')
                    ->default(null),
                Select::make('status_berkas')
                    ->options(['belum_upload' => 'Belum upload', 'draft' => 'Draft', 'selesai' => 'Selesai'])
                    ->default('belum_upload')
                    ->required(),
                DateTimePicker::make('finalisasi_at'),
                Select::make('status_verifikasi')
                    ->options([
            'belum_diajukan' => 'Belum diajukan',
            'menunggu_verifikasi_berkas' => 'Menunggu verifikasi berkas',
            'perlu_perbaikan' => 'Perlu perbaikan',
            'terverifikasi' => 'Terverifikasi',
        ])
                    ->default('belum_diajukan')
                    ->required(),
                TextInput::make('hasil_seleksi_pdf')
                    ->default(null),
                Select::make('status_seleksi')
                    ->options(['belum_ditentukan' => 'Belum ditentukan', 'lulus' => 'Lulus', 'tidak_lulus' => 'Tidak lulus'])
                    ->default('belum_ditentukan')
                    ->required(),
                Textarea::make('catatan_perbaikan')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('nomor_peserta')
                    ->default(null),
            ]);
    }
}
