@extends('layouts.admin')

@section('title', 'Kelola Ustadz — Admin RTQ Kawali')
@section('page_title', 'Kelola Ustadz PPDB')
@section('page_subtitle', 'Tambah, edit, dan hapus akun Ustadz PPDB')

@section('content')
<div class="space-y-5" x-data="{ showAdd: false, editId: null }">

    {{-- Add button --}}
    <div class="flex justify-end">
        <button @click="showAdd = !showAdd" class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Ustadz
        </button>
    </div>

    {{-- Add form --}}
    <div x-show="showAdd" x-transition class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5" style="display:none">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Tambah Ustadz Baru</h3>
        <form action="{{ route('admin.ustadz.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Nama</label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">No. Telepon</label>
                <input type="text" name="phone" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Password</label>
                <input type="password" name="password" required minlength="8" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-sm dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors">Simpan</button>
                <button type="button" @click="showAdd = false" class="px-5 py-2.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">Batal</button>
            </div>
        </form>
        @if($errors->any())
        <div class="mt-3 text-sm text-red-500">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
        @endif
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Dibuat</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($ustadzList as $ustadz)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-xs font-bold text-teal-600 dark:text-teal-400">
                                    {{ strtoupper(substr($ustadz->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $ustadz->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">{{ $ustadz->phone }}</td>
                        <td class="px-5 py-3.5 text-gray-400 text-xs hidden sm:table-cell">{{ $ustadz->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.ustadz.destroy', $ustadz->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus ustadz ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 transition-colors">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">Belum ada ustadz terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
