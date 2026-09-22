<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use Illuminate\Http\Request;

class AsramaController extends Controller
{
    public function index()
    {
        $asramas = Dormitory::withCount(['santris' => fn($q) => $q->where('status', 'aktif')])->orderBy('nama')->get();
        return view('admin.siakad.asrama.index', compact('asramas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        Dormitory::create($request->only('nama', 'kapasitas', 'keterangan'));
        return back()->with('success', 'Asrama berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $asrama = Dormitory::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $asrama->update($request->only('nama', 'kapasitas', 'keterangan'));
        return back()->with('success', 'Asrama berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Dormitory::findOrFail($id)->delete();
        return back()->with('success', 'Asrama berhasil dihapus.');
    }
}
