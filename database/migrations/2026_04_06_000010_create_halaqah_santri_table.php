<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halaqah_santri', function (Blueprint $table) {
            $table->foreignId('halaqah_id')->constrained()->onDelete('cascade');
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');
            $table->primary(['halaqah_id', 'santri_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halaqah_santri');
    }
};
