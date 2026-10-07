<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran akun PPDB.
     * Saat ini diarahkan ke halaman 'ppdb.belum-dibuka'.
     *
     * CARA MENGEMBALIKAN KE HALAMAN ASLI:
     * Cukup kembalikan ke:
     *   if (Auth::check()) return redirect()->route('ppdb.dashboard');
     *   return view('auth.register');
     */
    public function showForm()
    {
        // PPDB Belum Dibuka — Arahkan ke halaman pemberitahuan
        return redirect()->route('ppdb.belum-dibuka');

        /* === AKTIFKAN KEMBALI JIKA PENDAFTARAN SUDAH DIBUKA (1 NOVEMBER) ===
        if (Auth::check()) {
            return redirect()->route('ppdb.dashboard');
        }
        return view('auth.register');
        =================================================================== */
    }

    public function register(Request $request)
    {
        // Pendaftaran belum dibuka
        return redirect()->route('ppdb.belum-dibuka');

        /* === AKTIFKAN KEMBALI JIKA PENDAFTARAN SUDAH DIBUKA (1 NOVEMBER) ===
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^08[0-9]{8,13}$/', 'unique:users,phone'],
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid (08xxxxxxxxxx).',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'calon_santri',
        ]);

        Auth::login($user);

        return redirect()->route('ppdb.dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang di PPDB RTQ Kawali.');
        =================================================================== */
    }
}
