@extends('layouts.admin')

@section('title', 'Detail Pendaftar — Admin RTQ Kawali')
@section('page_title', 'Detail Pendaftar')
@section('page_subtitle', $registration->nama_lengkap ?? $registration->user->name ?? 'Data Pendaftar')

@section('content')
<div class="space-y-5 max-w-4xl">
    {{-- Back --}}
    <a href="{{ route('admin.pendaftar.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>

    {{-- Header Card --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-xl font-bold text-indigo-600 dark:text-indigo-400">
                    {{ strtoupper(substr($registration->user->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $registration->nama_lengkap ?? $registration->user->name ?? '-' }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $registration->user->phone ?? '-' }} · {{ $registration->nomor_peserta ?? 'Belum ada nomor peserta' }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="w-20 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $registration->getProgressPercentage() }}%"></div>
                        </div>
                        <span class="text-xs font-semibold text-gray-500">{{ $registration->getProgressPercentage() }}% selesai</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-wrap">
                @if(!$registration->nomor_peserta)
                <form action="{{ route('admin.pendaftar.override', $registration->id) }}" method="POST" onsubmit="return confirm('Override: Loloskan pendaftar ini walau belum lengkap?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/30 rounded-xl hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors">⚡ Override</button>
                </form>
                @endif
                <div x-data="{ showResetModal: false }">
                    <button @click="showResetModal = true" type="button" class="px-4 py-2 text-xs font-bold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/30 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">🔑 Reset Password</button>

                    {{-- Modal Reset Password --}}
                    <div x-show="showResetModal" style="display: none" class="fixed inset-0 z-100 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm" x-transition.opacity>
                        <div @click.away="showResetModal = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all" x-show="showResetModal" x-transition.scale.origin.bottom>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-lg">
                                    🔑
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Reset Password Santri</h3>
                            </div>
                            
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-6 space-y-3">
                                <p>Sistem akan mereset dan membuat ulang password untuk pendaftar <strong>{{ $registration->nama_lengkap ?? $registration->user->name ?? '-' }}</strong>.</p>
                                
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30 p-4 rounded-xl">
                                    <p class="text-xs text-blue-600 dark:text-blue-400 mb-1 font-semibold uppercase tracking-wider">Format Tanggal Lahir (YYYYMMDD):</p>
                                    <p class="font-mono text-2xl font-bold text-blue-700 dark:text-blue-300 select-all">{{ $registration->tanggal_lahir ? $registration->tanggal_lahir->format('Ymd') : '12345678' }}</p>
                                </div>
                                
                                <p class="text-xs text-amber-600 dark:text-amber-400 font-medium leading-relaxed">⚠️ Pasca reset, pastikan untuk memberitahukan password di atas kepada calon santri agar bisa kembali login.</p>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button @click="showResetModal = false" type="button" class="px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">Batal</button>
                                <form action="{{ route('admin.pendaftar.reset-password', $registration->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-lg shadow-blue-500/30">Konfirmasi Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.pendaftar.destroy', $registration->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">🗑 Hapus</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Data Sections --}}
    @php
        $sections = [
            'Pembayaran' => [
                ['label' => 'Status', 'value' => $registration->getStepStatus(1)],
            ],
            'Data Diri' => [
                ['label' => 'Nama Lengkap', 'value' => $registration->nama_lengkap],
                ['label' => 'Tempat Lahir', 'value' => $registration->tempat_lahir],
                ['label' => 'Tanggal Lahir', 'value' => $registration->tanggal_lahir?->format('d F Y')],
                ['label' => 'Asal Sekolah', 'value' => $registration->asal_sekolah],
                ['label' => 'NISN', 'value' => $registration->nisn],
                ['label' => 'Hafal Quran', 'value' => $registration->pernah_hafal_quran ? 'Ya (' . ($registration->jumlah_hafalan ?? '-') . ')' : 'Belum'],
                ['label' => 'Anak ke', 'value' => ($registration->anak_ke ?? '-') . ' dari ' . ($registration->jumlah_saudara ?? '-') . ' bersaudara'],
            ],
            'Keluarga' => [
                ['label' => 'Nama Ayah', 'value' => $registration->nama_ayah],
                ['label' => 'Pekerjaan Ayah', 'value' => $registration->pekerjaan_ayah],
                ['label' => 'No HP Ayah', 'value' => $registration->no_hp_ayah],
                ['label' => 'Nama Ibu', 'value' => $registration->nama_ibu],
                ['label' => 'Pekerjaan Ibu', 'value' => $registration->pekerjaan_ibu],
                ['label' => 'No HP Ibu', 'value' => $registration->no_hp_ibu],
                ['label' => 'Alamat', 'value' => $registration->alamat_rumah],
            ],
            'Status' => [
                ['label' => 'Finalisasi', 'value' => $registration->finalisasi_at ? '✅ ' . $registration->finalisasi_at->format('d/m/Y H:i') : '❌ Belum'],
                ['label' => 'Verifikasi', 'value' => $registration->getStepStatus(6)],
                ['label' => 'Nomor Peserta', 'value' => $registration->nomor_peserta ?? 'Belum generate'],
                ['label' => 'Catatan Perbaikan', 'value' => $registration->catatan_perbaikan],
            ],
        ];
    @endphp

    @foreach($sections as $sectionTitle => $fields)
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $sectionTitle }}</h3>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/20">
            @foreach($fields as $field)
            <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 sm:w-36 shrink-0">{{ $field['label'] }}</span>
                <span class="text-sm text-gray-900 dark:text-white">{{ $field['value'] ?? '-' }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- Berkas (dengan download links) --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200/80 dark:border-gray-700/40 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700/40 bg-gray-50/50 dark:bg-gray-900/20">
            <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Berkas Upload</h3>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/20">
            @php
                $files = [
                    ['label' => 'Bukti Pembayaran', 'field' => 'bukti_pembayaran', 'type' => 'bukti_pembayaran'],
                    ['label' => 'Kartu Keluarga', 'field' => 'kartu_keluarga', 'type' => 'kartu_keluarga'],
                    ['label' => 'Foto 3x4', 'field' => 'foto_3x4', 'type' => 'foto_3x4'],
                    ['label' => 'Ijazah/Raport', 'field' => 'ijazah_raport', 'type' => 'ijazah_raport'],
                ];
            @endphp
            @foreach($files as $file)
            <div class="px-5 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 w-36 shrink-0">{{ $file['label'] }}</span>
                    @if($registration->{$file['field']})
                        <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">✅ Terupload</span>
                    @else
                        <span class="text-xs font-semibold text-gray-400">❌ Belum upload</span>
                    @endif
                </div>
                @if($registration->{$file['field']})
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.pendaftar.file.preview', [$registration->id, $file['type']]) }}"
                        target="_blank"
                        class="px-3 py-1.5 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                        👁 Preview
                    </a>
                    <a href="{{ route('admin.pendaftar.file', [$registration->id, $file['type']]) }}"
                        class="px-3 py-1.5 text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-colors">
                        📥 Download
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
