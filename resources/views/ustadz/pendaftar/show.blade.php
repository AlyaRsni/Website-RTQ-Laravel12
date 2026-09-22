@extends('layouts.ustadz')

@section('title', 'Review Pendaftar — Ustadz RTQ Kawali')
@section('page_title', 'Review Pendaftar')
@section('page_subtitle', $registration->nama_lengkap ?? $registration->user->name ?? 'Data Pendaftar')

@section('content')
<div class="space-y-5 max-w-4xl">
    <a href="{{ route('ustadz.pendaftar.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    {{-- Header --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-xl font-bold text-teal-600 dark:text-teal-400">
                {{ strtoupper(substr($registration->user->name ?? '?', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $registration->nama_lengkap ?? $registration->user->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $registration->user->phone ?? '-' }} · {{ $registration->nomor_peserta ?? 'Belum ada nomor' }}</p>
                @php
                    $badge = match($registration->status_verifikasi) {
                        'terverifikasi' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                        'menunggu_verifikasi_berkas' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                        'perlu_perbaikan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                        default => 'bg-gray-100 dark:bg-gray-800 text-gray-500',
                    };
                @endphp
                <span class="inline-block mt-2 px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ $registration->getStepStatus(6) }}</span>
            </div>
        </div>
    </div>

    {{-- Data Sections --}}
    @php
        $sections = [
            'Data Diri' => [
                ['label' => 'Nama Lengkap', 'value' => $registration->nama_lengkap],
                ['label' => 'TTL', 'value' => ($registration->tempat_lahir ?? '-') . ', ' . ($registration->tanggal_lahir?->format('d F Y') ?? '-')],
                ['label' => 'Asal Sekolah', 'value' => $registration->asal_sekolah],
                ['label' => 'NISN', 'value' => $registration->nisn],
                ['label' => 'Hafalan', 'value' => $registration->pernah_hafal_quran ? 'Ya (' . ($registration->jumlah_hafalan ?? '-') . ')' : 'Belum'],
            ],
            'Keluarga' => [
                ['label' => 'Ayah', 'value' => ($registration->nama_ayah ?? '-') . ' — ' . ($registration->pekerjaan_ayah ?? '-')],
                ['label' => 'HP Ayah', 'value' => $registration->no_hp_ayah],
                ['label' => 'Ibu', 'value' => ($registration->nama_ibu ?? '-') . ' — ' . ($registration->pekerjaan_ibu ?? '-')],
                ['label' => 'HP Ibu', 'value' => $registration->no_hp_ibu],
                ['label' => 'Alamat', 'value' => $registration->alamat_rumah],
            ],
        ];
    @endphp

    @foreach($sections as $sectionTitle => $fields)
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $sectionTitle }}</h3>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/20">
            @foreach($fields as $field)
            <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 sm:w-32 shrink-0">{{ $field['label'] }}</span>
                <span class="text-sm text-gray-900 dark:text-white">{{ $field['value'] ?? '-' }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Berkas (dengan download links) --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Berkas</h3>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/20">
            @php
                $files = [
                    ['label' => 'Bukti Pembayaran', 'field' => 'bukti_pembayaran', 'type' => 'bukti_pembayaran'],
                    ['label' => 'Kartu Keluarga', 'field' => 'kartu_keluarga', 'type' => 'kartu_keluarga'],
                    ['label' => 'Foto 3x4', 'field' => 'foto_3x4', 'type' => 'foto_3x4'],
                    ['label' => 'Ijazah/Raport', 'field' => 'ijazah_raport', 'type' => 'ijazah_raport'],
                ];
            @endphp
            @foreach($files as $file)
            <div class="px-5 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 w-36 shrink-0">{{ $file['label'] }}</span>
                    @if($registration->{$file['field']})
                        <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">✅ Terupload</span>
                    @else
                        <span class="text-xs font-semibold text-gray-400">❌ Belum</span>
                    @endif
                </div>
                @if($registration->{$file['field']})
                <div class="flex items-center gap-2">
                    <a href="{{ route('ustadz.pendaftar.file.preview', [$registration->id, $file['type']]) }}"
                        target="_blank"
                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                        👁 Preview
                    </a>
                    <a href="{{ route('ustadz.pendaftar.file', [$registration->id, $file['type']]) }}"
                        class="px-3 py-1.5 text-xs font-semibold text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/20 rounded-lg hover:bg-teal-100 dark:hover:bg-teal-900/40 transition-colors">
                        📥 Download
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Verification Form --}}
    @if($registration->finalisasi_at)
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-teal-50/50 dark:bg-teal-900/10">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">📝 Form Verifikasi</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Tentukan status verifikasi pendaftar ini</p>
        </div>
        <form action="{{ route('ustadz.pendaftar.verify', $registration->id) }}" method="POST" class="p-5 space-y-4" x-data="{ status: '{{ $registration->status_verifikasi }}' }">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all"
                    :class="status === 'terverifikasi' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-emerald-300'">
                    <input type="radio" name="status" value="terverifikasi" x-model="status" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Terverifikasi ✅</p>
                        <p class="text-xs text-gray-500">Berkas & pembayaran lengkap</p>
                    </div>
                </label>

                <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all"
                    :class="status === 'perlu_perbaikan' ? 'border-orange-500 bg-orange-50 dark:bg-orange-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-orange-300'">
                    <input type="radio" name="status" value="perlu_perbaikan" x-model="status" class="sr-only">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-800/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Perlu Perbaikan ⚠️</p>
                        <p class="text-xs text-gray-500">Ada yang perlu diperbaiki</p>
                    </div>
                </label>
            </div>

            <div x-show="status === 'perlu_perbaikan'" x-transition style="display:none">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Catatan Perbaikan</label>
                <textarea name="catatan" rows="3" placeholder="Jelaskan apa yang perlu diperbaiki..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none">{{ $registration->catatan_perbaikan }}</textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-teal-600 text-white font-bold rounded-xl hover:bg-teal-700 shadow-lg shadow-teal-600/20 transition-all text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Verifikasi
            </button>
        </form>
    </div>
    @else
    <div class="bg-amber-50 dark:bg-amber-900/10 rounded-2xl border border-amber-200 dark:border-amber-800/30 p-5 text-center">
        <p class="text-sm font-medium text-amber-700 dark:text-amber-300">⏳ Pendaftar belum melakukan finalisasi.</p>
        <p class="text-xs text-amber-500 dark:text-amber-400 mt-1">Verifikasi hanya dapat dilakukan setelah pendaftar mengirim data finalisasi.</p>
    </div>
    @endif
</div>
@endsection
