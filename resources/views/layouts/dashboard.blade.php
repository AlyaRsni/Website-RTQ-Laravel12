<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ sidebarOpen: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => { if(val) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_rtq.png') }}">
    <meta name="description" content="Dashboard PPDB Calon Santri - Pondok Pesantren RTQ Kawali">
    <title>@yield('title', 'Dashboard PPDB — RTQ Kawali')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-[#0a0f1a] text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <div class="flex min-h-screen">

        {{-- ==================== SIDEBAR ==================== --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex flex-col h-full bg-white/80 dark:bg-[#111827]/90 backdrop-blur-2xl border-r border-gray-200/60 dark:border-gray-700/40">
                {{-- Logo Area --}}
                <div class="flex items-center gap-3.5 px-6 py-6 border-b border-gray-100 dark:border-gray-800/60">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5 shadow-lg shadow-blue-500/25">
                        <div class="w-full h-full rounded-[14px] bg-white dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-sm font-extrabold tracking-tight text-gray-900 dark:text-white">RTQ Kawali</h1>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium">Dashboard PPDB</p>
                    </div>
                    {{-- Close btn (mobile) --}}
                    <button @click="sidebarOpen = false" class="lg:hidden ml-auto p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- User Card --}}
                <div class="mx-4 mt-5 mb-2">
                    <div class="bg-linear-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 border border-blue-100/60 dark:border-blue-800/30">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-linear-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-blue-500/20">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">Calon Santri</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
                    <p class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Menu Utama</p>
                    
                    <a href="{{ route('ppdb.dashboard') }}" 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                        {{ request()->routeIs('ppdb.dashboard') 
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 shadow-sm' 
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-white' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('ppdb.dashboard') ? 'bg-blue-100 dark:bg-blue-800/40' : 'bg-gray-100 dark:bg-gray-800' }}">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        Dashboard
                    </a>

                    <p class="px-3 mt-5 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Langkah Pendaftaran</p>

                    @php
                        $reg = Auth::user()->ppdbRegistration;
                        $sidebarSteps = [
                            1 => ['title' => 'Pembayaran', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                            2 => ['title' => 'Data Diri', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            3 => ['title' => 'Kontak Ortu', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                            4 => ['title' => 'Upload Berkas', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            5 => ['title' => 'Finalisasi', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                    @endphp

                    @foreach($sidebarSteps as $stepNum => $stepInfo)
                        @php
                            $isActive = request()->routeIs('ppdb.step.' . $stepNum);
                            $isCompleted = $reg && $reg->isStepCompleted($stepNum);
                            $isAccessible = $reg && $reg->isStepAccessible($stepNum);
                            $isFinalized = $reg && $reg->isFinalized();
                        @endphp
                        @if($isAccessible && !$isFinalized)
                            <a href="{{ route('ppdb.step.' . $stepNum) }}"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                {{ $isActive 
                                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 shadow-sm font-semibold' 
                                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-white' }}">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center 
                                    {{ $isCompleted ? 'bg-emerald-100 dark:bg-emerald-800/30' : ($isActive ? 'bg-blue-100 dark:bg-blue-800/40' : 'bg-gray-100 dark:bg-gray-800') }}">
                                    @if($isCompleted)
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <span class="text-xs font-bold {{ $isActive ? 'text-blue-600 dark:text-blue-300' : 'text-gray-400 dark:text-gray-500' }}">{{ $stepNum }}</span>
                                    @endif
                                </div>
                                {{ $stepInfo['title'] }}
                            </a>
                        @else
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-300 dark:text-gray-600 cursor-not-allowed opacity-60">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-100 dark:bg-gray-800/50">
                                    @if($isCompleted)
                                        <svg class="w-4 h-4 text-emerald-400 dark:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    @endif
                                </div>
                                {{ $stepInfo['title'] }}
                            </div>
                        @endif
                    @endforeach

                    <p class="px-3 mt-5 mb-2 text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 dark:text-gray-500">Informasi</p>

                    <a href="{{ route('ppdb.status-kelulusan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                        {{ request()->routeIs('ppdb.status-kelulusan') 
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 shadow-sm' 
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-white' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('ppdb.status-kelulusan') ? 'bg-blue-100 dark:bg-blue-800/40' : 'bg-gray-100 dark:bg-gray-800' }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        Hasil Seleksi
                    </a>

                    <a href="{{ route('ppdb.tanggal-penting') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                        {{ request()->routeIs('ppdb.tanggal-penting') 
                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 shadow-sm' 
                            : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-white' }}">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ request()->routeIs('ppdb.tanggal-penting') ? 'bg-blue-100 dark:bg-blue-800/40' : 'bg-gray-100 dark:bg-gray-800' }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        Tanggal Penting
                    </a>
                </nav>

                {{-- Sidebar Footer --}}
                <div class="px-4 py-4 border-t border-gray-100 dark:border-gray-800/60 space-y-1.5">
                    <button @click="darkMode = !darkMode"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-white transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                            <svg x-show="!darkMode" class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            <svg x-show="darkMode" x-cloak style="display:none" class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                    </button>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                            <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </div>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" style="display:none"></div>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-[#111827]/80 backdrop-blur-xl border-b border-gray-200/60 dark:border-gray-700/40">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">@yield('page_title', 'Dashboard')</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">@yield('page_subtitle', 'PPDB Tahun Ajaran 2026/2027')</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Notification placeholder --}}
                        <div class="relative">
                            <button class="p-2.5 rounded-xl text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content Area --}}
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/30 rounded-2xl p-4 flex items-center gap-3 animate-[slideDown_0.3s_ease-out]">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-800/40 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300 flex-1">{{ session('success') }}</p>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-800/40 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-red-700 dark:text-red-300 flex-1">{{ session('error') }}</p>
                    <button @click="show = false" class="text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @endif

                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="px-4 sm:px-6 lg:px-8 py-4 border-t border-gray-100 dark:border-gray-800/40">
                <p class="text-xs text-center text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} Pondok Pesantren RTQ Kawali — Yayasan Mutiara Gema Insani</p>
            </footer>
        </div>
    </div>

    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
