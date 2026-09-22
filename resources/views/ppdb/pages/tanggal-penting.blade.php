@extends('layouts.dashboard')

@section('title', 'Tanggal Penting — Dashboard PPDB')
@section('page_title', 'Tanggal Penting')
@section('page_subtitle', 'Jadwal dan agenda pendaftaran Santri Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-linear-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-xl shadow-indigo-500/20">
        {{-- Decorative blobs --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="text-white">
                <h2 class="text-2xl font-extrabold tracking-tight">Timeline Pendaftaran</h2>
                <p class="mt-2 text-indigo-100 text-sm leading-relaxed max-w-md">
                    Berikut adalah jadwal lengkap kegiatan Penerimaan Peserta Didik Baru (PPDB) Pondok Pesantren RTQ Kawali. Pastikan Anda tidak melewatkan setiap tahapannya.
                </p>
            </div>
            <div class="shrink-0 w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>

    {{-- Timeline via Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        
        {{-- Card 1 --}}
        <div class="group bg-white dark:bg-gray-800/60 rounded-3xl border border-gray-200/80 dark:border-gray-700/40 p-6 sm:p-8 hover:border-emerald-300 dark:hover:border-emerald-700/60 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-bl-full group-hover:bg-emerald-500/10 transition-colors"></div>
            
            <div class="flex items-start gap-4 sm:gap-5 relative z-10">
                <div class="shrink-0 w-12 h-12 bg-emerald-100 dark:bg-emerald-900/40 rounded-2xl flex items-center justify-center border border-emerald-200 dark:border-emerald-800/50">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Mei - Juni 2026</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">Pendaftaran Online</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Pengisian formulir pendaftaran, upload berkas, dan finalisasi data secara online melalui dashboard PPDB.
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="group bg-white dark:bg-gray-800/60 rounded-3xl border border-gray-200/80 dark:border-gray-700/40 p-6 sm:p-8 hover:border-amber-300 dark:hover:border-amber-700/60 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-bl-full group-hover:bg-amber-500/10 transition-colors"></div>
            
            <div class="flex items-start gap-4 sm:gap-5 relative z-10">
                <div class="shrink-0 w-12 h-12 bg-amber-100 dark:bg-amber-900/40 rounded-2xl flex items-center justify-center border border-amber-200 dark:border-amber-800/50">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                </div>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Juli 2026</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">Tes & Wawancara</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Ujian seleksi masuk berupa tes tertulis, tes lisan (hafalan), dan sesi wawancara untuk calon santri beserta orang tua.
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="group bg-white dark:bg-gray-800/60 rounded-3xl border border-gray-200/80 dark:border-gray-700/40 p-6 sm:p-8 hover:border-blue-300 dark:hover:border-blue-700/60 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-bl-full group-hover:bg-blue-500/10 transition-colors"></div>
            
            <div class="flex items-start gap-4 sm:gap-5 relative z-10">
                <div class="shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/40 rounded-2xl flex items-center justify-center border border-blue-200 dark:border-blue-800/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Agustus 2026</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">Pengumuman Hasil</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Penerbitan Surat Keputusan (SK) Kelulusan. Anda dapat mengecek dan mengunduh surat langsung di sistem ini.
                    </p>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="group bg-white dark:bg-gray-800/60 rounded-3xl border border-gray-200/80 dark:border-gray-700/40 p-6 sm:p-8 hover:border-purple-300 dark:hover:border-purple-700/60 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rounded-bl-full group-hover:bg-purple-500/10 transition-colors"></div>
            
            <div class="flex items-start gap-4 sm:gap-5 relative z-10">
                <div class="shrink-0 w-12 h-12 bg-purple-100 dark:bg-purple-900/40 rounded-2xl flex items-center justify-center border border-purple-200 dark:border-purple-800/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">September 2026</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">Daftar Ulang & Orientasi</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Proses daftar ulang kedatangan fisik ke pondok, asessment awal program, serta Masa Ta'aruf Santri (MATASA).
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
