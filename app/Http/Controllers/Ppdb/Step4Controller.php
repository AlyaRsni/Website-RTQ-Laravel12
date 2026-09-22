<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Step4Controller extends Controller
{
    public function show()
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(4)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi kontak orang tua terlebih dahulu.');
        }

        return view('ppdb.steps.step4', [
            'registration' => $registration,
        ]);
    }

    public function upload(Request $request)
    {
        $registration = Auth::user()->ppdbRegistration;

        if (!$registration->isStepAccessible(4)) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Lengkapi kontak orang tua terlebih dahulu.');
        }

        if ($registration->isFinalized()) {
            return redirect()->route('ppdb.dashboard')
                ->with('error', 'Data sudah dikirim dan tidak bisa diubah.');
        }

        $isDraft = $request->has('save_draft');

        $rules = [
            'kartu_keluarga' => ($isDraft ? 'nullable' : ($registration->kartu_keluarga ? 'nullable' : 'required')) . '|file|mimes:pdf|max:10240',
            'foto_3x4' => ($isDraft ? 'nullable' : ($registration->foto_3x4 ? 'nullable' : 'required')) . '|file|mimes:jpg,jpeg|max:10240',
            'ijazah_raport' => ($isDraft ? 'nullable' : ($registration->ijazah_raport ? 'nullable' : 'required')) . '|file|mimes:pdf|max:10240',
        ];

        $messages = [
            'kartu_keluarga.required' => 'Kartu Keluarga wajib diupload.',
            'kartu_keluarga.mimes' => 'Kartu Keluarga harus berformat PDF.',
            'kartu_keluarga.max' => 'Ukuran file maksimal 10MB.',
            'foto_3x4.required' => 'Foto 3x4 wajib diupload.',
            'foto_3x4.mimes' => 'Foto 3x4 harus berformat JPG/JPEG.',
            'foto_3x4.max' => 'Ukuran file maksimal 10MB.',
            'ijazah_raport.required' => 'Ijazah/Raport wajib diupload.',
            'ijazah_raport.mimes' => 'Ijazah/Raport harus berformat PDF.',
            'ijazah_raport.max' => 'Ukuran file maksimal 10MB.',
        ];

        $request->validate($rules, $messages);

        $userId = Auth::id();
        $updates = [];

        if ($request->hasFile('kartu_keluarga')) {
            if ($registration->kartu_keluarga) {
                Storage::disk('ppdb')->delete($registration->kartu_keluarga);
            }
            $updates['kartu_keluarga'] = $request->file('kartu_keluarga')
                ->storeAs($userId, 'kartu_keluarga.pdf', 'ppdb');
        }

        if ($request->hasFile('foto_3x4')) {
            if ($registration->foto_3x4) {
                Storage::disk('ppdb')->delete($registration->foto_3x4);
            }
            $ext = $request->file('foto_3x4')->getClientOriginalExtension();
            $updates['foto_3x4'] = $request->file('foto_3x4')
                ->storeAs($userId, 'foto_3x4.' . $ext, 'ppdb');
        }

        if ($request->hasFile('ijazah_raport')) {
            if ($registration->ijazah_raport) {
                Storage::disk('ppdb')->delete($registration->ijazah_raport);
            }
            $updates['ijazah_raport'] = $request->file('ijazah_raport')
                ->storeAs($userId, 'ijazah_raport.pdf', 'ppdb');
        }

        // Determine status
        $reg = $registration->fresh();
        $hasKk = isset($updates['kartu_keluarga']) || $reg->kartu_keluarga;
        $hasFoto = isset($updates['foto_3x4']) || $reg->foto_3x4;
        $hasIjazah = isset($updates['ijazah_raport']) || $reg->ijazah_raport;

        if ($isDraft) {
            $updates['status_berkas'] = ($hasKk || $hasFoto || $hasIjazah) ? 'draft' : 'belum_upload';
        } else {
            $updates['status_berkas'] = ($hasKk && $hasFoto && $hasIjazah) ? 'selesai' : 'draft';
        }

        $registration->update($updates);

        $msg = $isDraft ? 'Berkas disimpan sebagai draft.' : 'Berkas berhasil diupload!';
        return redirect()->route($isDraft ? 'ppdb.step.4' : 'ppdb.dashboard')
            ->with('success', $msg);
    }
}
