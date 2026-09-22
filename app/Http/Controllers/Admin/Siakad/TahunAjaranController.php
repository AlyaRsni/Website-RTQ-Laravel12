<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = AcademicYear::withCount('semesters')->orderByDesc('id')->get();
        return view('admin.siakad.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:20|unique:academic_years,nama',
        ]);

        AcademicYear::create($request->only('nama'));
        return back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $ta = AcademicYear::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:20|unique:academic_years,nama,' . $id,
        ]);

        $ta->update($request->only('nama'));
        return back()->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function toggleActive($id)
    {
        $ta = AcademicYear::findOrFail($id);

        // Deactivate all others first
        AcademicYear::where('id', '!=', $id)->update(['is_active' => false]);
        $ta->update(['is_active' => !$ta->is_active]);

        return back()->with('success', 'Status tahun ajaran diperbarui.');
    }

    public function destroy($id)
    {
        AcademicYear::findOrFail($id)->delete();
        return back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
