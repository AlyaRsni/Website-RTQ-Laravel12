@extends('layouts.ustadz-halaqah')
@section('title', 'Input Nilai — Ustadz Halaqah')
@section('page_title', 'Input Nilai')
@section('page_subtitle', 'Penilaian mata pelajaran per halaqah')

@section('content')
<div x-data="{ saving: false }">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.nilai.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
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
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Mata Pelajaran</label>
                <select name="subject_id" required
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <option value="">— Pilih Mata Pelajaran —</option>
                    @foreach($subjects as $subj)
                        <option value="{{ $subj->id }}" {{ request('subject_id') == $subj->id ? 'selected' : '' }}>
                            [{{ $subj->kode }}] {{ $subj->nama }} — {{ $subj->category->nama ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Grades Table --}}
    @if($selectedHalaqah && $selectedSubject)
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $selectedHalaqah->nama }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Mata Pelajaran: <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $selectedSubject->nama }}</span></p>
                </div>
                <span class="inline-flex items-center px-3 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-lg">
                    {{ $grades->count() }} santri
                </span>
            </div>
        </div>

        @if($grades->isEmpty())
            <div class="p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Halaqah ini belum memiliki santri</p>
            </div>
        @else
            <form action="{{ route('siakad.ustadz.nilai.store') }}" method="POST" @submit="saving = true">
                @csrf
                <input type="hidden" name="halaqah_id" value="{{ $selectedHalaqah->id }}">
                <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider w-12">No</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nama Santri</th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nilai Tersimpan</th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Tipe</th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nilai Baru</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($grades as $idx => $santri)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4">
                                    <input type="hidden" name="nilai[{{ $idx }}][santri_id]" value="{{ $santri->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($santri->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{ $santri->nis }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($santri->existing_grades->isNotEmpty())
                                        <div class="flex flex-wrap justify-center gap-1.5">
                                            @foreach($santri->existing_grades as $eg)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg">
                                                    {{ ucfirst($eg->tipe) }}: <span class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($eg->nilai, 0) }}</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <select name="nilai[{{ $idx }}][tipe]"
                                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm text-center focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                        <option value="harian">Harian</option>
                                        <option value="tugas">Tugas</option>
                                        <option value="uts">UTS</option>
                                        <option value="uas">UAS</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" name="nilai[{{ $idx }}][nilai]" min="0" max="100" step="0.01" placeholder="0-100" required
                                        class="w-24 mx-auto block px-3 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm text-center focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="nilai[{{ $idx }}][catatan]" placeholder="Opsional..."
                                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50 flex justify-end">
                    <button type="submit" :disabled="saving"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 disabled:bg-amber-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all duration-200">
                        <svg x-show="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <svg x-show="!saving" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="saving ? 'Menyimpan...' : 'Simpan Nilai'"></span>
                    </button>
                </div>
            </form>
        @endif
    </div>
    @elseif(request('halaqah_id'))
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30 rounded-2xl p-6 text-center">
            <p class="text-sm font-semibold text-amber-700 dark:text-amber-300">Pilih halaqah dan mata pelajaran terlebih dahulu</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah dan mata pelajaran untuk input nilai</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan filter di atas untuk menampilkan daftar santri</p>
        </div>
    @endif
</div>
@endsection
