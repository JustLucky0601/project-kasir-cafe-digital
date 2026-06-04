<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Produk;
$id = $argv[1] ?? 1;
$val = $argv[2] ?? 0;
$p = Produk::find($id);
if (!$p) { echo "Produk id=$id not found\n"; exit(1); }
$p->tersedia = (int)$val;
$p->save();
echo "Set produk {$p->id} tersedia={$p->tersedia}\n";
