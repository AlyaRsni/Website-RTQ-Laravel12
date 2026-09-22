<?php

namespace App\Http\Controllers\Siakad\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Halaqah;
use App\Models\HafalanExam;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class UjianHafalanController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = UstadzHalaqah::where('user_id', auth()->id())->firstOrFail();
        $halaqahs = Halaqah::where('ustadz_id', $ustadz->id)->with('semester.academicYear')->get();

        $selectedHalaqah = null;
        $exams = collect();
        $kategoriFilter = $request->get('kategori', '');

        if ($request->filled('halaqah_id')) {
            $selectedHalaqah = Halaqah::where('id', $request->halaqah_id)
                ->where('ustadz_id', $ustadz->id)
                ->with('santris')
                ->first();

            if ($selectedHalaqah) {
                $query = HafalanExam::where('halaqah_id', $selectedHalaqah->id)
                    ->with('santri')
                    ->orderByDesc('tanggal_ujian');

                if ($kategoriFilter) {
                    $query->where('kategori', $kategoriFilter);
                }

                $exams = $query->take(50)->get();
            }
        }

        return view('siakad.ustadz.ujian-hafalan.index', compact(
            'halaqahs', 'selectedHalaqah', 'exams', 'kategoriFilter'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'halaqah_id'     => 'required|exists:halaqahs,id',
            'santri_id'      => 'required|exists:santris,id',
            'kategori'       => 'required|in:per_juz,semester,bulanan',
            'juz'            => 'nullable|integer|min:1|max:30',
            'surat_mulai'    => 'nullable|string|max:255',
            'ayat_mulai'     => 'nullable|integer|min:1',
            'surat_selesai'  => 'nullable|string|max:255',
            'ayat_selesai'   => 'nullable|integer|min:1',
            'nilai_bacaan'   => 'required|integer|min:0|max:100',
            'nilai_hafalan'  => 'required|integer|min:0|max:100',
            'catatan'        => 'nullable|string',
            'evaluasi'       => 'nullable|string',
            'tanggal_ujian'  => 'required|date',
        ]);

        HafalanExam::create($request->only(
            'halaqah_id', 'santri_id', 'kategori', 'juz',
            'surat_mulai', 'ayat_mulai', 'surat_selesai', 'ayat_selesai',
            'nilai_bacaan', 'nilai_hafalan', 'catatan', 'evaluasi', 'tanggal_ujian'
        ));

        return back()->with('success', 'Hasil ujian hafalan berhasil disimpan.');
    }
}
