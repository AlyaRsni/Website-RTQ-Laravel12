<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri_permissions', function (Blueprint $table) {
            $table->time('jam_keluar')->nullable()->after('tanggal_selesai');
            $table->time('jam_kembali')->nullable()->after('jam_keluar');
        });
    }

    public function down(): void
    {
        Schema::table('santri_permissions', function (Blueprint $table) {
            $table->dropColumn(['jam_keluar', 'jam_kembali']);
        });
    }
};
