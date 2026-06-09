<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens;

    protected $fillable = ['username','password','role','nama_lengkap'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['password' => 'hashed']; }
    public function transaksis(): HasMany { return $this->hasMany(Transaksi::class); }
}

