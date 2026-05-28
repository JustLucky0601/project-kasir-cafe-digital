<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Delete the Nasi Beef Teriyaki product
App\Models\Produk::where('nama_produk','like','%Nasi Beef%')->delete();
echo "Product deleted\n";
