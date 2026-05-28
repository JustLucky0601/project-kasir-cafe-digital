<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if the new product was created
$p = App\Models\Produk::where('nama_produk','like','%Test Tanpa Foto%')->first();
if ($p) {
    echo "Produk ditemukan!\n";
    echo "ID: " . $p->id . "\n";
    echo "Nama: " . $p->nama_produk . "\n";
    echo "Harga: " . $p->harga . "\n";
    echo "Stok: " . $p->stok . "\n";
    echo "Foto: " . ($p->foto ?? 'NULL') . "\n";
} else {
    echo "Produk tidak ditemukan\n";
}
