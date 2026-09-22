<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafalan_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('halaqah_id')->constrained()->onDelete('cascade');
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('jenis', ['ziyadah', 'murojaah']);
            $table->string('surat')->nullable();
            $table->integer('ayat_mulai')->nullable();
            $table->integer('ayat_selesai')->nullable();
            $table->integer('juz')->nullable();
            $table->enum('kualitas', ['mumtaz', 'jayyid_jiddan', 'jayyid', 'maqbul', 'perlu_perbaikan'])->default('jayyid');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalan_journals');
    }
};
