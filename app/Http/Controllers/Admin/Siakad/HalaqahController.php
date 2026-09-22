<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Halaqah;
use App\Models\Santri;
use App\Models\Semester;
use App\Models\UstadzHalaqah;
use Illuminate\Http\Request;

class HalaqahController extends Controller
{
    public function index(Request $request)
    {
        $semesters = Semester::with('academicYear')->orderByDesc('id')->get();
        $activeSemester = $request->get('semester_id')
            ? Semester::find($request->get('semester_id'))
            : Semester::active()->first();

        $halaqahs = $activeSemester
            ? Halaqah::where('semester_id', $activeSemester->id)
                ->with(['ustadz', 'semester.academicYear'])
                ->withCount('santris')
                ->orderBy('nama')
                ->get()
            : collect();

        $ustadzs = UstadzHalaqah::aktif()->get();

        return view('admin.siakad.halaqah.index', compact('semesters', 'activeSemester', 'halaqahs', 'ustadzs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'ustadz_id' => 'required|exists:ustadzs,id',
            'nama' => 'required|string|max:255',
        ]);

        Halaqah::create($request->only('semester_id', 'ustadz_id', 'nama'));
        return back()->with('success', 'Halaqah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $halaqah = Halaqah::with(['ustadz', 'semester.academicYear', 'santris'])->findOrFail($id);
        $availableSantris = Santri::aktif()
            ->whereDoesntHave('halaqahs', fn($q) => $q->where('halaqah_id', $id))
            ->orderBy('nama_lengkap')
            ->get();

        return view('admin.siakad.halaqah.show', compact('halaqah', 'availableSantris'));
    }

    public function update(Request $request, $id)
    {
        $halaqah = Halaqah::findOrFail($id);
        $request->validate([
            'ustadz_id' => 'required|exists:ustadzs,id',
            'nama' => 'required|string|max:255',
        ]);

        $halaqah->update($request->only('ustadz_id', 'nama'));
        return back()->with('success', 'Halaqah berhasil diperbarui.');
    }

    public function addSantri(Request $request, $id)
    {
        $request->validate([
            'santri_ids' => 'required|array',
            'santri_ids.*' => 'exists:santris,id',
        ]);

        $halaqah = Halaqah::findOrFail($id);
        $halaqah->santris()->syncWithoutDetaching($request->santri_ids);

        return back()->with('success', count($request->santri_ids) . ' santri berhasil ditambahkan ke halaqah.');
    }

    public function removeSantri($halaqahId, $santriId)
    {
        $halaqah = Halaqah::findOrFail($halaqahId);
        $halaqah->santris()->detach($santriId);

        return back()->with('success', 'Santri berhasil dikeluarkan dari halaqah.');
    }

    public function destroy($id)
    {
        Halaqah::findOrFail($id)->delete();
        return back()->with('success', 'Halaqah berhasil dihapus.');
    }
}
