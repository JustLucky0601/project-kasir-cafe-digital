<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseApiController
{
    public function stats()
    {
        $user = Auth::user();

        $q = Transaksi::query();
        if ($user && $user->role === 'kasir') {
            $q->where('user_id', $user->id);
        }

        $totalTransaksi = (clone $q)->count();
        $totalPendapatan = (clone $q)->sum('total_bayar');
        $totalKembalian = (clone $q)->sum('kembalian');

        return $this->respond(true, 'OK', [
            'total_transaksi' => $totalTransaksi,
            'total_pendapatan' => (int) $totalPendapatan,
            'total_kembalian' => (int) $totalKembalian,
        ]);
    }
}

