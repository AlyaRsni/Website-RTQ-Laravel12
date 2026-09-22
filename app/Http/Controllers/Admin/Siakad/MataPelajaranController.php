<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectCategory;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $categories = SubjectCategory::with('subjects')->orderBy('nama')->get();
        return view('admin.siakad.mata-pelajaran.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100|unique:subject_categories,nama']);
        SubjectCategory::create($request->only('nama'));
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroyCategory($id)
    {
        SubjectCategory::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:subject_categories,id',
            'kode' => 'required|string|max:20|unique:subjects,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Subject::create($request->only('category_id', 'kode', 'nama', 'deskripsi'));
        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:subject_categories,id',
            'kode' => 'required|string|max:20|unique:subjects,kode,' . $id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $subject->update($request->only('category_id', 'kode', 'nama', 'deskripsi'));
        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
