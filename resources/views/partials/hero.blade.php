{{-- Hero Section --}}
<section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero-bg.png') }}" alt="Pondok Pesantren RTQ Kawali"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-blue-900/70 to-gray-900/80"></div>
    </div>

    {{-- Decorative Islamic Pattern Overlay --}}
    <div class="absolute inset-0 opacity-5"
        style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    {{-- Content --}}

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center pt-20">
        <div
            class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20 mb-8">
            <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
            <span class="text-white/90 text-sm font-medium">Pendaftaran Santri Baru Dibuka</span>
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-6">
            Rumah Tahfidz Qur'an Kawali
        </h1>
        <h3 class="text-lg sm:text-xl font-bold text-white leading-tight mb-6">Yayasan Mutiara Gema Insani</h3>

        <p class="text-lg sm:text-xl text-blue-100/90 max-w-2xl mx-auto mb-10 leading-relaxed">
            Selamat datang di sistem informasi dan pendaftaran online Pondok Pesantren RTQ Kawali.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/informasi-ppdb"
                class="group inline-flex items-center gap-2 px-8 py-4 bg-blue-600 text-white font-semibold rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-600/30 dark:shadow-blue-900/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-600/40">
                Informasi Pendaftaran
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
            <a href="#profil"
                class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-2xl border border-white/20 hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
        </svg>
    </div>
</section>