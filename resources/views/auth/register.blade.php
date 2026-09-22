@extends('layouts.landing')

@section('title', 'Daftar Akun — RTQ Kawali')

@section('content')
    <div class="min-h-screen flex" x-data="{ showPassword: false, showConfirmPassword: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), toggleTheme() { this.darkMode = !this.darkMode; if(this.darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } } }">

        {{-- Left Side — Decorative Panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-linear-to-br from-[#001233] via-[#002045] to-[#0a3d6e]">
            {{-- Animated decorative blobs --}}
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/15 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] animate-pulse" style="animation-delay:2s"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/5 rounded-full blur-[150px]"></div>

            {{-- Geometric accents --}}
            <div class="absolute top-20 right-20 w-32 h-32 border border-white/5 rounded-3xl rotate-12"></div>
            <div class="absolute bottom-32 left-16 w-20 h-20 border border-white/5 rounded-2xl -rotate-6"></div>
            <div class="absolute top-1/3 left-10 w-16 h-16 border border-white/3 rounded-xl rotate-45"></div>

            {{-- Islamic Pattern Overlay --}}
            <div class="absolute inset-0 opacity-3"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>

            {{-- Content --}}
            <div class="relative z-10 flex flex-col items-center justify-center w-full px-12">
                <div class="w-28 h-28 mb-8 animate-[fadeInUp_0.8s_ease-out]">
                    <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo RTQ Kawali" class="w-full h-full object-contain drop-shadow-2xl">
                </div>
                <h2 class="text-3xl font-extrabold text-white tracking-tight mb-3 animate-[fadeInUp_0.8s_ease-out_0.1s_both]">RTQ Kawali</h2>
                <p class="text-blue-200/70 text-center max-w-sm leading-relaxed animate-[fadeInUp_0.8s_ease-out_0.2s_both]">
                    Bergabunglah bersama kami dalam membentuk generasi Qur'ani yang berakhlak mulia
                </p>

                {{-- Decorative dots --}}
                <div class="mt-12 flex items-center gap-2 animate-[fadeInUp_0.8s_ease-out_0.3s_both]">
                    <span class="w-2 h-2 rounded-full bg-blue-400/50"></span>
                    <span class="w-8 h-2 rounded-full bg-blue-400/30"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-400/50"></span>
                </div>

                {{-- Steps preview --}}
                <div class="mt-12 space-y-4 w-full max-w-xs animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
                    <div class="flex items-center gap-3 bg-white/6 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/8">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                            <span class="text-emerald-300 font-bold text-sm">1</span>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Buat Akun</p>
                            <p class="text-blue-200/50 text-xs">Daftarkan nomor telepon Anda</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/6 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/8">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                            <span class="text-blue-300 font-bold text-sm">2</span>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Isi Formulir PPDB</p>
                            <p class="text-blue-200/50 text-xs">Lengkapi data dan upload berkas</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/6 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/8">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0">
                            <span class="text-amber-300 font-bold text-sm">3</span>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Ikuti Seleksi</p>
                            <p class="text-blue-200/50 text-xs">Tes dan wawancara offline</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side — Register Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
            {{-- Background decorations --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-100/40 dark:bg-blue-900/10 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 bg-indigo-100/30 dark:bg-indigo-900/10 rounded-full blur-[60px]"></div>

            <div class="relative z-10 w-full max-w-md px-6 sm:px-8 py-12">
                {{-- Dark mode toggle --}}
                <div class="absolute top-6 right-6 sm:top-8 sm:right-8">
                    <button type="button" @click="toggleTheme()"
                        class="p-2.5 text-gray-500 hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" x-cloak style="display: none;" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>
                </div>

                {{-- Mobile Logo --}}
                <div class="lg:hidden flex flex-col items-center mb-10">
                    <div class="w-20 h-20 mb-4">
                        <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo RTQ Kawali" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">RTQ Kawali</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Yayasan Mutiara Gema Insani</p>
                </div>

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Daftar Akun Baru ✨
                    </h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm sm:text-base">
                        Buat akun untuk memulai pendaftaran sebagai calon santri
                    </p>
                </div>

                {{-- Info Banner --}}
                <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-2xl p-4 flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-800/40 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-blue-700 dark:text-blue-300 leading-relaxed">
                        Akun ini digunakan untuk mengisi formulir PPDB dan memantau status pendaftaran Anda.
                    </p>
                </div>

                {{-- Register Form --}}
                {{-- Error Messages --}}
                @if($errors->any())
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form action="{{ route('ppdb.register') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Full Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}"
                                class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm">
                        </div>
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx" required value="{{ old('phone') }}"
                                class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Nomor ini akan digunakan untuk login</p>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'" placeholder="Buat password (min. 8 karakter)" required
                                class="w-full pl-12 pr-12 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" placeholder="Ulangi password" required
                                class="w-full pl-12 pr-12 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Terms Agreement --}}
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="terms" name="terms" required
                            class="w-4 h-4 mt-1 rounded-md border-2 border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-800 transition-colors">
                        <label for="terms" class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed cursor-pointer">
                            Saya menyetujui <a href="{{ route('dalam-pengembangan') }}" target="_blank" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Syarat & Ketentuan</a> serta <a href="{{ route('dalam-pengembangan') }}" target="_blank" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Kebijakan Privasi</a> RTQ Kawali
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-3.5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-600/25 dark:shadow-blue-900/40 hover:shadow-xl hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Buat Akun
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-8 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Sudah punya akun?</span>
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                </div>

                {{-- Login Link --}}
                <a href="{{ route('login') }}"
                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50/50 dark:hover:bg-gray-750 transition-all duration-200 text-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Masuk ke Akun
                </a>

                {{-- Back to home --}}
                <div class="mt-8 text-center">
                    <a href="/" class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection
