@extends('layouts.ustadz-halaqah')
@section('title', 'Absensi — Ustadz Halaqah')
@section('page_title', 'Absensi')
@section('page_subtitle', 'Pencatatan kehadiran santri per halaqah')

@section('content')
<div x-data="{ saving: false }">
    {{-- Filter --}}
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 mb-6">
        <form method="GET" action="{{ route('siakad.ustadz.absensi.index') }}" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Pilih Halaqah</label>
                <select name="halaqah_id" required
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                    <option value="">— Pilih Halaqah —</option>
                    @foreach($halaqahs as $hq)
                        <option value="{{ $hq->id }}" {{ request('halaqah_id') == $hq->id ? 'selected' : '' }}>
                            {{ $hq->nama }} ({{ $hq->semester->academicYear->nama ?? '' }} — {{ ucfirst($hq->semester->tipe ?? '') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-48">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all">
                Tampilkan
            </button>
        </form>
    </div>

    {{-- Attendance Table --}}
    @if($selectedHalaqah)
    <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $selectedHalaqah->nama }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Absensi tanggal {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs font-bold rounded-lg">
                    {{ $attendances->count() }} santri
                </span>
            </div>
        </div>

        @if($attendances->isEmpty())
            <div class="p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Halaqah ini belum memiliki santri</p>
            </div>
        @else
            <form action="{{ route('siakad.ustadz.absensi.store') }}" method="POST" @submit="saving = true">
                @csrf
                <input type="hidden" name="halaqah_id" value="{{ $selectedHalaqah->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50">
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider w-12">No</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Nama Santri</th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Status</th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($attendances as $idx => $santri)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4">
                                    <input type="hidden" name="absensi[{{ $idx }}][santri_id]" value="{{ $santri->id }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($santri->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $santri->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{ $santri->nis }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @php $currentStatus = $santri->attendance_status; @endphp
                                        @foreach(['hadir' => '✓', 'sakit' => 'S', 'izin' => 'I', 'alpha' => 'A'] as $status => $label)
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="absensi[{{ $idx }}][status]" value="{{ $status }}"
                                                {{ $currentStatus === $status ? 'checked' : '' }}
                                                {{ !$currentStatus && $status === 'hadir' ? 'checked' : '' }}
                                                class="peer sr-only">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-xs font-bold border-2 transition-all duration-200
                                                peer-checked:border-transparent peer-checked:text-white peer-checked:shadow-md
                                                {{ $status === 'hadir' ? 'peer-checked:bg-emerald-500 peer-checked:shadow-emerald-500/30 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-emerald-300' : '' }}
                                                {{ $status === 'sakit' ? 'peer-checked:bg-amber-500 peer-checked:shadow-amber-500/30 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-amber-300' : '' }}
                                                {{ $status === 'izin' ? 'peer-checked:bg-blue-500 peer-checked:shadow-blue-500/30 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-blue-300' : '' }}
                                                {{ $status === 'alpha' ? 'peer-checked:bg-red-500 peer-checked:shadow-red-500/30 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:border-red-300' : '' }}
                                            ">{{ $label }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="absensi[{{ $idx }}][keterangan]" placeholder="Opsional..."
                                        class="w-full px-3 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50 flex justify-end">
                    <button type="submit" :disabled="saving"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-600 hover:bg-amber-700 disabled:bg-amber-400 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-500/25 transition-all duration-200">
                        <svg x-show="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <svg x-show="!saving" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="saving ? 'Menyimpan...' : 'Simpan Absensi'"></span>
                    </button>
                </div>
            </form>
        @endif
    </div>
    @elseif(request('halaqah_id'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800/30 rounded-2xl p-6 text-center">
            <p class="text-sm font-semibold text-red-600 dark:text-red-400">Halaqah tidak ditemukan atau bukan milik Anda</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Pilih halaqah dan tanggal untuk mulai absensi</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Gunakan filter di atas untuk menampilkan daftar santri</p>
        </div>
    @endif
</div>
@endsection
