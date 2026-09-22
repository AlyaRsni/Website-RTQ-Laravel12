<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Dormitory;
use App\Models\Halaqah;
use App\Models\PpdbRegistration;
use App\Models\Santri;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\SubjectCategory;
use App\Models\User;
use App\Models\UstadzHalaqah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ============================================================
        // PPDB — Existing seeders (untouched)
        // ============================================================

        // Default Admin
        User::updateOrCreate(
            ['phone' => '081111111111'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        // Default Ustadz PPDB
        User::updateOrCreate(
            ['phone' => '08222222222'],
            [
                'name' => 'Ustadz Ahmad',
                'password' => bcrypt('password123'),
                'role' => 'ustadz_ppdb',
            ]
        );

        User::updateOrCreate(
            ['phone' => '08222222233'],
            [
                'name' => 'Ustadz Bilal',
                'password' => bcrypt('password123'),
                'role' => 'ustadz_ppdb',
            ]
        );

        // Dummy calon santri with various registration progress
        $calonSantri = [
            [
                'user' => ['name' => 'Ahmad Fadhil', 'phone' => '08310000001'],
                'reg' => [
                    'status_pembayaran' => 'diterima', 'bukti_pembayaran' => 'dummy/bukti.pdf',
                    'nama_lengkap' => 'Ahmad Fadhil', 'tempat_lahir' => 'Ciamis', 'tanggal_lahir' => '2012-03-15',
                    'asal_sekolah' => 'SD Negeri 1 Kawali', 'nisn' => '0012345678',
                    'nama_ayah' => 'Budi Santoso', 'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Siti Aminah', 'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'alamat_rumah' => 'Jl. Raya Kawali No. 123', 'status_data_diri' => 'selesai',
                    'no_hp_ayah' => '6281200001111', 'no_hp_ibu' => '6281200002222', 'status_kontak' => 'selesai',
                    'status_berkas' => 'selesai', 'kartu_keluarga' => 'dummy/kk.pdf', 'foto_3x4' => 'dummy/foto.jpg', 'ijazah_raport' => 'dummy/ijazah.pdf',
                    'finalisasi_at' => now()->subDays(5),
                    'status_verifikasi' => 'menunggu_verifikasi_berkas',
                ],
            ],
            [
                'user' => ['name' => 'Muhammad Rizki', 'phone' => '08310000002'],
                'reg' => [
                    'status_pembayaran' => 'diterima', 'bukti_pembayaran' => 'dummy/bukti.pdf',
                    'nama_lengkap' => 'Muhammad Rizki', 'tempat_lahir' => 'Tasikmalaya', 'tanggal_lahir' => '2012-07-22',
                    'asal_sekolah' => 'SD IT Al-Falah', 'nisn' => '0012345679',
                    'pernah_hafal_quran' => true, 'jumlah_hafalan' => '5 Juz',
                    'nama_ayah' => 'Irfan', 'pekerjaan_ayah' => 'PNS',
                    'nama_ibu' => 'Rina', 'pekerjaan_ibu' => 'Guru',
                    'alamat_rumah' => 'Jl. Siliwangi No. 45', 'status_data_diri' => 'selesai',
                    'no_hp_ayah' => '6281300001111', 'no_hp_ibu' => '6281300002222', 'status_kontak' => 'selesai',
                    'status_berkas' => 'selesai', 'kartu_keluarga' => 'dummy/kk.pdf', 'foto_3x4' => 'dummy/foto.jpg', 'ijazah_raport' => 'dummy/ijazah.pdf',
                    'finalisasi_at' => now()->subDays(3),
                    'status_verifikasi' => 'terverifikasi', 'nomor_peserta' => 'PPDB-2026-0001',
                ],
            ],
            [
                'user' => ['name' => 'Hafizh Albani', 'phone' => '08310000003'],
                'reg' => [
                    'status_pembayaran' => 'diterima', 'bukti_pembayaran' => 'dummy/bukti.pdf',
                    'nama_lengkap' => 'Hafizh Albani', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '2013-01-10',
                    'asal_sekolah' => 'SD Al-Irsyad', 'nisn' => '0012345680',
                    'nama_ayah' => 'Rahman', 'pekerjaan_ayah' => 'Pedagang',
                    'nama_ibu' => 'Nisa', 'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'alamat_rumah' => 'Jl. Merdeka No. 10', 'status_data_diri' => 'selesai',
                    'no_hp_ayah' => '6281400001111', 'no_hp_ibu' => '6281400002222', 'status_kontak' => 'selesai',
                    'status_berkas' => 'selesai', 'kartu_keluarga' => 'dummy/kk.pdf', 'foto_3x4' => 'dummy/foto.jpg', 'ijazah_raport' => 'dummy/ijazah.pdf',
                    'finalisasi_at' => now()->subDays(2),
                    'status_verifikasi' => 'perlu_perbaikan', 'catatan_perbaikan' => 'Foto 3x4 terlalu buram, mohon upload ulang dengan kualitas lebih baik.',
                ],
            ],
            [
                'user' => ['name' => 'Zahra Aisyah', 'phone' => '08310000004'],
                'reg' => [
                    'status_pembayaran' => 'diterima', 'bukti_pembayaran' => 'dummy/bukti.pdf',
                    'nama_lengkap' => 'Zahra Aisyah', 'tempat_lahir' => 'Ciamis', 'tanggal_lahir' => '2012-11-05',
                    'asal_sekolah' => 'SD Negeri 2 Kawali', 'nisn' => '0012345681',
                    'nama_ayah' => 'Dani', 'pekerjaan_ayah' => 'Petani',
                    'nama_ibu' => 'Dewi', 'pekerjaan_ibu' => 'Pedagang',
                    'alamat_rumah' => 'Kp. Cikaret RT 01/02', 'status_data_diri' => 'selesai',
                    'status_kontak' => 'belum_isi',
                ],
            ],
            [
                'user' => ['name' => 'Yusuf Ramadhan', 'phone' => '08310000005'],
                'reg' => [
                    'status_pembayaran' => 'diterima', 'bukti_pembayaran' => 'dummy/bukti.pdf',
                    'status_data_diri' => 'draft',
                    'nama_lengkap' => 'Yusuf Ramadhan',
                ],
            ],
        ];

        foreach ($calonSantri as $data) {
            $user = User::updateOrCreate(
                ['phone' => $data['user']['phone']],
                [
                    'name' => $data['user']['name'],
                    'password' => bcrypt('password123'),
                    'role' => 'calon_santri',
                ]
            );

            PpdbRegistration::updateOrCreate(
                ['user_id' => $user->id],
                array_merge(
                    ['tahun_ajaran' => '2026/2027'],
                    $data['reg']
                )
            );
        }

        // ============================================================
        // SIAKAD — Data Dummy
        // ============================================================

        // Tahun Ajaran
        $ta = AcademicYear::updateOrCreate(
            ['nama' => '2026/2027'],
            ['is_active' => true]
        );

        // Semester
        $semGanjil = Semester::updateOrCreate(
            ['academic_year_id' => $ta->id, 'tipe' => 'ganjil'],
            ['tanggal_mulai' => '2026-07-14', 'tanggal_selesai' => '2026-12-20', 'is_active' => true]
        );

        Semester::updateOrCreate(
            ['academic_year_id' => $ta->id, 'tipe' => 'genap'],
            ['tanggal_mulai' => '2027-01-04', 'tanggal_selesai' => '2027-06-15', 'is_active' => false]
        );

        // Kategori Mata Pelajaran
        $catDiniyyah = SubjectCategory::updateOrCreate(['nama' => 'Diniyyah']);
        $catTahfidz = SubjectCategory::updateOrCreate(['nama' => 'Tahfidz']);
        $catUmum = SubjectCategory::updateOrCreate(['nama' => 'Umum']);

        // Mata Pelajaran
        Subject::updateOrCreate(['kode' => 'DIN-01'], ['category_id' => $catDiniyyah->id, 'nama' => 'Nahwu Shorof', 'deskripsi' => 'Ilmu tata bahasa Arab']);
        Subject::updateOrCreate(['kode' => 'DIN-02'], ['category_id' => $catDiniyyah->id, 'nama' => 'Fiqih', 'deskripsi' => 'Hukum Islam praktis']);
        Subject::updateOrCreate(['kode' => 'DIN-03'], ['category_id' => $catDiniyyah->id, 'nama' => 'Aqidah Akhlaq', 'deskripsi' => 'Keyakinan dan budi pekerti']);
        Subject::updateOrCreate(['kode' => 'TAH-01'], ['category_id' => $catTahfidz->id, 'nama' => 'Tahfidz Al-Quran', 'deskripsi' => 'Hafalan Al-Quran']);
        Subject::updateOrCreate(['kode' => 'TAH-02'], ['category_id' => $catTahfidz->id, 'nama' => 'Tajwid', 'deskripsi' => 'Ilmu baca Al-Quran']);
        Subject::updateOrCreate(['kode' => 'UMM-01'], ['category_id' => $catUmum->id, 'nama' => 'Matematika']);
        Subject::updateOrCreate(['kode' => 'UMM-02'], ['category_id' => $catUmum->id, 'nama' => 'Bahasa Indonesia']);

        // Asrama
        $asrama1 = Dormitory::updateOrCreate(['nama' => 'Asrama Al-Fatih'], ['kapasitas' => 20, 'keterangan' => 'Asrama putra lantai 1']);
        $asrama2 = Dormitory::updateOrCreate(['nama' => 'Asrama Al-Amin'], ['kapasitas' => 15, 'keterangan' => 'Asrama putra lantai 2']);

        // Ustadz Halaqah
        $userUstadz1 = User::updateOrCreate(
            ['phone' => '08500000001'],
            ['name' => 'Ustadz Hasan', 'password' => bcrypt('password123'), 'role' => 'ustadz_halaqah']
        );
        $ustadz1 = UstadzHalaqah::updateOrCreate(
            ['user_id' => $userUstadz1->id],
            ['nama_lengkap' => 'Ustadz Hasan', 'spesialisasi' => 'Tahfidz', 'status' => 'aktif']
        );

        $userUstadz2 = User::updateOrCreate(
            ['phone' => '08500000002'],
            ['name' => 'Ustadz Umar', 'password' => bcrypt('password123'), 'role' => 'ustadz_halaqah']
        );
        $ustadz2 = UstadzHalaqah::updateOrCreate(
            ['user_id' => $userUstadz2->id],
            ['nama_lengkap' => 'Ustadz Umar', 'spesialisasi' => 'Fiqih & Nahwu', 'status' => 'aktif']
        );

        // Santri (login via NIS, not phone)
        $santriData = [
            ['name' => 'Ibrahim Malik', 'nis' => '20260101', 'jk' => 'laki-laki', 'ttl' => 'Ciamis', 'tgl' => '2013-05-12', 'ayah' => 'Malik', 'ibu' => 'Fatimah', 'asrama' => $asrama1->id, 'stage' => 3],
            ['name' => 'Zaid Abdurrahman', 'nis' => '20260102', 'jk' => 'laki-laki', 'ttl' => 'Tasikmalaya', 'tgl' => '2013-08-20', 'ayah' => 'Abdurrahman', 'ibu' => 'Khadijah', 'asrama' => $asrama1->id, 'stage' => 1],
            ['name' => 'Usamah Hamzah', 'nis' => '20260103', 'jk' => 'laki-laki', 'ttl' => 'Bandung', 'tgl' => '2012-11-03', 'ayah' => 'Hamzah', 'ibu' => 'Aisyah', 'asrama' => $asrama2->id, 'stage' => 5],
        ];

        $santriIds = [];
        foreach ($santriData as $sd) {
            $userSantri = User::updateOrCreate(
                ['phone' => 'NIS-' . $sd['nis']],
                ['name' => $sd['name'], 'password' => bcrypt('password123'), 'role' => 'santri']
            );
            $santri = Santri::updateOrCreate(
                ['user_id' => $userSantri->id],
                [
                    'nis' => $sd['nis'],
                    'nama_lengkap' => $sd['name'],
                    'jenis_kelamin' => $sd['jk'],
                    'tempat_lahir' => $sd['ttl'],
                    'tanggal_lahir' => $sd['tgl'],
                    'nama_ayah' => $sd['ayah'],
                    'nama_ibu' => $sd['ibu'],
                    'dormitory_id' => $sd['asrama'],
                    'status' => 'aktif',
                    'hafalan_stage' => $sd['stage'] ?? null,
                ]
            );
            $santriIds[] = $santri->id;
        }

        // Halaqah
        $hq1 = Halaqah::updateOrCreate(
            ['semester_id' => $semGanjil->id, 'nama' => 'Halaqah Al-Fatih'],
            ['ustadz_id' => $ustadz1->id]
        );
        $hq2 = Halaqah::updateOrCreate(
            ['semester_id' => $semGanjil->id, 'nama' => 'Halaqah Al-Amin'],
            ['ustadz_id' => $ustadz2->id]
        );

        // Assign santri to halaqah
        $hq1->santris()->syncWithoutDetaching([$santriIds[0], $santriIds[1]]);
        $hq2->santris()->syncWithoutDetaching([$santriIds[2]]);

        // Pengumuman
        Announcement::updateOrCreate(
            ['judul' => 'Selamat Datang di SIAKAD RTQ Kawali'],
            [
                'user_id' => User::where('role', 'admin')->first()->id,
                'konten' => 'Alhamdulillah, Sistem Informasi Akademik Pondok Pesantren RTQ Kawali kini telah resmi digunakan. Semoga bermanfaat untuk seluruh civitas akademika.',
                'target' => 'semua',
                'is_pinned' => true,
                'published_at' => now(),
            ]
        );
    }
}
