@extends('layouts.ustadz-halaqah')
@section('title', 'Ujian Hafalan — Ustadz Halaqah')
@section('page_title', 'Ujian Hafalan')
@section('page_subtitle', 'Penilaian ujian hafalan Al-Quran santri')

@section('content')
<div x-data="{ showForm: false, saving: false }">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.ujian-hafalan.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
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
            <div class="w-full sm:w-48">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori</label>
                <select name="kategori"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="per_juz" {{ $kategoriFilter === 'per_juz' ? 'selected' : '' }}>Ujian Per Juz</option>
                    <option value="semester" {{ $kategoriFilter === 'semester' ? 'selected' : '' }}>Ujian Semester</option>
                    <option value="bulanan" {{ $kategoriFilter === 'bulanan' ? 'selected' : '' }}>Ujian Bulanan</option>
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
            <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat ujian hafalan santri</p>
        </div>
        <button @click="showForm = !showForm"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Input Ujian Hafalan
        </button>
    </div>

    {{-- Add Form --}}
    <div x-show="showForm" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            Input Hasil Ujian Hafalan
        </h4>
        <form action="{{ route('siakad.ustadz.ujian-hafalan.store') }}" method="POST" @submit="saving = true">
            @csrf
            <input type="hidden" name="halaqah_id" value="{{ $selectedHalaqah->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                {{-- Santri --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Santri <span class="text-red-500">*</span></label>
                    <select name="santri_id" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">— Pilih Santri —</option>
                        @foreach($selectedHalaqah->santris as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kategori Ujian --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori Ujian <span class="text-red-500">*</span></label>
                    <select name="kategori" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="per_juz">Ujian Per Juz</option>
                        <option value="semester">Ujian Semester</option>
                        <option value="bulanan">Ujian Bulanan</option>
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Ujian <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_ujian" value="{{ now()->format('Y-m-d') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>

                {{-- Juz --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Juz</label>
                    <input type="number" name="juz" min="1" max="30" placeholder="1-30"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>

                {{-- Surah Mulai --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Dari Surah</label>
                    <input type="text" name="surat_mulai" placeholder="Contoh: Al-Baqarah"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>

                {{-- Surah Selesai --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Sampai Surah</label>
                    <input type="text" name="surat_selesai" placeholder="Contoh: Ali Imran"
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                </div>

                {{-- Ayat Range --}}
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ayat Mulai</label>
                        <input type="number" name="ayat_mulai" min="1" placeholder="1"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ayat Selesai</label>
                        <input type="number" name="ayat_selesai" min="1" placeholder="286"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Nilai Bacaan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nilai Bacaan <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai_bacaan" min="0" max="100" placeholder="0-100" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <p class="text-[10px] text-gray-400 mt-1">Tajwid, makhorijul huruf, kelancaran</p>
                </div>

                {{-- Nilai Hafalan --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nilai Hafalan <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai_hafalan" min="0" max="100" placeholder="0-100" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <p class="text-[10px] text-gray-400 mt-1">Kelancaran, kesesuaian hafalan</p>
                </div>
            </div>

            {{-- Catatan & Evaluasi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan tentang ujian..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Evaluasi</label>
                    <textarea name="evaluasi" rows="3" placeholder="Evaluasi dan saran untuk santri..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 disabled:bg-amber-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                    <svg x-show="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <span x-text="saving ? 'Menyimpan...' : 'Simpan Hasil Ujian'"></span>
                </button>
                <button type="button" @click="showForm = false" class="px-4 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Ujian', 'count' => $exams->count(), 'color' => 'amber', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ['label' => 'Per Juz', 'count' => $exams->where('kategori', 'per_juz')->count(), 'color' => 'blue', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['label' => 'Semester', 'count' => $exams->where('kategori', 'semester')->count(), 'color' => 'indigo', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['label' => 'Bulanan', 'count' => $exams->where('kategori', 'bulanan')->count(), 'color' => 'emerald', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ];
        @endphp
        @foreach($statCards as $stat)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $stat['count'] }}</p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- History Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        @if($exams->isEmpty())
            <div class="p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada hasil ujian hafalan</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Klik "Input Ujian Hafalan" untuk mulai mencatat</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700/50">
                            <th class="text-left px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Tanggal</th>
                            <th class="text-left px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Santri</th>
                            <th class="text-center px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Kategori</th>
                            <th class="text-center px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Juz</th>
                            <th class="text-left px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Range Surah</th>
                            <th class="text-center px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Bacaan</th>
                            <th class="text-center px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Hafalan</th>
                            <th class="text-center px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Rata²</th>
                            <th class="text-left px-5 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($exams as $exam)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="px-5 py-4 text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ $exam->tanggal_ujian->format('d/m/Y') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($exam->santri->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $exam->santri->nama_lengkap ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $katColor = match($exam->kategori) {
                                        'per_juz'  => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                        'semester' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300',
                                        'bulanan'  => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $katColor }}">
                                    {{ $exam->kategori_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">{{ $exam->juz ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                {{ $exam->range_surah }}
                                @if($exam->ayat_mulai || $exam->ayat_selesai)
                                    <span class="text-gray-400 text-xs">({{ $exam->ayat_mulai ?? '?' }} - {{ $exam->ayat_selesai ?? '?' }})</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold {{ $exam->nilai_bacaan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($exam->nilai_bacaan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $exam->nilai_bacaan }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold {{ $exam->nilai_hafalan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($exam->nilai_hafalan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $exam->nilai_hafalan }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $avg = $exam->rata_rata;
                                    $avgColor = $avg >= 80 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : ($avg >= 60 ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300');
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $avgColor }}">
                                    {{ $avg }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-500 dark:text-gray-400 max-w-[200px]">
                                @if($exam->catatan)
                                    <p class="text-xs truncate" title="{{ $exam->catatan }}">{{ $exam->catatan }}</p>
                                @endif
                                @if($exam->evaluasi)
                                    <p class="text-xs text-amber-600 dark:text-amber-400 truncate mt-0.5" title="{{ $exam->evaluasi }}">📝 {{ $exam->evaluasi }}</p>
                                @endif
                                @if(!$exam->catatan && !$exam->evaluasi)
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
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
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah untuk melihat ujian hafalan</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan filter di atas untuk menampilkan data</p>
        </div>
    @endif
</div>
@endsection
