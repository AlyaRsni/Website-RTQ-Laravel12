@extends('layouts.admin')
@section('title', 'Ustadz Halaqah — SIAKAD')
@section('page_title', 'Ustadz Halaqah')
@section('page_subtitle', 'Kelola data ustadz pengampu halaqah')

@section('content')
<div x-data="{ showCreate: false }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Ustadz Halaqah</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ustadzs->count() }} ustadz terdaftar</p>
        </div>
        <button @click="showCreate = !showCreate"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Ustadz
        </button>
    </div>

    {{-- Create Form --}}
    <div x-show="showCreate" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.ustadz.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">No. Telepon <span class="text-red-500">*</span></label>
                <input type="text" name="phone" required placeholder="08xxx" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password <span class="text-red-500">*</span></label>
                <input type="text" name="password" value="password123" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Spesialisasi</label>
                <input type="text" name="spesialisasi" placeholder="Tahfidz / Fiqih" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nama</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">NIP</th>
                        <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Spesialisasi</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Halaqah</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($ustadzs as $ust)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($ust->nama_lengkap, 0, 1)) }}</div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $ust->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-400">{{ $ust->user->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $ust->nip ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $ust->spesialisasi ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg">{{ $ust->halaqahs_count }} halaqah</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $ust->status === 'aktif' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $ust->status === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ ucfirst($ust->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.siakad.ustadz.destroy', $ust->id) }}" method="POST" onsubmit="return confirm('Hapus ustadz ini beserta akun loginnya?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">Belum ada data ustadz halaqah</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
