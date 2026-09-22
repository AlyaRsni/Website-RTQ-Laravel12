@extends('layouts.dashboard')

@section('title', 'Kontak Orang Tua — PPDB RTQ Kawali')
@section('page_title', 'Kontak Orang Tua')
@section('page_subtitle', 'Step 3 — Nomor WhatsApp orang tua')

@section('content')
<div class="max-w-2xl mx-auto space-y-6" x-data="kontakForm()">

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/15 dark:to-blue-900/15 rounded-2xl border border-cyan-200/60 dark:border-cyan-800/30 p-5">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-cyan-100 dark:bg-cyan-800/30 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Format Nomor WhatsApp</h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Masukkan nomor HP dengan format Indonesia dimulai dari <strong class="text-cyan-600 dark:text-cyan-400">62</strong> (tanpa tanda +). 
                    Contoh: <code class="bg-cyan-100 dark:bg-cyan-800/30 px-1.5 py-0.5 rounded text-cyan-700 dark:text-cyan-300 text-[11px] font-mono">6281234567890</code>
                </p>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form action="{{ route('ppdb.step.3.save') }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cyan-100 dark:bg-cyan-800/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Nomor WhatsApp Orang Tua</h2>
                </div>
            </div>
            <div class="p-6 space-y-6">
                {{-- No HP Ayah --}}
                <div>
                    <label for="no_hp_ayah" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        No HP Ayah (WhatsApp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-sm font-semibold text-gray-400 dark:text-gray-500">+</span>
                        </div>
                        <input type="tel" id="no_hp_ayah" name="no_hp_ayah" 
                            value="{{ old('no_hp_ayah', $registration->no_hp_ayah) }}" 
                            placeholder="6281234567890"
                            x-model="hpAyah"
                            class="w-full pl-8 pr-12 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all duration-200 text-sm font-mono">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <template x-if="isValidPhone(hpAyah)">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <template x-if="hpAyah && !isValidPhone(hpAyah)">
                                <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                        </div>
                    </div>
                    <p class="mt-1.5 text-xs" :class="hpAyah && !isValidPhone(hpAyah) ? 'text-red-500' : 'text-gray-400 dark:text-gray-500'">
                        <span x-show="!hpAyah || isValidPhone(hpAyah)">Format: 62 diikuti 8-13 digit angka</span>
                        <span x-show="hpAyah && !isValidPhone(hpAyah)">⚠️ Format tidak valid. Harus dimulai dengan 62</span>
                    </p>
                </div>

                {{-- No HP Ibu --}}
                <div>
                    <label for="no_hp_ibu" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        No HP Ibu (WhatsApp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-sm font-semibold text-gray-400 dark:text-gray-500">+</span>
                        </div>
                        <input type="tel" id="no_hp_ibu" name="no_hp_ibu" 
                            value="{{ old('no_hp_ibu', $registration->no_hp_ibu) }}" 
                            placeholder="6281234567890"
                            x-model="hpIbu"
                            class="w-full pl-8 pr-12 py-3.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all duration-200 text-sm font-mono">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <template x-if="isValidPhone(hpIbu)">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <template x-if="hpIbu && !isValidPhone(hpIbu)">
                                <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                        </div>
                    </div>
                    <p class="mt-1.5 text-xs" :class="hpIbu && !isValidPhone(hpIbu) ? 'text-red-500' : 'text-gray-400 dark:text-gray-500'">
                        <span x-show="!hpIbu || isValidPhone(hpIbu)">Format: 62 diikuti 8-13 digit angka</span>
                        <span x-show="hpIbu && !isValidPhone(hpIbu)">⚠️ Format tidak valid. Harus dimulai dengan 62</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
            <a href="{{ route('ppdb.dashboard') }}"
                class="w-full sm:w-auto px-6 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-all duration-200 text-sm text-center">
                ← Kembali
            </a>
            <button type="submit"
                :disabled="!isValidPhone(hpAyah) || !isValidPhone(hpIbu)"
                class="w-full sm:flex-1 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 text-white font-bold rounded-xl hover:from-cyan-700 hover:to-cyan-800 shadow-lg shadow-cyan-600/25 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 text-sm flex items-center justify-center gap-2">
                Simpan & Lanjutkan
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
        </div>
    </form>
</div>

<script>
function kontakForm() {
    return {
        hpAyah: '{{ old('no_hp_ayah', $registration->no_hp_ayah ?? '') }}',
        hpIbu: '{{ old('no_hp_ibu', $registration->no_hp_ibu ?? '') }}',
        isValidPhone(phone) {
            return /^62[0-9]{8,13}$/.test(phone);
        }
    }
}
</script>
@endsection
