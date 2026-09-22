@extends('layouts.landing')

@section('title', 'Masuk — RTQ Kawali')

@section('content')
    <div class="min-h-screen flex" x-data="{ showPassword: false, showForgotModal: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), toggleTheme() { this.darkMode = !this.darkMode; if(this.darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } } }">

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
                    Sistem Informasi Akademik Pondok Pesantren Rumah Tahfidz Qur'an Kawali
                </p>

                {{-- Decorative dots --}}
                <div class="mt-12 flex items-center gap-2 animate-[fadeInUp_0.8s_ease-out_0.3s_both]">
                    <span class="w-2 h-2 rounded-full bg-blue-400/50"></span>
                    <span class="w-8 h-2 rounded-full bg-blue-400/30"></span>
                    <span class="w-2 h-2 rounded-full bg-blue-400/50"></span>
                </div>

                {{-- Feature highlights --}}
                <div class="mt-12 space-y-4 w-full max-w-xs animate-[fadeInUp_0.8s_ease-out_0.4s_both]">
                    <div class="flex items-center gap-3 bg-white/6 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/8">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">Halaqah Digital</p>
                            <p class="text-blue-200/50 text-xs">Pantau perkembangan hafalan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/6 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/8">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-semibold">PPDB Online</p>
                            <p class="text-blue-200/50 text-xs">Pendaftaran mudah dan cepat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side — Login Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
            {{-- Background decorations for right side --}}
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
                        Ahlan Wa Sahlan
                    </h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm sm:text-base">
                        Masuk ke akun Anda untuk mengakses sistem
                    </p>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/30 rounded-2xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
                </div>
                @endif

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

                {{-- Login Form --}}
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nomor Telepon / NIS --}}
                    <div>
                        <label for="login" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Telepon atau NIS
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="login" name="login" type="text" placeholder="08xxxxxxxxxx atau NIS" required value="{{ old('login') }}"
                                class="w-full pl-12 pr-4 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm">
                        </div>
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
                            <input id="password" name="password" :type="showPassword ? 'text' : 'password'" placeholder="Masukkan password" required
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

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded-md border-2 border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-800 transition-colors">
                            <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Ingat saya</span>
                        </label>
                        <button type="button" @click="showForgotModal = true" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                            Lupa password?
                        </button>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full py-3.5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-600/25 dark:shadow-blue-900/40 hover:shadow-xl hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-8 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Belum punya akun?</span>
                    <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
                </div>

                {{-- Register Link --}}
                <a href="{{ route('ppdb.register') }}"
                    class="w-full inline-flex items-center justify-center gap-2 py-3.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50/50 dark:hover:bg-gray-750 transition-all duration-200 text-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Daftar Sebagai Calon Santri
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

        {{-- Modal Lupa Password --}}
        <div x-show="showForgotModal" style="display: none" class="fixed inset-0 z-100 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
            <div @click.away="showForgotModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm p-6 mx-4 transform transition-all" x-show="showForgotModal" x-transition.scale.origin.bottom>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lupa Password?</h3>
                </div>
                
                <div class="text-sm text-gray-600 dark:text-gray-300 mb-6 space-y-3 leading-relaxed">
                    <p>Karena alasan keamanan, sistem tidak melayani reset password secara mandiri.</p>
                    <p>Silakan menghubungi <strong>Panitia PPDB</strong> untuk meminta bantuan reset password (jangan lupa sebutkan nama lengkap dan nomor telepon yang didaftarkan).</p>
                    
                    <a href="https://wa.me/6285294491824" target="_blank" class="mt-4 flex items-center justify-center gap-2 w-full py-3 bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold rounded-xl transition-colors shadow-lg shadow-green-500/20">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.646.685 5.161 1.986 7.411L.069 24l4.675-1.921A11.954 11.954 0 0012.03 24c6.645 0 12.03-5.385 12.03-12.03S18.676 0 12.031 0zm0 22.015c-2.247 0-4.444-.606-6.37-1.751l-.456-.27-3.473 1.427 1.446-3.385-.297-.472A9.97 9.97 0 012.015 12.03C2.015 6.505 6.505 2.015 12.03 2.015c5.526 0 10.016 4.49 10.016 10.015 0 5.526-4.49 10.015-10.016 10.015zm5.5-7.531c-.302-.151-1.782-.876-2.059-.977-.277-.101-.478-.151-.68.151-.2.302-.782.977-.958 1.178-.176.2-.353.226-.655.075-.302-.151-1.275-.47-2.427-1.494-.897-.798-1.503-1.784-1.68-2.086-.177-.302-.019-.465.132-.616.136-.136.302-.352.453-.528.151-.176.2-.302.303-.503.101-.2.05-.377-.025-.528-.075-.151-.68-1.636-.932-2.24-.246-.59-.496-.51-.68-.519-.176-.01-.378-.01-.58-.01-.2 0-.528.075-.805.377-.277.302-1.056 1.03-1.056 2.514 0 1.484 1.082 2.918 1.233 3.12.151.2 2.128 3.245 5.155 4.551 2.036.877 2.822.95 3.82.798.92-.14 2.834-1.157 3.236-2.274.402-1.117.402-2.073.277-2.274-.125-.2-.478-.302-.78-.453z"/></svg>
                        Hubungi Admin PPDB
                    </a>
                </div>

                <div class="flex justify-end mt-4">
                    <button @click="showForgotModal = false" type="button" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-xl transition-all">Tutup</button>
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
