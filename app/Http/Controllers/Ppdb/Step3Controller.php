<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Step3Controller extends Controller
{
    public function show()
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(3)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi data diri terlebih dahulu.');
        }

        return view('ppdb.steps.step3', [
            'registration' => $registration,
        ]);
    }

    public function save(Request $request)
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(3)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi data diri terlebih dahulu.');
        }

        if ($registration->isFinalized()) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Data sudah dikirim dan tidak bisa diubah.');
        }

        $validated = $request->validate([
            'no_hp_ayah' => ['required', 'string', 'regex:/^62[0-9]{8,13}$/'],
            'no_hp_ibu' => ['required', 'string', 'regex:/^62[0-9]{8,13}$/'],
        ], [
            'no_hp_ayah.required' => 'No HP Ayah wajib diisi.',
            'no_hp_ayah.regex' => 'Format No HP Ayah harus 62xxx (contoh: 6281234567890).',
            'no_hp_ibu.required' => 'No HP Ibu wajib diisi.',
            'no_hp_ibu.regex' => 'Format No HP Ibu harus 62xxx (contoh: 6281234567890).',
        ]);

        $validated['status_kontak'] = 'selesai';

        $registration->update($validated);

        return redirect()->route('ppdb.dashboard')
            ->with('success', 'Kontak orang tua berhasil disimpan!');
    }
}
