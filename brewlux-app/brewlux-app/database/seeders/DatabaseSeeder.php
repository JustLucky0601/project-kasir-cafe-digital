<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Kategori, Produk};

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['username'=>'admin',  'password'=>Hash::make('admin123'), 'role'=>'admin',  'nama_lengkap'=>'Administrator']);
        User::create(['username'=>'kasir1', 'password'=>Hash::make('kasir123'), 'role'=>'kasir',  'nama_lengkap'=>'Siti Rahayu']);
        User::create(['username'=>'kasir2', 'password'=>Hash::make('kasir123'), 'role'=>'kasir',  'nama_lengkap'=>'Budi Santoso']);

        $ks=[['nama_kategori'=>'Kopi','icon'=>'☕'],['nama_kategori'=>'Non-Kopi','icon'=>'🧋'],
             ['nama_kategori'=>'Makanan','icon'=>'🍽️'],['nama_kategori'=>'Cemilan','icon'=>'🥐'],
             ['nama_kategori'=>'Dessert','icon'=>'🍰']];
        foreach ($ks as $k) Kategori::create($k);

        $ps=[
            ['nama_produk'=>'Espresso Classico',  'harga'=>18000,'stok'=>50,'kategori_id'=>1,'deskripsi'=>'Espresso murni dengan crema sempurna dari biji arabika pilihan.'],
            ['nama_produk'=>'Cappuccino Velvet',  'harga'=>25000,'stok'=>40,'kategori_id'=>1,'deskripsi'=>'Cappuccino dengan susu steam micro-foam lembut.'],
            ['nama_produk'=>'Latte Art Special',  'harga'=>28000,'stok'=>40,'kategori_id'=>1,'deskripsi'=>'Latte dengan sentuhan seni latte art dari barista kami.'],
            ['nama_produk'=>'Cold Brew Classic',  'harga'=>30000,'stok'=>30,'kategori_id'=>1,'deskripsi'=>'Cold brew 18 jam dengan body penuh dan smooth.'],
            ['nama_produk'=>'Americano Bold',     'harga'=>20000,'stok'=>50,'kategori_id'=>1,'deskripsi'=>'Espresso dengan air panas, bold dan refreshing.'],
            ['nama_produk'=>'Matcha Latte',       'harga'=>27000,'stok'=>35,'kategori_id'=>2,'deskripsi'=>'Matcha premium grade ceremonial dengan susu oat.'],
            ['nama_produk'=>'Taro Milk Tea',      'harga'=>25000,'stok'=>35,'kategori_id'=>2,'deskripsi'=>'Milk tea dengan talas ungu asli dan pearl.'],
            ['nama_produk'=>'Lychee Sparkling',   'harga'=>22000,'stok'=>40,'kategori_id'=>2,'deskripsi'=>'Minuman sparkling dengan aroma leci segar.'],
            ['nama_produk'=>'Nasi Goreng Truffle','harga'=>45000,'stok'=>25,'kategori_id'=>3,'deskripsi'=>'Nasi goreng dengan minyak truffle dan telur mata sapi.'],
            ['nama_produk'=>'Pasta Aglio e Olio', 'harga'=>48000,'stok'=>20,'kategori_id'=>3,'deskripsi'=>'Pasta dengan bawang putih, cabai, dan parsley segar.'],
            ['nama_produk'=>'Club Sandwich',      'harga'=>38000,'stok'=>20,'kategori_id'=>3,'deskripsi'=>'Sandwich lapis tiga dengan ayam dan keju.'],
            ['nama_produk'=>'Croissant Butter',   'harga'=>22000,'stok'=>20,'kategori_id'=>4,'deskripsi'=>'Croissant renyah berlapis mentega Prancis.'],
            ['nama_produk'=>'Banana Cake',        'harga'=>18000,'stok'=>15,'kategori_id'=>4,'deskripsi'=>'Kue pisang moist dengan topping walnut.'],
            ['nama_produk'=>'Tiramisu Slice',     'harga'=>32000,'stok'=>15,'kategori_id'=>5,'deskripsi'=>'Tiramisu lembut dengan espresso dan mascarpone.'],
            ['nama_produk'=>'Cheesecake New York','harga'=>35000,'stok'=>15,'kategori_id'=>5,'deskripsi'=>'Cheesecake klasik New York dengan topping berry.'],
        ];
        foreach ($ps as $p) Produk::create($p);
    }
}
