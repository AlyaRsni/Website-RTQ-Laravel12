@extends('layouts.dashboard')

@section('title', 'Preview & Finalisasi — PPDB RTQ Kawali')
@section('page_title', 'Preview & Finalisasi')
@section('page_subtitle', 'Step 5 — Review data sebelum mengirim')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{ confirmed: false }">

    {{-- Warning Card --}}
    @if(!$registration->isFinalized())
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/15 dark:to-orange-900/15 rounded-2xl border border-amber-200/60 dark:border-amber-800/30 p-5">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-100 dark:bg-amber-800/30 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">⚠️ Perhatian</h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Setelah Anda mengirim data, <strong>data tidak dapat diubah lagi</strong> kecuali diminta perbaikan oleh Ustadz PPDB. 
                    Pastikan semua data sudah benar sebelum mengirim.
                </p>
            </div>
        </div>
    </div>
    @endif

    {{-- Already finalized --}}
    @if($registration->isFinalized())
    <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-200 dark:border-emerald-800/30 p-5 text-center">
        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center">
            <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Data Sudah Dikirim ✅</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">Dikirim pada {{ $registration->finalisasi_at->format('d M Y, H:i') }} WIB</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-4">
        <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Preview: Data Diri --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-800/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Data Diri</h2>
            </div>
            @if(!$registration->isFinalized())
            <a href="{{ route('ppdb.step.2') }}" class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline">Edit ✏️</a>
            @endif
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                @php
                    $dataFields = [
                        'Nama Lengkap' => $registration->nama_lengkap,
                        'Tempat Lahir' => $registration->tempat_lahir,
                        'Tanggal Lahir' => $registration->tanggal_lahir?->format('d M Y'),
                        'Asal Sekolah' => $registration->asal_sekolah,
                        'NISN' => $registration->nisn,
                        'Pernah Hafal Qur\'an' => $registration->pernah_hafal_quran ? 'Ya' : 'Belum',
                        'Jumlah Hafalan' => $registration->jumlah_hafalan ?: '-',
                        'Anak Ke' => $registration->anak_ke,
                        'Jumlah Saudara' => $registration->jumlah_saudara,
                        'Nama Ayah' => $registration->nama_ayah,
                        'Pekerjaan Ayah' => $registration->pekerjaan_ayah,
                        'Nama Ibu' => $registration->nama_ibu,
                        'Pekerjaan Ibu' => $registration->pekerjaan_ibu,
                    ];
                @endphp
                @foreach($dataFields as $label => $value)
                <div>
                    <dt class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $label }}</dt>
                    <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white">{{ $value ?? '-' }}</dd>
                </div>
                @endforeach
            </dl>
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/40">
                <dt class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Alamat Rumah</dt>
                <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white leading-relaxed">{{ $registration->alamat_rumah ?? '-' }}</dd>
            </div>
        </div>
    </div>

    {{-- Preview: Kontak --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-cyan-100 dark:bg-cyan-800/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Kontak Orang Tua</h2>
            </div>
            @if(!$registration->isFinalized())
            <a href="{{ route('ppdb.step.3') }}" class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline">Edit ✏️</a>
            @endif
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">No HP Ayah (WA)</dt>
                    <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white font-mono">+{{ $registration->no_hp_ayah ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">No HP Ibu (WA)</dt>
                    <dd class="mt-0.5 text-sm font-medium text-gray-900 dark:text-white font-mono">+{{ $registration->no_hp_ibu ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Preview: Berkas --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Berkas</h2>
            </div>
            @if(!$registration->isFinalized())
            <a href="{{ route('ppdb.step.4') }}" class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline">Edit ✏️</a>
            @endif
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @php
                    $berkas = [
                        ['label' => 'Bukti Pembayaran', 'file' => $registration->bukti_pembayaran, 'icon' => '💳'],
                        ['label' => 'Kartu Keluarga', 'file' => $registration->kartu_keluarga, 'icon' => '📄'],
                        ['label' => 'Foto 3x4', 'file' => $registration->foto_3x4, 'icon' => '📷'],
                        ['label' => 'Ijazah / Raport', 'file' => $registration->ijazah_raport, 'icon' => '📜'],
                    ];
                @endphp
                @foreach($berkas as $doc)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/30">
                    <span class="text-lg">{{ $doc['icon'] }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $doc['label'] }}</p>
                    </div>
                    @if($doc['file'])
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 uppercase">
                        ✓ Ada
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 uppercase">
                        ✕ Belum
                    </span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Finalization --}}
    @if(!$registration->isFinalized())
    <form action="{{ route('ppdb.step.5.finalize') }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm p-6">
            {{-- Confirmation Checkbox --}}
            <div class="flex items-start gap-3 mb-6">
                <input type="checkbox" id="konfirmasi" name="konfirmasi" x-model="confirmed"
                    class="w-5 h-5 mt-0.5 rounded-md border-2 border-gray-300 dark:border-gray-600 text-purple-600 focus:ring-purple-500 dark:bg-gray-800 transition-colors cursor-pointer">
                <label for="konfirmasi" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed cursor-pointer">
                    <strong class="text-gray-900 dark:text-white">Saya yakin data sudah benar.</strong>
                    <br>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Dengan mengirim data, saya menyatakan bahwa seluruh informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                    </span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit" :disabled="!confirmed"
                class="w-full py-4 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 text-white font-extrabold rounded-2xl hover:from-purple-700 hover:via-purple-800 hover:to-indigo-800 shadow-xl shadow-purple-600/30 hover:shadow-2xl hover:shadow-purple-600/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-xl text-sm flex items-center justify-center gap-2.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                🚀 Kirim Data Pendaftaran (Final)
            </button>
        </div>
    </form>
    @endif

    <div class="text-center">
        <a href="{{ route('ppdb.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
