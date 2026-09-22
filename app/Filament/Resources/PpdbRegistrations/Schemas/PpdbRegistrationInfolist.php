<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PpdbRegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('tahun_ajaran'),
                TextEntry::make('bukti_pembayaran')
                    ->placeholder('-'),
                TextEntry::make('status_pembayaran')
                    ->badge(),
                TextEntry::make('alasan_tolak_pembayaran')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('nama_lengkap')
                    ->placeholder('-'),
                TextEntry::make('tempat_lahir')
                    ->placeholder('-'),
                TextEntry::make('tanggal_lahir')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('asal_sekolah')
                    ->placeholder('-'),
                TextEntry::make('nisn')
                    ->placeholder('-'),
                IconEntry::make('pernah_hafal_quran')
                    ->boolean(),
                TextEntry::make('jumlah_hafalan')
                    ->placeholder('-'),
                TextEntry::make('anak_ke')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('jumlah_saudara')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('nama_ayah')
                    ->placeholder('-'),
                TextEntry::make('pekerjaan_ayah')
                    ->placeholder('-'),
                TextEntry::make('nama_ibu')
                    ->placeholder('-'),
                TextEntry::make('pekerjaan_ibu')
                    ->placeholder('-'),
                TextEntry::make('alamat_rumah')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status_data_diri')
                    ->badge(),
                TextEntry::make('no_hp_ayah')
                    ->placeholder('-'),
                TextEntry::make('no_hp_ibu')
                    ->placeholder('-'),
                TextEntry::make('status_kontak')
                    ->badge(),
                TextEntry::make('kartu_keluarga')
                    ->placeholder('-'),
                TextEntry::make('foto_3x4')
                    ->placeholder('-'),
                TextEntry::make('ijazah_raport')
                    ->placeholder('-'),
                TextEntry::make('status_berkas')
                    ->badge(),
                TextEntry::make('finalisasi_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status_verifikasi')
                    ->badge(),
                TextEntry::make('hasil_seleksi_pdf')
                    ->placeholder('-'),
                TextEntry::make('status_seleksi')
                    ->badge(),
                TextEntry::make('catatan_perbaikan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('nomor_peserta')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
