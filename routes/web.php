<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Ppdb\DashboardController;
use App\Http\Controllers\Ppdb\Step1Controller;
use App\Http\Controllers\Ppdb\Step2Controller;
use App\Http\Controllers\Ppdb\Step3Controller;
use App\Http\Controllers\Ppdb\Step4Controller;
use App\Http\Controllers\Ppdb\Step5Controller;
use App\Http\Controllers\Admin\Siakad\TahunAjaranController;
use App\Http\Controllers\Admin\Siakad\SemesterController;
use App\Http\Controllers\Admin\Siakad\MataPelajaranController;
use App\Http\Controllers\Admin\Siakad\AsramaController;
use App\Http\Controllers\Admin\Siakad\SantriController as AdminSantriController;
use App\Http\Controllers\Admin\Siakad\UstadzHalaqahController as AdminUstadzHalaqahController;
use App\Http\Controllers\Admin\Siakad\HalaqahController;
use App\Http\Controllers\Admin\Siakad\PengumumanController;
use App\Http\Controllers\Admin\Siakad\DashboardController as SiakadDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PendaftarController as AdminPendaftar;
use App\Http\Controllers\Admin\UstadzController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HasilSeleksiController;
use App\Http\Controllers\Ustadz\DashboardController as UstadzDashboard;
use App\Http\Controllers\Ustadz\PendaftarController as UstadzPendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin'          => redirect()->route('admin.dashboard'),
            'ustadz_ppdb'    => redirect()->route('ustadz.dashboard'),
            'calon_santri'   => redirect()->route('ppdb.dashboard'),
            'ustadz_halaqah' => redirect()->route('siakad.ustadz.dashboard'),
            'santri'         => redirect()->route('siakad.santri.dashboard'),
            default          => view('landing'),
        };
    }
    return view('landing');
});

Route::get('/informasi-ppdb', function () {
    return view('ppdb.info');
})->name('ppdb.info');

Route::get('/ppdb/hasil-seleksi', function (Illuminate\Http\Request $request) {
    include resource_path('views/ppdb_lama/data.php');

    $keyword = $request->query('nama', '');
    $hasil = [];

    if (strlen(trim($keyword)) >= 3) {
        $safeKeyword = strtolower(trim($keyword));
        foreach ($santri as $s) {
            if (str_contains(strtolower($s['nama']), $safeKeyword)) {
                $hasil[] = $s;
            }
        }
    }

    return view('ppdb.hasil-seleksi', [
        'keyword' => $keyword,
        'hasil' => $hasil,
        'totalSantri' => count($santri),
    ]);
})->name('ppdb.hasil-seleksi');

Route::get('/ppdb/download-sk', function (Illuminate\Http\Request $request) {
    include resource_path('views/ppdb_lama/data.php');

    $filename = basename($request->query('file', ''));
    $filepath = public_path('pdf/hasil_seleksi/files/' . $filename);

    $allowed = false;
    foreach ($santri as $s) {
        if ($s['file'] === $filename) {
            $allowed = true;
            break;
        }
    }

    if (!$allowed || !file_exists($filepath)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->download($filepath, $filename, [
        'Content-Type' => 'application/pdf',
    ]);
})->name('ppdb.download-sk');

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/ppdb/register', [RegisterController::class, 'showForm'])->name('ppdb.register');
    Route::post('/ppdb/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// CALON SANTRI — Dashboard PPDB
// ============================================================
Route::middleware(['auth', 'role:calon_santri'])->prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/step/1', [Step1Controller::class, 'show'])->name('step.1');
    Route::post('/step/1', [Step1Controller::class, 'upload'])->name('step.1.upload');

    Route::get('/step/2', [Step2Controller::class, 'show'])->name('step.2');
    Route::post('/step/2', [Step2Controller::class, 'save'])->name('step.2.save');

    Route::get('/step/3', [Step3Controller::class, 'show'])->name('step.3');
    Route::post('/step/3', [Step3Controller::class, 'save'])->name('step.3.save');

    Route::get('/step/4', [Step4Controller::class, 'show'])->name('step.4');
    Route::post('/step/4', [Step4Controller::class, 'upload'])->name('step.4.upload');

    Route::get('/step/5', [Step5Controller::class, 'show'])->name('step.5');
    Route::post('/step/5/finalize', [Step5Controller::class, 'finalize'])->name('step.5.finalize');

    // Download hasil seleksi
    Route::get('/download-hasil-seleksi', function () {
        $reg = auth()->user()->ppdbRegistration;
        if (!$reg || $reg->hasil_seleksi_status !== 'tersedia' || !$reg->hasil_seleksi_pdf) {
            return redirect()->route('ppdb.dashboard')->with('error', 'Hasil seleksi belum tersedia.');
        }
        return \Illuminate\Support\Facades\Storage::disk('ppdb')->download(
            $reg->hasil_seleksi_pdf,
            'Hasil_Seleksi_' . str_replace(' ', '_', $reg->nama_lengkap ?? $reg->user->name) . '.pdf'
        );
    })->name('download-hasil');

    // Halaman baru
    Route::get('/hasil-seleksi', [DashboardController::class, 'hasilSeleksi'])->name('hasil-seleksi');
    Route::get('/tanggal-penting', [DashboardController::class, 'tanggalPenting'])->name('tanggal-penting');
});

