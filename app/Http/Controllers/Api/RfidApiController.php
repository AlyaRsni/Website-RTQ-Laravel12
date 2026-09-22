<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrayerAttendance;
use App\Models\Santri;
use Illuminate\Http\Request;

class RfidApiController extends Controller
{
    /**
     * Endpoint for hardware RFID reader (ESP32/Arduino)
     * POST /api/rfid/tap
     * Body: { "uid": "A1B2C3D4", "waktu_shalat": "subuh" }
     */
    public function tap(Request $request)
    {
        $request->validate([
            'uid'          => 'required|string',
            'waktu_shalat' => 'required|in:subuh,dzuhur,ashar,maghrib,isya',
        ]);

        $santri = Santri::with('dormitory')->where('rfid_uid', $request->uid)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu tidak terdaftar',
            ], 404);
        }

        $tanggal = now()->format('Y-m-d');

        // Check duplicate
        $existing = PrayerAttendance::where('santri_id', $santri->id)
            ->where('waktu_shalat', $request->waktu_shalat)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existing) {
            return response()->json([
                'success'   => false,
                'message'   => 'Sudah tercatat',
                'santri'    => $santri->nama_lengkap,
                'duplicate' => true,
            ]);
        }

        $attendance = PrayerAttendance::create([
            'santri_id'    => $santri->id,
            'waktu_shalat' => $request->waktu_shalat,
            'tanggal'      => $tanggal,
            'status'       => 'hadir',
            'metode'       => 'rfid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OK',
            'santri'  => $santri->nama_lengkap,
            'shalat'  => $request->waktu_shalat,
        ]);
    }
}
