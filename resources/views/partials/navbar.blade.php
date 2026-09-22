{{-- Navbar --}}
<nav id="navbar"
    x-data="{ mobileOpen: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), toggleTheme() { this.darkMode = !this.darkMode; if(this.darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } } }"
    class="fixed top-0 left-0 right-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md shadow-sm dark:border-b dark:border-gray-800 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 shrink-0 group">
                <div
                    class="hidden lg:flex w-12 h-12 items-center justify-center transition-transform group-hover:scale-105">
                    <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo RTQ Kawali"
                        class="w-full h-full object-contain">
                </div>
                <div>
                    <span
                        class="text-base font-bold text-gray-900 dark:text-white leading-tight block group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">RTQ
                        Kawali</span>
                    <span
                        class="text-[10px] text-gray-500 dark:text-gray-500 font-medium tracking-wider uppercase">Yayasan
                        Mutiara Gema
                        Insani</span>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="/#beranda"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Beranda</a>
                <a href="/#profil"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Profil</a>
                <a href="/#program"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Program</a>
                <a href="/#fasilitas"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Fasilitas</a>
                <a href="{{ route('ppdb.info') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Informasi
                    PPDB</a>
                <a href="/#kontak"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Kontak</a>
            </div>

            {{-- Desktop CTA Buttons --}}
            <div class="hidden lg:flex items-center gap-3">
                {{-- Dark Mode Toggle --}}
                <button type="button" @click="toggleTheme()"
                    class="p-2.5 text-gray-500 hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors mr-2">
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
                <a href="{{ route('login') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-blue-600 dark:text-blue-400 border-2 border-blue-600 dark:border-blue-500 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-800 transition-all duration-200">Login
                    Santri</a>
                <a href="{{ route('ppdb.register') }}"
                    class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/25 dark:shadow-blue-900/40 transition-all duration-200">Daftar
                    PPDB</a>
            </div>

            {{-- Mobile Hamburger & Dark Mode --}}
            <div class="flex items-center gap-2 lg:hidden">
                <button type="button" @click="toggleTheme()"
                    class="p-2 text-gray-500 hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
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
                <button id="mobile-menu-btn"
                    class="relative w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center justify-center"
                    @click="mobileOpen = !mobileOpen">
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 transition-all duration-300"
                        :class="mobileOpen ? 'rotate-90 opacity-0 scale-50' : 'rotate-0 opacity-100 scale-100'"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300 absolute transition-all duration-300"
                        :class="mobileOpen ? 'rotate-0 opacity-100 scale-100' : '-rotate-90 opacity-0 scale-50'"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-collapse x-cloak
        class="lg:hidden border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 pb-4">
        <div class="px-4 pt-2 space-y-1">
            <a href="/#beranda"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Beranda</a>
            <a href="/#profil"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Profil</a>
            <a href="/#program"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Program</a>
            <a href="/#fasilitas"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Fasilitas</a>
            <a href="{{ route('ppdb.info') }}"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Informasi
                PPDB</a>
            <a href="/#kontak"
                class="block px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-lg transition">Kontak</a>
        </div>
        <div class="px-4 pt-3 flex flex-col gap-2">
            <a href="{{ route('login') }}"
                class="w-full text-center px-5 py-2.5 text-sm font-semibold text-blue-600 dark:text-blue-400 border-2 border-blue-600 dark:border-blue-500 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-800 transition">Login
                Santri</a>
            <a href="{{ route('ppdb.register') }}"
                class="w-full text-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/25 dark:shadow-blue-900/40 transition">Daftar
                PPDB</a>
        </div>
    </div>
</nav>