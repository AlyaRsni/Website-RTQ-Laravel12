@extends('layouts.ustadz-halaqah')
@section('title', 'Jurnal Hafalan — Ustadz Halaqah')
@section('page_title', 'Jurnal Hafalan')
@section('page_subtitle', 'Pencatatan hafalan Al-Quran santri')

@section('content')
<div x-data="{ showForm: false, saving: false }">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.hafalan.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
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
            <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat jurnal hafalan terbaru</p>
        </div>
        <button @click="showForm = !showForm"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Hafalan
        </button>
    </div>

    {{-- Add Form --}}
    <div x-show="showForm" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Input Jurnal Hafalan Baru</h4>
        <form action="{{ route('siakad.ustadz.hafalan.store') }}" method="POST" @submit="saving = true">
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
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Jenis</label>
                    <select name="jenis" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="ziyadah">Ziyadah (Hafalan Baru)</option>
                        <option value="murojaah">Murojaah (Pengulangan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Surat</label>
                    <input type="text" name="surat" placeholder="Contoh: Al-Baqarah"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ayat Mulai</label>
                        <input type="number" name="ayat_mulai" min="1" placeholder="1"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ayat Selesai</label>
                        <input type="number" name="ayat_selesai" min="1" placeholder="10"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Juz</label>
                    <input type="number" name="juz" min="1" max="30" placeholder="1-30"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kualitas</label>
                    <select name="kualitas" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="mumtaz">Mumtaz (Istimewa)</option>
                        <option value="jayyid_jiddan">Jayyid Jiddan (Sangat Baik)</option>
                        <option value="jayyid" selected>Jayyid (Baik)</option>
                        <option value="maqbul">Maqbul (Cukup)</option>
                        <option value="perlu_perbaikan">Perlu Perbaikan</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan</label>
                    <input type="text" name="catatan" placeholder="Catatan opsional..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 disabled:bg-amber-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                    <svg x-show="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Hafalan'"></span>
                </button>
                <button type="button" @click="showForm = false" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- History Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        @if($journals->isEmpty())
            <div class="p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada jurnal hafalan</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Klik "Tambah Hafalan" untuk mulai mencatat</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/50">
                            <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Santri</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Jenis</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Surat / Ayat</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Juz</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Kualitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($journals as $j)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $j->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($j->santri->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $j->santri->nama_lengkap ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ $j->jenis === 'ziyadah' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' }}">
                                    {{ ucfirst($j->jenis) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $j->surat ?? '-' }}
                                @if($j->ayat_mulai)
                                    <span class="text-gray-400 dark:text-gray-500">: {{ $j->ayat_mulai }}{{ $j->ayat_selesai ? ' - ' . $j->ayat_selesai : '' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">{{ $j->juz ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $kualitasColor = match($j->kualitas) {
                                        'mumtaz' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                        'jayyid_jiddan' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                        'jayyid' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300',
                                        'maqbul' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                        'perlu_perbaikan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                        default => 'bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $kualitasColor }}">
                                    {{ $j->kualitas_label }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah untuk melihat jurnal hafalan</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan filter di atas untuk menampilkan riwayat hafalan</p>
        </div>
    @endif
</div>
@endsection
