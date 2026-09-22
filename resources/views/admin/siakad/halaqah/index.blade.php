@extends('layouts.admin')
@section('title', 'Kelola Halaqah — SIAKAD')
@section('page_title', 'Kelola Halaqah')
@section('page_subtitle', 'Manajemen halaqah per semester')

@section('content')
<div x-data="{ showCreate: false }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Halaqah</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                @if($activeSemester) Semester: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $activeSemester->label }}</span> @else Belum ada semester aktif @endif
            </p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <select name="semester_id" onchange="this.form.submit()" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm">
                    <option value="">-- Pilih Semester --</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem->id }}" {{ $activeSemester && $activeSemester->id == $sem->id ? 'selected' : '' }}>{{ $sem->label }}</option>
                    @endforeach
                </select>
            </form>
            @if($activeSemester)
            <button @click="showCreate = !showCreate"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Halaqah
            </button>
            @endif
        </div>
    </div>

    {{-- Create Form --}}
    @if($activeSemester)
    <div x-show="showCreate" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.halaqah.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            @csrf
            <input type="hidden" name="semester_id" value="{{ $activeSemester->id }}">
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Halaqah</label>
                <input type="text" name="nama" placeholder="Halaqah Al-Fatih" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Ustadz Pengampu</label>
                <select name="ustadz_id" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    @foreach($ustadzs as $ust)
                        <option value="{{ $ust->id }}">{{ $ust->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan</button>
        </form>
    </div>
    @endif

    {{-- Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($halaqahs as $hq)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr($hq->nama, 0, 2)) }}</div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $hq->nama }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hq->ustadz->nama_lengkap ?? 'Belum ada ustadz' }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    {{ $hq->santris_count }} santri
                </span>
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('admin.siakad.halaqah.show', $hq->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <form action="{{ route('admin.siakad.halaqah.destroy', $hq->id) }}" method="POST" onsubmit="return confirm('Hapus halaqah ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 px-6 py-12 text-center">
            <p class="text-sm text-gray-400">Belum ada halaqah di semester ini</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
