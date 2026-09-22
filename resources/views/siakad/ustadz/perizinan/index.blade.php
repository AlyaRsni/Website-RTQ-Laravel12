@extends('layouts.ustadz-halaqah')
@section('title', 'Perizinan — Ustadz Halaqah')
@section('page_title', 'Perizinan Santri')
@section('page_subtitle', 'Kelola perizinan santri via tap kartu RFID')

@section('content')
<div x-data="perizinanApp()" class="space-y-6">

    {{-- ═══ Stats Cards ═══ --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @php
            $statCards = [
                ['label' => 'Diajukan', 'value' => $stats['diajukan'], 'color' => 'amber',  'icon' => '📋'],
                ['label' => 'Disetujui', 'value' => $stats['disetujui'], 'color' => 'emerald','icon' => '✅'],
                ['label' => 'Ditolak',   'value' => $stats['ditolak'],   'color' => 'red',    'icon' => '❌'],
                ['label' => 'Selesai',   'value' => $stats['selesai'],   'color' => 'blue',   'icon' => '🏁'],
            ];
        @endphp
        @foreach($statCards as $sc)
        <div class="bg-white dark:bg-gray-800/40 rounded-xl border border-gray-200/60 dark:border-gray-700/30 px-4 py-3 flex items-center gap-3">
            <span class="text-lg">{{ $sc['icon'] }}</span>
            <div>
                <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $sc['value'] }}</p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $sc['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══ SCAN POPUP OVERLAY ═══ --}}
    <div x-show="showPopup" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-400" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak @click.self="dismissPopup()">
        <div x-show="showPopup"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-75 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-400" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
             class="w-80 rounded-3xl overflow-hidden shadow-2xl ring-4 ring-amber-400/50">

            {{-- Header --}}
            <div class="bg-gradient-to-br from-amber-500 to-orange-600 px-6 pt-8 pb-16 text-center relative">
                <div class="w-14 h-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3"/></svg>
                </div>
                <p class="text-white font-semibold text-sm">Santri Terdeteksi</p>
            </div>

            {{-- Santri Card --}}
            <div class="bg-white dark:bg-gray-800 px-6 pb-6 -mt-10 relative">
                {{-- Photo --}}
                <div class="flex justify-center -mt-2 mb-3">
                    <template x-if="popupSantri?.foto">
                        <img :src="'/storage/' + popupSantri.foto" :alt="popupSantri.nama"
                            class="w-20 h-20 rounded-2xl object-cover border-4 border-white dark:border-gray-800 shadow-xl">
                    </template>
                    <template x-if="!popupSantri?.foto">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white text-3xl font-bold border-4 border-white dark:border-gray-800 shadow-xl"
                             x-text="popupSantri?.nama?.charAt(0)?.toUpperCase() || '?'"></div>
                    </template>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white" x-text="popupSantri?.nama || '-'"></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="'NIS: ' + (popupSantri?.nis || '-')"></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" x-text="'Asrama: ' + (popupSantri?.asrama || '-')"></p>
                </div>

                {{-- Active Permissions --}}
                <template x-if="popupPermissions.length > 0">
                    <div class="mt-4 bg-amber-50 dark:bg-amber-900/10 rounded-xl p-3">
                        <p class="text-[11px] font-semibold text-amber-700 dark:text-amber-300 mb-2">⚠️ Izin aktif:</p>
                        <template x-for="p in popupPermissions" :key="p.jenis">
                            <div class="py-1.5">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-medium text-gray-700 dark:text-gray-300" x-text="p.jenis"></span>
                                    <span class="text-amber-600 dark:text-amber-400" x-text="p.durasi + ' hari'"></span>
                                </div>
                                <template x-if="p.jam_keluar || p.jam_kembali">
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] text-gray-400" x-show="p.jam_keluar" x-text="'🕐 Keluar: ' + p.jam_keluar"></span>
                                        <span class="text-[10px] text-gray-400" x-show="p.jam_kembali" x-text="'🕐 Kembali: ' + p.jam_kembali"></span>
                                    </div>
                                </template>
                                <template x-if="p.is_terlambat">
                                    <div class="mt-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 rounded text-[10px] font-bold text-red-600 dark:text-red-400 inline-block">
                                        ⚠️ Terlambat <span x-text="p.keterlambatan"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Dismiss button --}}
                <button @click="dismissPopup()" class="mt-4 w-full py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition-all">
                    Lanjutkan Buat Izin →
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ RFID Scan + Form ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Scan Card --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
            <div class="text-center mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-amber-500/25 transition-transform"
                    :class="scanning ? 'animate-pulse scale-110' : ''">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tap Kartu untuk Perizinan</h3>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tempelkan kartu RFID, data santri akan muncul</p>
            </div>

            <div class="relative">
                <input type="text" x-ref="rfidInput" x-model="rfidUid"
                    @keydown.enter.prevent="scanCard()"
                    placeholder="Scan kartu atau ketik UID..."
                    autofocus
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border-2 border-amber-300 dark:border-amber-600 rounded-xl text-sm font-mono text-center focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all">
                <button @click="scanCard()" :disabled="scanning"
                    class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg transition-all">
                    <span x-show="!scanning">Scan</span>
                    <svg x-show="scanning" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </div>

            {{-- Scan Error --}}
            <div x-show="scanError" x-transition class="mt-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-xl p-3 text-center">
                <p class="text-sm font-semibold text-red-600 dark:text-red-400" x-text="scanError"></p>
            </div>

            {{-- Selected Santri Info (after popup dismissed) --}}
            <div x-show="santriData && !showPopup" x-transition class="mt-4">
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/30 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <template x-if="santriData?.foto">
                            <img :src="'/storage/' + santriData.foto" :alt="santriData.nama"
                                class="w-12 h-12 rounded-xl object-cover shadow-md">
                        </template>
                        <template x-if="!santriData?.foto">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-lg font-bold shadow-md"
                                x-text="santriData?.nama?.charAt(0)?.toUpperCase() || '?'"></div>
                        </template>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="santriData?.nama || '-'"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="'NIS: ' + (santriData?.nis||'-') + ' · ' + (santriData?.asrama||'-')"></p>
                        </div>
                    </div>

                    {{-- Active Permissions if any --}}
                    <template x-if="activePermissions.length > 0">
                        <div class="bg-white dark:bg-gray-800/50 rounded-lg p-3 mb-3">
                            <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 mb-2">Izin aktif:</p>
                            <template x-for="p in activePermissions" :key="p.jenis">
                                <div class="flex items-center justify-between text-xs py-1">
                                    <span class="font-medium text-gray-700 dark:text-gray-300" x-text="p.jenis"></span>
                                    <div class="text-right">
                                        <span class="text-gray-400" x-text="p.mulai + ' — ' + p.selesai"></span>
                                        <span class="ml-1.5 px-1.5 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded text-[10px] font-bold" x-text="p.durasi + ' hari'"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Or pick santri manually --}}
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1.5">Atau pilih santri manual:</label>
                <select x-model="manualSantriId"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="">— Pilih Santri —</option>
                    @foreach($santris as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_lengkap }} ({{ $s->nis }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Permission Form --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                Buat Perizinan
            </h3>
            <form action="{{ route('siakad.ustadz.perizinan.store') }}" method="POST" class="space-y-4">
                @csrf

                <input type="hidden" name="santri_id" x-bind:value="santriData?.id || manualSantriId">

                {{-- Info siapa --}}
                <div x-show="santriData || manualSantriId" class="bg-gray-50 dark:bg-gray-900/30 rounded-xl p-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    Perizinan untuk: <strong x-text="santriData?.nama || (manualSantriId ? 'Santri terpilih' : '-')"></strong>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Jenis Izin <span class="text-red-500">*</span></label>
                    <select name="jenis" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                        <option value="">— Pilih Jenis —</option>
                        <option value="pulang">🏠 Pulang</option>
                        <option value="sakit">🏥 Sakit</option>
                        <option value="kegiatan">📅 Kegiatan</option>
                        <option value="lainnya">📝 Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Alasan / Keperluan <span class="text-red-500">*</span></label>
                    <textarea name="alasan" required rows="2" placeholder="Jelaskan alasan perizinan..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3" x-data="{ tglMulai: '{{ now()->format('Y-m-d') }}', tglSelesai: '{{ now()->format('Y-m-d') }}' }">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" required x-model="tglMulai"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" required x-model="tglSelesai"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    </div>

                    {{-- Jam Keluar & Kembali — terutama untuk izin 1 hari --}}
                    <div class="col-span-2 grid grid-cols-2 gap-3" x-show="tglMulai && tglSelesai" x-transition>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                🕐 Jam Keluar
                                <template x-if="tglMulai === tglSelesai">
                                    <span class="text-amber-500 text-xs font-normal">(disarankan)</span>
                                </template>
                            </label>
                            <input type="time" name="jam_keluar"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500"
                                :class="tglMulai === tglSelesai ? 'border-amber-300 dark:border-amber-600' : ''">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                🕐 Jam Kembali
                                <template x-if="tglMulai === tglSelesai">
                                    <span class="text-amber-500 text-xs font-normal">(disarankan)</span>
                                </template>
                            </label>
                            <input type="time" name="jam_kembali"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500"
                                :class="tglMulai === tglSelesai ? 'border-amber-300 dark:border-amber-600' : ''">
                        </div>
                        {{-- Hint for 1-day permissions --}}
                        <template x-if="tglMulai === tglSelesai">
                            <div class="col-span-2">
                                <div class="flex items-center gap-2 px-3 py-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800/30 rounded-xl">
                                    <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-xs text-amber-700 dark:text-amber-300">Izin 1 hari — disarankan isi jam keluar & kembali untuk tracking waktu</p>
                                </div>
                            </div>
                        </template>
                    </div>
                    {{-- Duration display --}}
                    <div class="col-span-2" x-show="tglMulai && tglSelesai">
                        <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-xl">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                Durasi:
                                <strong x-text="(() => {
                                    if (!tglMulai || !tglSelesai) return '-';
                                    const start = new Date(tglMulai);
                                    const end = new Date(tglSelesai);
                                    const diff = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                                    return diff > 0 ? diff + ' hari' : 'Tanggal tidak valid';
                                })()"></strong>
                                <span class="text-blue-500 dark:text-blue-400 text-xs ml-1" x-text="(() => {
                                    if (!tglMulai || !tglSelesai) return '';
                                    const start = new Date(tglMulai);
                                    const end = new Date(tglSelesai);
                                    const opts = { day: 'numeric', month: 'short', year: 'numeric' };
                                    return '(' + start.toLocaleDateString('id-ID', opts) + ' — ' + end.toLocaleDateString('id-ID', opts) + ')';
                                })()"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Catatan Ustadz</label>
                    <input type="text" name="catatan_ustadz" placeholder="Opsional..."
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Status</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status" value="diajukan" checked class="peer sr-only">
                            <div class="text-center py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 peer-checked:text-amber-700 dark:peer-checked:text-amber-300 text-sm font-semibold text-gray-500 transition-all">
                                📋 Diajukan
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status" value="disetujui" class="peer sr-only">
                            <div class="text-center py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-300 text-sm font-semibold text-gray-500 transition-all">
                                ✅ Langsung Setujui
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" :disabled="!santriData && !manualSantriId"
                    class="w-full py-3 bg-amber-600 hover:bg-amber-700 disabled:bg-gray-300 dark:disabled:bg-gray-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all disabled:shadow-none">
                    Simpan Perizinan
                </button>
            </form>
        </div>
    </div>

    {{-- ═══ Filter & List ═══ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        {{-- Filter --}}
        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar Perizinan</h3>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['' => 'Semua', 'diajukan' => '📋 Diajukan', 'disetujui' => '✅ Disetujui', 'ditolak' => '❌ Ditolak', 'selesai' => '🏁 Selesai'] as $key => $label)
                    <a href="{{ route('siakad.ustadz.perizinan.index', $key ? ['status' => $key] : []) }}"
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all
                        {{ $status === $key ? 'bg-amber-500 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Santri</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Jenis</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Durasi</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700/30">
                    @forelse($permissions as $perm)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                @if($perm->santri->foto ?? false)
                                    <img src="{{ asset('storage/' . $perm->santri->foto) }}" alt="{{ $perm->santri->nama_lengkap }}"
                                        class="w-8 h-8 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                        {{ strtoupper(substr($perm->santri->nama_lengkap ?? '?', 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $perm->santri->nama_lengkap ?? '-' }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $perm->santri->nis ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 hidden sm:table-cell">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $perm->jenis_label }}</span>
                            <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ Str::limit($perm->alasan, 40) }}</p>
                        </td>
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $perm->tanggal_mulai->format('d M') }} — {{ $perm->tanggal_selesai->format('d M Y') }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-xs font-semibold {{ $perm->durasi > 3 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-500 dark:text-gray-400' }}">{{ $perm->durasi }} hari</span>

                                {{-- Tampilkan jam jika ada --}}
                                @if($perm->jam_keluar || $perm->jam_kembali)
                                    <span class="text-[10px] text-gray-400 dark:text-gray-500">
                                        @if($perm->jam_keluar)🕐 {{ substr($perm->jam_keluar, 0, 5) }}@endif
                                        @if($perm->jam_keluar && $perm->jam_kembali) — @endif
                                        @if($perm->jam_kembali){{ substr($perm->jam_kembali, 0, 5) }}@endif
                                    </span>
                                @endif

                                @if($perm->status === 'disetujui' && $perm->tanggal_selesai->isFuture() && !$perm->is_terlambat)
                                    @php $sisaHari = now()->startOfDay()->diffInDays($perm->tanggal_selesai, false) + 1; @endphp
                                    <span class="px-1.5 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded text-[10px] font-bold">sisa {{ $sisaHari }} hari</span>
                                @endif
                            </div>

                            {{-- Badge Terlambat --}}
                            @if($perm->is_terlambat)
                                <div class="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/30 rounded-lg animate-pulse">
                                    <svg class="w-3 h-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                    <span class="text-[10px] font-bold text-red-600 dark:text-red-400">TERLAMBAT</span>
                                    @if($perm->keterlambatan)
                                        <span class="text-[10px] text-red-500 dark:text-red-400">{{ $perm->keterlambatan }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $badge = match($perm->status) {
                                    'diajukan'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                    'disetujui' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                    'ditolak'   => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                    'selesai'   => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                    default     => 'bg-gray-100 text-gray-500',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold {{ $badge }}">{{ ucfirst($perm->status) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            @if($perm->status === 'diajukan')
                            <div x-data="{ open: false }" class="relative inline-block">
                                <button @click="open = !open" class="text-xs font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 transition-colors">
                                    Tindakan ▾
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2 z-50">
                                    <form action="{{ route('siakad.ustadz.perizinan.update', $perm->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">✅ Setujui</button>
                                    </form>
                                    <form action="{{ route('siakad.ustadz.perizinan.update', $perm->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">❌ Tolak</button>
                                    </form>
                                </div>
                            </div>
                            @elseif($perm->status === 'disetujui')
                            <form action="{{ route('siakad.ustadz.perizinan.update', $perm->id) }}" method="POST" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 transition-colors">🏁 Selesai</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                            <p class="text-sm">Belum ada data perizinan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($permissions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700/50">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function perizinanApp() {
    return {
        rfidUid: '',
        scanning: false,
        scanError: '',
        santriData: null,
        activePermissions: [],
        manualSantriId: '',

        // Popup state
        showPopup: false,
        popupSantri: null,
        popupPermissions: [],

        dismissPopup() {
            this.showPopup = false;
            this.$nextTick(() => this.$refs.rfidInput.focus());
        },

        async scanCard() {
            if (!this.rfidUid.trim() || this.scanning) return;
            this.scanning = true;
            this.scanError = '';
            this.santriData = null;
            this.activePermissions = [];

            try {
                const res = await fetch('{{ route("siakad.ustadz.perizinan.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ rfid_uid: this.rfidUid.trim() }),
                });

                const data = await res.json();

                if (data.success) {
                    this.santriData = data.santri;
                    this.activePermissions = data.active_permissions || [];
                    this.manualSantriId = '';

                    // Calculate duration for each active permission
                    this.popupPermissions = (data.active_permissions || []).map(p => {
                        const start = new Date(p.mulai_raw || p.mulai);
                        const end = new Date(p.selesai_raw || p.selesai);
                        let durasi = '-';
                        if (!isNaN(start) && !isNaN(end)) {
                            durasi = Math.floor((end - start) / (1000*60*60*24)) + 1;
                        }
                        return {
                            ...p,
                            durasi,
                            jam_keluar: p.jam_keluar || null,
                            jam_kembali: p.jam_kembali || null,
                            is_terlambat: p.is_terlambat || false,
                            keterlambatan: p.keterlambatan || null,
                        };
                    });

                    // Show popup
                    this.popupSantri = data.santri;
                    this.showPopup = true;
                } else {
                    this.scanError = data.message;
                }
            } catch (e) {
                this.scanError = 'Terjadi kesalahan jaringan.';
            }

            this.rfidUid = '';
            this.scanning = false;
            this.$nextTick(() => this.$refs.rfidInput.focus());

            setTimeout(() => { this.scanError = ''; }, 4000);
        }
    };
}
</script>
@endsection