// ============================================================
// ADMIN — Dashboard & Management
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Pendaftar management
    Route::get('/pendaftar', [AdminPendaftar::class, 'index'])->name('pendaftar.index');
    Route::get('/pendaftar/{id}', [AdminPendaftar::class, 'show'])->name('pendaftar.show');
    Route::delete('/pendaftar/{id}', [AdminPendaftar::class, 'destroy'])->name('pendaftar.destroy');
    Route::post('/pendaftar/{id}/override', [AdminPendaftar::class, 'override'])->name('pendaftar.override');
    Route::post('/pendaftar/{id}/reset-password', [AdminPendaftar::class, 'resetPassword'])->name('pendaftar.reset-password');

    // File preview/download
    Route::get('/pendaftar/{id}/file/{type}', [AdminPendaftar::class, 'downloadFile'])->name('pendaftar.file');
    Route::get('/pendaftar/{id}/file/{type}/preview', [AdminPendaftar::class, 'previewFile'])->name('pendaftar.file.preview');

    // Ustadz management
    Route::get('/ustadz', [UstadzController::class, 'index'])->name('ustadz.index');
    Route::post('/ustadz', [UstadzController::class, 'store'])->name('ustadz.store');
    Route::put('/ustadz/{id}', [UstadzController::class, 'update'])->name('ustadz.update');
    Route::delete('/ustadz/{id}', [UstadzController::class, 'destroy'])->name('ustadz.destroy');

    // Export
    Route::get('/export-csv', [ExportController::class, 'exportCsv'])->name('export.csv');

    // Hasil seleksi
    Route::get('/hasil-seleksi', [HasilSeleksiController::class, 'index'])->name('hasil-seleksi.index');
    Route::post('/hasil-seleksi/{id}/upload', [HasilSeleksiController::class, 'upload'])->name('hasil-seleksi.upload');
    Route::post('/hasil-seleksi/toggle', [HasilSeleksiController::class, 'toggleDownload'])->name('hasil-seleksi.toggle');
    Route::delete('/hasil-seleksi/{id}', [HasilSeleksiController::class, 'deleteFile'])->name('hasil-seleksi.delete');
});

// ============================================================
// USTADZ PPDB — Verifikasi & Review
// ============================================================
Route::middleware(['auth', 'role:ustadz_ppdb'])->prefix('ustadz')->name('ustadz.')->group(function () {
    Route::get('/dashboard', [UstadzDashboard::class, 'index'])->name('dashboard');

    Route::get('/pendaftar', [UstadzPendaftar::class, 'index'])->name('pendaftar.index');
    Route::get('/pendaftar/{id}', [UstadzPendaftar::class, 'show'])->name('pendaftar.show');
    Route::post('/pendaftar/{id}/verify', [UstadzPendaftar::class, 'verify'])->name('pendaftar.verify');

    // File preview/download for ustadz
    Route::get('/pendaftar/{id}/file/{type}', [UstadzPendaftar::class, 'downloadFile'])->name('pendaftar.file');
    Route::get('/pendaftar/{id}/file/{type}/preview', [UstadzPendaftar::class, 'previewFile'])->name('pendaftar.file.preview');
});

