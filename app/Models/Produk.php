<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model {
    protected $fillable = ['nama_produk','harga','stok','kategori_id','foto','deskripsi','tersedia','best_seller'];
    protected function casts(): array { return ['tersedia' => 'boolean', 'best_seller' => 'boolean']; }
    public function kategori(): BelongsTo { return $this->belongsTo(Kategori::class); }
    public function detailTransaksis(): HasMany { return $this->hasMany(DetailTransaksi::class); }
    public function getFotoUrlAttribute(): string {
        return $this->foto ? asset('storage/products/'.$this->foto) : '';
    }
}
