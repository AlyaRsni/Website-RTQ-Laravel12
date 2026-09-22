@extends('layouts.dashboard')

@section('title', 'Hasil Seleksi — Dashboard PPDB')
@section('page_title', 'Hasil Seleksi')
@section('page_subtitle', 'Pengumuman dan hasil seleksi pendaftaran Anda')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-linear-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-xl shadow-blue-500/20">
        {{-- Decorative circles --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="text-white">
                <h2 class="text-2xl font-extrabold tracking-tight">Pengumuman Kelulusan</h2>
                <p class="mt-2 text-blue-100 text-sm leading-relaxed max-w-md">
                    Hasil seleksi penerimaan santri baru Pondok Pesantren RTQ Kawali Tahun Ajaran 2026/2027.
                </p>
            </div>
            <div class="shrink-0 w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
        </div>
    </div>

    @if($registration->hasil_seleksi_pdf && $registration->hasil_seleksi_status === 'tersedia')
    <div class="bg-white dark:bg-gray-800/60 rounded-3xl border border-emerald-200/80 dark:border-emerald-800/40 p-6 sm:p-8 shadow-lg shadow-emerald-500/5 relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-1 bg-linear-to-r from-emerald-400 to-teal-500"></div>
        
        <div class="flex flex-col items-center text-center">
            <div class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/40 rounded-full flex items-center justify-center mb-5 border-4 border-white dark:border-gray-800 shadow-md">
                <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hasil Seleksi Telah Dirilis!</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 max-w-md">
                Surat Keputusan (SK) Kelulusan Anda sudah dapat diunduh. Silakan baca hasil seleksi dengan mendownload dokumen PDF berikut.
            </p>
            
            <a href="{{ route('ppdb.download-hasil') }}" 
                class="inline-flex items-center gap-3 px-8 py-4 bg-linear-to-r from-emerald-500 to-emerald-600 text-white font-bold rounded-2xl hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-500/30 transition-all hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download Dokumen PDF Pengumuman
            </a>
            
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50 w-full flex items-start gap-4">
                <div class="hidden sm:flex w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/20 items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-left">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Langkah Selanjutnya</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                        Jika Anda dinyatakan LULUS, silakan perhatikan instruksi daftar ulang dan persyaratan administrasi lanjutan yang tertera di dalam dokumen PDF tersebut. Pastikan juga mengecek halaman Tanggal Penting.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @elseif($registration->isFinalized() && $registration->status_verifikasi === 'terverifikasi')
    <div class="bg-gray-50 dark:bg-gray-800/40 rounded-3xl border border-gray-200/80 dark:border-gray-700/50 p-8 text-center flex flex-col items-center">
        <svg class="w-24 h-24 mb-4 text-emerald-400 dark:text-emerald-500/50 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Sedang Dalam Proses Seleksi</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
            Data pendaftaran Anda telah selesai diverifikasi dan saat ini sedang menunggu keputusan akhir penerimaan dari panitia PPDB.
        </p>
    </div>
    @else
    <div class="bg-gray-50 dark:bg-gray-800/40 rounded-3xl border border-gray-200/80 dark:border-gray-700/50 p-8 text-center flex flex-col items-center">
        <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700/50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Belum Tersedia</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
            Anda belum menyelesaikan seluruh tahapan pendaftaran atau data sedang berjalan dalam proses verifikasi.
        </p>
        <a href="{{ route('ppdb.dashboard') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 transition-colors">
            Cek Dashboard Anda
            <svg class="w-4 h-4" transform="rotate(180)" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
    </div>
    @endif

</div>
@endsection
