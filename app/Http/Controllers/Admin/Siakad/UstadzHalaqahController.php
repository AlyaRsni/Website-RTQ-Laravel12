<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\UstadzHalaqah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UstadzHalaqahController extends Controller
{
    public function index()
    {
        $ustadzs = UstadzHalaqah::with('user')->withCount('halaqahs')->orderByDesc('id')->get();
        return view('admin.siakad.ustadz.index', compact('ustadzs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
            'nip' => 'nullable|string|max:50|unique:ustadzs,nip',
            'spesialisasi' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nama_lengkap,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role' => 'ustadz_halaqah',
            ]);

            UstadzHalaqah::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'nip' => $request->nip,
                'spesialisasi' => $request->spesialisasi,
            ]);
        });

        return back()->with('success', 'Ustadz Halaqah berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $ustadz = UstadzHalaqah::with('user')->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:ustadzs,nip,' . $id,
            'spesialisasi' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $ustadz->update($request->only('nama_lengkap', 'nip', 'spesialisasi', 'status'));
        $ustadz->user->update(['name' => $request->nama_lengkap]);

        return back()->with('success', 'Data ustadz berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ustadz = UstadzHalaqah::findOrFail($id);
        $ustadz->user()->delete();
        return back()->with('success', 'Ustadz berhasil dihapus.');
    }
}
