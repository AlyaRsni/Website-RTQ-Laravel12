@extends('layouts.admin')
@section('title', 'Data Santri — SIAKAD')
@section('page_title', 'Data Santri')
@section('page_subtitle', 'Kelola data santri aktif')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Santri</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total: {{ $santris->total() }} santri</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS..."
                    class="px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 w-48">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
            </form>
            <a href="{{ route('admin.siakad.santri.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Santri
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">NIS</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nama</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Jenis Kelamin</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Asrama</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($santris as $santri)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-6 py-4"><span class="text-xs font-mono text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded">{{ $santri->nis }}</span></td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $santri->asal_sekolah ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400 capitalize">{{ $santri->jenis_kelamin }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $santri->dormitory->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @php $statusColors = ['aktif' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300', 'nonaktif' => 'bg-gray-100 dark:bg-gray-700/50 text-gray-500', 'lulus' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300', 'pindah' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300']; @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$santri->status] ?? '' }}">{{ ucfirst($santri->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.siakad.santri.show', $santri->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form action="{{ route('admin.siakad.santri.destroy', $santri->id) }}" method="POST" onsubmit="return confirm('Hapus santri ini beserta akun loginnya?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada data santri</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($santris->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50">{{ $santris->links() }}</div>
        @endif
    </div>
</div>
@endsection
