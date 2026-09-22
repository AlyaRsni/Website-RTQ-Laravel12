<?php

namespace App\Http\Controllers\Admin\Siakad;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')->orderByDesc('is_pinned')->orderByDesc('id')->get();
        return view('admin.siakad.pengumuman.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'target' => 'required|in:semua,ustadz,santri',
        ]);

        Announcement::create([
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'konten' => $request->konten,
            'target' => $request->target,
            'is_pinned' => $request->boolean('is_pinned'),
            'published_at' => $request->boolean('publish_now') ? now() : null,
        ]);

        return back()->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'target' => 'required|in:semua,ustadz,santri',
        ]);

        $announcement->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'target' => $request->target,
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function togglePublish($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'published_at' => $announcement->published_at ? null : now(),
        ]);

        $status = $announcement->published_at ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Pengumuman berhasil {$status}.");
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
