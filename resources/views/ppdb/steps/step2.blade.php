@extends('layouts.dashboard')

@section('title', 'Data Diri — PPDB RTQ Kawali')
@section('page_title', 'Data Diri Calon Santri')
@section('page_subtitle', 'Step 2 — Lengkapi data pribadi')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

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

    <form action="{{ route('ppdb.step.2.save') }}" method="POST" id="step2Form">
        @csrf

        {{-- Section: Identitas Pribadi --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-800/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Identitas Pribadi</h2>
                </div>
            </div>
            <div class="p-6 space-y-5">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $registration->nama_lengkap) }}" placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Tempat Lahir --}}
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $registration->tempat_lahir) }}" placeholder="Contoh: Ciamis"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $registration->tanggal_lahir?->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Asal Sekolah --}}
                    <div>
                        <label for="asal_sekolah" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Asal Sekolah <span class="text-red-500">*</span></label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $registration->asal_sekolah) }}" placeholder="Nama sekolah asal"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>

                    {{-- NISN --}}
                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NISN <span class="text-red-500">*</span></label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $registration->nisn) }}" placeholder="Nomor Induk Siswa Nasional"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Hafalan Qur'an --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden mb-5" x-data="{ pernahHafal: {{ old('pernah_hafal_quran', $registration->pernah_hafal_quran) ? 'true' : 'false' }} }">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-800/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Hafalan Qur'an</h2>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Pernah menghafal Al-Qur'an?</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="pernah_hafal_quran" value="1" x-model="pernahHafal" @click="pernahHafal = true"
                                {{ old('pernah_hafal_quran', $registration->pernah_hafal_quran) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:bg-gray-800">
                            <span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="pernah_hafal_quran" value="0" x-model="pernahHafal" @click="pernahHafal = false"
                                {{ !old('pernah_hafal_quran', $registration->pernah_hafal_quran) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:bg-gray-800">
                            <span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Belum</span>
                        </label>
                    </div>
                </div>

                <div x-show="pernahHafal" x-collapse>
                    <label for="jumlah_hafalan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jumlah Hafalan</label>
                    <input type="text" id="jumlah_hafalan" name="jumlah_hafalan" value="{{ old('jumlah_hafalan', $registration->jumlah_hafalan) }}" placeholder="Contoh: 5 Juz, atau Juz 30"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                </div>
            </div>
        </div>

        {{-- Section: Data Keluarga --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 shadow-sm overflow-hidden mb-5">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-800/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-white">Data Keluarga</h2>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="anak_ke" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Anak Ke <span class="text-red-500">*</span></label>
                        <input type="number" id="anak_ke" name="anak_ke" value="{{ old('anak_ke', $registration->anak_ke) }}" min="1" placeholder="1"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="jumlah_saudara" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jumlah Saudara <span class="text-red-500">*</span></label>
                        <input type="number" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara', $registration->jumlah_saudara) }}" min="0" placeholder="0"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama_ayah" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Ayah <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $registration->nama_ayah) }}" placeholder="Nama lengkap ayah"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="pekerjaan_ayah" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $registration->pekerjaan_ayah) }}" placeholder="Contoh: Wiraswasta"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama_ibu" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $registration->nama_ibu) }}" placeholder="Nama lengkap ibu"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                    <div>
                        <label for="pekerjaan_ibu" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $registration->pekerjaan_ibu) }}" placeholder="Contoh: Ibu Rumah Tangga"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm">
                    </div>
                </div>

                <div>
                    <label for="alamat_rumah" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat Rumah <span class="text-red-500">*</span></label>
                    <textarea id="alamat_rumah" name="alamat_rumah" rows="3" placeholder="Alamat lengkap termasuk RT/RW, desa, kecamatan, kabupaten"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 text-sm resize-none">{{ old('alamat_rumah', $registration->alamat_rumah) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <button type="submit" name="save_draft" value="1"
                class="w-full sm:w-auto px-6 py-3 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-750 transition-all duration-200 text-sm">
                💾 Simpan Draft
            </button>
            <button type="submit"
                class="w-full sm:flex-1 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-indigo-800 shadow-lg shadow-indigo-600/25 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-sm flex items-center justify-center gap-2">
                Simpan & Lanjutkan
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
        </div>

        {{-- Back link --}}
        <div class="text-center mt-4">
            <a href="{{ route('ppdb.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </form>
</div>
@endsection
