<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->enum('waktu_shalat', ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya']);
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'terlambat'])->default('hadir');
            $table->enum('metode', ['rfid', 'manual'])->default('rfid');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['santri_id', 'waktu_shalat', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_attendances');
    }
};