// ============================================================
// Misc
// ============================================================
Route::get('/ppdb/ditutup', function () {
    return view('ppdb.ditutup');
})->name('ppdb.ditutup');

Route::get('/dalam-pengembangan', function () {
    return view('pages.dalam-pengembangan');
})->name('dalam-pengembangan');

// ============================================================
// ADMIN — SIAKAD (Sistem Informasi Akademik)
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin/siakad')->name('admin.siakad.')->group(function () {
    // Dashboard SIAKAD
    Route::get('/dashboard', [SiakadDashboard::class, 'index'])->name('dashboard');

    // Tahun Ajaran
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
    Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::put('/tahun-ajaran/{id}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
    Route::post('/tahun-ajaran/{id}/toggle', [TahunAjaranController::class, 'toggleActive'])->name('tahun-ajaran.toggle');
    Route::delete('/tahun-ajaran/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');

    // Semester
    Route::get('/semester', [SemesterController::class, 'index'])->name('semester.index');
    Route::post('/semester', [SemesterController::class, 'store'])->name('semester.store');
    Route::post('/semester/{id}/toggle', [SemesterController::class, 'toggleActive'])->name('semester.toggle');
    Route::delete('/semester/{id}', [SemesterController::class, 'destroy'])->name('semester.destroy');

    // Mata Pelajaran / Kitab
    Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index'])->name('mata-pelajaran.index');
    Route::post('/mata-pelajaran/kategori', [MataPelajaranController::class, 'storeCategory'])->name('mata-pelajaran.kategori.store');
    Route::delete('/mata-pelajaran/kategori/{id}', [MataPelajaranController::class, 'destroyCategory'])->name('mata-pelajaran.kategori.destroy');
    Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store'])->name('mata-pelajaran.store');
    Route::put('/mata-pelajaran/{id}', [MataPelajaranController::class, 'update'])->name('mata-pelajaran.update');
    Route::delete('/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mata-pelajaran.destroy');

    // Asrama
    Route::get('/asrama', [AsramaController::class, 'index'])->name('asrama.index');
    Route::post('/asrama', [AsramaController::class, 'store'])->name('asrama.store');
    Route::put('/asrama/{id}', [AsramaController::class, 'update'])->name('asrama.update');
    Route::delete('/asrama/{id}', [AsramaController::class, 'destroy'])->name('asrama.destroy');

    // Data Santri
    Route::get('/santri', [AdminSantriController::class, 'index'])->name('santri.index');
    Route::get('/santri/create', [AdminSantriController::class, 'create'])->name('santri.create');
    Route::post('/santri', [AdminSantriController::class, 'store'])->name('santri.store');
    Route::get('/santri/{id}', [AdminSantriController::class, 'show'])->name('santri.show');
    Route::put('/santri/{id}', [AdminSantriController::class, 'update'])->name('santri.update');
    Route::delete('/santri/{id}', [AdminSantriController::class, 'destroy'])->name('santri.destroy');
    Route::post('/santri/{id}/halaqah', [AdminSantriController::class, 'addHalaqah'])->name('santri.add-halaqah');
    Route::delete('/santri/{santriId}/halaqah/{halaqahId}', [AdminSantriController::class, 'removeHalaqah'])->name('santri.remove-halaqah');
    Route::post('/santri/{id}/reset-password', [AdminSantriController::class, 'resetPassword'])->name('santri.reset-password');

    // Ustadz Halaqah
    Route::get('/ustadz', [AdminUstadzHalaqahController::class, 'index'])->name('ustadz.index');
    Route::post('/ustadz', [AdminUstadzHalaqahController::class, 'store'])->name('ustadz.store');
    Route::put('/ustadz/{id}', [AdminUstadzHalaqahController::class, 'update'])->name('ustadz.update');
    Route::delete('/ustadz/{id}', [AdminUstadzHalaqahController::class, 'destroy'])->name('ustadz.destroy');

    // Halaqah
    Route::get('/halaqah', [HalaqahController::class, 'index'])->name('halaqah.index');
    Route::post('/halaqah', [HalaqahController::class, 'store'])->name('halaqah.store');
    Route::get('/halaqah/{id}', [HalaqahController::class, 'show'])->name('halaqah.show');
    Route::put('/halaqah/{id}', [HalaqahController::class, 'update'])->name('halaqah.update');
    Route::post('/halaqah/{id}/santri', [HalaqahController::class, 'addSantri'])->name('halaqah.add-santri');
    Route::delete('/halaqah/{halaqahId}/santri/{santriId}', [HalaqahController::class, 'removeSantri'])->name('halaqah.remove-santri');
    Route::delete('/halaqah/{id}', [HalaqahController::class, 'destroy'])->name('halaqah.destroy');

    // Pengumuman
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::post('/pengumuman/{id}/toggle', [PengumumanController::class, 'togglePublish'])->name('pengumuman.toggle');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
});

