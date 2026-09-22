<?php
require 'data.php';

if (!isset($_GET['file'])) {
    die('Akses tidak valid');
}

$filename = basename($_GET['file']);
$filepath = __DIR__ . '/files/' . $filename;

/* cek apakah file ada di data */
$allowed = false;
foreach ($santri as $s) {
    if ($s['file'] === $filename) {
        $allowed = true;
        break;
    }
}

if (!$allowed || !file_exists($filepath)) {
    die('File tidak ditemukan');
}

/* paksa PDF */
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit;
