@extends('layouts.ustadz-halaqah')
@section('title', 'Rekap Absensi Shalat — Ustadz Halaqah')
@section('page_title', 'Rekap Absensi Shalat')
@section('page_subtitle', 'Riwayat kehadiran shalat berjamaah')

@section('content')
<div class="space-y-6">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <form method="GET" action="{{ route('siakad.ustadz.absensi-shalat.rekap') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $tanggalMulai }}"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ $tanggalAkhir }}"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>
            <div class="w-full sm:w-48">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Waktu Shalat</label>
                <select name="waktu_shalat"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="">Semua</option>
                    @foreach(['subuh','dzuhur','ashar','maghrib','isya'] as $w)
                    <option value="{{ $w }}" {{ $waktuShalat === $w ? 'selected' : '' }}>{{ ucfirst($w) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                Filter
            </button>
        </form>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalRecord }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Total Record</p>
        </div>
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $totalHari }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Jumlah Hari</p>
        </div>
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 text-center">
            <p class="text-2xl font-extrabold text-amber-600 dark:text-amber-400">{{ $totalHari > 0 ? round($totalRecord / $totalHari) : 0 }}</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Rata-rata/Hari</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Absensi</h3>
            <a href="{{ route('siakad.ustadz.absensi-shalat.index') }}" class="text-xs font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700">← Kembali ke Scan</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Santri</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Shalat</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Metode</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($attendances as $att)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($att->santri->nama_lengkap ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $att->santri->nama_lengkap ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $att->santri->nis ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $att->waktu_label }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">
                            {{ $att->tanggal->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold {{ $att->status === 'hadir' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' }}">
                                {{ $att->status === 'hadir' ? '✓ Hadir' : '⏰ Terlambat' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="text-xs font-medium {{ $att->metode === 'rfid' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                                {{ $att->metode === 'rfid' ? '📡 RFID' : '✍️ Manual' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                            <p class="text-sm">Tidak ada data pada periode ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($attendances->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/50">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
