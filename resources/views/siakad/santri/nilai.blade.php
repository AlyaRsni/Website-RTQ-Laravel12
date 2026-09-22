@extends('layouts.santri')
@section('title', 'Nilai / Rapor — Santri')
@section('page_title', 'Nilai / Rapor')
@section('page_subtitle', 'Rekapitulasi nilai mata pelajaran')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- STATISTIK KESELURUHAN                       --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $overallStats['total_mapel'] }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Mata Pelajaran</p>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $overallStats['total_nilai'] }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Total Nilai</p>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-green-100 dark:from-emerald-900/30 dark:to-green-900/30 flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <p class="text-2xl font-extrabold {{ $overallStats['rata_rata'] !== null && $overallStats['rata_rata'] >= 75 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-900 dark:text-white' }}">{{ $overallStats['rata_rata'] ?? '-' }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Rata-rata</p>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-yellow-100 dark:from-amber-900/30 dark:to-yellow-900/30 flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $overallStats['nilai_max'] ?? '-' }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Nilai Tertinggi</p>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4 text-center">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30 flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $overallStats['nilai_min'] ?? '-' }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">Nilai Terendah</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- NILAI PER MATA PELAJARAN                    --}}
    {{-- ═══════════════════════════════════════════ --}}
    @if($gradesBySubject->count() > 0)
        @foreach($gradesBySubject as $item)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
            {{-- Header --}}
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-teal-500/20">
                        {{ strtoupper(substr($item->subject->kode ?? 'N', 0, 3)) }}
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->subject->nama }}</h3>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ $item->subject->category->nama ?? '-' }} · {{ $item->total_count }} nilai</p>
                    </div>
                </div>
                <div class="text-right">
                    @php
                        $avg = $item->overall_avg;
                        $avgColor = $avg >= 85 ? 'text-emerald-600 dark:text-emerald-400' : ($avg >= 70 ? 'text-teal-600 dark:text-teal-400' : ($avg >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400'));
                        $avgBg = $avg >= 85 ? 'bg-emerald-50 dark:bg-emerald-900/20' : ($avg >= 70 ? 'bg-teal-50 dark:bg-teal-900/20' : ($avg >= 50 ? 'bg-amber-50 dark:bg-amber-900/20' : 'bg-red-50 dark:bg-red-900/20'));
                    @endphp
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-lg font-extrabold {{ $avgColor }} {{ $avgBg }}">
                        {{ $avg ?? '-' }}
                    </span>
                    <p class="text-[10px] text-gray-400 mt-0.5">Rata-rata</p>
                </div>
            </div>

            {{-- Breakdown per Tipe --}}
            <div class="px-5 py-4">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                    @foreach(['harian' => 'Harian', 'tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS'] as $tipe => $label)
                    @php $tipeData = $item->by_tipe[$tipe]; @endphp
                    <div class="p-3 rounded-xl {{ $tipeData['count'] > 0 ? 'bg-gray-50 dark:bg-gray-900/30' : 'bg-gray-50/50 dark:bg-gray-900/10' }}">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">{{ $label }}</p>
                        @if($tipeData['count'] > 0)
                            @php
                                $tAvg = $tipeData['avg'];
                                $tColor = $tAvg >= 85 ? 'text-emerald-600 dark:text-emerald-400' : ($tAvg >= 70 ? 'text-teal-600 dark:text-teal-400' : ($tAvg >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400'));
                            @endphp
                            <p class="text-xl font-extrabold {{ $tColor }}">{{ $tAvg }}</p>
                            <p class="text-[10px] text-gray-400">{{ $tipeData['count'] }} nilai</p>
                        @else
                            <p class="text-xl font-extrabold text-gray-300 dark:text-gray-600">—</p>
                            <p class="text-[10px] text-gray-300 dark:text-gray-600">Belum ada</p>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Detail Grades Table --}}
                <details class="group">
                    <summary class="cursor-pointer text-xs font-semibold text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 flex items-center gap-1.5 select-none">
                        <svg class="w-3.5 h-3.5 transition-transform group-open:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        Lihat detail {{ $item->total_count }} nilai
                    </summary>
                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="text-center py-2 px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nilai</th>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Catatan</th>
                                    <th class="text-right py-2 px-3 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                                @foreach($item->grades->sortByDesc('created_at') as $grade)
                                @php
                                    $gColor = $grade->nilai >= 85 ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20' : ($grade->nilai >= 70 ? 'text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/20' : ($grade->nilai >= 50 ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20' : 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20'));
                                    $tipeLabel = match($grade->tipe) { 'harian' => 'Harian', 'tugas' => 'Tugas', 'uts' => 'UTS', 'uas' => 'UAS', default => $grade->tipe };
                                    $tipeBg = match($grade->tipe) { 'harian' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300', 'tugas' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300', 'uts' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300', 'uas' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300', default => 'bg-gray-100 text-gray-500' };
                                @endphp
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/10">
                                    <td class="py-2.5 px-3">
                                        <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold {{ $tipeBg }}">{{ $tipeLabel }}</span>
                                    </td>
                                    <td class="py-2.5 px-3 text-center">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-lg text-sm font-bold {{ $gColor }}">{{ number_format($grade->nilai, 1) }}</span>
                                    </td>
                                    <td class="py-2.5 px-3 text-xs text-gray-500 dark:text-gray-400 max-w-[200px] truncate">{{ $grade->catatan ?? '-' }}</td>
                                    <td class="py-2.5 px-3 text-right text-xs text-gray-400 dark:text-gray-500">{{ $grade->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
            </div>
        </div>
        @endforeach
    @else
        {{-- Empty State --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Belum Ada Nilai</h3>
            <p class="text-xs text-gray-400 dark:text-gray-500">Nilai akan muncul setelah ustadz menginput nilai mata pelajaran.</p>
        </div>
    @endif

</div>
@endsection
