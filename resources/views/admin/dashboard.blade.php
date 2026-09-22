@extends('layouts.admin')

@section('title', 'Dashboard Admin — RTQ Kawali')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview PPDB Tahun Ajaran 2026/2027')

@section('content')
<div class="space-y-6 lg:space-y-8">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
        @php
            $stats = [
                ['label' => 'Total Pendaftar', 'value' => $totalPendaftar, 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'indigo', 'bg' => 'from-indigo-500 to-indigo-600'],
                ['label' => 'Terverifikasi', 'value' => $terverifikasi, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'bg' => 'from-emerald-500 to-emerald-600'],
                ['label' => 'Menunggu Verifikasi', 'value' => $menungguVerifikasi, 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'bg' => 'from-amber-500 to-amber-600'],
                ['label' => 'Rata-rata Progress', 'value' => $avgProgress . '%', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'color' => 'cyan', 'bg' => 'from-cyan-500 to-cyan-600'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-gray-200/50 dark:hover:shadow-none transition-all duration-300 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Mini stat cards row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
            $miniStats = [
                ['label' => 'Sudah Finalisasi', 'value' => $sudahFinalisasi, 'dot' => 'bg-blue-500'],
                ['label' => 'Perlu Perbaikan', 'value' => $perluPerbaikan, 'dot' => 'bg-orange-500'],
                ['label' => 'Nomor Peserta', 'value' => $sudahNomor, 'dot' => 'bg-purple-500'],
                ['label' => 'Ustadz PPDB', 'value' => $totalUstadz, 'dot' => 'bg-teal-500'],
            ];
        @endphp

        @foreach($miniStats as $ms)
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3">
            <span class="w-2 h-2 rounded-full {{ $ms['dot'] }} shrink-0"></span>
            <div>
                <p class="text-lg font-bold text-gray-900 dark:text-white leading-none">{{ $ms['value'] }}</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $ms['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Bar Chart: Pendaftar per hari --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Pendaftar 30 Hari Terakhir</h3>
            <div class="h-64">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        {{-- Doughnut: Status Breakdown --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Status Verifikasi</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('admin.export.csv') }}" class="group bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-indigo-200/30 dark:hover:shadow-none hover:border-indigo-300 dark:hover:border-indigo-700/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            </div>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Export Data CSV</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Download semua data pendaftar</p>
        </a>

        <a href="{{ route('admin.hasil-seleksi.index') }}" class="group bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-purple-200/30 dark:hover:shadow-none hover:border-purple-300 dark:hover:border-purple-700/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Hasil Seleksi</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Upload & kelola PDF hasil</p>
        </a>

        <a href="{{ route('admin.ustadz.index') }}" class="group bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-teal-200/30 dark:hover:shadow-none hover:border-teal-300 dark:hover:border-teal-700/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Kelola Ustadz</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tambah & kelola akun ustadz</p>
        </a>
    </div>

    {{-- Recent Pendaftar --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Pendaftar Terbaru</h3>
            <a href="{{ route('admin.pendaftar.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Telepon</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progress</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($recentPendaftar as $reg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ strtoupper(substr($reg->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $reg->nama_lengkap ?? $reg->user->name ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $reg->nomor_peserta ?? 'Belum ada nomor' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">{{ $reg->user->phone ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $reg->getProgressPercentage() >= 100 ? 'bg-emerald-500' : 'bg-indigo-500' }}" style="width: {{ $reg->getProgressPercentage() }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $reg->getProgressPercentage() }}%</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            @php
                                $badge = match($reg->status_verifikasi) {
                                    'terverifikasi' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    'menunggu_verifikasi_berkas' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    'perlu_perbaikan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                    default => 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ $reg->getStepStatus(6) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.pendaftar.show', $reg->id) }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                            <p class="text-sm">Belum ada pendaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? 'rgba(255,255,255,0.5)' : 'rgba(0,0,0,0.5)';

    // Bar Chart
    new Chart(document.getElementById('dailyChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyData->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))) !!},
            datasets: [{
                label: 'Pendaftar',
                data: {!! json_encode($dailyData->pluck('count')) !!},
                backgroundColor: isDark ? 'rgba(99,102,241,0.6)' : 'rgba(99,102,241,0.8)',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 10 }, stepSize: 1 }, beginAtZero: true },
            }
        }
    });

    // Doughnut
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($statusBreakdown)) !!},
            datasets: [{
                data: {!! json_encode(array_values($statusBreakdown)) !!},
                backgroundColor: ['#94a3b8', '#f59e0b', '#f97316', '#10b981'],
                borderWidth: 0,
                spacing: 2,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: textColor, font: { size: 11 }, padding: 12, usePointStyle: true, pointStyleWidth: 8 } }
            }
        }
    });
});
</script>
@endsection
