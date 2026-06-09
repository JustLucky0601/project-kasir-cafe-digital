<?php

namespace App\Http\Controllers\Api;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends BaseApiController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Biasanya kasir hanya melihat transaksinya sendiri.
        $q = Transaksi::query()->with(['user', 'details.produk']);
        if ($user && $user->role === 'kasir') {
            $q->where('user_id', $user->id);
        }

        $transaksis = $q->orderByDesc('id')->get();

        return $this->respond(true, 'OK', [
            'items' => $transaksis->map(function ($t) {
                return [
                    'id' => $t->id,
                    'nomor_nota' => $t->nomor_nota,
                    'tanggal_transaksi' => $t->tanggal_transaksi,
                    'total_harga' => $t->total_harga,
                    'total_bayar' => $t->total_bayar,
                    'kembalian' => $t->kembalian,
                    'metode_bayar' => $t->metode_bayar,
                    'status_pembayaran' => $t->status_pembayaran,
                    'user' => [
                        'id' => $t->user?->id,
                        'nama_lengkap' => $t->user?->nama_lengkap,
                        'username' => $t->user?->username,
                    ],
                ];
            }),
        ]);
    }

    public function show(int $id)
    {
        $user = Auth::user();
        $t = Transaksi::with(['user', 'details.produk'])->find($id);
        if (!$t) {
            return $this->respond(false, 'Transaksi not found', [], 404);
        }

        if ($user && $user->role === 'kasir' && (int) $t->user_id !== (int) $user->id) {
            return $this->respond(false, 'Forbidden', [], 403);
        }

        return $this->respond(true, 'OK', [
            'item' => [
                'id' => $t->id,
                'nomor_nota' => $t->nomor_nota,
                'tanggal_transaksi' => $t->tanggal_transaksi,
                'total_harga' => $t->total_harga,
                'total_bayar' => $t->total_bayar,
                'kembalian' => $t->kembalian,
                'metode_bayar' => $t->metode_bayar,
                'status_pembayaran' => $t->status_pembayaran,
                'bukti_transfer' => $t->bukti_transfer,
                'details' => $t->details->map(fn($d) => [
                    'id' => $d->id,
                    'produk_id' => $d->produk_id,
                    'nama_produk' => $d->produk?->nama_produk,
                    'jumlah_beli' => $d->jumlah_beli,
                    'harga_satuan' => $d->harga_satuan,
                    'subtotal' => $d->subtotal,
                ]),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:0',
            'total_bayar' => 'required|integer|min:0',
            'kembalian' => 'required|integer|min:0',
            'metode_bayar' => 'required|in:tunai,qris,transfer',
            'qris_ref' => 'nullable|string',
        ]);

        $items = $v['items'];

        try {
            DB::beginTransaction();

            $statusPembayaran = null;
            if ($request->input('metode_bayar') === 'transfer') {
                $statusPembayaran = 'paid';
            }

            $trx = Transaksi::create([
                'nomor_nota' => Transaksi::generateNomor(),
                'tanggal_transaksi' => now(),
                'total_harga' => (int) $request->input('total_harga'),
                'total_bayar' => (int) $request->input('total_bayar'),
                'kembalian' => (int) $request->input('kembalian'),
                'metode_bayar' => $request->input('metode_bayar'),
                'qris_ref' => $request->input('qris_ref'),
                'status_pembayaran' => $statusPembayaran ?? 'paid',
                'bukti_transfer' => null,
                'user_id' => Auth::id(),
            ]);

            foreach ($items as $item) {
                $p = Produk::lockForUpdate()->findOrFail((int) $item['id']);

                if ($request->input('metode_bayar') !== 'transfer') {
                    if ($p->stok < (int) $item['qty']) {
                        throw new \Exception("Stok {$p->nama_produk} tidak cukup! Sisa: {$p->stok}");
                    }
                    $p->decrement('stok', (int) $item['qty']);
                }

                DetailTransaksi::create([
                    'transaksi_id' => $trx->id,
                    'produk_id' => $p->id,
                    'jumlah_beli' => (int) $item['qty'],
                    'harga_satuan' => $p->harga,
                    'subtotal' => $p->harga * (int) $item['qty'],
                ]);
            }

            DB::commit();

            return $this->respond(true, 'Transaksi created', [
                'id' => $trx->id,
                'nomor_nota' => $trx->nomor_nota,
                'status_pembayaran' => $trx->status_pembayaran,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond(false, $e->getMessage(), [], 422);
        }
    }
}

