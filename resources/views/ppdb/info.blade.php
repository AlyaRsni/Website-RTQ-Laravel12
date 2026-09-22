@extends('layouts.landing')

@section('title', 'Informasi PPDB — RTQ Kawali')

@section('content')
    @include('partials.navbar')

    {{-- Hero Section --}}
    <section
        class="relative pt-32 pb-24 lg:pt-44 lg:pb-36 overflow-hidden bg-linear-to-br from-[#001233] via-[#002045] to-[#0a3d6e]">
        {{-- Animated decorative blobs --}}
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/15 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] animate-pulse"
            style="animation-delay:2s"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/5 rounded-full blur-[150px]">
        </div>
        {{-- Geometric accent --}}
        <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-3xl rotate-12 hidden lg:block"></div>
        <div class="absolute bottom-16 left-16 w-20 h-20 border border-white/5 rounded-2xl -rotate-6 hidden lg:block"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <span
                class="inline-flex items-center gap-2 py-2 px-5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-red-100 text-sm font-semibold tracking-wider uppercase mb-8 animate-[fadeInUp_0.6s_ease-out]">
                <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                Pendaftaran Telah Ditutup
            </span>
            <h1 class="text-4xl md:text-4xl lg:text-6xl font-extrabold text-white tracking-[-0.03em] mb-6 leading-[1.05]">
                Penerimaan Peserta<br /><span
                    class="bg-linear-to-r from-amber-300 via-amber-400 to-yellow-300 bg-clip-text text-transparent">Didik
                    Baru</span>
            </h1>
            <p class="mt-6 text-sm md:text-xl text-blue-200/80 max-w-2xl mx-auto font-light leading-relaxed">
                Bergabunglah bersama kami membentuk generasi Qur'ani yang berakhlak mulia, cerdas, dan mandiri.
            </p>
            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('ppdb.ditutup') }}"
                    class="group px-8 py-4 text-sm font-bold text-white bg-red-600 rounded-2xl shadow-xl shadow-red-500/20 hover:bg-red-700 hover:scale-[1.03] transition-all duration-300 flex items-center justify-center gap-2">
                    Pendaftaran Ditutup
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </a>
                <a href="{{ route('ppdb.hasil-seleksi') }}"
                    class="px-8 py-4 text-sm font-bold text-white bg-white/10 backdrop-blur-sm border border-white/15 rounded-2xl hover:bg-white/20 transition-all duration-300">
                    Hasil Seleksi Gelombang 1
                </a>
            </div>
        </div>
    </section>

    {{-- Quick Access — Compact Grid --}}
    <section class="relative -mt-10 z-40 px-4 sm:px-6 lg:px-8 mb-8">
        <div
            class="max-w-5xl mx-auto bg-white dark:bg-gray-900 rounded-3xl shadow-[0_20px_60px_rgba(0,20,60,0.12)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.4)] p-6 md:p-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                <a href="#jadwal"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">📅</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Jadwal</span>
                </a>
                <a href="#alur"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">🔄</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Alur</span>
                </a>
                <a href="#syarat"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">📋</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Syarat</span>
                </a>
                <a href="#berkas"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">📁</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Berkas</span>
                </a>
                <a href="#perlengkapan"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">🎒</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Perlengkapan</span>
                </a>
                <a href="#biaya"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">💰</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Biaya</span>
                </a>
                <a href="#kontak"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">📞</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Kontak</span>
                </a>
                <a href="#faq"
                    class="group flex flex-col items-center gap-2 p-3 rounded-2xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">
                    <span class="text-2xl group-hover:scale-110 transition-transform">❓</span>
                    <span
                        class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">FAQ</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Jadwal Section --}}
    <section id="jadwal" class="py-20 bg-gray-50 dark:bg-gray-800/50 scroll-mt-24 relative overflow-hidden">
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-200/20 dark:bg-blue-800/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-20 -right-20 w-60 h-60 bg-amber-200/20 dark:bg-amber-800/10 rounded-full blur-[80px]">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">Penjadwalan Penting
                </h2>
                <p class="mt-4 text-sm lg:text-lg text-gray-600 dark:text-gray-400">Catat tanggal-tanggal penting berikut
                    agar tidak
                    tertinggal.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,32,69,0.05)] transform transition hover:-translate-y-2">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📝</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pendaftaran Online</h3>
                    <p class="text-blue-600 dark:text-blue-400 font-semibold mb-4">1 Februari - 31 Maret 2026</p>
                    <p class="text-gray-600 dark:text-gray-400 line-clamp-3">Pengisian formulir pendaftaran secara online
                        melalui website resmi RTQ Kawali.</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,32,69,0.05)] transform transition hover:-translate-y-2">
                    <div
                        class="w-14 h-14 bg-amber-50 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-2xl">✍️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Seleksi & Wawancara</h3>
                    <p class="text-amber-600 dark:text-amber-400 font-semibold mb-4">4 April 2026</p>
                    <p class="text-gray-600 dark:text-gray-400">Tes Al-Qur'an dan wawancara calon santri beserta
                        orang tua </p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,32,69,0.05)] transform transition hover:-translate-y-2">
                    <div
                        class="w-14 h-14 bg-green-50 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🎉</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pengumuman Kelulusan</h3>
                    <p class="text-green-600 dark:text-green-400 font-semibold mb-4">15 April 2026</p>
                    <p class="text-gray-600 dark:text-gray-400">Pengumuman hasil seleksi dapat diakses melalui Website resmi
                        kami di <a href="www.rtqkawali.com" class="text-bold">www.rtqkawali.com</a>.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Alur Kegiatan --}}
    <section id="alur" class="py-24 bg-white dark:bg-gray-900 scroll-mt-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16 md:flex justify-between items-end">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">Alur
                        Kegiatan</h2>
                    <p class="text-sm lg:text-lg text-gray-600 dark:text-gray-400">Pahami setiap tahapan proses penerimaan
                        peserta
                        didik baru dari awal hingga akhir.</p>
                </div>
            </div>

            <div class="relative">
                <div
                    class="hidden md:block absolute top-[45px] left-0 w-full h-[2px] bg-linear-to-r from-blue-100 via-blue-500 to-blue-100 dark:from-gray-800 dark:via-blue-600 dark:to-gray-800">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                    <div class="relative z-10 bg-white dark:bg-gray-900 pt-6 md:pt-0 group">
                        <div
                            class="w-24 h-24 mx-auto md:mx-0 bg-blue-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-white dark:border-gray-900 group-hover:scale-110 transition-transform">
                            <span class="text-[#002045] dark:text-blue-400 text-2xl font-bold">01</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 text-center md:text-left">Daftar
                            Online
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-center md:text-left">Calon santri mengisi data diri
                            dan mengupload berkas pada form yang telah ditentukan</p>
                    </div>

                    <div class="relative z-10 bg-white dark:bg-gray-900 pt-6 md:pt-0 group">
                        <div
                            class="w-24 h-24 mx-auto md:mx-0 bg-blue-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-white dark:border-gray-900 group-hover:scale-110 transition-transform">
                            <span class="text-[#002045] dark:text-blue-400 text-2xl font-bold">02</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 text-center md:text-left">Seleksi
                            masuk</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-center md:text-left">Calon peserta mengikuti tes
                            seleksi masuk sesuai dengan jadwal yang telah ditentukan.
                            <br> <span class="font-bold">( 04 April 2026 | Offline | MTQ
                                Ubay Bin Kaab)</span>
                        </p>
                    </div>

                    <div class="relative z-10 bg-white dark:bg-gray-900 pt-6 md:pt-0 group">
                        <div
                            class="w-24 h-24 mx-auto md:mx-0 bg-blue-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-white dark:border-gray-900 group-hover:scale-110 transition-transform">
                            <span class="text-[#002045] dark:text-blue-400 text-2xl font-bold">03</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 text-center md:text-left">Interview
                            Orangtua</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-center md:text-left">Orangtua mengikuti sesi
                            wawancara untuk memastikan kesesuaian program dengan kebutuhan calon peserta. <br> <span
                                class="font-bold">( 04 April 2026 | Offline | MTQ
                                Ubay Bin Kaab)</span></p>
                    </div>

                    <div class="relative z-10 bg-white dark:bg-gray-900 pt-6 md:pt-0 group">
                        <div
                            class="w-24 h-24 mx-auto md:mx-0 bg-blue-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-6 shadow-sm border-4 border-white dark:border-gray-900 group-hover:scale-110 transition-transform">
                            <span class="text-[#002045] dark:text-blue-400 text-2xl font-bold">04</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 text-center md:text-left">
                            Pengumuman
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-center md:text-left">Cek status kelulusan setelah
                            mengikuti seleksi dan wawancara.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Syarat dan Berkas --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                {{-- Persyaratan --}}
                <div id="syarat"
                    class="bg-white dark:bg-gray-900 p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,32,69,0.05)] scroll-mt-24">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Persyaratan Calon Santri</h2>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Ikhwan (Usia
                                15
                                - 25 Tahun)
                                atau Minimal Lulusan SMP/MTs/Sederajat
                            </p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Mampu Membaca
                                Al-Qur'an</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Membayar Uang
                                PendaftaranSevesar Rp.500.000,
                                Melalui transfer ke <span class="italic">Nomor rekening : </span> <br>
                                <span class="font-bold"> Bank Syariah Indonesia (BSI) : 7232048063 <br>
                                    A.N : ASEP ZAM ZAMI ARIF </span> <br>
                                Dan simpan bukti transfer untuk dipakai di upload di formulir Pendaftaran
                            </p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Sehat Jasmani
                                Rohani</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Mengikuti
                                semua
                                ketentuan dan Tahapan PPDB</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Bersedia
                                mengikuti program pembelajaran</p>
                        </li>
                    </ul>
                </div>

                {{-- Berkas --}}
                <div id="berkas"
                    class="bg-linear-to-br from-[#002045] to-[#1a365d] p-10 rounded-3xl shadow-xl scroll-mt-24 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <h2 class="text-3xl font-bold text-white mb-8 relative z-10">Ketentuan Upload Berkas Pendaftaran Online
                    </h2>
                    <ul class="space-y-6 relative z-10">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-white text-sm font-bold">1</span>
                            </div>
                            <p class="text-blue-50 text-lg">Kartu Keluarga - dengan kualitas gambar yang jelas, dengan
                                format jpg, ukuran tidak lebih dari 1 MB</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-white text-sm font-bold">2</span>
                            </div>
                            <p class="text-blue-50 text-lg">Foto 3x4 Terbaru - Mengenakan Pakaian putih dengan latar
                                belakang merah, dalam format jpg.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-white text-sm font-bold">3</span>
                            </div>
                            <p class="text-blue-50 text-lg">Ijazah Pendidikan Terakhir atau Raport semester 4 - dalam
                                Format
                                PDF, ukuran tidak lebih dari 1 MB</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 mt-1">
                                <span class="text-white text-sm font-bold">4</span>
                            </div>
                            <p class="text-blue-50 text-lg">Bukti Uang Transaksi pendaftaran - dalam format jpg, ukuran
                                tidak lebih dari 1 MB</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Berkas yang perlu dipersiapkan --}}
        <div id="syarat"
            class="bg-white mt-6 dark:bg-gray-900 p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,32,69,0.05)] scroll-mt-24">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Berkas yang perlu dipersiapkan</h2>
            <ul class="space-y-6">
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Ijazah Pendidikan
                        Terakhir/Rapor semester 4
                    </p>
                </li>
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Kartu Keluarga</p>
                </li>
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Pas Foto 3x4 Terbaru
                        (Berpakaian putih dengan latar merah)
                    </p>
                </li>
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Bukti transaksi uang
                        pendaftaran</p>
                </li>
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Formulir pendaftaran
                        yang sudah diisi</p>
                </li>
                <li class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center shrink-0 mt-1">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 text-base lg:text-lg leading-relaxed">Bersedia
                        mengikuti program pembelajaran</p>
                </li>
            </ul>
        </div>
    </section>

    {{-- Perlengkapan --}}
    <section id="perlengkapan" class="py-24 bg-white dark:bg-gray-900 scroll-mt-24 relative overflow-hidden">
        <div class="absolute top-10 right-10 w-64 h-64 bg-indigo-100/30 dark:bg-indigo-900/10 rounded-full blur-[100px]">
        </div>
        <div class="absolute bottom-10 left-10 w-48 h-48 bg-pink-100/20 dark:bg-pink-900/10 rounded-full blur-[80px]">
        </div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">Perlengkapan
                    Peserta</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Perlengkapan yang perlu dipersiapkan peserta untuk
                    kegiatan Seleksi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📖</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Mushaf Al-Qur'an</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">membawa mushaf Al-Qur'an pribadi untuk kegiatan
                        pembelajaran.</p>
                </div>
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">👕</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Pakaian untuk 2 hari</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Busana muslim, jaket, dan pakaian tidur secukupnya.
                    </p>
                </div>
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🛌</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Bantal & Selimut</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Bagi yang memerlukan, silakan bawa bantal dan
                        selimut pribadi.</p>
                </div>
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🍱</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Bekal Makanan / Snack</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Bagi yang memerlukan, silakan membawa bekal makanan
                        atau snack.</p>
                </div>
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-cyan-100 dark:bg-cyan-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">☂️</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Payung / Jas Hujan / Ponco</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Perlengkapan hujan untuk berjaga-jaga selama
                        kegiatan.</p>
                </div>
                <div
                    class="group bg-gray-50 dark:bg-gray-800/50 p-8 rounded-2xl hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-rose-100 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🧴</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Alat Mandi</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Sabun, sampo, sikat gigi, odol, handuk, dan
                        perlengkapan mandi lainnya.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Biaya Pendidikan --}}
    <section id="biaya" class="py-24 bg-gray-50 dark:bg-gray-800/50 scroll-mt-24 relative overflow-hidden">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-100/20 dark:bg-blue-900/10 rounded-full blur-[120px]">
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">Biaya
                    Pendidikan</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Rincian biaya pendidikan selama menjadi santri di
                    Pondok
                    Pesantren RTQ Kawali.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Biaya Pendaftaran --}}
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-[0_10px_40px_rgba(0,32,69,0.05)] hover:shadow-[0_20px_60px_rgba(0,32,69,0.1)] transition-all duration-500 hover:-translate-y-1">
                    <div
                        class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-2xl">📝</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Pendaftaran</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Dibayarkan satu kali saat mendaftar</p>
                    <div class="text-3xl font-extrabold text-gray-900 dark:text-white">Rp 500.000</div>
                </div>

                {{-- Biaya Awal Masuk --}}
                <div
                    class="bg-linear-to-br from-[#002045] to-[#1a365d] rounded-3xl p-8 shadow-xl relative overflow-hidden hover:-translate-y-1 transition-all duration-500">
                    <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute -left-4 -top-4 w-20 h-20 bg-amber-400/10 rounded-full blur-xl"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                            <span class="text-2xl">🏫</span>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">Awal Masuk</h3>
                        <p class="text-sm text-blue-200 mb-5">Dibayarkan jika dinyatakan LULUS</p>
                        <div class="text-3xl font-extrabold text-white">Rp 3.000.000</div>
                    </div>
                </div>

                {{-- SPP / Syahriyah --}}
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl p-8 shadow-[0_10px_40px_rgba(0,32,69,0.05)] hover:shadow-[0_20px_60px_rgba(0,32,69,0.1)] transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-4 right-4">
                        <span
                            class="inline-block px-3 py-1 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full uppercase tracking-wider">Beasiswa</span>
                    </div>
                    <div
                        class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-2xl">🎓</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">SPP / Syahriyah</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Biaya bulanan selama menempuh pendidikan</p>
                    <div
                        class="text-3xl font-extrabold bg-linear-to-r from-emerald-500 to-teal-500 bg-clip-text text-transparent">
                        Beasiswa</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak Panitia PPDB --}}
    <section id="kontak" class="py-24 bg-white dark:bg-gray-900 scroll-mt-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-80 h-80 bg-blue-100/40 dark:bg-blue-900/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-60 h-60 bg-emerald-100/30 dark:bg-emerald-900/10 rounded-full blur-[80px]">
        </div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-14">
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">Hubungi
                    Panitia
                    PPDB</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Silakan hubungi narahubung di
                    masing-masing pondok untuk informasi lebih lanjut.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Card 1 — Pondok RTQ --}}
                <div
                    class="group relative bg-linear-to-br from-gray-50 to-white dark:from-gray-800/80 dark:to-gray-900 rounded-3xl p-10 shadow-[0_10px_40px_rgba(0,32,69,0.06)] hover:shadow-[0_20px_60px_rgba(0,32,69,0.12)] transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-gray-400/10 rounded-full blur-2xl group-hover:bg-gray-400/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-[#25D366]/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <div
                                class="w-12 h-12 flex items-center justify-center transition-transform group-hover:scale-105">
                                <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo RTQ Kawali"
                                    class="w-full h-full object-contain">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">RTQ Kawali</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Kawali, Ciamis - Jawa Barat</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Narahubung</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">Ustadz. Gugum Purnama</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">WhatsApp</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">+6282119469657</p>
                                </div>
                            </div>
                        </div>
                        <a href="https://wa.me/6282119469657" target="_blank"
                            class="mt-8 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#25D366] text-white font-bold rounded-xl hover:bg-[#1ebd5b] transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
                {{-- Card 2 — Pondok Icakan --}}
                <div
                    class="group relative bg-linear-to-br from-gray-50 to-white dark:from-gray-800/80 dark:to-gray-900 rounded-3xl p-10 shadow-[0_10px_40px_rgba(0,32,69,0.06)] hover:shadow-[0_20px_60px_rgba(0,32,69,0.12)] transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-400/10 rounded-full blur-2xl group-hover:bg-indigo-400/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-16 h-16 bg-[#25D366]/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <div
                                class="w-12 h-12 flex items-center justify-center transition-transform group-hover:scale-105">
                                <img src="{{ asset('images/logo-icakan-500.png') }}" alt="Logo RTQ Kawali"
                                    class="w-full h-full object-contain">
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">MTQ Ubay bin Ka'ab</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Cipaku, Ciamis - Jawa Barat</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Narahubung</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">Ustadz Yudi Nurdani</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">WhatsApp</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">+6281220749065</p>
                                </div>
                            </div>
                        </div>
                        <a href="https://wa.me/6281220749065" target="_blank"
                            class="mt-8 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#25D366] text-white font-bold rounded-xl hover:bg-[#1ebd5b] transition-all duration-300 shadow-lg shadow-green-500/20 hover:shadow-green-500/40 hover:scale-[1.02]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                            </svg>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section id="faq" class="py-24 bg-white dark:bg-gray-900 scroll-mt-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">Pertanyaan
                    Seputar PPDB</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Jawaban dari pertanyaan yang sering ditanyakan oleh
                    calon pendaftar.</p>
            </div>

            <div class="space-y-4" x-data="{ active: null }">
                <!-- Item 1 -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="active = (active === 1 ? null : 1)"
                        class="w-full text-left px-8 py-6 focus:outline-none flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900 dark:text-white">Apakah pendaftaran hanya secara
                            online?</span>
                        <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300"
                            :class="{ 'rotate-180': active === 1 }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Ya, untuk saat ini kami memprioritaskan pendaftaran secara online melalui website ini agar
                            proses pendataan lebih terpusat dan efisien.
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="active = (active === 2 ? null : 2)"
                        class="w-full text-left px-8 py-6 focus:outline-none flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900 dark:text-white">Bagaimana Proses Seleksi
                            dilakukan</span>
                        <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300"
                            :class="{ 'rotate-180': active === 2 }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Proses seleksi dilakukan melalui tes tertulis dan wawancara, untuk menguji kemampuan akademik
                            serta kesiapan mental calon peserta didik.
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="active = (active === 3 ? null : 3)"
                        class="w-full text-left px-8 py-6 focus:outline-none flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900 dark:text-white">Dimana tempat tes peserta
                            didik?</span>
                        <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300"
                            :class="{ 'rotate-180': active === 3 }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 leading-relaxed">
                            InsyaAllah akan dilakukan di Markaz Tahfidz Icakan Ubay bin Ka'ab
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden transition-all duration-300">
                    <button @click="active = (active === 4 ? null : 4)"
                        class="w-full text-left px-8 py-6 focus:outline-none flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900 dark:text-white">Apakah Kedua pondok tersebut
                            bermanhaj
                            sama?</span>
                        <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300"
                            :class="{ 'rotate-180': active === 4 }" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="active === 4" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-600 dark:text-gray-400 leading-relaxed">
                            Ya, Kedua pondok tersebut memiliki manhaj yang sama, berlandaskan pada Al-Quran dan Sunnah
                            dengan pemahaman Salafus Shalih
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Disclaimer/Pernyataan --}}
    <section class="py-16 bg-[#002045] text-center border-t-8 border-amber-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <svg class="w-12 h-12 text-amber-500 mx-auto mb-6 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
            </svg>
            <h2 class="text-2xl lg:text-3xl font-bold text-white mb-6">Pernyataan Kesediaan</h2>
            <p class="text-lg text-blue-200 leading-relaxed font-light">
                "Dengan mendaftar sebagai Calon Santri Pondok Pesantren RTQ Kawali, pendaftar dan pendaftar wali/orangtua
                menyatakan dengan sungguh-sungguh bersedia menaati seluruh peraturan yang berlaku dan menerima segala
                keputusan Panitia PPDB (Penerimaan Peserta Didik Baru)"
            </p>
        </div>
    </section>

    @include('partials.footer')
@endsection
