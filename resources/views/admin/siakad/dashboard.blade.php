@extends('layouts.admin')

@section('title', 'Dashboard SIAKAD — RTQ Kawali')
@section('page_title', 'Dashboard SIAKAD')
@section('page_subtitle', 'Overview Sistem Informasi Akademik' . ($activeYear ? ' — ' . $activeYear->nama : ''))

@section('content')
<div class="space-y-6 lg:space-y-8">

    {{-- ═══════════════════════════════════════════════
         SECTION 1 — Hero Stat Cards
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
        @php
            $heroStats = [
                [
                    'label' => 'Total Santri',
                    'value' => $totalSantri,
                    'sub'   => $santriAktif . ' aktif',
                    'icon'  => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    'color' => 'indigo',
                    'gradient' => 'from-indigo-500 to-violet-600',
                ],
                [
                    'label' => 'Ustadz Halaqah',
                    'value' => $totalUstadz,
                    'sub'   => $ustadzAktif . ' aktif',
                    'icon'  => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'color' => 'emerald',
                    'gradient' => 'from-emerald-500 to-teal-600',
                ],
                [
                    'label' => 'Halaqah',
                    'value' => $totalHalaqah,
                    'sub'   => $activeSemester ? $activeSemester->label : '-',
                    'icon'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'color' => 'amber',
                    'gradient' => 'from-amber-500 to-orange-600',
                ],
                [
                    'label' => 'Rata-rata Kehadiran',
                    'value' => $rataKehadiran . '%',
                    'sub'   => '30 hari terakhir',
                    'icon'  => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'cyan',
                    'gradient' => 'from-cyan-500 to-blue-600',
                ],
            ];
        @endphp

        @foreach($heroStats as $idx => $stat)
        <div class="relative overflow-hidden bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-{{ $stat['color'] }}-200/30 dark:hover:shadow-none transition-all duration-300 group"
             style="animation: fadeSlideUp 0.5s {{ $idx * 0.1 }}s both ease-out">
            {{-- Gradient glow --}}
            <div class="absolute -top-8 -right-8 w-24 h-24 bg-gradient-to-br {{ $stat['gradient'] }} rounded-full opacity-10 group-hover:opacity-20 group-hover:scale-125 transition-all duration-500"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $stat['gradient'] }} flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-{{ $stat['color'] }}-500/20">
                        <svg class="w-5.5 h-5.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                </div>
                <p class="text-2xl lg:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">{{ $stat['label'] }}</p>
                <p class="text-[11px] text-{{ $stat['color'] }}-500 dark:text-{{ $stat['color'] }}-400 font-semibold mt-0.5">{{ $stat['sub'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 2 — Quick Info Mini Cards
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3">
        @php
            $miniCards = [
                ['label' => 'Asrama',      'value' => $totalAsrama,       'dot' => 'bg-violet-500',  'icon' => '🏠'],
                ['label' => 'Mata Pelajaran','value' => $totalMapel,      'dot' => 'bg-blue-500',    'icon' => '📚'],
                ['label' => 'Total Hafalan','value' => $totalHafalan,     'dot' => 'bg-emerald-500', 'icon' => '📖'],
                ['label' => 'Hafalan Bulan Ini','value' => $hafalanBulanIni,'dot' => 'bg-teal-500', 'icon' => '🗓️'],
                ['label' => 'Pelanggaran',  'value' => $totalPelanggaran, 'dot' => 'bg-red-500',     'icon' => '⚠️'],
                ['label' => 'Prestasi',     'value' => $totalPrestasi,    'dot' => 'bg-amber-500',   'icon' => '⭐'],
            ];
        @endphp

        @foreach($miniCards as $mc)
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
            <span class="text-lg">{{ $mc['icon'] }}</span>
            <div class="min-w-0">
                <p class="text-lg font-bold text-gray-900 dark:text-white leading-none">{{ $mc['value'] }}</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5 truncate">{{ $mc['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 3 — Charts Row
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Bar: Status Santri --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Status Santri</h3>
                <span class="text-[11px] font-semibold text-indigo-500 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded-md">{{ $totalSantri }} total</span>
            </div>
            <div class="h-56">
                <canvas id="statusSantriChart"></canvas>
            </div>
        </div>

        {{-- Doughnut: Gender --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Jenis Kelamin</h3>
            </div>
            <div class="h-56 flex items-center justify-center">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        {{-- Doughnut: Kehadiran --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Kehadiran 30 Hari</h3>
                <span class="text-[11px] font-semibold text-emerald-500 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-md">{{ $rataKehadiran }}% hadir</span>
            </div>
            <div class="h-56 flex items-center justify-center">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 4 — Attendance Trend + Hafalan Quality
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Line: Attendance Trend 7 Hari --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Tren Kehadiran 7 Hari</h3>
            <div class="h-64">
                <canvas id="attendanceTrendChart"></canvas>
            </div>
        </div>

        {{-- Horizontal Bar: Hafalan Quality --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Kualitas Hafalan</h3>
                <span class="text-[11px] font-semibold text-emerald-500 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-md">{{ $totalHafalan }} record</span>
            </div>
            <div class="h-64">
                <canvas id="hafalanQualityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 5 — Asrama Occupancy + Nilai Overview
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Asrama Occupancy --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Kapasitas Asrama</h3>
            <div class="space-y-4">
                @forelse($asramaData as $asrama)
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $asrama->nama }}</span>
                        </div>
                        <span class="text-xs font-bold {{ $asrama->santris_count >= $asrama->kapasitas ? 'text-red-500' : 'text-emerald-500' }}">
                            {{ $asrama->santris_count }}/{{ $asrama->kapasitas }}
                        </span>
                    </div>
                    @php
                        $pct = $asrama->kapasitas > 0 ? round(($asrama->santris_count / $asrama->kapasitas) * 100) : 0;
                        $barColor = $pct >= 90 ? 'bg-red-500' : ($pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500');
                    @endphp
                    <div class="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $barColor }} transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                    @if($asrama->keterangan)
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">{{ $asrama->keterangan }}</p>
                    @endif
                </div>
                @empty
                <p class="text-sm text-gray-400 dark:text-gray-500 py-4 text-center">Belum ada data asrama</p>
                @endforelse
            </div>
        </div>

        {{-- Nilai & Disiplin Summary --}}
        <div class="space-y-5">
            {{-- Rata-rata Nilai --}}
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Performa Akademik</h3>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <span class="text-xl font-extrabold text-white">{{ $avgNilai }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Rata-rata Nilai</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">dari {{ $totalNilai }} record</p>
                    </div>
                </div>
            </div>

            {{-- Disiplin Summary --}}
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Kedisiplinan</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-3 text-center">
                        <p class="text-xl font-extrabold text-red-600 dark:text-red-400">{{ $totalPelanggaran }}</p>
                        <p class="text-[11px] text-red-500 dark:text-red-400 font-medium mt-0.5">Pelanggaran</p>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-xl p-3 text-center">
                        <p class="text-xl font-extrabold text-amber-600 dark:text-amber-400">{{ $totalPrestasi }}</p>
                        <p class="text-[11px] text-amber-500 dark:text-amber-400 font-medium mt-0.5">Prestasi</p>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-2 text-center">{{ $disiplinBulanIni }} catatan bulan ini</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 6 — Recent Activity + Announcements + Santri Terbaru
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Recent Activity Feed --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-50 dark:divide-gray-700/30">
                @forelse($recentActivity as $activity)
                <div class="px-5 py-3.5 flex items-start gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                    <span class="text-lg mt-0.5">{{ $activity['icon'] }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $activity['desc'] }}</p>
                    </div>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 shrink-0">
                        {{ \Carbon\Carbon::parse($activity['time'])->format('d M') }}
                    </span>
                </div>
                @empty
                <div class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                    <p class="text-sm">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Announcements --}}
        <div class="space-y-5">
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">📢 Pengumuman</h3>
                    <a href="{{ route('admin.siakad.pengumuman.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">Kelola →</a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($announcements as $ann)
                    <div class="px-5 py-3.5">
                        <div class="flex items-center gap-2 mb-1">
                            @if($ann->is_pinned)
                            <span class="text-[10px] font-bold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-1.5 py-0.5 rounded">📌 Pinned</span>
                            @endif
                            <span class="text-[11px] text-gray-400">{{ $ann->published_at->format('d M Y') }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $ann->judul }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 line-clamp-2">{{ Str::limit($ann->konten, 100) }}</p>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-gray-400 dark:text-gray-500">
                        <p class="text-sm">Belum ada pengumuman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 7 — Santri Terbaru Table
    ═══════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Santri Terbaru</h3>
            <a href="{{ route('admin.siakad.santri.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Asrama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">JK</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($santriTerbaru as $s)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-mono font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded">{{ $s->nis }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $s->nama_lengkap }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $s->tempat_lahir ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">{{ $s->dormitory->nama ?? '-' }}</td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="text-xs font-medium {{ $s->jenis_kelamin === 'laki-laki' ? 'text-blue-600 dark:text-blue-400' : 'text-pink-600 dark:text-pink-400' }}">
                                {{ $s->jenis_kelamin === 'laki-laki' ? '♂ L' : '♀ P' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $badge = match($s->status) {
                                    'aktif'    => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    'nonaktif' => 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400',
                                    'lulus'    => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    'pindah'   => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    default    => 'bg-gray-100 text-gray-500',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ ucfirst($s->status) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('admin.siakad.santri.show', $s->id) }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 transition-colors">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                            <p class="text-sm">Belum ada data santri</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SECTION 8 — Quick Actions
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $actions = [
                ['route' => 'admin.siakad.santri.create', 'title' => 'Tambah Santri', 'desc' => 'Daftarkan santri baru', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'gradient' => 'from-indigo-500 to-purple-600'],
                ['route' => 'admin.siakad.halaqah.index', 'title' => 'Kelola Halaqah', 'desc' => 'Atur kelompok halaqah', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'gradient' => 'from-amber-500 to-orange-600'],
                ['route' => 'admin.siakad.pengumuman.index', 'title' => 'Pengumuman', 'desc' => 'Buat pengumuman baru', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z', 'gradient' => 'from-emerald-500 to-teal-600'],
                ['route' => 'admin.siakad.ustadz.index', 'title' => 'Kelola Ustadz', 'desc' => 'Tambah & atur ustadz', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'gradient' => 'from-cyan-500 to-blue-600'],
            ];
        @endphp

        @foreach($actions as $act)
        <a href="{{ route($act['route']) }}" class="group bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5 hover:shadow-lg hover:shadow-gray-200/50 dark:hover:shadow-none transition-all duration-300 hover:-translate-y-0.5">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $act['gradient'] }} flex items-center justify-center mb-3 group-hover:scale-110 group-hover:rotate-3 transition-all shadow-lg shadow-gray-300/20 dark:shadow-none">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $act['icon'] }}"/></svg>
            </div>
            <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $act['title'] }}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $act['desc'] }}</p>
        </a>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     Charts Script
═══════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor  = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor  = isDark ? 'rgba(255,255,255,0.5)' : 'rgba(0,0,0,0.5)';

    const commonScaleOpts = {
        grid: { color: gridColor },
        ticks: { color: textColor, font: { size: 10 } },
    };

    // ── 1. Status Santri (Bar Chart) ──
    new Chart(document.getElementById('statusSantriChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($statusBreakdown)) !!},
            datasets: [{
                data: {!! json_encode(array_values($statusBreakdown)) !!},
                backgroundColor: ['#10b981', '#94a3b8', '#3b82f6', '#f59e0b'],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ...commonScaleOpts, grid: { display: false } },
                y: { ...commonScaleOpts, beginAtZero: true, ticks: { ...commonScaleOpts.ticks, stepSize: 1 } },
            }
        }
    });

    // ── 2. Gender (Doughnut) ──
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($genderBreakdown)) !!},
            datasets: [{
                data: {!! json_encode(array_values($genderBreakdown)) !!},
                backgroundColor: ['#6366f1', '#ec4899'],
                borderWidth: 0, spacing: 3,
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

    // ── 3. Kehadiran (Doughnut) ──
    new Chart(document.getElementById('attendanceChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($attendanceBreakdown)) !!},
            datasets: [{
                data: {!! json_encode(array_values($attendanceBreakdown)) !!},
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                borderWidth: 0, spacing: 3,
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

    // ── 4. Attendance Trend (Line Chart) ──
    const trendData = @json($attendanceTrend);
    new Chart(document.getElementById('attendanceTrendChart'), {
        type: 'line',
        data: {
            labels: trendData.map(d => {
                const dt = new Date(d.date);
                return dt.getDate() + '/' + (dt.getMonth()+1);
            }),
            datasets: [
                {
                    label: 'Hadir',
                    data: trendData.map(d => d.hadir),
                    borderColor: '#10b981',
                    backgroundColor: isDark ? 'rgba(16,185,129,0.1)' : 'rgba(16,185,129,0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                },
                {
                    label: 'Tidak Hadir',
                    data: trendData.map(d => d.tidak_hadir),
                    borderColor: '#ef4444',
                    backgroundColor: isDark ? 'rgba(239,68,68,0.1)' : 'rgba(239,68,68,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#ef4444',
                }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { color: textColor, font: { size: 11 }, padding: 12, usePointStyle: true, pointStyleWidth: 8 } }
            },
            scales: {
                x: { ...commonScaleOpts, grid: { display: false } },
                y: { ...commonScaleOpts, beginAtZero: true, ticks: { ...commonScaleOpts.ticks, stepSize: 1 } },
            }
        }
    });

    // ── 5. Hafalan Quality (Horizontal Bar) ──
    new Chart(document.getElementById('hafalanQualityChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($hafalanQuality)) !!},
            datasets: [{
                data: {!! json_encode(array_values($hafalanQuality)) !!},
                backgroundColor: ['#10b981', '#14b8a6', '#06b6d4', '#f59e0b', '#ef4444'],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ...commonScaleOpts, beginAtZero: true, ticks: { ...commonScaleOpts.ticks, stepSize: 1 } },
                y: { ...commonScaleOpts, grid: { display: false } },
            }
        }
    });
});
</script>

<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
