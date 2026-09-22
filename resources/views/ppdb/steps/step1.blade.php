@extends('layouts.dashboard')

@section('title', 'Upload Pembayaran — PPDB RTQ Kawali')
@section('page_title', 'Upload Bukti Pembayaran')
@section('page_subtitle', 'Step 1 — Upload bukti transfer pendaftaran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="fileUpload()">

    {{-- Info Card --}}
    <div class="bg-linear-to-r from-blue-50 to-cyan-50 dark:from-blue-900/15 dark:to-cyan-900/15 rounded-2xl border border-blue-200/60 dark:border-blue-800/30 p-5">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-800/30 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Petunjuk Upload</h3>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Upload bukti transfer dalam format <strong>PDF</strong></li>
                    <li>• Ukuran file maksimal <strong>1 MB</strong></li>
                    <li>• Pastikan bukti transfer terlihat jelas</li>
                    <li>• Bukti pembayaran akan diverifikasi bersama berkas lainnya di tahap akhir</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Already uploaded --}}
    @if($registration->bukti_pembayaran)
    <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl border border-emerald-200 dark:border-emerald-800/30 p-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900 dark:text-white">Bukti Pembayaran Sudah Diupload ✅</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">File berhasil disimpan. Anda bisa lanjut atau upload ulang.</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('ppdb.step.2') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all">
                Lanjut ke Data Diri
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </div>
    @endif

    {{-- Upload Form (always visible so user can re-upload) --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                {{ $registration->bukti_pembayaran ? 'Upload Ulang Bukti Transfer' : 'Upload Bukti Transfer' }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                {{ $registration->bukti_pembayaran ? 'Ganti file jika diperlukan' : 'Pastikan file yang Anda upload sudah benar' }}
            </p>

            @if($errors->any())
            <div class="mb-5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-xl p-4">
                <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-start gap-2"><span class="mt-0.5">⚠️</span> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('ppdb.step.1.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Drop Zone --}}
                <div class="relative border-2 border-dashed rounded-2xl transition-all duration-300 cursor-pointer"
                    :class="isDragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 scale-[1.01]' : (fileName ? 'border-emerald-300 dark:border-emerald-700 bg-emerald-50/50 dark:bg-emerald-900/10' : 'border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-750')"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)"
                    @click="$refs.fileInput.click()"
                >
                    <input type="file" name="bukti_pembayaran" accept=".pdf" class="hidden" x-ref="fileInput" @change="handleFileSelect($event)" required>

                    <div class="flex flex-col items-center justify-center py-10 px-6">
                        <template x-if="!fileName">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    Drag & drop atau <span class="text-blue-600 dark:text-blue-400">klik untuk memilih</span>
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Format PDF, maksimal 1MB</p>
                            </div>
                        </template>
                        <template x-if="fileName">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-0.5" x-text="fileName"></p>
                                <p class="text-xs text-gray-400 dark:text-gray-500" x-text="fileSize"></p>
                                <button type="button" @click.stop="removeFile()" class="mt-2 text-xs text-red-500 hover:text-red-600 font-semibold">Ganti file</button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" :disabled="!fileName"
                    class="w-full mt-5 py-3.5 bg-linear-to-r from-blue-600 to-blue-700 text-white font-bold rounded-2xl hover:from-blue-700 hover:to-blue-800 shadow-lg shadow-blue-600/25 hover:shadow-xl hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-lg flex items-center justify-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    {{ $registration->bukti_pembayaran ? 'Upload Ulang' : 'Upload Bukti Pembayaran' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Back to dashboard --}}
    <div class="text-center">
        <a href="{{ route('ppdb.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
function fileUpload() {
    return {
        isDragging: false,
        fileName: '',
        fileSize: '',
        handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) this.setFile(file);
        },
        handleDrop(e) {
            this.isDragging = false;
            const file = e.dataTransfer.files[0];
            if (file) {
                this.$refs.fileInput.files = e.dataTransfer.files;
                this.setFile(file);
            }
        },
        setFile(file) {
            this.fileName = file.name;
            this.fileSize = (file.size / 1024).toFixed(1) + ' KB';
        },
        removeFile() {
            this.fileName = '';
            this.fileSize = '';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endsection
