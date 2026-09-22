@extends('layouts.landing')

@section('title', 'Hasil Seleksi Gelombang 1 — RTQ Kawali')

@section('content')
    @include('partials.navbar')

    {{-- Hero Section --}}
    <section
        class="relative pt-32 pb-20 lg:pt-44 lg:pb-28 overflow-hidden bg-linear-to-br from-[#001233] via-[#002045] to-[#0a3d6e]">
        {{-- Animated decorative blobs --}}
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/15 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] animate-pulse"
            style="animation-delay:2s"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/5 rounded-full blur-[150px]">
        </div>
        {{-- Geometric accent --}}
        <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-3xl rotate-12 hidden lg:block"></div>
        <div class="absolute bottom-16 left-16 w-20 h-20 border border-white/5 rounded-2xl -rotate-6 hidden lg:block">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <a href="{{ route('ppdb.info') }}"
                class="inline-flex items-center gap-2 py-2 px-5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-blue-200 text-sm font-semibold tracking-wider uppercase mb-8 hover:bg-white/20 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Info PPDB
            </a>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-[-0.03em] mb-6 leading-[1.05]">
                Hasil Seleksi<br /><span
                    class="bg-linear-to-r from-amber-300 via-amber-400 to-yellow-300 bg-clip-text text-transparent">Gelombang
                    1</span>
            </h1>
            <p class="mt-4 text-base md:text-xl text-blue-200/80 max-w-2xl mx-auto font-light leading-relaxed">
                PPDB Pondok Pesantren RTQ Kawali — Tahun Ajaran 2026/2027
            </p>
        </div>
    </section>

    {{-- Search Section --}}
    <section class="relative -mt-12 md:-mt-16 z-40 px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-3xl mx-auto" x-data="{
            keyword: '{{ addslashes($keyword) }}',
            allData: @js($hasil),
            searched: {{ $keyword && strlen(trim($keyword)) >= 3 ? 'true' : 'false' }},
        }">
            {{-- Search Card --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-[0_20px_60px_rgba(0,20,60,0.12)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.4)] p-8 md:p-10 border border-gray-100 dark:border-gray-800">

                {{-- Header --}}
                <div class="text-center mb-8">
                    <div
                        class="w-16 h-16 bg-blue-50 dark:bg-blue-900/40 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">Cari Hasil Seleksi</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base">
                        Masukkan <span class="font-semibold text-blue-600 dark:text-blue-400">minimal 3 huruf</span> dari
                        nama lengkap untuk mencari hasil seleksi.
                    </p>
                </div>

                {{-- Search Form --}}
                <form method="GET" action="{{ route('ppdb.hasil-seleksi') }}" class="mb-6">
                    <div class="flex gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="nama" x-model="keyword"
                                placeholder="Ketik nama santri... (contoh: Athar, Muhammad, Zaid)"
                                value="{{ $keyword }}"
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 text-sm md:text-base"
                                required minlength="3" id="search-input">
                        </div>
                        <button type="submit"
                            class="px-6 md:px-8 py-4 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-sm md:text-base shrink-0">
                            Cari
                        </button>
                    </div>
                </form>

                {{-- Stats --}}
                @if ($keyword && strlen(trim($keyword)) >= 3)
                    <div class="flex items-center justify-center gap-6 text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                            <span>Ditemukan: <strong class="text-gray-700 dark:text-gray-300">{{ count($hasil) }}</strong> hasil</span>
                        </div>
                    </div>
                @endif

                {{-- Warning for short query --}}
                @if ($keyword && strlen(trim($keyword)) < 3)
                    <div
                        class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-2xl mb-6">
                        <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <p class="text-sm text-amber-700 dark:text-amber-300 font-medium">Masukkan minimal 3 huruf untuk
                            pencarian.</p>
                    </div>
                @endif

                {{-- Results --}}
                @if ($keyword && strlen(trim($keyword)) >= 3)
                    @if (count($hasil) > 0)
                        <div class="space-y-4">
                            @foreach ($hasil as $index => $row)
                                <div
                                    class="group bg-gray-50 dark:bg-gray-800/60 rounded-2xl p-5 md:p-6 border border-gray-100 dark:border-gray-700/50 hover:border-blue-200 dark:hover:border-blue-800/50 hover:shadow-lg transition-all duration-300 animate-[fadeInUp_0.4s_ease-out_{{ $index * 0.08 }}s_both]">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-start gap-4 min-w-0">
                                            {{-- Number badge --}}
                                            <div
                                                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center shrink-0">
                                                <span
                                                    class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $index + 1 }}</span>
                                            </div>
                                            <div class="min-w-0">
                                                <h3
                                                    class="font-bold text-gray-900 dark:text-white text-base md:text-lg truncate">
                                                    {{ $row->nama_lengkap ?? $row->user?->name ?? 'Tanpa Nama' }}
                                                </h3>
                                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                                    @if(!empty($row->nomor_peserta))
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-mono">
                                                            No. {{ $row->nomor_peserta }}
                                                        </span>
                                                    @endif
                                                    <div class="flex items-center gap-1.5 truncate">
                                                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                            </path>
                                                        </svg>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                            {{ $row->asal_sekolah ?? '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Download Button --}}
                                        <a href="{{ route('ppdb.download-sk', ['id' => $row->id]) }}"
                                            class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-600/20 hover:shadow-emerald-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 shrink-0 w-full sm:w-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Download SK
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- No Results --}}
                        <div class="text-center py-10">
                            <div
                                class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-5">
                                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Nama Tidak Ditemukan</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">
                                Tidak ditemukan hasil untuk "<span
                                    class="font-semibold text-gray-700 dark:text-gray-300">{{ $keyword }}</span>".
                                Pastikan penulisan nama sudah benar.
                            </p>
                        </div>
                    @endif
                @else
                    @if (!$keyword)
                        {{-- Initial State / Empty --}}
                        <div class="text-center py-10">
                            <div
                                class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-5">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Cari Nama Anda</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">
                                Ketik nama di kolom pencarian di atas untuk menemukan surat keputusan hasil seleksi Anda.
                            </p>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Info Card --}}
            <div
                class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-5 border border-blue-100 dark:border-blue-800/30">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-700 dark:text-blue-300 font-medium mb-1">Informasi</p>
                        <p class="text-sm text-blue-600/70 dark:text-blue-400/70">
                            File yang diunduh berupa Surat Keterangan Hasil Test & Wawancara PPDB 2026/2027.
                            Jika nama Anda tidak ditemukan, silakan hubungi
                            <a href="https://wa.me/6282119469657" target="_blank"
                                class="font-semibold underline hover:text-blue-800 dark:hover:text-blue-200 transition-colors">Panitia
                                PPDB</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
