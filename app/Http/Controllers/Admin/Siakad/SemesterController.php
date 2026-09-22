<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjarans = AcademicYear::orderByDesc('id')->get();
        $activeTA = $request->get('tahun_ajaran_id')
            ? AcademicYear::find($request->get('tahun_ajaran_id'))
            : AcademicYear::active()->first();

        $semesters = $activeTA
            ? $activeTA->semesters()->orderBy('tipe')->get()
            : collect();

        return view('admin.siakad.semester.index', compact('tahunAjarans', 'activeTA', 'semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'tipe' => 'required|in:ganjil,genap',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        Semester::create($request->only('academic_year_id', 'tipe', 'tanggal_mulai', 'tanggal_selesai'));
        return back()->with('success', 'Semester berhasil ditambahkan.');
    }

    public function toggleActive($id)
    {
        $semester = Semester::findOrFail($id);
        // Deactivate all others
        Semester::where('id', '!=', $id)->update(['is_active' => false]);
        $semester->update(['is_active' => !$semester->is_active]);

        return back()->with('success', 'Status semester diperbarui.');
    }

    public function destroy($id)
    {
        Semester::findOrFail($id)->delete();
        return back()->with('success', 'Semester berhasil dihapus.');
    }
}
