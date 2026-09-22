@extends('layouts.admin')
@section('title', 'Tahun Ajaran — SIAKAD')
@section('page_title', 'Tahun Ajaran')
@section('page_subtitle', 'Manajemen Tahun Ajaran Akademik')

@section('content')
<div x-data="{ showCreate: false, editId: null }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Tahun Ajaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola tahun ajaran untuk sistem akademik</p>
        </div>
        <button @click="showCreate = !showCreate"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tahun Ajaran
        </button>
    </div>

    {{-- Create Form --}}
    <div x-show="showCreate" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.tahun-ajaran.store') }}" method="POST" class="flex flex-col sm:flex-row items-end gap-4">
            @csrf
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Tahun Ajaran</label>
                <input type="text" name="nama" placeholder="Contoh: 2026/2027" required
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
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
                        <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Semester</th>
                        <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($tahunAjarans as $ta)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-6 py-4">
                            <template x-if="editId === {{ $ta->id }}">
                                <form action="{{ route('admin.siakad.tahun-ajaran.update', $ta->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="nama" value="{{ $ta->nama }}" class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                    <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg">Simpan</button>
                                    <button type="button" @click="editId = null" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg">Batal</button>
                                </form>
                            </template>
                            <template x-if="editId !== {{ $ta->id }}">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $ta->nama }}</span>
                            </template>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 text-xs font-semibold rounded-lg">{{ $ta->semesters_count }} semester</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.siakad.tahun-ajaran.toggle', $ta->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-all {{ $ta->is_active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $ta->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                    {{ $ta->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button @click="editId = {{ $ta->id }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.siakad.tahun-ajaran.destroy', $ta->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada tahun ajaran</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Klik tombol "Tambah Tahun Ajaran" untuk memulai</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
