@extends('layouts.landing')

@section('title', 'Pendaftaran PPDB Belum Dibuka — RTQ Kawali')

@section('content')
    @include('partials.navbar')

    {{--
        CATATAN:
        Seluruh styling inti halaman ini ditulis di <style> internal di bawah (prefix .bd-),
        BUKAN memakai class Tailwind. Tujuannya:
        1. Warna di-hardcode (tema terang tetap) -> kebal terhadap class .dark / Dark Mode OS.
        2. Animasi memakai @keyframes manual -> tetap jalan walau CSS Tailwind belum ter-build.
    --}}
    <style>
        /* ===== Kunci tema: paksa mode terang di area halaman ini ===== */
        .bd-page {
            color-scheme: light;
            position: relative;
            overflow: hidden;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 1rem 5rem;
            background: linear-gradient(135deg, #fffbeb 0%, #ffffff 45%, #eff6ff 100%);
            color: #1e293b;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .bd-page *, .bd-page *::before, .bd-page *::after { box-sizing: border-box; }

        /* ===== Keyframes manual ===== */
        @keyframes bd-blink {
            0%, 100% { opacity: 1; }
            50%      { opacity: .35; }
        }
        @keyframes bd-ping {
            0%       { transform: scale(1);   opacity: .8; }
            75%, 100%{ transform: scale(2.4); opacity: 0; }
        }
        @keyframes bd-glow {
            0%, 100% { opacity: .55; transform: scale(1); }
            50%      { opacity: .9;  transform: scale(1.08); }
        }
        @keyframes bd-float {
            0%, 100% { transform: translateY(0) rotate(12deg); }
            50%      { transform: translateY(-14px) rotate(16deg); }
        }
        @keyframes bd-fade-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== Class animasi custom ===== */
        .bd-anim-blink { animation: bd-blink 1.6s ease-in-out infinite; }
        .bd-anim-glow  { animation: bd-glow 4s ease-in-out infinite; }
        .bd-anim-float { animation: bd-float 7s ease-in-out infinite; }
        .bd-anim-fade  { animation: bd-fade-up .7s ease-out both; }
        .bd-delay-1 { animation-delay: .1s; }
        .bd-delay-2 { animation-delay: .2s; }
        .bd-delay-3 { animation-delay: .3s; }
        .bd-delay-4 { animation-delay: .4s; }

        @media (prefers-reduced-motion: reduce) {
            .bd-page [class*="bd-anim-"], .bd-ping-dot::after { animation: none !important; }
        }

        /* ===== Dekorasi latar ===== */
        .bd-blob { position: absolute; border-radius: 9999px; filter: blur(90px); pointer-events: none; }
        .bd-blob--amber { top: 3rem; left: 2rem; width: 20rem; height: 20rem; background: #fde68a; }
        .bd-blob--blue  { bottom: 2rem; right: 2rem; width: 24rem; height: 24rem; background: #bfdbfe; animation-delay: 2s; }
        .bd-shape {
            position: absolute; border: 2px solid rgba(0, 32, 69, .08); border-radius: 1.5rem;
            pointer-events: none; display: none;
        }
        .bd-shape--1 { top: 7rem; right: 5rem; width: 8rem; height: 8rem; }
        .bd-shape--2 { bottom: 7rem; left: 4rem; width: 5rem; height: 5rem; animation-delay: 1.5s; }
        @media (min-width: 1024px) { .bd-shape { display: block; } }

        /* ===== Konten ===== */
        .bd-container { position: relative; z-index: 10; width: 100%; max-width: 48rem; margin: 0 auto; text-align: center; }

        .bd-icon-wrap { position: relative; width: 6.5rem; height: 6.5rem; margin: 0 auto 1.5rem; }
        .bd-icon-glow { position: absolute; inset: 0; border-radius: 1.75rem; background: #fcd34d; filter: blur(18px); }
        .bd-icon {
            position: relative; width: 100%; height: 100%; border-radius: 1.75rem;
            background: #ffffff; border: 1px solid #fde68a;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 20px 40px -12px rgba(217, 119, 6, .35);
        }
        .bd-icon svg { width: 3.25rem; height: 3.25rem; color: #d97706; }

        .bd-pill {
            display: inline-flex; align-items: center; gap: .6rem;
            padding: .45rem 1.1rem; margin-bottom: 1.5rem; border-radius: 9999px;
            background: #fef3c7; border: 1px solid #fcd34d; color: #92400e;
            font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
        }
        .bd-ping-dot { position: relative; width: .55rem; height: .55rem; border-radius: 9999px; background: #f59e0b; }
        .bd-ping-dot::after {
            content: ''; position: absolute; inset: 0; border-radius: 9999px; background: #f59e0b;
            animation: bd-ping 1.4s cubic-bezier(0, 0, .2, 1) infinite;
        }

        .bd-title {
            margin: 0 0 1.25rem; color: #002045; font-weight: 800; line-height: 1.1;
            letter-spacing: -.03em; font-size: clamp(2rem, 6vw, 3.75rem);
        }
        .bd-title span {
            background: linear-gradient(90deg, #d97706, #f59e0b, #b45309);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent; color: #d97706;
        }
        .bd-lead { max-width: 36rem; margin: 0 auto 2rem; color: #475569; font-size: 1.05rem; line-height: 1.7; }
        .bd-lead strong { color: #002045; font-weight: 700; }

        .bd-card {
            background: #ffffff; border: 1px solid #e2e8f0; border-radius: 1.5rem;
            padding: 1.5rem; margin-bottom: 1.75rem;
            box-shadow: 0 20px 50px -20px rgba(0, 32, 69, .18);
        }
        .bd-card-label {
            margin: 0 0 1rem; color: #b45309; font-size: .75rem; font-weight: 700;
            letter-spacing: .14em; text-transform: uppercase;
        }
        .bd-countdown { display: grid; grid-template-columns: repeat(4, 1fr); gap: .75rem; max-width: 28rem; margin: 0 auto; }
        .bd-count-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: .9rem .25rem; }
        .bd-count-num { display: block; color: #002045; font-size: clamp(1.5rem, 5vw, 2.25rem); font-weight: 900; line-height: 1; }
        .bd-count-num--accent { color: #d97706; }
        .bd-count-unit { display: block; margin-top: .4rem; color: #64748b; font-size: .7rem; font-weight: 600; text-transform: uppercase; }

        .bd-check-head { display: flex; align-items: center; gap: .75rem; margin-bottom: 1rem; text-align: left; }
        .bd-check-head h2 { margin: 0; color: #002045; font-size: 1.05rem; font-weight: 700; }
        .bd-check-icon {
            width: 2rem; height: 2rem; border-radius: .75rem; background: #fef3c7; color: #d97706;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .bd-check-icon svg { width: 1rem; height: 1rem; }
        .bd-check-grid { display: grid; grid-template-columns: 1fr; gap: .75rem; text-align: left; }
        @media (min-width: 640px) { .bd-check-grid { grid-template-columns: 1fr 1fr; } }
        .bd-check-item {
            display: flex; gap: .6rem; align-items: flex-start; padding: .8rem;
            background: #f8fafc; border: 1px solid #f1f5f9; border-radius: .8rem;
            color: #334155; font-size: .875rem; line-height: 1.5;
        }
        .bd-check-item b { color: #002045; }
        .bd-check-mark { color: #16a34a; font-weight: 800; }

        .bd-actions { display: flex; flex-direction: column; gap: .85rem; align-items: center; justify-content: center; }
        @media (min-width: 640px) { .bd-actions { flex-direction: row; } }
        .bd-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; padding: .9rem 1.6rem; border-radius: 1rem;
            font-size: .9rem; font-weight: 700; text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
        }
        @media (min-width: 640px) { .bd-btn { width: auto; } }
        .bd-btn svg { width: 1.2rem; height: 1.2rem; flex-shrink: 0; }
        .bd-btn:hover { transform: translateY(-2px); }
        .bd-btn--primary { background: #002045; color: #ffffff; box-shadow: 0 12px 24px -10px rgba(0, 32, 69, .6); }
        .bd-btn--primary:hover { background: #0a3d6e; color: #ffffff; }
        .bd-btn--wa { background: #25D366; color: #ffffff; box-shadow: 0 12px 24px -10px rgba(37, 211, 102, .6); }
        .bd-btn--wa:hover { background: #1ebe5a; color: #ffffff; }
        .bd-btn--ghost { background: #ffffff; color: #002045; border: 1px solid #cbd5e1; }
        .bd-btn--ghost:hover { background: #f1f5f9; color: #002045; }
    </style>

    <section class="bd-page">
        {{-- Dekorasi --}}
        <div class="bd-blob bd-blob--amber bd-anim-glow"></div>
        <div class="bd-blob bd-blob--blue bd-anim-glow"></div>
        <div class="bd-shape bd-shape--1 bd-anim-float"></div>
        <div class="bd-shape bd-shape--2 bd-anim-float"></div>

        <div class="bd-container"
            x-data="{
                targetDate: new Date('2026-11-01T00:00:00+07:00').getTime(),
                days: 0, hours: 0, minutes: 0, seconds: 0,
                updateCountdown() {
                    const diff = Math.max(0, this.targetDate - Date.now());
                    this.days = Math.floor(diff / 86400000);
                    this.hours = Math.floor((diff % 86400000) / 3600000);
                    this.minutes = Math.floor((diff % 3600000) / 60000);
                    this.seconds = Math.floor((diff % 60000) / 1000);
                },
                init() {
                    this.updateCountdown();
                    setInterval(() => this.updateCountdown(), 1000);
                }
            }">

            {{-- Ikon --}}
            <div class="bd-icon-wrap bd-anim-fade">
                <div class="bd-icon-glow bd-anim-glow"></div>
                <div class="bd-icon">
                    <svg class="bd-anim-blink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            {{-- Status --}}
            <div class="bd-pill bd-anim-fade bd-delay-1">
                <span class="bd-ping-dot"></span>
                <span>Segera Dibuka • 1 November 2026</span>
            </div>

            {{-- Judul --}}
            <h1 class="bd-title bd-anim-fade bd-delay-1">
                Pendaftaran PPDB<br><span>Belum Dibuka</span>
            </h1>

            <p class="bd-lead bd-anim-fade bd-delay-2">
                Pendaftaran Penerimaan Peserta Didik Baru (PPDB) Pondok Pesantren RTQ Kawali Tahun Ajaran 2026/2027
                belum dibuka dan <strong>akan resmi dibuka pada tanggal 1 November 2026</strong>.
            </p>

            {{-- Countdown --}}
            <div class="bd-card bd-anim-fade bd-delay-3">
                <p class="bd-card-label">Hitung Mundur Pembukaan Pendaftaran</p>
                <div class="bd-countdown">
                    <div class="bd-count-box">
                        <span class="bd-count-num" x-text="days">--</span>
                        <span class="bd-count-unit">Hari</span>
                    </div>
                    <div class="bd-count-box">
                        <span class="bd-count-num" x-text="hours">--</span>
                        <span class="bd-count-unit">Jam</span>
                    </div>
                    <div class="bd-count-box">
                        <span class="bd-count-num" x-text="minutes">--</span>
                        <span class="bd-count-unit">Menit</span>
                    </div>
                    <div class="bd-count-box">
                        <span class="bd-count-num bd-count-num--accent bd-anim-blink" x-text="seconds">--</span>
                        <span class="bd-count-unit">Detik</span>
                    </div>
                </div>
            </div>

            {{-- Checklist --}}
            <div class="bd-card bd-anim-fade bd-delay-4">
                <div class="bd-check-head">
                    <div class="bd-check-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2>Persiapan Menjelang Pembukaan Pendaftaran</h2>
                </div>
                <div class="bd-check-grid">
                    <div class="bd-check-item"><span class="bd-check-mark">✓</span><span>Siapkan scan <b>Kartu Keluarga (KK)</b> &amp; <b>Akta Kelahiran</b></span></div>
                    <div class="bd-check-item"><span class="bd-check-mark">✓</span><span>Siapkan <b>Pas Foto 3x4</b> &amp; <b>Nomor NISN</b></span></div>
                    <div class="bd-check-item"><span class="bd-check-mark">✓</span><span>Scan <b>Rapor Terakhir / Ijazah</b></span></div>
                    <div class="bd-check-item"><span class="bd-check-mark">✓</span><span>Pelajari jadwal, alur, &amp; syarat administrasi di website</span></div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="bd-actions bd-anim-fade bd-delay-4">
                <a href="{{ route('ppdb.info') }}" class="bd-btn bd-btn--primary">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Informasi &amp; Alur PPDB
                </a>
                <a href="https://wa.me/6282119469657?text=Assalamu'alaikum%20Panitia%20PPDB%20RTQ%20Kawali,%20saya%20ingin%20bertanya%20mengenai%20jadwal%20pendaftaran%20santri%20baru."
                    target="_blank" rel="noopener" class="bd-btn bd-btn--wa">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.159.57 4.184 1.564 5.938l-1.664 6.082 6.221-1.632c1.706.93 3.654 1.456 5.879 1.456 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z" />
                    </svg>
                    Tanya Panitia
                </a>
                <a href="/" class="bd-btn bd-btn--ghost">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
