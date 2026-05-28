<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk',100);
            $table->integer('harga');
            $table->integer('stok')->default(0);
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('foto',255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('produks'); }
};
