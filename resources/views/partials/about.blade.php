{{-- Tentang Kami --}}
<section id="profil" class="py-20 lg:py-28 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <span
                class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-sm font-semibold rounded-full mb-4 transition-colors">Tentang
                Kami</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white transition-colors">Mengenal Pondok
                Pesantren <span class="text-blue-600 dark:text-blue-500">RTQ Kawali</span></h2>
        </div>

        {{-- Content Grid --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {{-- Image --}}
            <div class="relative group">
                <div
                    class="rounded-3xl overflow-hidden shadow-2xl relative z-10 transition-transform duration-500 group-hover:scale-[1.02]">
                    <img src="{{ asset('images/about.jpeg') }}" alt="Suasana Belajar di RTQ Kawali"
                        class="w-full h-80 lg:h-[450px] object-cover">
                </div>
                <div
                    class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-600/10 dark:bg-blue-500/10 rounded-3xl z-0 transition-transform duration-500 group-hover:translate-x-2 group-hover:translate-y-2">
                </div>
                <div
                    class="absolute -top-6 -left-6 w-24 h-24 bg-blue-600/10 dark:bg-blue-500/10 rounded-3xl z-0 transition-transform duration-500 group-hover:-translate-x-2 group-hover:-translate-y-2">
                </div>
            </div>

            {{-- Text Content --}}
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 transition-colors">Mencetak Generasi
                    Qur'ani Sejak Dini</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed transition-colors">
                    Pondok Pesantren RTQ Kawali didirikan dengan cita-cita mulia untuk mencetak generasi muda yang hafal
                    Al-Qur'an, memahami ilmu agama secara mendalam, sekaligus memiliki kompetensi akademik yang unggul.
                    Dengan lingkungan yang kondusif dan metode pembelajaran yang terintegrasi, kami berkomitmen untuk
                    membimbing setiap santri mencapai potensi terbaiknya.
                </p>

                {{-- Visi Misi --}}
                <div class="space-y-4 pt-2">
                    <div
                        class="group/card flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center shrink-0 group-hover/card:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-1 transition-colors">Visi</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">Menjadi lembaga
                                pendidikan Islam terdepan yang melahirkan generasi Qur'ani, berakhlak mulia, dan berdaya
                                saing tinggi.</p>
                        </div>
                    </div>
                    <div
                        class="group/card flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-md border border-gray-100 dark:border-gray-700 transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center shrink-0 group-hover/card:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-1 transition-colors">Misi</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">Menyelenggarakan
                                pendidikan tahfidz dan kajian Islam yang berkualitas, membina akhlakul karimah, serta
                                mengembangkan potensi akademik dan keterampilan santri.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
