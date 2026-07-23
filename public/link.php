<?php
$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (file_exists($link)) {
    echo "File/folder shortcut 'storage' masih ada. Harap hapus dulu!";
} else {
    if (symlink($target, $link)) {
        echo "Sukses! Shortcut Storage berhasil dibuat untuk Hostinger!";
    } else {
        echo "Gagal. Fungsi symlink mungkin diblokir oleh Hostinger.";
    }
}
