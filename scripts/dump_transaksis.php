<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('transaksis')
    ->select('id','nomor_nota','total_harga','total_bayar','kembalian','metode_bayar','tanggal_transaksi')
    ->orderByDesc('id')
    ->limit(10)
    ->get();

echo $rows->toJson(JSON_PRETTY_PRINT) . PHP_EOL;
