@extends('layouts.ustadz-halaqah')
@section('title', 'Absensi Shalat — Ustadz Halaqah')
@section('page_title', 'Absensi Shalat')
@section('page_subtitle', 'Pencatatan kehadiran shalat berjamaah via RFID/NFC')

@section('content')
<div x-data="absensiShalat()" class="space-y-6">

    {{-- ═══ Prayer Time Selector + Date ═══ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
            {{-- Waktu Shalat Tabs --}}
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Waktu Shalat</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['subuh' => '🌅 Subuh', 'dzuhur' => '☀️ Dzuhur', 'ashar' => '🌤️ Ashar', 'maghrib' => '🌇 Maghrib', 'isya' => '🌙 Isya'] as $key => $label)
                    <button type="button"
                        @click="setWaktu('{{ $key }}')"
                        :class="waktuShalat === '{{ $key }}'
                            ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30 scale-105'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                        class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
            </div>
            {{-- Tanggal --}}
            <div class="w-full sm:w-44">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                <input type="date" x-model="tanggal"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
            </div>
        </div>
    </div>

    {{-- ═══ Summary Cards ═══ --}}
    <div class="grid grid-cols-5 gap-3">
        @foreach(['subuh' => '🌅', 'dzuhur' => '☀️', 'ashar' => '🌤️', 'maghrib' => '🌇', 'isya' => '🌙'] as $key => $emoji)
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-3 py-3 text-center
            {{ $waktuShalat === $key ? 'ring-2 ring-amber-500 ring-offset-2 dark:ring-offset-gray-900' : '' }}">
            <span class="text-lg">{{ $emoji }}</span>
            <p class="text-xl font-extrabold text-gray-900 dark:text-white mt-1" id="count-{{ $key }}">{{ $summary[$key] ?? 0 }}</p>
            <p class="text-[11px] text-gray-400 dark:text-gray-500">{{ ucfirst($key) }}</p>
        </div>
        @endforeach
    </div>

    {{-- ═══ SCAN POPUP OVERLAY ═══ --}}
    <div x-show="showPopup" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm pointer-events-none" x-cloak>
        <div x-show="showPopup"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-75 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 -translate-y-4"
             class="w-80 rounded-3xl overflow-hidden shadow-2xl pointer-events-auto"
             :class="popupType === 'success' ? 'ring-4 ring-emerald-400/50' : (popupType === 'duplicate' ? 'ring-4 ring-amber-400/50' : 'ring-4 ring-red-400/50')">

            {{-- Header gradient --}}
            <div class="relative px-6 pt-8 pb-16 text-center"
                 :class="popupType === 'success' ? 'bg-gradient-to-br from-emerald-500 to-teal-600' : (popupType === 'duplicate' ? 'bg-gradient-to-br from-amber-500 to-orange-600' : 'bg-gradient-to-br from-red-500 to-rose-600')">
                {{-- Status icon --}}
                <div class="mb-3">
                    <template x-if="popupType === 'success'">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center mx-auto animate-bounce">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </template>
                    <template x-if="popupType === 'duplicate'">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center mx-auto">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                    </template>
                    <template x-if="popupType === 'error'">
                        <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center mx-auto animate-shake">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                    </template>
                </div>
                <p class="text-white/90 text-sm font-semibold" x-text="popupMessage"></p>
            </div>

            {{-- Santri card (overlapping photo) --}}
            <template x-if="popupSantri">
                <div class="bg-white dark:bg-gray-800 px-6 pb-6 -mt-10 relative">
                    {{-- Photo --}}
                    <div class="flex justify-center -mt-2 mb-3">
                        <template x-if="popupSantri.foto">
                            <img :src="'/storage/' + popupSantri.foto" :alt="popupSantri.nama"
                                class="w-20 h-20 rounded-2xl object-cover border-4 border-white dark:border-gray-800 shadow-xl">
                        </template>
                        <template x-if="!popupSantri.foto">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-white dark:border-gray-800 shadow-xl"
                                 x-text="popupSantri.nama?.charAt(0)?.toUpperCase() || '?'"></div>
                        </template>
                    </div>
                    {{-- Info --}}
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white" x-text="popupSantri.nama"></h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="'NIS: ' + popupSantri.nis"></p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" x-text="'Asrama: ' + (popupSantri.asrama || '-')"></p>
                    </div>
                    {{-- Waktu --}}
                    <div class="mt-4 flex justify-center">
                        <div class="px-4 py-2 rounded-xl text-sm font-semibold"
                             :class="popupType === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300' : 'bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300'"
                             x-text="popupType === 'success' ? ('✅ ' + waktuLabel() + ' — Hadir') : ('⚠️ Sudah tercatat')"></div>
                    </div>
                    {{-- Progress bar (auto-dismiss timer) --}}
                    <div class="mt-4 h-1 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-100 ease-linear"
                             :class="popupType === 'success' ? 'bg-emerald-500' : (popupType === 'duplicate' ? 'bg-amber-500' : 'bg-red-500')"
                             :style="'width: ' + popupProgress + '%'"></div>
                    </div>
                </div>
            </template>

            {{-- Error only (no santri data) --}}
            <template x-if="!popupSantri && popupType === 'error'">
                <div class="bg-white dark:bg-gray-800 px-6 py-6 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3"/></svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kartu tidak dikenali</p>
                    {{-- Progress bar --}}
                    <div class="mt-4 h-1 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full transition-all duration-100 ease-linear"
                             :style="'width: ' + popupProgress + '%'"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- ═══ RFID Scanner Section ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Scan Input --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
            <div class="text-center mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-amber-500/25 transition-transform duration-300"
                    :class="scanning ? 'animate-pulse scale-110' : ''">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tap Kartu RFID</h3>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tempelkan kartu di reader</p>
            </div>

            {{-- RFID UID Input --}}
            <div class="relative">
                <input type="text" x-ref="rfidInput" x-model="rfidUid"
                    @keydown.enter.prevent="processScan()"
                    placeholder="Scan kartu atau ketik UID..."
                    autofocus
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border-2 border-amber-300 dark:border-amber-600 rounded-xl text-sm font-mono text-center focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all">
                <button @click="processScan()" :disabled="scanning"
                    class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition-all">
                    <span x-show="!scanning">Proses</span>
                    <svg x-show="scanning" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </div>

            {{-- Scan count today --}}
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    Total scan hari ini: <span class="font-bold text-amber-600 dark:text-amber-400" x-text="feedItems.length"></span>
                </p>
            </div>

            {{-- Auto-focus toggle --}}
            <label class="flex items-center gap-2 mt-3 cursor-pointer">
                <input type="checkbox" x-model="autoFocus" class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                <span class="text-xs text-gray-500 dark:text-gray-400">Auto-focus setelah scan</span>
            </label>
        </div>

        {{-- Live Feed --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    📋 Daftar Hadir Shalat <span class="text-amber-500" x-text="waktuLabel()"></span>
                </h3>
                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 px-2.5 py-1 rounded-lg"
                    x-text="feedItems.length + ' santri'"></span>
            </div>

            {{-- Feed List --}}
            <div class="divide-y divide-gray-50 dark:divide-gray-700/30 max-h-[500px] overflow-y-auto" id="liveFeed">
                <template x-for="(item, idx) in feedItems" :key="idx">
                    <div class="px-5 py-3.5 flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors"
                        :class="idx === 0 && item.isNew ? 'bg-emerald-50/60 dark:bg-emerald-900/10 animate-highlight' : ''">
                        {{-- Photo or initial --}}
                        <template x-if="item.foto">
                            <img :src="'/storage/' + item.foto" :alt="item.nama"
                                class="w-9 h-9 rounded-lg object-cover shadow-sm shrink-0">
                        </template>
                        <template x-if="!item.foto">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold shadow-sm shrink-0"
                                x-text="item.nama.charAt(0).toUpperCase()"></div>
                        </template>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="item.nama"></p>
                            <p class="text-[11px] text-gray-400 dark:text-gray-500" x-text="'NIS: ' + item.nis + ' · ' + item.asrama"></p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-bold"
                                :class="item.status === 'hadir' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300'"
                                x-text="item.status === 'hadir' ? '✓ Hadir' : '⏰ Terlambat'"></span>
                            <p class="text-[10px] text-gray-400 mt-0.5" x-text="item.waktu"></p>
                        </div>
                    </div>
                </template>

                <div x-show="feedItems.length === 0" class="p-10 text-center text-gray-400 dark:text-gray-500">
                    <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                    </div>
                    <p class="text-sm">Belum ada yang tap kartu</p>
                    <p class="text-xs mt-1">Scan kartu RFID untuk memulai</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Manual Input + Rekap Link ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Manual Input --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                Input Manual
            </h3>
            <form action="{{ route('siakad.ustadz.absensi-shalat.manual') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="tanggal" x-bind:value="tanggal">
                <input type="hidden" name="waktu_shalat" x-bind:value="waktuShalat">

                <select name="santri_id" required
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="">— Pilih Santri —</option>
                    @foreach($santris as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_lengkap }} ({{ $s->nis }})</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                        <option value="hadir">✓ Hadir</option>
                        <option value="terlambat">⏰ Terlambat</option>
                    </select>
                    <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        {{-- Rekap Link --}}
        <a href="{{ route('siakad.ustadz.absensi-shalat.rekap') }}" class="group bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 flex items-center gap-4 hover:shadow-lg hover:shadow-amber-200/30 dark:hover:shadow-none transition-all duration-300 hover:-translate-y-0.5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-900 dark:text-white">Rekap Absensi Shalat</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Lihat rekap kehadiran per periode →</p>
            </div>
        </a>
    </div>
</div>

<script>
function absensiShalat() {
    return {
        waktuShalat: '{{ $waktuShalat }}',
        tanggal: '{{ $tanggal }}',
        rfidUid: '',
        scanning: false,
        autoFocus: true,

        // Popup state
        showPopup: false,
        popupType: '',      // 'success' | 'duplicate' | 'error'
        popupMessage: '',
        popupSantri: null,
        popupProgress: 100,
        popupTimer: null,
        popupIntervalId: null,

        feedItems: @php
            $feedData = $attendances->map(function($a) {
                return [
                    'nama' => $a->santri->nama_lengkap ?? '-',
                    'nis' => $a->santri->nis ?? '-',
                    'asrama' => $a->santri->dormitory->nama ?? '-',
                    'foto' => $a->santri->foto ?? null,
                    'status' => $a->status,
                    'waktu' => $a->created_at->format('H:i:s'),
                    'isNew' => false,
                ];
            });
        @endphp {!! json_encode($feedData) !!},

        setWaktu(wk) {
            this.waktuShalat = wk;
            this.reloadPage();
        },

        waktuLabel() {
            const labels = {subuh:'Subuh', dzuhur:'Dzuhur', ashar:'Ashar', maghrib:'Maghrib', isya:'Isya'};
            return labels[this.waktuShalat] || '';
        },

        showScanPopup(type, message, santriData, durationMs = 3000) {
            // Clear any existing timer
            if (this.popupTimer) clearTimeout(this.popupTimer);
            if (this.popupIntervalId) clearInterval(this.popupIntervalId);

            this.popupType = type;
            this.popupMessage = message;
            this.popupSantri = santriData;
            this.popupProgress = 100;
            this.showPopup = true;

            // Animate progress bar
            const startTime = Date.now();
            this.popupIntervalId = setInterval(() => {
                const elapsed = Date.now() - startTime;
                this.popupProgress = Math.max(0, 100 - (elapsed / durationMs * 100));
            }, 50);

            // Auto-dismiss
            this.popupTimer = setTimeout(() => {
                clearInterval(this.popupIntervalId);
                this.showPopup = false;
                this.popupSantri = null;
            }, durationMs);
        },

        async processScan() {
            if (!this.rfidUid.trim() || this.scanning) return;
            this.scanning = true;

            try {
                const res = await fetch('{{ route("siakad.ustadz.absensi-shalat.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        rfid_uid: this.rfidUid.trim(),
                        waktu_shalat: this.waktuShalat,
                        tanggal: this.tanggal,
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    // Show success popup with santri photo
                    this.showScanPopup('success', '✅ ' + data.santri.nama, data.santri, 2500);

                    // Add to feed with highlight
                    this.feedItems.unshift({
                        nama: data.santri.nama,
                        nis: data.santri.nis,
                        asrama: data.santri.asrama,
                        foto: data.santri.foto,
                        status: data.attendance.status,
                        waktu: data.attendance.waktu,
                        isNew: true,
                    });

                    // Remove highlight after animation
                    setTimeout(() => {
                        if (this.feedItems[0]) this.feedItems[0].isNew = false;
                    }, 2000);

                    // Update counter
                    const counter = document.getElementById('count-' + this.waktuShalat);
                    if (counter) counter.textContent = data.total_hadir;
                } else if (data.duplicate) {
                    // Already recorded — show warning popup with santri data
                    this.showScanPopup('duplicate', data.message, data.santri, 2500);
                } else {
                    // Error popup
                    this.showScanPopup('error', data.message, null, 2500);
                }
            } catch (e) {
                this.showScanPopup('error', 'Terjadi kesalahan jaringan.', null, 2500);
            }

            this.rfidUid = '';
            this.scanning = false;

            if (this.autoFocus) {
                this.$nextTick(() => this.$refs.rfidInput.focus());
            }
        },

        reloadPage() {
            const url = new URL(window.location.href);
            url.searchParams.set('waktu_shalat', this.waktuShalat);
            url.searchParams.set('tanggal', this.tanggal);
            window.location.href = url.toString();
        },

        init() {
            // Watch tanggal changes
            this.$watch('tanggal', () => this.reloadPage());
        }
    };
}
</script>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}
.animate-shake { animation: shake 0.3s ease-in-out 2; }

@keyframes highlight {
    0% { background-color: rgba(16, 185, 129, 0.2); }
    100% { background-color: transparent; }
}
.animate-highlight { animation: highlight 2s ease-out; }
</style>
@endsection