// ============================================================
// USTADZ HALAQAH — SIAKAD
// ============================================================
Route::middleware(['auth', 'role:ustadz_halaqah'])->prefix('siakad/ustadz')->name('siakad.ustadz.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Siakad\Ustadz\DashboardController::class, 'index'])->name('dashboard');

    // Absensi
    Route::get('/absensi', [\App\Http\Controllers\Siakad\Ustadz\AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [\App\Http\Controllers\Siakad\Ustadz\AbsensiController::class, 'store'])->name('absensi.store');

    // Input Nilai
    Route::get('/nilai', [\App\Http\Controllers\Siakad\Ustadz\NilaiController::class, 'index'])->name('nilai.index');
    Route::post('/nilai', [\App\Http\Controllers\Siakad\Ustadz\NilaiController::class, 'store'])->name('nilai.store');

    // Jurnal Hafalan
    Route::get('/hafalan', [\App\Http\Controllers\Siakad\Ustadz\HafalanController::class, 'index'])->name('hafalan.index');
    Route::post('/hafalan', [\App\Http\Controllers\Siakad\Ustadz\HafalanController::class, 'store'])->name('hafalan.store');

    // Kedisiplinan
    Route::get('/disiplin', [\App\Http\Controllers\Siakad\Ustadz\DisiplinController::class, 'index'])->name('disiplin.index');
    Route::post('/disiplin', [\App\Http\Controllers\Siakad\Ustadz\DisiplinController::class, 'store'])->name('disiplin.store');

    // Rekap Bulanan
    Route::get('/rekap', [\App\Http\Controllers\Siakad\Ustadz\RekapBulananController::class, 'index'])->name('rekap.index');

    // Perizinan
    Route::get('/perizinan', [\App\Http\Controllers\Siakad\Ustadz\PerizinanController::class, 'index'])->name('perizinan.index');
    Route::post('/perizinan/scan', [\App\Http\Controllers\Siakad\Ustadz\PerizinanController::class, 'scanRfid'])->name('perizinan.scan');
    Route::post('/perizinan', [\App\Http\Controllers\Siakad\Ustadz\PerizinanController::class, 'store'])->name('perizinan.store');
    Route::put('/perizinan/{id}', [\App\Http\Controllers\Siakad\Ustadz\PerizinanController::class, 'update'])->name('perizinan.update');

    // Ujian Hafalan
    Route::get('/ujian-hafalan', [\App\Http\Controllers\Siakad\Ustadz\UjianHafalanController::class, 'index'])->name('ujian-hafalan.index');
    Route::post('/ujian-hafalan', [\App\Http\Controllers\Siakad\Ustadz\UjianHafalanController::class, 'store'])->name('ujian-hafalan.store');

    // Update Stage Hafalan Santri
    Route::put('/santri/{id}/stage', [\App\Http\Controllers\Siakad\Ustadz\DashboardController::class, 'updateStage'])->name('santri.update-stage');
});

// ============================================================
// SANTRI — SIAKAD
// ============================================================
Route::middleware(['auth', 'role:santri'])->prefix('siakad/santri')->name('siakad.santri.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Siakad\Santri\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perizinan', [\App\Http\Controllers\Siakad\Santri\DashboardController::class, 'perizinan'])->name('perizinan');
    Route::get('/hafalan', [\App\Http\Controllers\Siakad\Santri\HafalanController::class, 'index'])->name('hafalan');
});


