<?php

use Illuminate\Support\Facades\Route;

// ============================================================
// API — RFID Hardware (no auth, for ESP32/Arduino)
// ============================================================
Route::post('/rfid/tap', [\App\Http\Controllers\Api\RfidApiController::class, 'tap'])->name('api.rfid.tap');
