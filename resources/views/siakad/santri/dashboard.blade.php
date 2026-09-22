@extends('layouts.santri')
@section('title', 'Dashboard — Santri')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang, ' . $santri->nama_lengkap)

@section('content')
<div class="space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="relative h-32 bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-600">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djZoLTZWMzRoNnptMC0yMHY2aC02VjE0aDZ6TTIwIDM0djZoLTZWMzRoNnptMC0yMHY2aC02VjE0aDZ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-50"></div>
        </div>

        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-16 relative z-10">
                {{-- Profile Photo (display only — managed by admin) --}}
                <div>
                    @if($santri->foto)
                        <img src="{{ asset('storage/' . $santri->foto) }}" alt="Foto {{ $santri->nama_lengkap }}"
                            class="w-28 h-28 rounded-2xl object-cover border-4 border-white dark:border-gray-800 shadow-xl shadow-teal-500/20">
                    @else
                        <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 border-4 border-white dark:border-gray-800 shadow-xl shadow-teal-500/20 flex items-center justify-center">
                            <span class="text-4xl font-bold text-white">{{ strtoupper(substr($santri->nama_lengkap, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 pt-2 sm:pt-0 sm:pb-1">
                    <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2.5 py-1 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300 text-xs font-semibold rounded-lg">
                            NIS: {{ $santri->nis }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg">
                            {{ $santri->dormitory->nama ?? 'Belum ada asrama' }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold
                            {{ $santri->status === 'aktif' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $santri->status === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                            {{ ucfirst($santri->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bio Info --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-5 border-t border-gray-100 dark:border-gray-700/50">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tempat, Tgl Lahir</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">
                        {{ $santri->tempat_lahir ?? '-' }}{{ $santri->tanggal_lahir ? ', ' . $santri->tanggal_lahir->format('d/m/Y') : '' }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">{{ ucfirst($santri->jenis_kelamin) }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nama Ayah</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">{{ $santri->nama_ayah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nama Ibu</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white mt-0.5">{{ $santri->nama_ibu ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Level Stage Hafalan ═══ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        {{-- Header --}}
        <div class="relative px-5 py-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvZz48L3N2Zz4=')] opacity-60"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Level Stage Hafalan</h3>
                        <p class="text-[11px] text-white/70 font-medium">Progress menghafal Al-Quran</p>
                    </div>
                </div>
                @if($stageInfo)
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-xl text-white text-xs font-bold">
                            {{ $stageInfo->progress }}% Selesai
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-5">
            @if($stageInfo)
                {{-- Current Stage Display --}}
                <div class="flex flex-col sm:flex-row items-center gap-5 mb-5">
                    {{-- Stage Badge --}}
                    <div class="relative shrink-0">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex flex-col items-center justify-center shadow-xl shadow-purple-500/25">
                            <span class="text-3xl font-black text-white leading-none">{{ $stageInfo->stage }}</span>
                            <span class="text-[10px] font-bold text-white/80 uppercase tracking-wider mt-0.5">Stage</span>
                        </div>
                        @if($stageInfo->stage === 12)
                            <div class="absolute -top-1.5 -right-1.5 w-7 h-7 bg-amber-400 rounded-lg flex items-center justify-center shadow-md shadow-amber-400/40 animate-bounce">
                                <span class="text-sm">👑</span>
                            </div>
                        @endif
                    </div>

                    {{-- Stage Info --}}
                    <div class="flex-1 text-center sm:text-left">
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $stageInfo->label }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Menghafal <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $stageInfo->juz_label }}</span>
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            {{ count($stageInfo->juz) }} Juz dalam stage ini:
                            @foreach($stageInfo->juz as $j)
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded text-[10px] font-bold">{{ $j }}</span>
                            @endforeach
                        </p>

                        {{-- Progress Bar --}}
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-semibold text-gray-400 dark:text-gray-500">Progress Keseluruhan</span>
                                <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400">Stage {{ $stageInfo->stage }} / 12</span>
                            </div>
                            <div class="h-2.5 bg-gray-100 dark:bg-gray-700/50 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transition-all duration-1000 ease-out" style="width: {{ $stageInfo->progress }}%"></div>
                            </div>
                        </div>

                        {{-- Motivational Message --}}
                        <p class="mt-2 text-xs font-medium italic
                            @if($stageInfo->stage <= 3) text-teal-500 dark:text-teal-400
                            @elseif($stageInfo->stage <= 6) text-blue-500 dark:text-blue-400
                            @elseif($stageInfo->stage <= 9) text-purple-500 dark:text-purple-400
                            @else text-amber-500 dark:text-amber-400
                            @endif">
                            @if($stageInfo->stage <= 3)
                                "Setiap perjalanan dimulai dengan langkah pertama. Istiqomah! 💪"
                            @elseif($stageInfo->stage <= 6)
                                "Sudah seperempat jalan! Terus semangat menghafal! 📖"
                            @elseif($stageInfo->stage <= 9)
                                "Masya Allah, lebih dari setengah! Kamu luar biasa! 🌟"
                            @elseif($stageInfo->stage <= 11)
                                "Hampir selesai! Tinggal sedikit lagi menuju Khatam! 🚀"
                            @else
                                "Stage terakhir! Semoga menjadi Hafidz/Hafidzah! 👑"
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Stage Timeline/Stepper --}}
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700/50">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Peta Perjalanan</p>
                    <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-12 gap-2">
                        @foreach($stageMap as $num => $info)
                            @php
                                $isCompleted = $num < $stageInfo->stage;
                                $isCurrent   = $num === $stageInfo->stage;
                                $juzRange = count($info['juz']) === 1
                                    ? 'J' . $info['juz'][0]
                                    : 'J' . $info['juz'][0] . '-' . end($info['juz']);
                            @endphp
                            <div class="flex flex-col items-center gap-1">
                                <div class="w-full aspect-square rounded-xl flex flex-col items-center justify-center text-center transition-all duration-300
                                    @if($isCurrent) bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 shadow-lg shadow-purple-500/25 scale-105 ring-2 ring-purple-300 dark:ring-purple-600
                                    @elseif($isCompleted) bg-gradient-to-br from-emerald-400 to-teal-500 shadow-md shadow-emerald-500/15
                                    @else bg-gray-100 dark:bg-gray-800
                                    @endif">
                                    <span class="text-xs font-black {{ $isCurrent || $isCompleted ? 'text-white' : 'text-gray-400 dark:text-gray-500' }}">{{ $num }}</span>
                                    @if($isCompleted)
                                        <svg class="w-3 h-3 text-white/80 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                                <span class="text-[8px] font-semibold {{ $isCurrent ? 'text-purple-600 dark:text-purple-400' : ($isCompleted ? 'text-emerald-500 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500') }} leading-tight text-center">{{ $juzRange }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- Empty state --}}
                <div class="text-center py-6">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">Level Stage belum ditentukan</p>
                    <p class="text-xs text-gray-300 dark:text-gray-600 mt-1">Ustadz pengampu akan menentukan stage hafalanmu</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $attendanceStats['hadir'] }}</p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Hadir Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $attendanceStats['alpha'] }}</p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Alpha Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $recentHafalan->count() }}</p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Hafalan Terbaru</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $santri->halaqahs->count() }}</p>
                    <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">Halaqah</p>
                </div>
            </div>
        </div>
    </div>


    {{-- ═══ Perizinan Aktif ═══ --}}
    @if($activePermissions->isNotEmpty())
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                Perizinan Aktif
            </h3>
            <a href="{{ route('siakad.santri.perizinan') }}" class="text-xs font-semibold text-teal-600 dark:text-teal-400 hover:text-teal-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="space-y-2">
            @foreach($activePermissions as $perm)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $perm->jenis_label }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $perm->tanggal_mulai->format('d M') }} — {{ $perm->tanggal_selesai->format('d M Y') }}</p>
                </div>
                @php
                    $badge = match($perm->status) {
                        'diajukan'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                        'disetujui' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                        default     => 'bg-gray-100 text-gray-500',
                    };
                @endphp
                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ ucfirst($perm->status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Halaqah --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                Halaqah Saya
            </h3>
            @forelse($santri->halaqahs as $hq)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl mb-2 last:mb-0">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $hq->nama }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hq->semester->academicYear->nama ?? '-' }} — {{ ucfirst($hq->semester->tipe ?? '-') }}</p>
                </div>
                <span class="text-xs font-semibold text-teal-600 dark:text-teal-400">{{ $hq->ustadz->nama_lengkap ?? '-' }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">Belum ada halaqah</p>
            @endforelse
        </div>

        {{-- Recent Hafalan --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                Hafalan Terbaru
            </h3>
            @forelse($recentHafalan as $h)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl mb-2 last:mb-0">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $h->surat ?? '-' }} {{ $h->ayat_mulai ? ': '.$h->ayat_mulai.($h->ayat_selesai ? '-'.$h->ayat_selesai : '') : '' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $h->tanggal->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $h->jenis === 'ziyadah' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' }}">{{ ucfirst($h->jenis) }}</span>
                    @php
                        $kColor = match($h->kualitas) {
                            'mumtaz' => 'text-emerald-600 dark:text-emerald-400',
                            'jayyid_jiddan', 'jayyid' => 'text-blue-600 dark:text-blue-400',
                            'maqbul' => 'text-amber-600 dark:text-amber-400',
                            default => 'text-red-600 dark:text-red-400',
                        };
                    @endphp
                    <span class="text-xs font-bold {{ $kColor }}">{{ $h->kualitas_label }}</span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">Belum ada hafalan</p>
            @endforelse
        </div>
    </div>

    {{-- Pengumuman --}}
    @if($announcements->isNotEmpty())
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Pengumuman</h3>
        <div class="space-y-3">
            @foreach($announcements as $ann)
            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl">
                @if($ann->is_pinned)
                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg>
                </div>
                @endif
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $ann->judul }}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">{{ $ann->konten }}</p>
                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1">{{ $ann->published_at?->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
