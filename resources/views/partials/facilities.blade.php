{{-- Fasilitas --}}
<section id="fasilitas" class="py-20 lg:py-28 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span
                class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-sm font-semibold rounded-full mb-4">Fasilitas</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white transition-colors">Fasilitas <span
                    class="text-blue-600 dark:text-blue-500">Modern & Lengkap</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mt-4 max-w-2xl mx-auto transition-colors">Lingkungan belajar yang
                nyaman dan kondusif untuk mendukung proses pendidikan santri.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $facilities = [
                    [
                        'image' => 'facility-masjid.png',
                        'title' => 'Masjid',
                        'desc' => 'Masjid utama untuk ibadah dan kegiatan keagamaan.',
                    ],
                    [
                        'image' => 'facility-asrama.png',
                        'title' => 'Asrama Santri',
                        'desc' => 'Asrama bersih dan nyaman dilengkapi fasilitas penunjang harian.',
                    ],
                    [
                        'image' => 'tempat-belajar.jpg',
                        'title' => 'Tempat Belajar',
                        'desc' => 'Koleksi lengkap kitab dan buku referensi untuk pengembangan ilmu.',
                    ],
                    [
                        'image' => 'aula.jpg',
                        'title' => 'Aula Serbaguna',
                        'desc' => 'Aula digunakan untuk mendukung pembelajaran kegiatan bersama.',
                    ],
                ];
            @endphp

            @foreach ($facilities as $facility)
                <div
                    class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl dark:shadow-gray-900/50 hover:ring-2 hover:ring-blue-500/50 transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ asset('images/' . $facility['image']) }}" alt="{{ $facility['title'] }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 p-6 transform group-hover:-translate-y-1 transition-transform duration-300">
                        <h3 class="text-lg font-bold text-white mb-1">{{ $facility['title'] }}</h3>
                        <p class="text-sm text-gray-200">{{ $facility['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
