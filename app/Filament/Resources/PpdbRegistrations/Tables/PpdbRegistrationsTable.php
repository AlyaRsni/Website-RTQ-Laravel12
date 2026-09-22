<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PpdbRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tahun_ajaran')
                    ->searchable(),
                TextColumn::make('bukti_pembayaran')
                    ->searchable(),
                TextColumn::make('status_pembayaran')
                    ->badge(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                TextColumn::make('tempat_lahir')
                    ->searchable(),
                TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                TextColumn::make('asal_sekolah')
                    ->searchable(),
                TextColumn::make('nisn')
                    ->searchable(),
                IconColumn::make('pernah_hafal_quran')
                    ->boolean(),
                TextColumn::make('jumlah_hafalan')
                    ->searchable(),
                TextColumn::make('anak_ke')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_saudara')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nama_ayah')
                    ->searchable(),
                TextColumn::make('pekerjaan_ayah')
                    ->searchable(),
                TextColumn::make('nama_ibu')
                    ->searchable(),
                TextColumn::make('pekerjaan_ibu')
                    ->searchable(),
                TextColumn::make('status_data_diri')
                    ->badge(),
                TextColumn::make('no_hp_ayah')
                    ->searchable(),
                TextColumn::make('no_hp_ibu')
                    ->searchable(),
                TextColumn::make('status_kontak')
                    ->badge(),
                TextColumn::make('kartu_keluarga')
                    ->searchable(),
                TextColumn::make('foto_3x4')
                    ->searchable(),
                TextColumn::make('ijazah_raport')
                    ->searchable(),
                TextColumn::make('status_berkas')
                    ->badge(),
                TextColumn::make('finalisasi_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status_verifikasi')
                    ->badge(),
                TextColumn::make('hasil_seleksi_pdf')
                    ->searchable(),
                TextColumn::make('status_seleksi')
                    ->badge(),
                TextColumn::make('nomor_peserta')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
