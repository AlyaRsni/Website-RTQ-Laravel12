<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_rtq.png') }}">
    <meta name="description" content="Pondok Pesantren RTQ Kawali - Membangun Generasi Qur'ani, Berakhlak Mulia, dan Berprestasi. Pendaftaran online santri baru.">
    <title>@yield('title', 'Pondok Pesantren RTQ Kawali')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Alpine.js (Lightweight interactivity) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Script inlined untuk mencegah FOUC --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 transition-colors duration-300">
    @yield('content')
</body>
</html>
