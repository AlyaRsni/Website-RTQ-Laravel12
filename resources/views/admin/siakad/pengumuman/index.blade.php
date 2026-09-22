@extends('layouts.admin')
@section('title', 'Pengumuman — SIAKAD')
@section('page_title', 'Pengumuman')
@section('page_subtitle', 'Kelola pengumuman untuk ustadz & santri')

@section('content')
<div x-data="{ showCreate: false }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Pengumuman</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $announcements->count() }} pengumuman</p>
        </div>
        <button @click="showCreate = !showCreate"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </button>
    </div>

    {{-- Create Form --}}
    <div x-show="showCreate" x-transition x-cloak class="mb-6 bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-6">
        <form action="{{ route('admin.siakad.pengumuman.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Judul</label>
                    <input type="text" name="judul" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Konten</label>
                    <textarea name="konten" rows="4" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Target Audiens</label>
                    <select name="target" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="semua">Semua</option>
                        <option value="ustadz">Ustadz Saja</option>
                        <option value="santri">Santri Saja</option>
                    </select>
                </div>
                <div class="flex items-end gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="text-sm text-gray-600 dark:text-gray-400">📌 Pin di atas</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="publish_now" value="1" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Langsung publish</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all">Simpan Pengumuman</button>
        </form>
    </div>

    {{-- List --}}
    <div class="space-y-4">
        @forelse($announcements as $ann)
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 p-5 hover:shadow-md transition-all {{ $ann->is_pinned ? 'ring-2 ring-amber-300 dark:ring-amber-600' : '' }}">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        @if($ann->is_pinned) <span class="text-amber-500 text-xs">📌</span> @endif
                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $ann->judul }}</h4>
                        @php $tc = ['semua' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300', 'ustadz' => 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300', 'santri' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $tc[$ann->target] ?? '' }}">{{ ucfirst($ann->target) }}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $ann->konten }}</p>
                    <div class="flex items-center gap-3 mt-3 text-xs text-gray-400 dark:text-gray-500">
                        <span>{{ $ann->author->name ?? '-' }}</span>
                        <span>·</span>
                        <span>{{ $ann->created_at->diffForHumans() }}</span>
                        <span>·</span>
                        @if($ann->published_at)
                            <span class="text-emerald-500">✓ Published</span>
                        @else
                            <span class="text-amber-500">Draft</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <form action="{{ route('admin.siakad.pengumuman.toggle', $ann->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-all" title="{{ $ann->published_at ? 'Unpublish' : 'Publish' }}">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ann->published_at ? 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21' : 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' }}"/></svg>
                        </button>
                    </form>
                    <form action="{{ route('admin.siakad.pengumuman.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800/60 rounded-2xl border border-gray-200 dark:border-gray-700/50 px-6 py-12 text-center">
            <p class="text-sm text-gray-400">Belum ada pengumuman</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
