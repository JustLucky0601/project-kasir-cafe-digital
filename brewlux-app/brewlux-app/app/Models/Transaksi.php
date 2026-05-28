<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model {
    protected $fillable = ['nomor_nota','tanggal_transaksi','total_harga','total_bayar','kembalian','metode_bayar','qris_ref','user_id'];
    protected function casts(): array { return ['tanggal_transaksi' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function details(): HasMany { return $this->hasMany(DetailTransaksi::class); }
    public static function generateNomor(): string {
        $date = now()->format('Ymd');
        $last = self::whereDate('tanggal_transaksi', today())->count();
        return 'TRX-'.$date.'-'.str_pad($last+1, 3, '0', STR_PAD_LEFT);
    }
}
