<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Halaqah;
use App\Models\Subject;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();
        $subjects = Subject::with('category')->orderBy('kode')->get();

        $selectedHalaqah = null;
        $selectedSubject = null;
        $grades = collect();

        if ($request->filled('halaqah_id') && $request->filled('subject_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            $selectedSubject = Subject::find($request->subject_id);

            if ($selectedHalaqah && $selectedSubject) {
                $existingGrades = Grade::where('halaqah_id', $selectedHalaqah->id)
                    ->where('subject_id', $selectedSubject->id)
                    ->get()
                    ->groupBy('santri_id');

                $grades = $selectedHalaqah->santris->map(function ($santri) use ($existingGrades) {
                    $santri->existing_grades = $existingGrades->get($santri->id, collect());
                    return $santri;
                });
            }
        }

        return view('siakad.ustadz.nilai.index', compact('halaqahs', 'subjects', 'selectedHalaqah', 'selectedSubject', 'grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'halaqah_id' => 'required|exists:halaqahs,id',
            'subject_id' => 'required|exists:subjects,id',
            'nilai' => 'required|array',
            'nilai.*.santri_id' => 'required|exists:santris,id',
            'nilai.*.tipe' => 'required|in:tugas,uts,uas,harian',
            'nilai.*.nilai' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $data) {
            Grade::create([
                'halaqah_id' => $request->halaqah_id,
                'santri_id' => $data['santri_id'],
                'subject_id' => $request->subject_id,
                'tipe' => $data['tipe'],
                'nilai' => $data['nilai'],
                'catatan' => $data['catatan'] ?? null,
            ]);
        }

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}
