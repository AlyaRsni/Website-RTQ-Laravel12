@extends('layouts.landing')

@section('title', 'Dalam Pengembangan — RTQ Kawali')

@section('content')
    @include('partials.navbar')

    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-linear-to-br from-[#001233] via-[#002045] to-[#0a3d6e]">
        {{-- Decorative blobs --}}
        <div class="absolute top-10 left-10 w-72 h-72 bg-amber-500/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] animate-pulse" style="animation-delay:2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/5 rounded-full blur-[150px]"></div>

        {{-- Geometric accents --}}
        <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-3xl rotate-12 hidden lg:block"></div>
        <div class="absolute bottom-32 left-16 w-20 h-20 border border-white/5 rounded-2xl -rotate-6 hidden lg:block"></div>

        <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            {{-- Animated Icon --}}
            <div class="relative mx-auto w-28 h-28 mb-8 animate-[fadeInUp_0.6s_ease-out]">
                <div class="absolute inset-0 bg-amber-500/20 rounded-full blur-xl animate-pulse"></div>
                <div class="relative w-28 h-28 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full flex items-center justify-center">
                    <svg class="w-14 h-14 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-[-0.03em] mb-6 leading-[1.1] animate-[fadeInUp_0.6s_ease-out_0.1s_both]">
                Halaman Sedang<br />
                <span class="bg-linear-to-r from-amber-300 via-amber-400 to-yellow-300 bg-clip-text text-transparent">Dalam Pengembangan</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-base md:text-lg text-blue-200/70 max-w-lg mx-auto font-light leading-relaxed mb-10 animate-[fadeInUp_0.6s_ease-out_0.2s_both]">
                Tim kami sedang bekerja keras untuk menyiapkan halaman ini. InsyaAllah akan segera tersedia. Terima kasih atas kesabaran Anda.
            </p>

            {{-- Progress Indicator --}}
            <div class="max-w-sm mx-auto mb-10 animate-[fadeInUp_0.6s_ease-out_0.3s_both]">
                <div class="flex items-center justify-between text-xs text-blue-200/50 mb-2">
                    <span>Pengembangan</span>
                    <span class="text-amber-400 font-semibold">Dalam Proses</span>
                </div>
                <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-linear-to-r from-amber-400 to-yellow-300 rounded-full animate-pulse" style="width: 65%"></div>
                </div>
            </div>

            {{-- Feature Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10 animate-[fadeInUp_0.6s_ease-out_0.35s_both]">
                <div class="bg-white/6 backdrop-blur-sm border border-white/8 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <p class="text-white text-sm font-semibold">Aman & Terpercaya</p>
                </div>
                <div class="bg-white/6 backdrop-blur-sm border border-white/8 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <p class="text-white text-sm font-semibold">Cepat & Modern</p>
                </div>
                <div class="bg-white/6 backdrop-blur-sm border border-white/8 rounded-2xl p-5">
                    <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-white text-sm font-semibold">Responsif di Semua Perangkat</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-[fadeInUp_0.6s_ease-out_0.4s_both]">
                <a href="/"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#002045] font-bold rounded-2xl shadow-xl shadow-white/10 hover:shadow-white/20 hover:scale-[1.03] transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                <a href="https://wa.me/6282119469657" target="_blank"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#25D366] text-white font-bold rounded-2xl shadow-lg shadow-green-500/20 hover:bg-[#1ebd5b] hover:shadow-green-500/30 hover:scale-[1.03] transition-all duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                    </svg>
                    Hubungi Admin
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
