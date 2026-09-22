<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafalan_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('halaqah_id')->constrained()->onDelete('cascade');
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->enum('kategori', ['per_juz', 'semester', 'bulanan']);
            $table->integer('juz')->nullable();
            $table->string('surat_mulai')->nullable();
            $table->integer('ayat_mulai')->nullable();
            $table->string('surat_selesai')->nullable();
            $table->integer('ayat_selesai')->nullable();
            $table->integer('nilai_bacaan')->default(0);
            $table->integer('nilai_hafalan')->default(0);
            $table->text('catatan')->nullable();
            $table->text('evaluasi')->nullable();
            $table->date('tanggal_ujian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalan_exams');
    }
};
