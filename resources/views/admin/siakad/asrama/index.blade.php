@extends('layouts.admin')
@section('title', 'Data Asrama — SIAKAD')
@section('page_title', 'Data Asrama')
@section('page_subtitle', 'Kelola kamar & asrama santri')

@section('content')
<div x-data="{ showCreate: false, editId: null }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Asrama</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $asramas->count() }} asrama terdaftar</p>
        </div>
        <button @click="showCreate = !showCreate"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Asrama
        </button>
    </div>

    {{-- Create Form --}}
    <div x-show="showCreate" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.asrama.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Asrama</label>
                <input type="text" name="nama" placeholder="Asrama Al-Fatih" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Kapasitas</label>
                <input type="number" name="kapasitas" placeholder="20" min="1" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Keterangan</label>
                <input type="text" name="keterangan" placeholder="Opsional" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan</button>
        </form>
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($asramas as $asrama)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 hover:shadow-lg transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $asrama->nama }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $asrama->keterangan ?? 'Tanpa keterangan' }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.siakad.asrama.destroy', $asrama->id) }}" method="POST" onsubmit="return confirm('Hapus asrama ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg transition-all"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                </form>
            </div>
            {{-- Occupancy bar --}}
            @php $occupancy = $asrama->santris_count ?? 0; $pct = $asrama->kapasitas > 0 ? round(($occupancy / $asrama->kapasitas) * 100) : 0; @endphp
            <div class="mb-2">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="text-gray-500 dark:text-gray-400">Terisi</span>
                    <span class="font-semibold {{ $pct > 90 ? 'text-red-600' : ($pct > 70 ? 'text-amber-600' : 'text-emerald-600') }}">{{ $occupancy }} / {{ $asrama->kapasitas }}</span>
                </div>
                <div class="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-500 {{ $pct > 90 ? 'bg-red-500' : ($pct > 70 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 px-6 py-12 text-center">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada data asrama</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
