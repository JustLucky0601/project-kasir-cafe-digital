<?php
$vendor = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($vendor)) { echo "vendor autoload not found\n"; exit(1); }
require $vendor;
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Produk;
$prods = Produk::orderBy('id')->limit(12)->get();
foreach($prods as $p) {
    echo $p->id . "\t" . $p->nama_produk . "\t" . ($p->tersedia ? '1' : '0') . "\n";
}
