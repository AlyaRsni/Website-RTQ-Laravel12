@extends('layouts.landing')

@section('title', 'PPDB Ditutup — RTQ Kawali')

@section('content')
    @include('partials.navbar')

    <section
        class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-linear-to-br from-[#001233] via-[#002045] to-[#0a3d6e]">
        {{-- Decorative blobs --}}
        <div class="absolute top-10 left-10 w-72 h-72 bg-red-500/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] animate-pulse"
            style="animation-delay:2s"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/5 rounded-full blur-[150px]">
        </div>

        {{-- Geometric accents --}}
        <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-3xl rotate-12 hidden lg:block"></div>
        <div class="absolute bottom-32 left-16 w-20 h-20 border border-white/5 rounded-2xl -rotate-6 hidden lg:block"></div>

        <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            {{-- Animated Icon --}}
            <div class="relative mx-auto w-28 h-28 mb-8 animate-[fadeInUp_0.6s_ease-out]">
                <div class="absolute inset-0 bg-red-500/20 rounded-full blur-xl animate-pulse"></div>
                <div
                    class="relative w-28 h-28 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full flex items-center justify-center">
                    <svg class="w-14 h-14 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h1
                class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-[-0.03em] mb-6 leading-[1.1] animate-[fadeInUp_0.6s_ease-out_0.1s_both]">
                Pendaftaran PPDB<br />
                <span class="bg-linear-to-r from-red-400 via-rose-400 to-red-300 bg-clip-text text-transparent">Telah
                    Ditutup</span>
            </h1>

            {{-- Subtitle --}}
            <p
                class="text-base md:text-lg text-blue-200/70 max-w-lg mx-auto font-light leading-relaxed mb-4 animate-[fadeInUp_0.6s_ease-out_0.2s_both]">
                Pendaftaran Penerimaan Peserta Didik Baru (PPDB) Pondok Pesantren RTQ Kawali untuk Tahun Ajaran 2026/2027
                telah resmi ditutup.
            </p>

            {{-- Period Badge --}}
            <div
                class="inline-flex items-center gap-2 py-2 px-5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-blue-200 text-sm font-semibold mb-10 animate-[fadeInUp_0.6s_ease-out_0.25s_both]">
                <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Gelombang 2 — Ditutup 31 Maret 2026
            </div>

            {{-- Info Card --}}
            <div
                class="bg-white/8 backdrop-blur-md border border-white/10 rounded-3xl p-8 mb-10 animate-[fadeInUp_0.6s_ease-out_0.3s_both]">
                <div class="flex items-start gap-4 text-left">
                    <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-1">Informasi Selanjutnya</h3>
                        <p class="text-blue-200/60 text-sm leading-relaxed">
                            Bagi yang sudah mendaftar, silakan cek hasil seleksi melalui halaman pengumuman. Untuk informasi
                            gelombang berikutnya, pantau terus website dan media sosial kami.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div
                class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-[fadeInUp_0.6s_ease-out_0.4s_both]">
                <a href="{{ route('ppdb.hasil-seleksi') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#002045] font-bold rounded-2xl shadow-xl shadow-white/10 hover:shadow-white/20 hover:scale-[1.03] transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Cek Hasil Seleksi Gelombang 1
                </a>
                <a href="/"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/15 text-white font-semibold rounded-2xl hover:bg-white/20 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
