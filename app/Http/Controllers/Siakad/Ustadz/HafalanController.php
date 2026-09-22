<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Halaqah;
use App\Models\HafalanJournal;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class HafalanController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();

        $selectedHalaqah = null;
        $journals = collect();

        if ($request->filled('halaqah_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            if ($selectedHalaqah) {
                $journals = HafalanJournal::where('halaqah_id', $selectedHalaqah->id)
                    ->with('santri')
                    ->orderByDesc('tanggal')
                    ->take(50)
                    ->get();
            }
        }

        return view('siakad.ustadz.hafalan.index', compact('halaqahs', 'selectedHalaqah', 'journals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'halaqah_id' => 'required|exists:halaqahs,id',
            'santri_id' => 'required|exists:santris,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:ziyadah,murojaah',
            'surat' => 'nullable|string|max:255',
            'ayat_mulai' => 'nullable|integer|min:1',
            'ayat_selesai' => 'nullable|integer|min:1',
            'juz' => 'nullable|integer|min:1|max:30',
            'kualitas' => 'required|in:mumtaz,jayyid_jiddan,jayyid,maqbul,perlu_perbaikan',
            'catatan' => 'nullable|string',
        ]);

        HafalanJournal::create($request->only(
            'halaqah_id', 'santri_id', 'tanggal', 'jenis', 'surat',
            'ayat_mulai', 'ayat_selesai', 'juz', 'kualitas', 'catatan'
        ));

        return back()->with('success', 'Jurnal hafalan berhasil disimpan.');
    }
}
