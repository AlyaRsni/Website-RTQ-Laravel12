<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tahun_ajaran')->default('2026/2027');

            // Step 1: Pembayaran
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', [
                'belum_upload', 'menunggu_verifikasi', 'diterima', 'ditolak'
            ])->default('belum_upload');
            $table->text('alasan_tolak_pembayaran')->nullable();

            // Step 2: Data Diri
            $table->string('nama_lengkap')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('nisn')->nullable();
            $table->boolean('pernah_hafal_quran')->default(false);
            $table->string('jumlah_hafalan')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->enum('status_data_diri', [
                'belum_isi', 'draft', 'selesai'
            ])->default('belum_isi');

            // Step 3: Kontak Orang Tua
            $table->string('no_hp_ayah')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->enum('status_kontak', [
                'belum_isi', 'selesai'
            ])->default('belum_isi');

            // Step 4: Upload Berkas
            $table->string('kartu_keluarga')->nullable();
            $table->string('foto_3x4')->nullable();
            $table->string('ijazah_raport')->nullable();
            $table->enum('status_berkas', [
                'belum_upload', 'draft', 'selesai'
            ])->default('belum_upload');

            // Step 5: Finalisasi
            $table->timestamp('finalisasi_at')->nullable();

            // Step 6: Verifikasi
            $table->enum('status_verifikasi', [
                'belum_diajukan', 'menunggu_verifikasi_berkas', 'perlu_perbaikan', 'terverifikasi'
            ])->default('belum_diajukan');
            $table->text('catatan_perbaikan')->nullable();

            // Step 7: Nomor Peserta
            $table->string('nomor_peserta')->unique()->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
