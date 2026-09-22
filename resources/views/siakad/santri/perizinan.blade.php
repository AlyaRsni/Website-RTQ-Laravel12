@extends('layouts.santri')
@section('title', 'Perizinan — Santri')
@section('page_title', 'Perizinan Saya')
@section('page_subtitle', 'Riwayat perizinan dan status')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
            $statCards = [
                ['label' => 'Diajukan', 'value' => $stats['diajukan'], 'color' => 'amber',  'icon' => '📋'],
                ['label' => 'Disetujui', 'value' => $stats['disetujui'], 'color' => 'emerald','icon' => '✅'],
                ['label' => 'Ditolak',   'value' => $stats['ditolak'],   'color' => 'red',    'icon' => '❌'],
                ['label' => 'Selesai',   'value' => $stats['selesai'],   'color' => 'blue',   'icon' => '🏁'],
            ];
        @endphp
        @foreach($statCards as $sc)
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3">
            <span class="text-lg">{{ $sc['icon'] }}</span>
            <div>
                <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $sc['value'] }}</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $sc['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter & List --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        {{-- Filter --}}
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Perizinan</h3>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['' => 'Semua', 'diajukan' => '📋 Diajukan', 'disetujui' => '✅ Disetujui', 'ditolak' => '❌ Ditolak', 'selesai' => '🏁 Selesai'] as $key => $label)
                    <a href="{{ route('siakad.santri.perizinan', $key ? ['status' => $key] : []) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all
                        {{ $status === $key ? 'bg-teal-500 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Alasan</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Durasi</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($permissions as $perm)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @php
                                    $jenisIcon = match($perm->jenis) {
                                        'pulang' => '🏠', 'sakit' => '🏥', 'kegiatan' => '📅', default => '📝',
                                    };
                                @endphp
                                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-sm">
                                    {{ $jenisIcon }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $perm->jenis_label }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 hidden sm:table-cell">
                            <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $perm->alasan }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $perm->tanggal_mulai->format('d M') }} — {{ $perm->tanggal_selesai->format('d M Y') }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                <span class="text-xs text-gray-400">{{ $perm->durasi }} hari</span>
                                @if($perm->jam_keluar || $perm->jam_kembali)
                                    <span class="text-[10px] text-gray-400 dark:text-gray-500">
                                        @if($perm->jam_keluar)🕐 {{ substr($perm->jam_keluar, 0, 5) }}@endif
                                        @if($perm->jam_keluar && $perm->jam_kembali) — @endif
                                        @if($perm->jam_kembali){{ substr($perm->jam_kembali, 0, 5) }}@endif
                                    </span>
                                @endif
                            </div>
                            @if($perm->is_terlambat)
                                <div class="mt-1 inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/30 rounded-lg animate-pulse">
                                    <svg class="w-3 h-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                    <span class="text-[10px] font-bold text-red-600 dark:text-red-400">TERLAMBAT</span>
                                    @if($perm->keterlambatan)
                                        <span class="text-[10px] text-red-500 dark:text-red-400">{{ $perm->keterlambatan }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $badge = match($perm->status) {
                                    'diajukan'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    'disetujui' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    'ditolak'   => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                    'selesai'   => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    default     => 'bg-gray-100 text-gray-500',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ ucfirst($perm->status) }}</span>
                        </td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $perm->catatan_ustadz ?? '—' }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm">Belum ada data perizinan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($permissions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/50">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
