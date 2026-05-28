<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota',50)->unique();
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->integer('kembalian')->default(0);
            $table->enum('metode_bayar',['tunai','qris','transfer'])->default('tunai');
            $table->string('qris_ref',100)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transaksis'); }
};
