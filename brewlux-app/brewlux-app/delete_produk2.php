<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Delete the Test Tanpa Foto product
App\Models\Produk::where('nama_produk','like','%Test Tanpa Foto%')->delete();
echo "Product deleted\n";
