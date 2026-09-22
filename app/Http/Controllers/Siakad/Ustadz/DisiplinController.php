<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\DisciplineNote;
use App\Models\Halaqah;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class DisiplinController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();

        $selectedHalaqah = null;
        $notes = collect();

        if ($request->filled('halaqah_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            if ($selectedHalaqah) {
                $notes = DisciplineNote::where('halaqah_id', $selectedHalaqah->id)
                    ->with('santri')
                    ->orderByDesc('tanggal')
                    ->take(50)
                    ->get();
            }
        }

        return view('siakad.ustadz.disiplin.index', compact('halaqahs', 'selectedHalaqah', 'notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'halaqah_id' => 'required|exists:halaqahs,id',
            'santri_id' => 'required|exists:santris,id',
            'tipe' => 'required|in:pelanggaran,prestasi',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'poin' => 'required|integer|min:0',
        ]);

        DisciplineNote::create($request->only(
            'halaqah_id', 'santri_id', 'tipe', 'judul', 'deskripsi', 'tanggal', 'poin'
        ));

        return back()->with('success', 'Catatan kedisiplinan berhasil disimpan.');
    }
}
