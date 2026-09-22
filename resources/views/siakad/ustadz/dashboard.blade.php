@extends('layouts.ustadz-halaqah')
@section('title', 'Dashboard — Ustadz Halaqah')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 mb-8">
    {{-- Total Santri --}}
    <div class="group relative bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-300">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V21"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalSantri }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Santri</p>
            </div>
        </div>
    </div>

    {{-- Quick Action --}}
    <div class="group relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/30 transition-all duration-300">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <p class="text-lg font-bold text-white">Absensi Hari Ini</p>
                <a href="{{ route('siakad.ustadz.absensi.index') }}" class="text-sm text-amber-100 hover:text-white font-medium transition-colors">
                    Mulai Absensi →
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ═══ INSIGHT SANTRI — Tabel Data Lengkap ═══ --}}
@if($santriInsights->isNotEmpty())
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-md shadow-amber-500/20">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                Insight Santri
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10">Data hafalan, kehadiran & ujian — {{ now()->translatedFormat('F Y') }}</p>
        </div>
        <span class="inline-flex items-center px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-xl">
            {{ $santriInsights->count() }} Santri
        </span>
    </div>

    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-900/30">
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-wider sticky left-0 bg-gray-50/80 dark:bg-gray-900/60 backdrop-blur-sm z-10">Santri</th>
                        <th class="text-center px-2 py-3.5 font-semibold text-purple-600 dark:text-purple-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Stage</th>
                        <th colspan="4" class="text-center px-2 py-3.5 font-semibold text-emerald-600 dark:text-emerald-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Kehadiran</th>
                        <th colspan="3" class="text-center px-2 py-3.5 font-semibold text-blue-600 dark:text-blue-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Hafalan Bulan Ini</th>
                        <th colspan="3" class="text-center px-2 py-3.5 font-semibold text-amber-600 dark:text-amber-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Ujian</th>
                        <th class="text-center px-2 py-3.5 font-semibold text-red-500 dark:text-red-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Disiplin</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-wider border-l border-gray-100 dark:border-gray-700/50">Hafalan Terakhir</th>
                    </tr>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/30 dark:bg-gray-900/20">
                        <th class="sticky left-0 bg-gray-50/80 dark:bg-gray-900/60 backdrop-blur-sm z-10"></th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400 border-l border-gray-100 dark:border-gray-700/50">Level</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400 border-l border-gray-100 dark:border-gray-700/50">Hadir</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Alpha</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Sakit</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Izin</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400 border-l border-gray-100 dark:border-gray-700/50">Total</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Ziyadah</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Murojaah</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400 border-l border-gray-100 dark:border-gray-700/50">Jml</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Bacaan</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400">Hafalan</th>
                        <th class="text-center px-2 py-2 text-[9px] font-semibold text-gray-400 border-l border-gray-100 dark:border-gray-700/50">Catatan</th>
                        <th class="border-l border-gray-100 dark:border-gray-700/50"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @foreach($santriInsights as $i => $insight)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors">
                        {{-- Santri Name --}}
                        <td class="px-4 py-3 sticky left-0 bg-white dark:bg-gray-800/60 z-10">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold shadow-sm shadow-amber-500/20 shrink-0">
                                    {{ strtoupper(substr($insight->santri->nama_lengkap, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate max-w-[140px]">{{ $insight->santri->nama_lengkap }}</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ $insight->santri->nis }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Stage Hafalan --}}
                        <td class="text-center px-2 py-2 border-l border-gray-50 dark:border-gray-800">
                            <form action="{{ route('siakad.ustadz.santri.update-stage', $insight->santri->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="hafalan_stage" onchange="this.form.submit()"
                                    class="w-20 px-1.5 py-1 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-[10px] font-bold text-center focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all
                                    {{ $insight->santri->hafalan_stage ? 'text-purple-700 dark:text-purple-300' : 'text-gray-400 dark:text-gray-500' }}">
                                    <option value="" {{ !$insight->santri->hafalan_stage ? 'selected' : '' }}>—</option>
                                    @for($s = 1; $s <= 12; $s++)
                                        <option value="{{ $s }}" {{ $insight->santri->hafalan_stage == $s ? 'selected' : '' }}>Stage {{ $s }}</option>
                                    @endfor
                                </select>
                            </form>
                        </td>

                        {{-- Kehadiran --}}
                        <td class="text-center px-2 py-3 border-l border-gray-50 dark:border-gray-800">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">{{ $insight->hadir }}</span>
                        </td>
                        <td class="text-center px-2 py-3">
                            <span class="text-xs font-bold {{ $insight->alpha > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->alpha }}</span>
                        </td>
                        <td class="text-center px-2 py-3">
                            <span class="text-xs font-bold {{ $insight->sakit > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->sakit }}</span>
                        </td>
                        <td class="text-center px-2 py-3">
                            <span class="text-xs font-bold {{ $insight->izin > 0 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->izin }}</span>
                        </td>

                        {{-- Hafalan --}}
                        <td class="text-center px-2 py-3 border-l border-gray-50 dark:border-gray-800">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-xs font-bold {{ $insight->total_hafalan > 0 ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-400' }}">
                                {{ $insight->total_hafalan }}
                            </span>
                        </td>
                        <td class="text-center px-2 py-3">
                            <span class="text-xs font-semibold {{ $insight->ziyadah > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->ziyadah }}</span>
                        </td>
                        <td class="text-center px-2 py-3">
                            <span class="text-xs font-semibold {{ $insight->murojaah > 0 ? 'text-cyan-600 dark:text-cyan-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->murojaah }}</span>
                        </td>

                        {{-- Ujian --}}
                        <td class="text-center px-2 py-3 border-l border-gray-50 dark:border-gray-800">
                            <span class="text-xs font-bold {{ $insight->exam_count > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-300 dark:text-gray-600' }}">{{ $insight->exam_count }}</span>
                        </td>
                        <td class="text-center px-2 py-3">
                            @if($insight->avg_bacaan)
                                <span class="text-xs font-bold {{ $insight->avg_bacaan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($insight->avg_bacaan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $insight->avg_bacaan }}</span>
                            @else
                                <span class="text-xs text-gray-300 dark:text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="text-center px-2 py-3">
                            @if($insight->avg_hafalan)
                                <span class="text-xs font-bold {{ $insight->avg_hafalan >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($insight->avg_hafalan >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $insight->avg_hafalan }}</span>
                            @else
                                <span class="text-xs text-gray-300 dark:text-gray-600">-</span>
                            @endif
                        </td>

                        {{-- Disiplin --}}
                        <td class="text-center px-2 py-3 border-l border-gray-50 dark:border-gray-800">
                            @if($insight->disiplin_count > 0)
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md text-[10px] font-bold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">{{ $insight->disiplin_count }}</span>
                            @else
                                <span class="text-xs text-gray-300 dark:text-gray-600">0</span>
                            @endif
                        </td>

                        {{-- Last Hafalan --}}
                        <td class="px-4 py-3 border-l border-gray-50 dark:border-gray-800">
                            @if($insight->last_hafalan)
                                <div class="min-w-[120px]">
                                    <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 truncate">
                                        {{ $insight->last_hafalan->surat ?? '-' }}
                                        @if($insight->last_hafalan->ayat_mulai)
                                            <span class="text-gray-400">: {{ $insight->last_hafalan->ayat_mulai }}{{ $insight->last_hafalan->ayat_selesai ? '-'.$insight->last_hafalan->ayat_selesai : '' }}</span>
                                        @endif
                                    </p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ $insight->last_hafalan->tanggal->format('d/m/Y') }}</p>
                                </div>
                            @else
                                <span class="text-xs text-gray-300 dark:text-gray-600">Belum ada</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Pengumuman --}}
<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pengumuman Terbaru</h3>
    </div>

    @if($announcements->isEmpty())
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-8 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pengumuman</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($announcements as $ann)
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 hover:shadow-md transition-all duration-200">
                <div class="flex items-start gap-3">
                    @if($ann->is_pinned)
                    <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                    </div>
                    @else
                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $ann->judul }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $ann->konten }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $ann->published_at?->diffForHumans() ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
