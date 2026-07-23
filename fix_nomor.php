<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PengajuanSurat;
use App\Models\BukuRegisterSurat;

$pengajuans = PengajuanSurat::where('status', 'Selesai')->whereNull('nomor_surat')->get();
foreach ($pengajuans as $p) {
    $t = date('Y');
    $r = BukuRegisterSurat::firstOrCreate(['jenis_surat_id' => $p->jenis_surat_id, 'tahun' => $t]);
    $r->nomor_terakhir++;
    $r->save();
    
    $j = $p->jenisSurat;
    $k = $j->kode_surat ?? '470';
    $f = $j->format_nomor ?? '[KODE]/[NOMOR]/DS/[TAHUN]';
    
    $n = str_replace(['[KODE]','[NOMOR]','[TAHUN]'], [$k, str_pad($r->nomor_terakhir, 3, '0', STR_PAD_LEFT), $t], $f);
    
    $p->update(['nomor_surat' => $n]);
    echo 'Generated: ' . $n . "\n";
}
echo "Done.\n";
