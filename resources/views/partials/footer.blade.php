{{-- Footer --}}
<footer id="kontak" class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid md:grid-cols-3 gap-12">
            {{-- Kontak --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-20 h-20 flex items-center justify-center">
                        <img src="{{ asset('images/Logo_rtq.png') }}" alt="Logo RTQ Kawali"
                            class="w-full h-full object-contain">
                    </div>
                    <div>
                        <span class="text-lg font-bold text-white block">RTQ Kawali</span>
                        <span class="text-xs text-blue-400 font-medium">Pondok Pesantren</span>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        <span>Jl. Pesantren No. 01, Kawali, Ciamis, Jawa Barat 46253</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        <span>+62 812-3975-7088 (Admin RTQ WhatsApp)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <span>info@rtqkawali.com</span>
                    </div>
                </div>
            </div>

            {{-- Link Cepat --}}
            <div>
                <h4 class="text-white font-bold text-lg mb-6">Link Cepat</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#beranda" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#profil" class="hover:text-blue-400 transition">Profil Pesantren</a></li>
                    <li><a href="#program" class="hover:text-blue-400 transition">Program Unggulan</a></li>
                    <li><a href="#fasilitas" class="hover:text-blue-400 transition">Fasilitas</a></li>
                    <li><a href="{{ route('ppdb.info') }}" class="hover:text-blue-400 transition">Informasi PPDB</a></li>
                    <li><a href="{{ route('ppdb.ditutup') }}" class="hover:text-blue-400 transition">Pendaftaran PPDB</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">Login Santri</a></li>
                </ul>
            </div>

            {{-- Media Sosial --}}
            <div>
                <h4 class="text-white font-bold text-lg mb-6">Media Sosial</h4>
                <p class="text-sm mb-6">Ikuti kami di media sosial untuk informasi terbaru seputar kegiatan pesantren.
                </p>
                <div class="flex items-center gap-3">
                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/rtqkawali/"
                        class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-200"
                        aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                    {{-- YouTube --}}
                    <a href="https://www.youtube.com/@kawalimengaji"
                        class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-200"
                        aria-label="YouTube">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                    {{-- Website/Globe --}}
                    <a href="www.rtqkawali.com"
                        class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-200"
                        aria-label="Website">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-gray-800 dark:border-gray-800/80">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-center gap-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">&copy; 2026 Pondok Pesantren RTQ Kawali | Version 2.1 |
                Develoved by <a href="https://a-firman.github.io/Portofolio/"><Span
                        class="font-bold text-gray-300">A.F</Span></a></p>
        </div>
    </div>
</footer>