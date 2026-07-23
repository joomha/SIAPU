<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Ini adalah email percobaan dari Sistem SIAPU Desa Kadubeureum. Jika Anda menerima email ini, berarti konfigurasi email sudah berhasil!', function($message) {
        $message->to('masukkan_email_anda@gmail.com')
                ->subject('Tes Email SIAPU Desa');
    });
    echo "Email berhasil dikirim!\n";
} catch (Exception $e) {
    echo "GAGAL: " . $e->getMessage() . "\n";
}
