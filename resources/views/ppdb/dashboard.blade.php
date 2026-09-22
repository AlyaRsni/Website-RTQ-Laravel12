@extends('layouts.dashboard')

@section('title', 'Dashboard PPDB — RTQ Kawali')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Pantau progress pendaftaran Anda')

@section('content')
<div class="space-y-6 lg:space-y-8">

    {{-- Welcome Hero Card --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0f172a] via-[#1e293b] to-[#0f172a] p-6 sm:p-8">
        {{-- Decorative elements --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-[60px]"></div>
        <div class="absolute top-1/2 right-1/4 w-2 h-2 bg-blue-400/40 rounded-full animate-pulse"></div>
        <div class="absolute top-1/4 right-1/3 w-1.5 h-1.5 bg-cyan-400/30 rounded-full animate-pulse" style="animation-delay:1s"></div>
        
        {{-- Islamic pattern overlay --}}
        <div class="absolute inset-0 opacity-[0.03]"
            style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;40&quot; height=&quot;40&quot; viewBox=&quot;0 0 40 40&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M20 20.5V18H0v-2h20V0h2v16h18v2H22v4.5z&quot;/%3E%3C/g%3E%3C/svg%3E');"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Assalamu'alaikum, {{ explode(' ', $user->name)[0] }}! 👋
                </h1>
                <p class="mt-2 text-blue-200/60 text-sm sm:text-base leading-relaxed">
                    Lengkapi data pendaftaranmu untuk menjadi santri RTQ Kawali
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/10 shrink-0">
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-white">{{ $progress }}%</p>
                    <p class="text-[11px] text-blue-200/50 font-medium uppercase tracking-wider">Progress</p>
                </div>
                {{-- Circular progress --}}
                <div class="relative w-14 h-14">
                    <svg class="w-14 h-14 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="20" fill="none" stroke="currentColor" stroke-width="3" class="text-white/10"></circle>
                        <circle cx="24" cy="24" r="20" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" class="text-blue-400" stroke-dasharray="{{ 2 * 3.14159 * 20 }}" stroke-dashoffset="{{ 2 * 3.14159 * 20 * (1 - $progress / 100) }}" style="transition: stroke-dashoffset 1s ease-out"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        @if($progress === 100)
                            <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="w-5 h-5 text-blue-300/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Nomor Peserta (if generated) --}}
        @if($registration->nomor_peserta)
        <div class="relative z-10 mt-5 bg-gradient-to-r from-emerald-500/20 to-teal-500/20 rounded-2xl border border-emerald-400/20 p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <p class="text-xs text-emerald-300/70 font-semibold uppercase tracking-wider">Nomor Peserta Ujian</p>
                <p class="text-2xl font-extrabold text-emerald-300 tracking-wider">{{ $registration->nomor_peserta }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- Perlu Perbaikan Alert --}}
    @if($registration->needsRevision())
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/15 dark:to-orange-900/15 border border-red-200/60 dark:border-red-800/30 p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-800/30 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-bold text-red-800 dark:text-red-300">⚠️ Data Perlu Perbaikan</h3>
                <p class="text-xs text-red-600 dark:text-red-400 mt-1">Ustadz PPDB meminta Anda memperbaiki data berikut. Silakan edit data yang diminta, lalu kirim ulang melalui halaman Finalisasi.</p>
                @if($registration->catatan_perbaikan)
                <div class="mt-3 bg-white dark:bg-gray-800/60 rounded-xl p-4 border border-red-100 dark:border-red-800/20">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Catatan dari Ustadz:</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $registration->catatan_perbaikan }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Step Tracker Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5">
        @foreach($steps as $stepNum => $step)
            @php
                $colors = [
                    'blue' => ['bg' => 'from-blue-500 to-blue-600', 'light' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800/40', 'text' => 'text-blue-600 dark:text-blue-400', 'badge_bg' => 'bg-blue-100 dark:bg-blue-900/40', 'icon_bg' => 'bg-blue-100 dark:bg-blue-800/30'],
                    'indigo' => ['bg' => 'from-indigo-500 to-indigo-600', 'light' => 'bg-indigo-50 dark:bg-indigo-900/20', 'border' => 'border-indigo-200 dark:border-indigo-800/40', 'text' => 'text-indigo-600 dark:text-indigo-400', 'badge_bg' => 'bg-indigo-100 dark:bg-indigo-900/40', 'icon_bg' => 'bg-indigo-100 dark:bg-indigo-800/30'],
                    'cyan' => ['bg' => 'from-cyan-500 to-cyan-600', 'light' => 'bg-cyan-50 dark:bg-cyan-900/20', 'border' => 'border-cyan-200 dark:border-cyan-800/40', 'text' => 'text-cyan-600 dark:text-cyan-400', 'badge_bg' => 'bg-cyan-100 dark:bg-cyan-900/40', 'icon_bg' => 'bg-cyan-100 dark:bg-cyan-800/30'],
                    'emerald' => ['bg' => 'from-emerald-500 to-emerald-600', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20', 'border' => 'border-emerald-200 dark:border-emerald-800/40', 'text' => 'text-emerald-600 dark:text-emerald-400', 'badge_bg' => 'bg-emerald-100 dark:bg-emerald-900/40', 'icon_bg' => 'bg-emerald-100 dark:bg-emerald-800/30'],
                    'purple' => ['bg' => 'from-purple-500 to-purple-600', 'light' => 'bg-purple-50 dark:bg-purple-900/20', 'border' => 'border-purple-200 dark:border-purple-800/40', 'text' => 'text-purple-600 dark:text-purple-400', 'badge_bg' => 'bg-purple-100 dark:bg-purple-900/40', 'icon_bg' => 'bg-purple-100 dark:bg-purple-800/30'],
                    'orange' => ['bg' => 'from-orange-500 to-orange-600', 'light' => 'bg-orange-50 dark:bg-orange-900/20', 'border' => 'border-orange-200 dark:border-orange-800/40', 'text' => 'text-orange-600 dark:text-orange-400', 'badge_bg' => 'bg-orange-100 dark:bg-orange-900/40', 'icon_bg' => 'bg-orange-100 dark:bg-orange-800/30'],
                    'amber' => ['bg' => 'from-amber-500 to-amber-600', 'light' => 'bg-amber-50 dark:bg-amber-900/20', 'border' => 'border-amber-200 dark:border-amber-800/40', 'text' => 'text-amber-600 dark:text-amber-400', 'badge_bg' => 'bg-amber-100 dark:bg-amber-900/40', 'icon_bg' => 'bg-amber-100 dark:bg-amber-800/30'],
                ];
                $c = $colors[$step['color']];

                // Status badge styling
                $statusBadge = match(true) {
                    $step['completed'] => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-300', 'dot' => 'bg-emerald-500'],
                    str_contains($step['status'], 'Menunggu') => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-300', 'dot' => 'bg-amber-500 animate-pulse'],
                    str_contains($step['status'], 'Ditolak') || str_contains($step['status'], 'Perbaikan') => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-300', 'dot' => 'bg-red-500'],
                    str_contains($step['status'], 'Draft') => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-300', 'dot' => 'bg-blue-500'],
                    default => ['bg' => 'bg-gray-100 dark:bg-gray-800', 'text' => 'text-gray-500 dark:text-gray-400', 'dot' => 'bg-gray-400'],
                };
            @endphp

            <div class="group relative bg-white dark:bg-gray-800/60 rounded-2xl border {{ $step['completed'] ? 'border-emerald-200 dark:border-emerald-800/30' : 'border-gray-200/80 dark:border-gray-700/40' }} shadow-sm hover:shadow-lg hover:shadow-gray-200/50 dark:hover:shadow-none transition-all duration-300 {{ !$step['accessible'] && !$step['completed'] && $stepNum <= 5 ? 'opacity-50' : '' }}"
                @if($step['accessible'] && $step['route']) 
                    style="cursor: pointer" 
                    onclick="window.location='{{ route($step['route']) }}'" 
                @endif
            >
                {{-- Step Number Badge --}}
                <div class="absolute -top-2.5 left-5">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold
                        {{ $step['completed'] 
                            ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/30' 
                            : 'bg-gradient-to-r ' . $c['bg'] . ' text-white shadow-md shadow-' . $step['color'] . '-500/30' }}">
                        STEP {{ $stepNum }}
                    </span>
                </div>

                <div class="p-5 pt-6">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3.5 min-w-0">
                            {{-- Icon --}}
                            <div class="w-11 h-11 rounded-xl {{ $step['completed'] ? 'bg-emerald-100 dark:bg-emerald-800/30' : $c['icon_bg'] }} flex items-center justify-center shrink-0 transition-colors">
                                @if($step['completed'])
                                    <svg class="w-5.5 h-5.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                @elseif($step['icon'] === 'payment')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                @elseif($step['icon'] === 'user')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @elseif($step['icon'] === 'phone')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                @elseif($step['icon'] === 'document')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @elseif($step['icon'] === 'check')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif($step['icon'] === 'shield')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif($step['icon'] === 'ticket')
                                    <svg class="w-5 h-5 {{ $c['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ $step['title'] }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">{{ $step['description'] }}</p>
                            </div>
                        </div>

                        {{-- Accessibility indicator --}}
                        @if(!$step['accessible'] && !$step['completed'] && $stepNum <= 5)
                            <div class="shrink-0 w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                        @elseif($step['accessible'] && $step['route'])
                            <div class="shrink-0 w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-4 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $statusBadge['bg'] }} {{ $statusBadge['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $statusBadge['dot'] }}"></span>
                            {{ $step['status'] }}
                        </span>
                    </div>



                    {{-- Revision note for Step 6 --}}
                    @if($stepNum === 6 && $registration->status_verifikasi === 'perlu_perbaikan' && $registration->catatan_perbaikan)
                        <div class="mt-3 bg-orange-50 dark:bg-orange-900/10 rounded-xl border border-orange-100 dark:border-orange-800/30 p-3">
                            <p class="text-xs font-semibold text-orange-600 dark:text-orange-400 mb-1">Catatan Perbaikan:</p>
                            <p class="text-xs text-orange-500 dark:text-orange-400/70">{{ $registration->catatan_perbaikan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Hasil Seleksi Download --}}
    @if($registration->hasil_seleksi_pdf && $registration->hasil_seleksi_status === 'tersedia')
    <div class="bg-linear-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/15 dark:to-teal-900/15 rounded-2xl border border-emerald-200/60 dark:border-emerald-800/30 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">📄 Hasil Seleksi Tersedia!</h4>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">Hasil keputusan seleksi PPDB Anda sudah dapat diunduh.</p>
                </div>
            </div>
            <a href="{{ route('ppdb.download-hasil') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download PDF
            </a>
        </div>
    </div>
    @elseif($registration->nomor_peserta && (!$registration->hasil_seleksi_pdf || $registration->hasil_seleksi_status !== 'tersedia'))
    <div class="bg-gray-50 dark:bg-gray-800/30 rounded-2xl border border-gray-200/60 dark:border-gray-700/30 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Hasil seleksi belum tersedia</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">Silakan cek kembali nanti. Kami akan mengumumkan segera.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Info Card --}}
    <div class="bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 rounded-2xl border border-blue-200/60 dark:border-blue-800/30 p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-800/30 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Informasi Penting</h4>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1.5 leading-relaxed">
                    <li class="flex items-start gap-2"><span class="text-blue-500 mt-0.5">•</span> Setiap langkah harus diselesaikan secara berurutan</li>
                    <li class="flex items-start gap-2"><span class="text-blue-500 mt-0.5">•</span> Setelah upload pembayaran, Anda bisa langsung mengisi data</li>
                    <li class="flex items-start gap-2"><span class="text-blue-500 mt-0.5">•</span> Setelah finalisasi, data tidak dapat diubah kecuali diminta perbaikan</li>
                    <li class="flex items-start gap-2"><span class="text-blue-500 mt-0.5">•</span> Nomor peserta akan diberikan setelah berkas terverifikasi</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
