@extends('layouts.admin')
@section('title', $halaqah->nama . ' — SIAKAD')
@section('page_title', $halaqah->nama)
@section('page_subtitle', 'Ustadz: ' . ($halaqah->ustadz->nama_lengkap ?? '-'))

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- Info Card --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold">{{ strtoupper(substr($halaqah->nama, 0, 2)) }}</div>
            <div>
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $halaqah->nama }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $halaqah->semester->label ?? '' }} · Ustadz: {{ $halaqah->ustadz->nama_lengkap ?? '-' }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $halaqah->santris->count() }} santri terdaftar</p>
            </div>
        </div>
    </div>

    {{-- Add Santri --}}
    @if($availableSantris->count())
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Tambah Santri ke Halaqah</h3>
        <form action="{{ route('admin.siakad.halaqah.add-santri', $halaqah->id) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-4 max-h-64 overflow-y-auto">
                @foreach($availableSantris as $s)
                <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                    <input type="checkbox" name="santri_ids[]" value="{{ $s->id }}" class="w-4 h-4 text-indigo-600 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $s->nama_lengkap }}</p>
                        <p class="text-xs text-gray-400">{{ $s->nis }}</p>
                    </div>
                </label>
                @endforeach
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">Tambahkan Santri Terpilih</button>
        </form>
    </div>
    @endif

    {{-- Current Members --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <h3 class="font-bold text-gray-900 dark:text-white">Anggota Halaqah</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-6 py-3 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs">#</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs">NIS</th>
                        <th class="text-left px-6 py-3 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs">Nama</th>
                        <th class="text-right px-6 py-3 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($halaqah->santris as $i => $santri)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-6 py-3 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-3"><span class="text-xs font-mono text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-0.5 rounded">{{ $santri->nis }}</span></td>
                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</td>
                        <td class="px-6 py-3 text-right">
                            <form action="{{ route('admin.siakad.halaqah.remove-santri', [$halaqah->id, $santri->id]) }}" method="POST" onsubmit="return confirm('Keluarkan santri dari halaqah ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-semibold">Keluarkan</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada santri di halaqah ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.siakad.halaqah.index') }}" class="inline-flex px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">← Kembali</a>
</div>
@endsection
