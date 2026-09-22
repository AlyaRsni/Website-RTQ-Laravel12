@extends('layouts.ustadz-halaqah')
@section('title', 'Rekap Bulanan — Ustadz Halaqah')
@section('page_title', 'Rekap Bulanan')
@section('page_subtitle', 'Ringkasan pencapaian santri per bulan')

@section('content')
<div>
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.rekap.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
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
            <div class="w-full sm:w-52">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Bulan</label>
                <input type="month" name="bulan" value="{{ $bulan }}"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                Tampilkan Rekap
            </button>
        </form>
    </div>

    @if($selectedHalaqah)
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedHalaqah->nama }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Periode: <span class="font-semibold text-amber-600 dark:text-amber-400">{{ $tanggalAwal->translatedFormat('F Y') }}</span>
            </p>
        </div>
        <span class="inline-flex items-center px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-lg">
            {{ $santriSummaries->count() }} santri
        </span>
    </div>

    @if($santriSummaries->isEmpty())
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Halaqah belum memiliki santri</p>
        </div>
    @else
        {{-- Per-Santri Cards --}}
        <div class="space-y-6">
            @foreach($santriSummaries as $santri)
            <div x-data="{ expanded: false }" class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-300">
                {{-- Santri Header --}}
                <div class="px-6 py-5 cursor-pointer" @click="expanded = !expanded">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-amber-500/20">
                            {{ strtoupper(substr($santri->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{ $santri->nis }}</p>
                        </div>
                        <div class="hidden sm:flex items-center gap-3">
                            {{-- Mini Stats Badges --}}
                            <div class="text-center px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <p class="text-lg font-extrabold text-emerald-600 dark:text-emerald-400">{{ $santri->absensi['persen_hadir'] }}%</p>
                                <p class="text-[10px] text-emerald-500 dark:text-emerald-400 font-semibold">Kehadiran</p>
                            </div>
                            <div class="text-center px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <p class="text-lg font-extrabold text-blue-600 dark:text-blue-400">{{ $santri->hafalan['total'] }}</p>
                                <p class="text-[10px] text-blue-500 dark:text-blue-400 font-semibold">Hafalan</p>
                            </div>
                            @if($santri->nilai['rata_rata'])
                            <div class="text-center px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl">
                                <p class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">{{ $santri->nilai['rata_rata'] }}</p>
                                <p class="text-[10px] text-indigo-500 dark:text-indigo-400 font-semibold">Rata-rata</p>
                            </div>
                            @endif
                        </div>
                        <button class="p-2 rounded-lg text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-all">
                            <svg class="w-5 h-5 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>

                    {{-- Mobile Mini Stats --}}
                    <div class="flex sm:hidden items-center gap-2 mt-3">
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                            ✓ {{ $santri->absensi['persen_hadir'] }}%
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-xs font-semibold text-blue-600 dark:text-blue-400">
                            📖 {{ $santri->hafalan['total'] }}
                        </span>
                        @if($santri->nilai['rata_rata'])
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                            📊 {{ $santri->nilai['rata_rata'] }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Expanded Detail --}}
                <div x-show="expanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
                    <div class="px-6 pb-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- 1. Absensi --}}
                        <div class="bg-gray-50 dark:bg-gray-900/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/30">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                Kehadiran
                            </h5>
                            @if($santri->absensi['total'] > 0)
                                {{-- Progress Bar --}}
                                <div class="flex items-center gap-1 h-4 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 mb-3">
                                    @if($santri->absensi['hadir'] > 0)
                                    <div class="h-full bg-emerald-500 transition-all" style="width: {{ ($santri->absensi['hadir'] / $santri->absensi['total']) * 100 }}%"></div>
                                    @endif
                                    @if($santri->absensi['sakit'] > 0)
                                    <div class="h-full bg-amber-400 transition-all" style="width: {{ ($santri->absensi['sakit'] / $santri->absensi['total']) * 100 }}%"></div>
                                    @endif
                                    @if($santri->absensi['izin'] > 0)
                                    <div class="h-full bg-blue-400 transition-all" style="width: {{ ($santri->absensi['izin'] / $santri->absensi['total']) * 100 }}%"></div>
                                    @endif
                                    @if($santri->absensi['alpha'] > 0)
                                    <div class="h-full bg-red-500 transition-all" style="width: {{ ($santri->absensi['alpha'] / $santri->absensi['total']) * 100 }}%"></div>
                                    @endif
                                </div>
                                <div class="grid grid-cols-4 gap-2 text-center">
                                    <div>
                                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $santri->absensi['hadir'] }}</p>
                                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">Hadir</p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-amber-500 dark:text-amber-400">{{ $santri->absensi['sakit'] }}</p>
                                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">Sakit</p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-blue-500 dark:text-blue-400">{{ $santri->absensi['izin'] }}</p>
                                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">Izin</p>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-red-500 dark:text-red-400">{{ $santri->absensi['alpha'] }}</p>
                                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">Alpha</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-2">Belum ada data absensi</p>
                            @endif
                        </div>

                        {{-- 2. Hafalan --}}
                        <div class="bg-gray-50 dark:bg-gray-900/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/30">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                Hafalan
                            </h5>
                            @if($santri->hafalan['total'] > 0)
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex-1 text-center px-3 py-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $santri->hafalan['ziyadah'] }}</p>
                                        <p class="text-[10px] font-semibold text-emerald-500">Ziyadah</p>
                                    </div>
                                    <div class="flex-1 text-center px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $santri->hafalan['murojaah'] }}</p>
                                        <p class="text-[10px] font-semibold text-blue-500">Murojaah</p>
                                    </div>
                                </div>
                                @if($santri->hafalan['entries']->isNotEmpty())
                                <div class="space-y-1.5">
                                    @foreach($santri->hafalan['entries'] as $h)
                                    <div class="flex items-center justify-between text-xs px-2.5 py-1.5 bg-white dark:bg-gray-800/60 rounded-lg">
                                        <span class="text-gray-600 dark:text-gray-300">{{ $h->surat ?? '-' }} {{ $h->ayat_mulai ? ': '.$h->ayat_mulai.($h->ayat_selesai ? '-'.$h->ayat_selesai : '') : '' }}</span>
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $h->jenis === 'ziyadah' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' }}">{{ ucfirst($h->jenis) }}</span>
                                            <span class="text-gray-400">{{ $h->tanggal->format('d/m') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-2">Belum ada data hafalan</p>
                            @endif
                        </div>

                        {{-- 3. Nilai --}}
                        <div class="bg-gray-50 dark:bg-gray-900/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/30">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                Nilai
                                @if($santri->nilai['rata_rata'])
                                <span class="ml-auto text-xs font-bold px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-md">
                                    Rata-rata: {{ $santri->nilai['rata_rata'] }}
                                </span>
                                @endif
                            </h5>
                            @if($santri->nilai['total_entri'] > 0)
                                <div class="space-y-1.5">
                                    @foreach($santri->nilai['entries'] as $n)
                                    <div class="flex items-center justify-between text-xs px-2.5 py-1.5 bg-white dark:bg-gray-800/60 rounded-lg">
                                        <span class="text-gray-600 dark:text-gray-300">{{ $n->subject->nama ?? '-' }}</span>
                                        <div class="flex items-center gap-1.5">
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300">{{ ucfirst($n->tipe) }}</span>
                                            <span class="font-bold {{ $n->nilai >= 75 ? 'text-emerald-600 dark:text-emerald-400' : ($n->nilai >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ number_format($n->nilai, 0) }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-2">Belum ada data nilai</p>
                            @endif
                        </div>

                        {{-- 4. Kedisiplinan --}}
                        <div class="bg-gray-50 dark:bg-gray-900/30 rounded-2xl p-4 border border-gray-100 dark:border-gray-700/30">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                Kedisiplinan
                            </h5>
                            @if($santri->disiplin['pelanggaran'] > 0 || $santri->disiplin['prestasi'] > 0)
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="flex-1 text-center px-3 py-2 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                        <p class="text-lg font-bold text-red-600 dark:text-red-400">{{ $santri->disiplin['pelanggaran'] }}</p>
                                        <p class="text-[10px] font-semibold text-red-500">Pelanggaran</p>
                                        @if($santri->disiplin['poin_pelanggaran'] > 0)
                                        <p class="text-[10px] text-red-400">-{{ $santri->disiplin['poin_pelanggaran'] }} poin</p>
                                        @endif
                                    </div>
                                    <div class="flex-1 text-center px-3 py-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                        <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $santri->disiplin['prestasi'] }}</p>
                                        <p class="text-[10px] font-semibold text-emerald-500">Prestasi</p>
                                        @if($santri->disiplin['poin_prestasi'] > 0)
                                        <p class="text-[10px] text-emerald-400">+{{ $santri->disiplin['poin_prestasi'] }} poin</p>
                                        @endif
                                    </div>
                                </div>
                                @if($santri->disiplin['entries']->isNotEmpty())
                                <div class="space-y-1.5">
                                    @foreach($santri->disiplin['entries'] as $d)
                                    <div class="flex items-center justify-between text-xs px-2.5 py-1.5 bg-white dark:bg-gray-800/60 rounded-lg">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $d->tipe === 'pelanggaran' ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                                            <span class="text-gray-600 dark:text-gray-300 truncate">{{ $d->judul }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0 ml-2">
                                            <span class="font-bold {{ $d->tipe === 'pelanggaran' ? 'text-red-500' : 'text-emerald-500' }}">{{ $d->tipe === 'pelanggaran' ? '-' : '+' }}{{ $d->poin }}</span>
                                            <span class="text-gray-400">{{ $d->tanggal->format('d/m') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-2">Tidak ada catatan kedisiplinan</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    @elseif(request('halaqah_id'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-6 text-center">
            <p class="text-sm font-semibold text-red-600 dark:text-red-400">Halaqah tidak ditemukan atau bukan milik Anda</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah dan bulan untuk melihat rekap</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Semua pencapaian santri akan ditampilkan dalam satu halaman</p>
        </div>
    @endif
</div>
@endsection
