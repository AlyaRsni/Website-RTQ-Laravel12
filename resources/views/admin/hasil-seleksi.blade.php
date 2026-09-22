@extends('layouts.admin')

@section('title', 'Hasil Seleksi — Admin RTQ Kawali')
@section('page_title', 'Hasil Seleksi')
@section('page_subtitle', 'Upload PDF hasil seleksi & kelola akses download')

@section('content')
<div class="space-y-5">

    {{-- Toggle Card --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-5" x-data="{ enabled: {{ $globalToggle ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Download Hasil Seleksi</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Aktifkan agar calon santri dapat mengunduh hasil seleksi mereka</p>
            </div>
            <form action="{{ route('admin.hasil-seleksi.toggle') }}" method="POST" id="toggleForm">
                @csrf
                <input type="hidden" name="enable" :value="enabled ? '0' : '1'">
                <button type="submit"
                    class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                    :class="enabled ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600'"
                    @click.prevent="if(confirm(enabled ? 'Nonaktifkan download untuk semua calon santri?' : 'Aktifkan download untuk semua calon santri?')) { $el.closest('form').submit() }">
                    <span class="pointer-events-none inline-block h-6 w-6 rounded-full bg-white shadow-lg ring-0 transition-transform duration-200 ease-in-out"
                        :class="enabled ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
            </form>
        </div>
        <div class="mt-3 flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold" :class="enabled ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400'">
                <span x-text="enabled ? '✅ Aktif — Calon santri dapat mengunduh' : '🔒 Nonaktif — Download ditutup'"></span>
            </span>
        </div>
    </div>

    {{-- Upload Table --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/40">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Calon Santri dengan Nomor Peserta</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Upload PDF hasil keputusan seleksi per calon santri</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Nomor</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status PDF</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($registrations as $reg)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $reg->nama_lengkap ?? $reg->user->name }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell font-mono text-xs">{{ $reg->nomor_peserta }}</td>
                        <td class="px-5 py-3.5">
                            @if($reg->hasil_seleksi_pdf)
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">✅ Uploaded</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">Belum Upload</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.hasil-seleksi.upload', $reg->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2" x-data="{ file: null }">
                                    @csrf
                                    <label class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors cursor-pointer">
                                        {{ $reg->hasil_seleksi_pdf ? 'Ganti' : 'Upload' }} PDF
                                        <input type="file" name="hasil_pdf" accept=".pdf" class="hidden" @change="file = $event.target.files[0]; $el.closest('form').submit()">
                                    </label>
                                </form>
                                @if($reg->hasil_seleksi_pdf)
                                <form action="{{ route('admin.hasil-seleksi.delete', $reg->id) }}" method="POST" onsubmit="return confirm('Hapus file?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 transition-colors">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">Belum ada calon santri yang memiliki nomor peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
