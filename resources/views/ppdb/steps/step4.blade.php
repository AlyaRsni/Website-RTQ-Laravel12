@extends('layouts.dashboard')

@section('title', 'Upload Berkas — PPDB RTQ Kawali')
@section('page_title', 'Upload Berkas')
@section('page_subtitle', 'Step 4 — Upload dokumen persyaratan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="berkasUpload()">

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/15 dark:to-teal-900/15 rounded-2xl border border-emerald-200/60 dark:border-emerald-800/30 p-5">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Ketentuan Upload Berkas</h3>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Ukuran maksimal setiap file: <strong>10 MB</strong></li>
                    <li>• Kartu Keluarga & Ijazah/Raport: format <strong>PDF</strong></li>
                    <li>• Foto 3x4: format <strong>JPG/JPEG</strong></li>
                </ul>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('ppdb.step.4.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-5">
            @php
                $documents = [
                    ['key' => 'kartu_keluarga', 'label' => 'Kartu Keluarga', 'accept' => '.pdf', 'format' => 'PDF', 'icon_color' => 'emerald', 'current' => $registration->kartu_keluarga],
                    ['key' => 'foto_3x4', 'label' => 'Foto 3x4', 'accept' => '.jpg,.jpeg', 'format' => 'JPG/JPEG', 'icon_color' => 'blue', 'current' => $registration->foto_3x4],
                    ['key' => 'ijazah_raport', 'label' => 'Ijazah / Raport', 'accept' => '.pdf', 'format' => 'PDF', 'icon_color' => 'purple', 'current' => $registration->ijazah_raport],
                ];
            @endphp

            @foreach($documents as $doc)
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-{{ $doc['icon_color'] }}-100 dark:bg-{{ $doc['icon_color'] }}-800/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-{{ $doc['icon_color'] }}-600 dark:text-{{ $doc['icon_color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $doc['label'] }}</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Format {{ $doc['format'] }}, maks 10MB</p>
                            </div>
                        </div>

                        @if($doc['current'])
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Terupload
                        </span>
                        @endif
                    </div>

                    {{-- Upload area --}}
                    <div class="relative border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl hover:border-{{ $doc['icon_color'] }}-400 dark:hover:border-{{ $doc['icon_color'] }}-500 transition-all cursor-pointer p-4"
                        @click="$refs.{{ $doc['key'] }}.click()"
                        :class="files['{{ $doc['key'] }}'] ? 'border-emerald-300 dark:border-emerald-700 bg-emerald-50/50 dark:bg-emerald-900/10' : ''">
                        <input type="file" name="{{ $doc['key'] }}" accept="{{ $doc['accept'] }}" class="hidden" x-ref="{{ $doc['key'] }}" @change="handleFile('{{ $doc['key'] }}', $event)">
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center shrink-0"
                                :class="files['{{ $doc['key'] }}'] ? 'bg-emerald-100 dark:bg-emerald-800/30' : ''">
                                <template x-if="!files['{{ $doc['key'] }}']">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                </template>
                                <template x-if="files['{{ $doc['key'] }}']">
                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </template>
                            </div>
                            <div class="min-w-0 flex-1">
                                <template x-if="!files['{{ $doc['key'] }}']">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                            {{ $doc['current'] ? 'Ganti file' : 'Pilih file' }} atau drag & drop
                                        </p>
                                    </div>
                                </template>
                                <template x-if="files['{{ $doc['key'] }}']">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate" x-text="files['{{ $doc['key'] }}'].name"></p>
                                        <p class="text-xs text-gray-400" x-text="formatSize(files['{{ $doc['key'] }}'].size)"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
            <button type="submit" name="save_draft" value="1"
                class="w-full sm:w-auto px-6 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-all duration-200 text-sm">
                💾 Simpan Draft
            </button>
            <button type="submit"
                class="w-full sm:flex-1 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-xl hover:from-emerald-700 hover:to-emerald-800 shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-sm flex items-center justify-center gap-2">
                Simpan & Lanjutkan
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('ppdb.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </form>
</div>

<script>
function berkasUpload() {
    return {
        files: {},
        handleFile(key, e) {
            const file = e.target.files[0];
            if (file) this.files[key] = file;
        },
        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
    }
}
</script>
@endsection
