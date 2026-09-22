@extends('layouts.admin')
@section('title', $santri->nama_lengkap . ' — SIAKAD')
@section('page_title', 'Detail Santri')
@section('page_subtitle', $santri->nis . ' — ' . $santri->nama_lengkap)

@section('content')
<div class="max-w-5xl space-y-6" x-data="{ editMode: false }">

    {{-- Success alert --}}
    @if(session('success'))
    <div class="px-5 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/40 text-emerald-700 dark:text-emerald-300 text-sm font-medium flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Error alert --}}
    @if($errors->any())
    <div class="px-5 py-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/40 text-red-700 dark:text-red-300 text-sm">
        <p class="font-semibold mb-1">Terdapat kesalahan:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- Profile Header Card                                     --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8">
            <div class="flex items-center gap-4">
                @if($santri->foto)
                    <img src="{{ asset('storage/' . $santri->foto) }}" alt="Foto {{ $santri->nama_lengkap }}"
                        class="w-16 h-16 rounded-2xl object-cover border-2 border-white/30 shadow-lg">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($santri->nama_lengkap, 0, 1)) }}
                    </div>
                @endif
                <div class="text-white flex-1">
                    <h2 class="text-xl font-bold">{{ $santri->nama_lengkap }}</h2>
                    <p class="text-indigo-100 text-sm">NIS: {{ $santri->nis }} · {{ ucfirst($santri->jenis_kelamin) }}</p>
                    @php $sc = ['aktif' => 'bg-emerald-400/20 text-emerald-100', 'nonaktif' => 'bg-gray-400/20 text-gray-200', 'lulus' => 'bg-blue-400/20 text-blue-100', 'pindah' => 'bg-amber-400/20 text-amber-100']; @endphp
                    <span class="inline-flex mt-2 px-3 py-0.5 rounded-full text-xs font-semibold {{ $sc[$santri->status] ?? '' }}">{{ ucfirst($santri->status) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Edit Toggle --}}
                    <button @click="editMode = !editMode"
                        :class="editMode ? 'bg-amber-400/30 text-amber-100 ring-1 ring-amber-300/50' : 'bg-white/20 hover:bg-white/30 text-white'"
                        class="px-4 py-2 backdrop-blur rounded-xl text-sm font-semibold transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span x-text="editMode ? 'Tutup Edit' : 'Edit Data'"></span>
                    </button>
                    {{-- Upload foto --}}
                    <div x-data="{ showUpload: false }" class="relative">
                        <button @click="showUpload = !showUpload" class="px-3 py-2 bg-white/20 hover:bg-white/30 backdrop-blur rounded-xl text-sm font-semibold text-white transition-all">
                            📷 {{ $santri->foto ? 'Ganti Foto' : 'Upload Foto' }}
                        </button>
                        <div x-show="showUpload" x-transition x-cloak @click.away="showUpload = false"
                            class="absolute right-0 top-full mt-2 w-72 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-5 z-50">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Upload Foto Profil</h4>
                            <form action="{{ route('admin.siakad.santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <input type="hidden" name="nama_lengkap" value="{{ $santri->nama_lengkap }}">
                                <input type="hidden" name="jenis_kelamin" value="{{ $santri->jenis_kelamin }}">
                                <input type="hidden" name="status" value="{{ $santri->status }}">
                                <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" required
                                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300 mb-3">
                                <p class="text-[11px] text-gray-400 mb-3">JPG, PNG, WebP. Maks 2MB.</p>
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-5 divide-x divide-gray-100 dark:divide-gray-700/50">
            <div class="px-6 py-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">TTL</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $santri->tempat_lahir ?? '-' }}, {{ $santri->tanggal_lahir ? $santri->tanggal_lahir->format('d M Y') : '-' }}</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Asrama</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $santri->dormitory->nama ?? 'Belum ditentukan' }}</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Asal Sekolah</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $santri->asal_sekolah ?? '-' }}</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">Telepon Wali</p>
                <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">{{ $santri->telepon_wali ?? '-' }}</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">RFID/NFC</p>
                <p class="text-sm font-semibold mt-1 {{ $santri->rfid_uid ? 'text-emerald-600 dark:text-emerald-400 font-mono' : 'text-gray-400 dark:text-gray-500' }}">{{ $santri->rfid_uid ?? 'Belum ada' }}</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- Akun Login Santri                                       --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden" x-data="{ showResetPw: false }">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10">
            <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg></div>
                Akun Login Santri
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="p-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Login Menggunakan NIS</p>
                    <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400 font-mono">{{ $santri->nis }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">Santri login dengan NIS + password</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-900/30 rounded-xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Password</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">••••••••</p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">Diatur oleh admin</p>
                    </div>
                    <button @click="showResetPw = !showResetPw" type="button"
                        :class="showResetPw ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40'"
                        class="px-3 py-2 text-xs font-semibold rounded-xl transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        <span x-text="showResetPw ? 'Batal' : 'Ubah Password'"></span>
                    </button>
                </div>
            </div>

            {{-- Reset Password Form --}}
            <div x-show="showResetPw" x-transition x-cloak>
                <form action="{{ route('admin.siakad.santri.reset-password', $santri->id) }}" method="POST" class="p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/30 rounded-xl">
                    @csrf
                    <div class="flex items-end gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Password Baru</label>
                            <input type="text" name="new_password" required placeholder="Minimal 6 karakter" minlength="6"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all whitespace-nowrap">
                            Simpan Password
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2">⚠️ Password akan langsung berubah. Pastikan santri mengetahui password barunya.</p>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- EDIT MODE: Full Biodata Form                            --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div x-show="editMode" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <form action="{{ route('admin.siakad.santri.update', $santri->id) }}" method="POST" class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
            @csrf @method('PUT')
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/10 dark:to-orange-900/10">
                <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Biodata Santri
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ubah data santri lalu klik "Simpan Perubahan"</p>
            </div>
            <div class="p-6 space-y-6">
                {{-- Data Diri --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-xs text-indigo-600 dark:text-indigo-400 font-bold">1</span>
                        Data Diri
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                                <option value="laki-laki" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                                @foreach(['aktif', 'nonaktif', 'lulus', 'pindah'] as $st)
                                <option value="{{ $st }}" {{ old('status', $santri->status) == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $santri->asal_sekolah) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Alamat</label>
                            <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">{{ old('alamat', $santri->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Data Orang Tua --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-xs text-indigo-600 dark:text-indigo-400 font-bold">2</span>
                        Data Orang Tua / Wali
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Ayah</label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $santri->nama_ayah) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Ibu</label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $santri->nama_ibu) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Telepon Wali</label>
                            <input type="text" name="telepon_wali" value="{{ old('telepon_wali', $santri->telepon_wali) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        </div>
                    </div>
                </div>

                {{-- Asrama --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-xs text-emerald-600 dark:text-emerald-400 font-bold">3</span>
                        Penempatan Asrama
                    </h4>
                    <select name="dormitory_id" class="w-full sm:w-1/2 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        <option value="">-- Belum ditentukan --</option>
                        @foreach($asramas as $asrama)
                            <option value="{{ $asrama->id }}" {{ old('dormitory_id', $santri->dormitory_id) == $asrama->id ? 'selected' : '' }}>
                                {{ $asrama->nama }} (Kapasitas: {{ $asrama->kapasitas }}, Isi: {{ $asrama->occupancy }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- RFID/NFC UID --}}
                <div>
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-xs text-cyan-600 dark:text-cyan-400 font-bold">4</span>
                        Kartu RFID / NFC
                    </h4>
                    <div class="sm:w-1/2">
                        <input type="text" name="rfid_uid" value="{{ old('rfid_uid', $santri->rfid_uid) }}" placeholder="Scan atau ketik UID kartu RFID"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-mono focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">Contoh: A1B2C3D4. Kosongkan untuk menghapus UID yang sudah ada.</p>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/50">
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    <button type="button" @click="editMode = false" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Batal</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- READ-ONLY: Data Orang Tua & Halaqah (shown when not editing) --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div x-show="!editMode" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Data Orang Tua --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                Data Orang Tua
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Nama Ayah</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $santri->nama_ayah ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Nama Ibu</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $santri->nama_ibu ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500 dark:text-gray-400">Alamat</dt><dd class="font-medium text-gray-900 dark:text-white text-right max-w-[60%]">{{ $santri->alamat ?? '-' }}</dd></div>
            </dl>
        </div>

        {{-- Halaqah yang diikuti --}}
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                Halaqah
            </h3>
            @if($santri->halaqahs->count())
            <div class="space-y-3">
                @foreach($santri->halaqahs as $hq)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-xl">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $hq->nama }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hq->semester->academicYear->nama ?? '' }} — {{ ucfirst($hq->semester->tipe ?? '') }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $hq->ustadz->nama_lengkap ?? '-' }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400 dark:text-gray-500">Belum terdaftar di halaqah manapun</p>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════ --}}
    {{-- Kelola Halaqah (always visible)                         --}}
    {{-- ═══════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50 bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-violet-900/10 dark:to-indigo-900/10">
            <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                Kelola Halaqah
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Masukkan atau keluarkan santri dari halaqah semester aktif</p>
        </div>
        <div class="p-6 space-y-4">
            {{-- Halaqah saat ini --}}
            @if($santri->halaqahs->count())
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Halaqah Terdaftar</p>
                <div class="space-y-2">
                    @foreach($santri->halaqahs as $hq)
                    <div class="flex items-center justify-between p-3 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/30 rounded-xl group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-800/40 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $hq->nama }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $hq->semester->academicYear->nama ?? '' }} — {{ ucfirst($hq->semester->tipe ?? '') }} · Ustadz: {{ $hq->ustadz->nama_lengkap ?? '-' }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.siakad.santri.remove-halaqah', [$santri->id, $hq->id]) }}" method="POST"
                            onsubmit="return confirm('Keluarkan santri dari halaqah {{ $hq->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Keluarkan
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tambah ke halaqah --}}
            @if($availableHalaqahs->count())
            <div class="pt-3 {{ $santri->halaqahs->count() ? 'border-t border-gray-100 dark:border-gray-700/50' : '' }}">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Tambahkan ke Halaqah</p>
                <form action="{{ route('admin.siakad.santri.add-halaqah', $santri->id) }}" method="POST" class="flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <select name="halaqah_id" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-white">
                            <option value="">-- Pilih Halaqah --</option>
                            @foreach($availableHalaqahs as $hq)
                            <option value="{{ $hq->id }}">{{ $hq->nama }} — {{ $hq->ustadz->nama_lengkap ?? '-' }} ({{ $hq->semester->academicYear->nama ?? '' }} {{ ucfirst($hq->semester->tipe ?? '') }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Tambahkan
                    </button>
                </form>
            </div>
            @elseif(!$activeSemester)
            <div class="text-center py-4">
                <p class="text-sm text-amber-600 dark:text-amber-400">⚠️ Belum ada semester aktif. Aktifkan semester terlebih dahulu untuk mengelola halaqah.</p>
            </div>
            @elseif($availableHalaqahs->isEmpty() && $santri->halaqahs->isEmpty())
            <div class="text-center py-4">
                <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada halaqah di semester aktif. <a href="{{ route('admin.siakad.halaqah.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Buat halaqah</a></p>
            </div>
            @endif
        </div>
    </div>

    {{-- ═══ Kehadiran Shalat Berjamaah (bulan ini) ═══ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
            Shalat Berjamaah — {{ now()->translatedFormat('F Y') }}
        </h3>
        <div class="grid grid-cols-5 gap-3">
            @foreach(['subuh' => '🌅', 'dzuhur' => '☀️', 'ashar' => '🌤️', 'maghrib' => '🌇', 'isya' => '🌙'] as $key => $emoji)
            @php $pct = now()->day > 0 ? round(($prayerStats[$key] ?? 0) / now()->day * 100) : 0; @endphp
            <div class="text-center p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl">
                <span class="text-lg">{{ $emoji }}</span>
                <p class="text-xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $prayerStats[$key] ?? 0 }}</p>
                <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ ucfirst($key) }}</p>
                <div class="mt-1.5 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-amber-500' : 'bg-red-400') }}" style="width: {{ $pct }}%"></div>
                </div>
                <p class="text-[9px] text-gray-400 mt-0.5">{{ $pct }}%</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ═══ Perizinan Terbaru ═══ --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
            Perizinan Terbaru
        </h3>
        @if($recentPermissions->count())
        <div class="space-y-2">
            @foreach($recentPermissions as $perm)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/30 rounded-xl">
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $perm->jenis_label }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $perm->tanggal_mulai->format('d M') }} — {{ $perm->tanggal_selesai->format('d M Y') }} ({{ $perm->durasi }} hari)
                        @if($perm->jam_keluar || $perm->jam_kembali)
                            <span class="text-gray-400">·
                                @if($perm->jam_keluar)🕐 {{ substr($perm->jam_keluar, 0, 5) }}@endif
                                @if($perm->jam_keluar && $perm->jam_kembali) — @endif
                                @if($perm->jam_kembali){{ substr($perm->jam_kembali, 0, 5) }}@endif
                            </span>
                        @endif
                    </p>
                    @if($perm->alasan)
                    <p class="text-xs text-gray-400 mt-0.5 truncate max-w-md">{{ Str::limit($perm->alasan, 60) }}</p>
                    @endif
                    @if($perm->is_terlambat)
                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800/30 rounded text-[10px] font-bold text-red-600 dark:text-red-400 animate-pulse">
                            ⚠️ TERLAMBAT {{ $perm->keterlambatan }}
                        </span>
                    @endif
                </div>
                <div class="text-right">
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
                    @if($perm->approver)
                    <p class="text-[10px] text-gray-400 mt-1">oleh {{ $perm->approver->name }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada data perizinan</p>
        @endif
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.siakad.santri.index') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">← Kembali</a>
    </div>

</div>
@endsection
