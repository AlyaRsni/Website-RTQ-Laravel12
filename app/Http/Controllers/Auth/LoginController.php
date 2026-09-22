<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Nomor telepon atau NIS wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = $request->login;
        $password = $request->password;

        // Try to find santri by NIS first
        $santri = Santri::where('nis', $loginInput)->first();

        if ($santri) {
            // Login via NIS — authenticate the associated user
            $user = $santri->user;
            if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();
                return $this->redirectByRole($user);
            }

            return back()->withErrors([
                'login' => 'NIS atau password salah.',
            ])->onlyInput('login');
        }

        // Otherwise try login via phone number
        if (Auth::attempt(['phone' => $loginInput, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'login' => 'Nomor telepon/NIS atau password salah.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil keluar.');
    }

    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'ustadz_ppdb' => redirect()->route('ustadz.dashboard'),
            'calon_santri' => redirect()->route('ppdb.dashboard'),
            'ustadz_halaqah' => redirect()->route('siakad.ustadz.dashboard'),
            'santri' => redirect()->route('siakad.santri.dashboard'),
            default => redirect('/'),
        };
    }
}
