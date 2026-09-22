@extends('layouts.ustadz-halaqah')
@section('title', 'Kedisiplinan — Ustadz Halaqah')
@section('page_title', 'Kedisiplinan')
@section('page_subtitle', 'Pencatatan pelanggaran dan prestasi santri')

@section('content')
<div x-data="{ showForm: false, saving: false }">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.disiplin.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pilih Halaqah</label>
                <select name="halaqah_id" required
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <option value="">— Pilih Halaqah —</option>
                    @foreach($halaqahs as $hq)
                        <option value="{{ $hq->id }}" {{ request('halaqah_id') == $hq->id ? 'selected' : '' }}>
                            {{ $hq->nama }} ({{ $hq->semester->academicYear->nama ?? '' }} — {{ ucfirst($hq->semester->tipe ?? '') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                Tampilkan
            </button>
        </form>
    </div>

    @if($selectedHalaqah)
    {{-- Header + Add Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $selectedHalaqah->nama }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat catatan kedisiplinan</p>
        </div>
        <button @click="showForm = !showForm"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Catatan
        </button>
    </div>

    {{-- Add Form --}}
    <div x-show="showForm" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Input Catatan Kedisiplinan Baru</h4>
        <form action="{{ route('siakad.ustadz.disiplin.store') }}" method="POST" @submit="saving = true">
            @csrf
            <input type="hidden" name="halaqah_id" value="{{ $selectedHalaqah->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Santri</label>
                    <select name="santri_id" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">— Pilih Santri —</option>
                        @foreach($selectedHalaqah->santris as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ now()->format('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tipe</label>
                    <select name="tipe" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="pelanggaran">⚠️ Pelanggaran</option>
                        <option value="prestasi">🌟 Prestasi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Judul</label>
                    <input type="text" name="judul" placeholder="Contoh: Terlambat shalat berjamaah" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Poin</label>
                    <input type="number" name="poin" min="0" value="0" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Deskripsi kejadian..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 disabled:bg-amber-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                    <svg x-show="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Catatan'"></span>
                </button>
                <button type="button" @click="showForm = false" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- History --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        @if($notes->isEmpty())
            <div class="p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada catatan kedisiplinan</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Klik "Tambah Catatan" untuk mulai mencatat</p>
            </div>
        @else
            <div class="divide-y divide-gray-50 dark:divide-gray-800">
                @foreach($notes as $note)
                <div class="px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                            {{ $note->tipe === 'pelanggaran' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30' }}">
                            @if($note->tipe === 'pelanggaran')
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @else
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $note->judul }}</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold
                                    {{ $note->tipe === 'pelanggaran' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' }}">
                                    {{ ucfirst($note->tipe) }}
                                </span>
                                @if($note->poin > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold
                                    {{ $note->tipe === 'pelanggaran' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' }}">
                                    {{ $note->tipe === 'pelanggaran' ? '-' : '+' }}{{ $note->poin }} poin
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-5 h-5 rounded bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-[9px] font-bold">
                                    {{ strtoupper(substr($note->santri->nama_lengkap ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $note->santri->nama_lengkap ?? '-' }}</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">•</span>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $note->tanggal->format('d/m/Y') }}</span>
                            </div>
                            @if($note->deskripsi)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $note->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    @elseif(request('halaqah_id'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-6 text-center">
            <p class="text-sm font-semibold text-red-600 dark:text-red-400">Halaqah tidak ditemukan atau bukan milik Anda</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah untuk melihat catatan kedisiplinan</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan filter di atas untuk menampilkan riwayat</p>
        </div>
    @endif
</div>
@endsection
