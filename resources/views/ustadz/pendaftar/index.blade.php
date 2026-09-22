@extends('layouts.ustadz')

@section('title', 'Data Pendaftar — Ustadz RTQ Kawali')
@section('page_title', 'Data Pendaftar')
@section('page_subtitle', 'Daftar calon santri yang sudah finalisasi')

@section('content')
<div class="space-y-5">
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau nomor peserta..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
            </div>
            <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white min-w-[180px]">
                <option value="">Semua Status</option>
                <option value="menunggu_verifikasi_berkas" {{ request('status') === 'menunggu_verifikasi_berkas' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="perlu_perbaikan" {{ request('status') === 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white text-sm font-semibold rounded-xl hover:bg-teal-700 transition-colors">Cari</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-16 hidden sm:table-cell">No. Urut</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pendaftar</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Nomor Peserta</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($pendaftar as $index => $reg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 text-xs hidden sm:table-cell">{{ $pendaftar->firstItem() + $index }}</td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $reg->nama_lengkap ?? $reg->user->name }}</p>
                            <p class="text-[11px] text-gray-400">Finalisasi: {{ $reg->finalisasi_at?->format('d/m/Y H:i') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 font-mono text-xs hidden md:table-cell">{{ $reg->nomor_peserta ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $badge = match($reg->status_verifikasi) {
                                    'terverifikasi' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    'menunggu_verifikasi_berkas' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    'perlu_perbaikan' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                    default => 'bg-gray-100 dark:bg-gray-800 text-gray-500',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ $reg->getStepStatus(6) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('ustadz.pendaftar.show', $reg->id) }}" class="px-3 py-1.5 text-xs font-semibold text-teal-600 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/20 rounded-lg hover:bg-teal-100 dark:hover:bg-teal-900/40 transition-colors">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400">Belum ada pendaftar yang sudah finalisasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendaftar->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/40">{{ $pendaftar->links() }}</div>
        @endif
    </div>
</div>
@endsection
