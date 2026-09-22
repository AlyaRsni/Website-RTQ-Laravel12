@extends('layouts.santri')
@section('title', 'Absensi Shalat — Santri')
@section('page_title', 'Absensi Shalat')
@section('page_subtitle', 'Riwayat kehadiran shalat berjamaah')

@section('content')
<div class="space-y-6">
    {{-- Filter Bulan/Tahun --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <form method="GET" action="{{ route('siakad.santri.absensi-shalat') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Bulan</label>
                <select name="bulan" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-full sm:w-32">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tahun</label>
                <select name="tahun" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-teal-500/25 transition-all">
                Filter
            </button>
        </form>
    </div>

    {{-- Summary Cards per Waktu Shalat --}}
    <div class="grid grid-cols-5 gap-3">
        @foreach(['subuh' => '🌅', 'dzuhur' => '☀️', 'ashar' => '🌤️', 'maghrib' => '🌇', 'isya' => '🌙'] as $key => $emoji)
        @php $pct = $hariSampaiSekarang > 0 ? round(($prayerStats[$key] ?? 0) / $hariSampaiSekarang * 100) : 0; @endphp
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-3 py-4 text-center">
            <span class="text-2xl">{{ $emoji }}</span>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $prayerStats[$key] ?? 0 }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ ucfirst($key) }}</p>
            <div class="mt-2 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500 {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-400') }}" style="width: {{ $pct }}%"></div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1">{{ $pct }}% dari {{ $hariSampaiSekarang }} hari</p>
        </div>
        @endforeach
    </div>

    {{-- Statistik Ringkasan --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalRecord }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Total Kehadiran</p>
        </div>
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $hariSampaiSekarang * 5 }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Target Shalat</p>
        </div>
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            @php $totalPct = ($hariSampaiSekarang * 5) > 0 ? round($totalRecord / ($hariSampaiSekarang * 5) * 100) : 0; @endphp
            <p class="text-2xl font-extrabold {{ $totalPct >= 80 ? 'text-emerald-600 dark:text-emerald-400' : ($totalPct >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $totalPct }}%</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Persentase</p>
        </div>
    </div>

    {{-- Detail Harian --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Detail Harian — {{ \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400">🌅 Subuh</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400">☀️ Dzuhur</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400">🌤️ Ashar</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400">🌇 Maghrib</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400">🌙 Isya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @php
                        $maxDay = ($bulan == now()->month && $tahun == now()->year) ? now()->day : \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;
                    @endphp
                    @for($d = $maxDay; $d >= 1; $d--)
                    @php
                        $dateStr = sprintf('%04d-%02d-%02d', $tahun, $bulan, $d);
                        $dayData = $dailyData[$dateStr] ?? collect();
                        $dayAttendances = $dayData->keyBy('waktu_shalat');
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($dateStr)->translatedFormat('d M (D)') }}
                        </td>
                        @foreach(['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'] as $wk)
                        <td class="px-3 py-3 text-center">
                            @if(isset($dayAttendances[$wk]))
                                @php $att = $dayAttendances[$wk]; @endphp
                                <span class="inline-flex w-7 h-7 rounded-lg items-center justify-center {{ $att->status === 'hadir' ? 'bg-emerald-100 dark:bg-emerald-900/30' : 'bg-amber-100 dark:bg-amber-900/30' }}">
                                    {{ $att->status === 'hadir' ? '✓' : '⏰' }}
                                </span>
                            @else
                                <span class="inline-flex w-7 h-7 rounded-lg items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-300 dark:text-gray-600">—</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
