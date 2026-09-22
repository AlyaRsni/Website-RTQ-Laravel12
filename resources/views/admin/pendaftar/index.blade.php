@extends('layouts.admin')

@section('title', 'Data Pendaftar — Admin RTQ Kawali')
@section('page_title', 'Data Pendaftar')
@section('page_subtitle', 'Kelola semua data calon santri')

@section('content')
<div class="space-y-5">
    {{-- Search & Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, telepon, atau nomor peserta..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:text-white transition-all">
            </div>
            <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white min-w-[180px]">
                <option value="">Semua Status</option>
                <option value="belum_diajukan" {{ request('status') === 'belum_diajukan' ? 'selected' : '' }}>Belum Diajukan</option>
                <option value="menunggu_verifikasi_berkas" {{ request('status') === 'menunggu_verifikasi_berkas' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="perlu_perbaikan" {{ request('status') === 'perlu_perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors">Cari</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-16">No. Urut</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pendaftar</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Telepon</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progress</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($pendaftar as $i => $reg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $pendaftar->firstItem() + $i }}</td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $reg->nama_lengkap ?? $reg->user->name ?? '-' }}</p>
                            <p class="text-[11px] text-gray-400">{{ $reg->nomor_peserta ?? 'Belum ada nomor' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $reg->user->phone ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $reg->getProgressPercentage() >= 100 ? 'bg-emerald-500' : 'bg-indigo-500' }}" style="width: {{ $reg->getProgressPercentage() }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ $reg->getProgressPercentage() }}%</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 hidden lg:table-cell">
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
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.pendaftar.show', $reg->id) }}" class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">Detail</a>
                                <form action="{{ route('admin.pendaftar.destroy', $reg->id) }}" method="POST" x-data onsubmit="return confirm('Yakin hapus data pendaftar ini? Tindakan tidak bisa dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <p class="text-sm font-medium">Belum ada data pendaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendaftar->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/40">
            {{ $pendaftar->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
