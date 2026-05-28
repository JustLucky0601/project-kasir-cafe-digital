<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$p = App\Models\Produk::where('nama_produk','like','%Nasi Beef%')->first();
if ($p) {
    echo "ID: ".$p->id."\n";
    echo "Nama: ".$p->nama_produk."\n";
    echo "Foto: ".($p->foto ?? 'NULL')."\n";
    echo "Tersedia: ".($p->tersedia ? 'true' : 'false')."\n";
    echo "Asset URL: ".($p->foto ? asset('storage/products/'.$p->foto) : 'N/A')."\n";
} else {
    echo "Produk tidak ditemukan\n";
}
