<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Step2Controller extends Controller
{
    public function show()
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(2)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Silakan upload bukti pembayaran terlebih dahulu.');
        }

        return view('ppdb.steps.step2', [
            'registration' => $registration,
        ]);
    }

    public function save(Request $request)
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(2)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Silakan upload bukti pembayaran terlebih dahulu.');
        }

        if ($registration->isFinalized()) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Data sudah dikirim dan tidak bisa diubah.');
        }

        $isDraft = $request->has('save_draft');

        $rules = [
            'nama_lengkap' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'tempat_lahir' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'tanggal_lahir' => $isDraft ? 'nullable|date' : 'required|date|before:today',
            'asal_sekolah' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'nisn' => $isDraft ? 'nullable|string|max:20' : 'required|string|max:20',
            'pernah_hafal_quran' => 'nullable|boolean',
            'jumlah_hafalan' => 'nullable|string|max:255',
            'anak_ke' => $isDraft ? 'nullable|integer|min:1' : 'required|integer|min:1',
            'jumlah_saudara' => $isDraft ? 'nullable|integer|min:0' : 'required|integer|min:0',
            'nama_ayah' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'pekerjaan_ayah' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'nama_ibu' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'pekerjaan_ibu' => $isDraft ? 'nullable|string|max:255' : 'required|string|max:255',
            'alamat_rumah' => $isDraft ? 'nullable|string' : 'required|string',
        ];

        $messages = [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'anak_ke.required' => 'Anak ke berapa wajib diisi.',
            'jumlah_saudara.required' => 'Jumlah saudara wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'pekerjaan_ayah.required' => 'Pekerjaan ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'pekerjaan_ibu.required' => 'Pekerjaan ibu wajib diisi.',
            'alamat_rumah.required' => 'Alamat rumah wajib diisi.',
        ];

        $validated = $request->validate($rules, $messages);
        $validated['pernah_hafal_quran'] = $request->boolean('pernah_hafal_quran');
        $validated['status_data_diri'] = $isDraft ? 'draft' : 'selesai';

        $registration->update($validated);

        $msg = $isDraft ? 'Data disimpan sebagai draft.' : 'Data diri berhasil disimpan!';
        return redirect()->route($isDraft ? 'ppdb.step.2' : 'ppdb.dashboard')
            ->with('success', $msg);
    }
}
