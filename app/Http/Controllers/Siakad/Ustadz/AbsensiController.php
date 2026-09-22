<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Halaqah;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();

        $selectedHalaqah = null;
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        $attendances = collect();

        if ($request->filled('halaqah_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            if ($selectedHalaqah) {
                $existingAttendances = Attendance::where('halaqah_id', $selectedHalaqah->id)
                    ->where('tanggal', $tanggal)
                    ->pluck('status', 'santri_id');

                $attendances = $selectedHalaqah->santris->map(function ($santri) use ($existingAttendances) {
                    $santri->attendance_status = $existingAttendances->get($santri->id, null);
                    return $santri;
                });
            }
        }

        return view('siakad.ustadz.absensi.index', compact('halaqahs', 'selectedHalaqah', 'tanggal', 'attendances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'halaqah_id' => 'required|exists:halaqahs,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.santri_id' => 'required|exists:santris,id',
            'absensi.*.status' => 'required|in:hadir,sakit,izin,alpha',
        ]);

        foreach ($request->absensi as $data) {
            Attendance::updateOrCreate(
                [
                    'halaqah_id' => $request->halaqah_id,
                    'santri_id' => $data['santri_id'],
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Absensi berhasil disimpan untuk tanggal ' . $request->tanggal);
    }
}
