@extends('layouts.ustadz')

@section('title', 'Dashboard Ustadz — RTQ Kawali')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Panel Verifikasi PPDB')

@section('content')
<div class="space-y-6 lg:space-y-8">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-5">
        @php
            $stats = [
                ['label' => 'Menunggu Verifikasi', 'value' => $menungguVerifikasi, 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'desc' => 'Perlu ditindak'],
                ['label' => 'Terverifikasi', 'value' => $terverifikasi, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'desc' => 'Sudah lolos'],
                ['label' => 'Perlu Perbaikan', 'value' => $perluPerbaikan, 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'color' => 'orange', 'desc' => 'Menunggu revisi'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $stat['label'] }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $stat['desc'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Summary Row --}}
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
            <div>
                <p class="text-lg font-bold text-gray-900 dark:text-white leading-none">{{ $totalPendaftar }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Total Pendaftar</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-purple-500 shrink-0"></span>
            <div>
                <p class="text-lg font-bold text-gray-900 dark:text-white leading-none">{{ $sudahFinalisasi }}</p>
                <p class="text-[11px] text-gray-400 mt-0.5">Sudah Finalisasi</p>
            </div>
        </div>
    </div>

    {{-- Pending Verifikasi --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">🔔 Menunggu Verifikasi Anda</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pendaftar yang sudah finalisasi dan membutuhkan review</p>
            </div>
            <a href="{{ route('ustadz.pendaftar.index', ['status' => 'menunggu_verifikasi_berkas']) }}" class="text-xs font-semibold text-teal-600 dark:text-teal-400 hover:text-teal-700 transition-colors">Lihat Semua →</a>
        </div>

        @forelse($pendingList as $reg)
        <a href="{{ route('ustadz.pendaftar.show', $reg->id) }}" class="flex items-center justify-between px-5 py-4 border-b border-gray-50 dark:border-gray-700/20 hover:bg-teal-50/50 dark:hover:bg-teal-900/10 transition-colors group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-sm font-bold text-amber-600 dark:text-amber-400">
                    {{ strtoupper(substr($reg->user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $reg->nama_lengkap ?? $reg->user->name }}</p>
                    <p class="text-[11px] text-gray-400">Finalisasi: {{ $reg->finalisasi_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300">Perlu Review</span>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-teal-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
        @empty
        <div class="px-5 py-10 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-emerald-300 dark:text-emerald-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Semua sudah diverifikasi! 🎉</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tidak ada pendaftar yang menunggu verifikasi</p>
        </div>
        @endforelse
    </div>

    {{-- Recent Verified --}}
    @if($recentVerified->isNotEmpty())
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">✅ Terakhir Diverifikasi</h3>
        </div>
        @foreach($recentVerified as $reg)
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-50 dark:border-gray-700/20 last:border-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $reg->nama_lengkap ?? $reg->user->name }}</p>
                    <p class="text-[11px] text-gray-400">{{ $reg->nomor_peserta }}</p>
                </div>
            </div>
            <span class="text-[11px] text-gray-400">{{ $reg->updated_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
