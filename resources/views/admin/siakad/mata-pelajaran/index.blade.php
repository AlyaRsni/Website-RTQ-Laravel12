@extends('layouts.admin')
@section('title', 'Mata Pelajaran — SIAKAD')
@section('page_title', 'Mata Pelajaran / Kitab')
@section('page_subtitle', 'Kelola kategori dan mata pelajaran')

@section('content')
<div x-data="{ showCategory: false, showSubject: false, editId: null }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Mata Pelajaran</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Dikelompokkan berdasarkan kategori</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="showCategory = !showCategory"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                + Kategori
            </button>
            <button @click="showSubject = !showSubject"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                + Mata Pelajaran
            </button>
        </div>
    </div>

    {{-- Create Category --}}
    <div x-show="showCategory" x-transition x-cloak class="mb-4 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.mata-pelajaran.kategori.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Kategori</label>
                <input type="text" name="nama" placeholder="Contoh: Diniyyah, Tahfidz, Umum" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan</button>
        </form>
    </div>

    {{-- Create Subject --}}
    <div x-show="showSubject" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.mata-pelajaran.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kategori</label>
                <select name="category_id" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kode</label>
                <input type="text" name="kode" placeholder="MTK-01" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama</label>
                <input type="text" name="nama" placeholder="Nahwu Shorof" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan</button>
        </form>
    </div>

    {{-- Categories & Subjects --}}
    @forelse($categories as $cat)
    <div class="mb-4 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/30">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="font-bold text-gray-900 dark:text-white">{{ $cat->nama }}</span>
                <span class="text-xs text-gray-400 dark:text-gray-500">({{ $cat->subjects->count() }} mapel)</span>
            </div>
            <form action="{{ route('admin.siakad.mata-pelajaran.kategori.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori beserta semua mata pelajarannya?')">
                @csrf @method('DELETE')
                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
            </form>
        </div>
        @if($cat->subjects->count())
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @foreach($cat->subjects as $subj)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                    <td class="px-6 py-3 w-28"><span class="text-xs font-mono text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded">{{ $subj->kode }}</span></td>
                    <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $subj->nama }}</td>
                    <td class="px-6 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $subj->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-3 text-right">
                        <form action="{{ route('admin.siakad.mata-pelajaran.destroy', $subj->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg transition-all"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="px-6 py-8 text-center text-sm text-gray-400 dark:text-gray-500">Belum ada mata pelajaran di kategori ini</div>
        @endif
    </div>
    @empty
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 px-6 py-12 text-center">
        <div class="flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada kategori mata pelajaran</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tambahkan kategori terlebih dahulu (Diniyyah, Tahfidz, Umum)</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
