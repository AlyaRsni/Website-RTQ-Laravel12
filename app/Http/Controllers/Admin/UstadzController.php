<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UstadzController extends Controller
{
    public function index()
    {
        $ustadzList = User::where('role', 'ustadz_ppdb')->latest()->get();
        return view('admin.ustadz.index', compact('ustadzList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone|max:20',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'ustadz_ppdb',
        ]);

        return redirect()->route('admin.ustadz.index')
            ->with('success', 'Ustadz PPDB berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $ustadz = User::where('role', 'ustadz_ppdb')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $ustadz->id,
            'password' => 'nullable|string|min:8',
        ]);

        $ustadz->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $ustadz->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.ustadz.index')
            ->with('success', 'Data Ustadz berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ustadz = User::where('role', 'ustadz_ppdb')->findOrFail($id);
        $ustadz->delete();

        return redirect()->route('admin.ustadz.index')
            ->with('success', 'Ustadz berhasil dihapus.');
    }
}
