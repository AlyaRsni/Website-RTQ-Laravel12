<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\Halaqah;
use App\Models\Santri;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with(['user', 'dormitory']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $santris = $query->orderByDesc('id')->paginate(15)->withQueryString();
        return view('admin.siakad.santri.index', compact('santris'));
    }

    public function create()
    {
        $asramas = Dormitory::orderBy('nama')->get();
        return view('admin.siakad.santri.create', compact('asramas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:santris,nis',
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'telepon_wali' => 'nullable|string|max:20',
            'dormitory_id' => 'nullable|exists:dormitories,id',
            'rfid_uid' => 'nullable|string|max:50|unique:santris,rfid_uid',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan santri lain.',
        ]);

        DB::transaction(function () use ($request) {
            $nis = $request->nis;

            // Create user account (santri login via NIS, phone is internal placeholder)
            $user = User::create([
                'name' => $request->nama_lengkap,
                'phone' => 'NIS-' . $nis,
                'password' => bcrypt($request->password),
                'role' => 'santri',
            ]);

            // Handle foto upload
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto-santri', 'public');
            }

            // Create santri profile
            Santri::create([
                'user_id' => $user->id,
                'nis' => $nis,
                'nama_lengkap' => $request->nama_lengkap,
                'foto' => $fotoPath,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'telepon_wali' => $request->telepon_wali,
                'dormitory_id' => $request->dormitory_id,
                'rfid_uid' => $request->rfid_uid ?: null,
            ]);
        });

        return redirect()->route('admin.siakad.santri.index')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function show($id)
    {
        $santri = Santri::with(['user', 'dormitory', 'halaqahs.ustadz', 'halaqahs.semester.academicYear'])->findOrFail($id);

        // Data for edit forms
        $asramas = Dormitory::orderBy('nama')->get();

        // Get halaqahs from active semester that the santri is NOT yet in
        $activeSemester = Semester::active()->first();
        $availableHalaqahs = collect();
        if ($activeSemester) {
            $availableHalaqahs = Halaqah::where('semester_id', $activeSemester->id)
                ->with(['ustadz', 'semester.academicYear'])
                ->whereDoesntHave('santris', fn($q) => $q->where('santri_id', $santri->id))
                ->orderBy('nama')
                ->get();
        }

        // Prayer attendance stats (bulan ini)
        $prayerStats = [];
        foreach (['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $wk) {
            $prayerStats[$wk] = \App\Models\PrayerAttendance::where('santri_id', $santri->id)
                ->where('waktu_shalat', $wk)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();
        }

        // Recent permissions
        $recentPermissions = \App\Models\SantriPermission::where('santri_id', $santri->id)
            ->with('approver')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.siakad.santri.show', compact(
            'santri', 'asramas', 'availableHalaqahs', 'activeSemester',
            'prayerStats', 'recentPermissions'
        ));
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::with('user')->findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'telepon_wali' => 'nullable|string|max:20',
            'dormitory_id' => 'nullable|exists:dormitories,id',
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
            'rfid_uid' => 'nullable|string|max:50|unique:santris,rfid_uid,' . $santri->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $updateData = $request->only(
            'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
            'asal_sekolah', 'alamat', 'nama_ayah', 'nama_ibu', 'telepon_wali',
            'dormitory_id', 'status'
        );
        $updateData['rfid_uid'] = $request->rfid_uid ?: null;
        $santri->update($updateData);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($santri->foto && Storage::disk('public')->exists($santri->foto)) {
                Storage::disk('public')->delete($santri->foto);
            }
            $santri->update(['foto' => $request->file('foto')->store('foto-santri', 'public')]);
        }

        $santri->user->update(['name' => $request->nama_lengkap]);

        return back()->with('success', 'Data santri berhasil diperbarui.');
    }

    /**
     * Assign santri to a halaqah (from santri detail page).
     */
    public function addHalaqah(Request $request, $id)
    {
        $request->validate([
            'halaqah_id' => 'required|exists:halaqahs,id',
        ]);

        $santri = Santri::findOrFail($id);
        $santri->halaqahs()->syncWithoutDetaching([$request->halaqah_id]);

        return back()->with('success', 'Santri berhasil dimasukkan ke halaqah.');
    }

    /**
     * Remove santri from a halaqah (from santri detail page).
     */
    public function removeHalaqah($santriId, $halaqahId)
    {
        $santri = Santri::findOrFail($santriId);
        $santri->halaqahs()->detach($halaqahId);

        return back()->with('success', 'Santri berhasil dikeluarkan dari halaqah.');
    }

    /**
     * Reset password santri (admin only).
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|string|min:6',
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 6 karakter.',
        ]);

        $santri = Santri::with('user')->findOrFail($id);
        $santri->user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return back()->with('success', 'Password santri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $santri = Santri::findOrFail($id);
        $santri->user()->delete(); // cascade deletes santri record too
        return redirect()->route('admin.siakad.santri.index')->with('success', 'Santri berhasil dihapus.');
    }
}
