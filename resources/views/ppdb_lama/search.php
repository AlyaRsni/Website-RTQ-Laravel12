<?php
require 'data.php';

$keyword = '';
$hasil = [];

if (isset($_GET['nama'])) {
    $keyword = trim($_GET['nama']);
    $safeKeyword = strtolower($keyword);

    if (strlen($safeKeyword) >= 3) {
        foreach ($santri as $s) {
            if (strpos(strtolower($s['nama']), $safeKeyword) !== false) {
                $hasil[] = $s;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengumuman Kelulusan PPDB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="/assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css" />
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="/assets/css/magnific-popup.min.css" />
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="/assets/css/animate.min.css" />
    <!-- Boxicons CSS -->
    <link rel="stylesheet" href="/assets/css/boxicons.min.css" />
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="/assets/fonts/flaticon.css" />
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="assets/css/meanmenu.min.css" />
    <!-- Style CSS -->
    <link rel="stylesheet" href="/assets/css/style.css" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/assets/css/responsive.css" />
    <!-- Theme Dark CSS -->
    <link rel="stylesheet" href="/assets/css/theme-dark.css" />
    <!-- Bootstrap 5 -->
   

 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="card shadow-sm">
                <div class="card-body">
                   
                    <h4 class="text-center mb-3">
                        🔍 Pengumuman Kelulusan PPDB Tahun Ajaran 2026/2027
                    </h4>

                    <p class="text-center text-muted small">
                        Masukkan <b>minimal 3 huruf</b> dari nama lengkap santri
                    </p>

                    <form method="GET">
                        <div class="input-group mb-3">
                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Contoh: Athar / Muhammad / Zaid"
                                   value="<?= htmlspecialchars($keyword) ?>"
                                   required>
                            <button class="btn btn-primary">Cari</button>
                        </div>
                    </form>

                    <?php if ($keyword && strlen($keyword) < 3): ?>
                        <div class="alert alert-warning small">
                            Minimal 3 huruf untuk pencarian.
                        </div>
                    <?php endif; ?>

                    <?php if ($keyword && strlen($keyword) >= 3): ?>
                        <hr>

                        <?php if (count($hasil) > 0): ?>
                            <h6 class="mb-3">Hasil Pencarian:</h6>

                            <?php foreach ($hasil as $row): ?>
                                <div class="border rounded p-3 mb-3">
                                    <strong>Nama:</strong><br>
                                    <?= htmlspecialchars($row['nama']) ?><br><br>

                                    <strong>Asal:</strong><br>
                                    <?= htmlspecialchars($row['asal']) ?><br><br>

                                        <a href="download.php?file=<?= urlencode($row['file']) ?>" class="btn btn-success btn-sm">

                                        ⬇ Download Surat Keputusan
                                    </a>
                                </div>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <div class="alert alert-danger small">
                                Nama tidak ditemukan. Pastikan penulisan benar.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>

            <p class="text-center text-muted mt-3 small">
                © PPDB 2026/2027 | RTQ Kawali | MTQ Ubay Bin Ka'ab
            </p>

        </div>
    </div>
</div>

</body>
</html>
