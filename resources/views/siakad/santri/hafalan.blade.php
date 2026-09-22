@extends('layouts.santri')
@section('title', 'Hafalan — Santri')
@section('page_title', 'Hafalan')
@section('page_subtitle', 'Ringkasan hafalan & hasil ujian')

@section('content')
<div class="space-y-6">
    {{-- Month Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <form method="GET" action="{{ route('siakad.santri.hafalan') }}" class="flex flex-wrap items-end gap-4">
            <div class="w-32">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Bulan</label>
                <select name="bulan"
                    class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-28">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun</label>
                <select name="tahun"
                    class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- RINGKASAN HAFALAN BULANAN                   --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            Ringkasan Hafalan — {{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}
        </h3>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-blue-100/60 dark:border-blue-800/30">
                <p class="text-2xl font-extrabold text-blue-700 dark:text-blue-300">{{ $journals->count() }}</p>
                <p class="text-[11px] font-semibold text-blue-500/70 dark:text-blue-400/60 mt-0.5">Total Hafalan</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-4 border border-emerald-100/60 dark:border-emerald-800/30">
                <p class="text-2xl font-extrabold text-emerald-700 dark:text-emerald-300">{{ $totalZiyadah }}</p>
                <p class="text-[11px] font-semibold text-emerald-500/70 dark:text-emerald-400/60 mt-0.5">Ziyadah</p>
            </div>
            <div class="bg-gradient-to-br from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20 rounded-xl p-4 border border-cyan-100/60 dark:border-cyan-800/30">
                <p class="text-2xl font-extrabold text-cyan-700 dark:text-cyan-300">{{ $totalMurojaah }}</p>
                <p class="text-[11px] font-semibold text-cyan-500/70 dark:text-cyan-400/60 mt-0.5">Murojaah</p>
            </div>
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4 border border-amber-100/60 dark:border-amber-800/30">
                @php
                    $juzSet = $journals->pluck('juz')->filter()->unique();
                @endphp
                <p class="text-2xl font-extrabold text-amber-700 dark:text-amber-300">{{ $juzSet->count() }}</p>
                <p class="text-[11px] font-semibold text-amber-500/70 dark:text-amber-400/60 mt-0.5">Juz Disentuh</p>
            </div>
        </div>

        {{-- Kualitas Breakdown --}}
        @if($journals->isNotEmpty())
        <div class="mb-5">
            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Distribusi Kualitas</p>
            <div class="flex flex-wrap gap-2">
                @php
                    $kualitasLabels = [
                        'mumtaz' => ['label' => 'Mumtaz', 'color' => 'emerald'],
                        'jayyid_jiddan' => ['label' => 'Jayyid Jiddan', 'color' => 'blue'],
                        'jayyid' => ['label' => 'Jayyid', 'color' => 'indigo'],
                        'maqbul' => ['label' => 'Maqbul', 'color' => 'amber'],
                        'perlu_perbaikan' => ['label' => 'Perlu Perbaikan', 'color' => 'red'],
                    ];
                @endphp
                @foreach($kualitasLabels as $key => $meta)
                    @if(($kualitasStats[$key] ?? 0) > 0)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-{{ $meta['color'] }}-100 dark:bg-{{ $meta['color'] }}-900/30 text-{{ $meta['color'] }}-700 dark:text-{{ $meta['color'] }}-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-{{ $meta['color'] }}-500"></span>
                        {{ $meta['label'] }}: {{ $kualitasStats[$key] }}
                    </span>
                    @endif
                @endforeach
                @if($kualitasStats->isEmpty())
                    <span class="text-xs text-gray-400">Belum ada data</span>
                @endif
            </div>
        </div>
        @endif

        {{-- Hafalan Table --}}
        @if($journals->isEmpty())
            <div class="text-center py-8">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">Belum ada catatan hafalan bulan ini</p>
            </div>
        @else
            <div class="overflow-x-auto -mx-5">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-t border-gray-100 dark:border-gray-700/50">
                            <th class="text-left px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="text-center px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Jenis</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Surat / Ayat</th>
                            <th class="text-center px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Juz</th>
                            <th class="text-center px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Kualitas</th>
                            <th class="text-left px-5 py-3 font-semibold text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($journals as $j)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                            <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $j->tanggal->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $j->jenis === 'ziyadah' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' }}">{{ ucfirst($j->jenis) }}</span>
                            </td>
                            <td class="px-5 py-3 text-gray-700 dark:text-gray-300">
                                {{ $j->surat ?? '-' }}
                                @if($j->ayat_mulai)
                                    <span class="text-gray-400">: {{ $j->ayat_mulai }}{{ $j->ayat_selesai ? ' - ' . $j->ayat_selesai : '' }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center text-gray-600 dark:text-gray-400">{{ $j->juz ?? '-' }}</td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $kColor = match($j->kualitas) {
                                        'mumtaz' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                        'jayyid_jiddan' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                        'jayyid' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300',
                                        'maqbul' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                        'perlu_perbaikan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $kColor }}">{{ $j->kualitas_label }}</span>
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400 max-w-[150px] truncate">{{ $j->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- HASIL UJIAN HAFALAN                         --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                Hasil Ujian Hafalan
            </h3>
            {{-- Category filter --}}
            <form method="GET" action="{{ route('siakad.santri.hafalan') }}" class="flex items-center gap-2">
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <select name="kategori_ujian" onchange="this.form.submit()"
                    class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-xs focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="per_juz" {{ $kategoriFilter === 'per_juz' ? 'selected' : '' }}>Per Juz</option>
                    <option value="semester" {{ $kategoriFilter === 'semester' ? 'selected' : '' }}>Semester</option>
                    <option value="bulanan" {{ $kategoriFilter === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </form>
        </div>

        {{-- Exam Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-5">
            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-3 text-center">
                <p class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $examStats['total'] }}</p>
                <p class="text-[10px] font-semibold text-gray-400 dark:text-gray-500">Total Ujian</p>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-center">
                <p class="text-lg font-extrabold text-blue-700 dark:text-blue-300">{{ $examStats['per_juz'] }}</p>
                <p class="text-[10px] font-semibold text-blue-400 dark:text-blue-500">Per Juz</p>
            </div>
            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-3 text-center">
                <p class="text-lg font-extrabold text-indigo-700 dark:text-indigo-300">{{ $examStats['semester'] }}</p>
                <p class="text-[10px] font-semibold text-indigo-400 dark:text-indigo-500">Semester</p>
            </div>
            <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-3 text-center">
                <p class="text-lg font-extrabold text-emerald-700 dark:text-emerald-300">{{ $examStats['bulanan'] }}</p>
                <p class="text-[10px] font-semibold text-emerald-400 dark:text-emerald-500">Bulanan</p>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-3 text-center col-span-2 sm:col-span-1">
                @php $totalAvg = ($avgBacaan && $avgHafalan) ? round(($avgBacaan + $avgHafalan) / 2, 1) : 0; @endphp
                <p class="text-lg font-extrabold text-amber-700 dark:text-amber-300">{{ $totalAvg ?: '-' }}</p>
                <p class="text-[10px] font-semibold text-amber-400 dark:text-amber-500">Rata-rata</p>
            </div>
        </div>

        {{-- Average Bars --}}
        @if($avgBacaan || $avgHafalan)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-600 dark:text-gray-400">Rata-rata Bacaan</p>
                    <p class="text-sm font-extrabold {{ $avgBacaan >= 80 ? 'text-emerald-600' : ($avgBacaan >= 60 ? 'text-amber-600' : 'text-red-600') }}">{{ round($avgBacaan, 1) }}</p>
                </div>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $avgBacaan >= 80 ? 'bg-emerald-500' : ($avgBacaan >= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min($avgBacaan, 100) }}%"></div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-bold text-gray-600 dark:text-gray-400">Rata-rata Hafalan</p>
                    <p class="text-sm font-extrabold {{ $avgHafalan >= 80 ? 'text-emerald-600' : ($avgHafalan >= 60 ? 'text-amber-600' : 'text-red-600') }}">{{ round($avgHafalan, 1) }}</p>
                </div>
                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $avgHafalan >= 80 ? 'bg-emerald-500' : ($avgHafalan >= 60 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ min($avgHafalan, 100) }}%"></div>
                </div>
            </div>
        </div>
        @endif

        {{-- Exam Results Table --}}
        @if($exams->isEmpty())
            <div class="text-center py-8">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">Belum ada hasil ujian hafalan</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($exams as $exam)
                <div class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-4 hover:bg-gray-100/70 dark:hover:bg-gray-800/40 transition-colors" x-data="{ expanded: false }">
                    {{-- Header Row --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 cursor-pointer" @click="expanded = !expanded">
                        <div class="flex items-center gap-3">
                            @php
                                $katColor = match($exam->kategori) {
                                    'per_juz'  => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    'semester' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300',
                                    'bulanan'  => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    default    => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-semibold {{ $katColor }}">
                                {{ $exam->kategori_label }}
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $exam->range_surah }}
                                    @if($exam->juz)
                                        <span class="text-gray-400 dark:text-gray-500 text-xs">(Juz {{ $exam->juz }})</span>
                                    @endif
                                </p>
                                <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ $exam->tanggal_ujian->format('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Scores --}}
                            <div class="flex items-center gap-2">
                                <div class="text-center">
                                    <p class="text-xs font-bold {{ $exam->nilai_bacaan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($exam->nilai_bacaan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $exam->nilai_bacaan }}</p>
                                    <p class="text-[9px] text-gray-400">Bacaan</p>
                                </div>
                                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700"></div>
                                <div class="text-center">
                                    <p class="text-xs font-bold {{ $exam->nilai_hafalan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($exam->nilai_hafalan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $exam->nilai_hafalan }}</p>
                                    <p class="text-[9px] text-gray-400">Hafalan</p>
                                </div>
                                <div class="w-px h-6 bg-gray-200 dark:bg-gray-700"></div>
                                <div class="text-center">
                                    @php
                                        $avg = $exam->rata_rata;
                                        $avgC = $avg >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($avg >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400');
                                    @endphp
                                    <p class="text-xs font-extrabold {{ $avgC }}">{{ $avg }}</p>
                                    <p class="text-[9px] text-gray-400">Rata²</p>
                                </div>
                            </div>
                            {{-- Predikat --}}
                            @php
                                $predColor = match(true) {
                                    $avg >= 90 => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    $avg >= 80 => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    $avg >= 70 => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300',
                                    $avg >= 60 => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    default    => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold {{ $predColor }}">{{ $exam->predikat }}</span>
                            {{-- Expand icon --}}
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>

                    {{-- Detail (Expanded) --}}
                    <div x-show="expanded" x-transition x-cloak class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700/50">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @if($exam->catatan)
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Catatan</p>
                                <p class="text-xs text-gray-600 dark:text-gray-300">{{ $exam->catatan }}</p>
                            </div>
                            @endif
                            @if($exam->evaluasi)
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Evaluasi Ustadz</p>
                                <p class="text-xs text-gray-600 dark:text-gray-300">{{ $exam->evaluasi }}</p>
                            </div>
                            @endif
                            @if(!$exam->catatan && !$exam->evaluasi)
                            <p class="text-xs text-gray-400 col-span-2">Tidak ada catatan atau evaluasi</p>
                            @endif
                        </div>
                        @if($exam->ayat_mulai || $exam->ayat_selesai)
                        <div class="mt-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Range Ayat</p>
                            <p class="text-xs text-gray-600 dark:text-gray-300">Ayat {{ $exam->ayat_mulai ?? '?' }} — {{ $exam->ayat_selesai ?? '?' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
