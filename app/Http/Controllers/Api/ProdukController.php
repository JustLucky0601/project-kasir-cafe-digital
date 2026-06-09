<?php

namespace App\Http\Controllers\Api;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends BaseApiController
{
    public function index(Request $request)
    {
        $q = Produk::query()->with('kategori');

        // Default: tampilkan yang tersedia & stok > 0 (untuk konsisten dengan kasir UI)
        $q->where('tersedia', true)->where('stok', '>', 0);

        if ($request->filled('kategori_id')) {
            $q->where('kategori_id', $request->query('kategori_id'));
        }

        if ($request->filled('search')) {
            $q->where('nama_produk', 'like', '%'.$request->query('search').'%');
        }

        $produks = $q->orderByDesc('id')->get();

        return $this->respond(true, 'OK', [
            'items' => $produks->map(fn($p) => [
                'id' => $p->id,
                'nama_produk' => $p->nama_produk,
                'harga' => $p->harga,
                'stok' => $p->stok,
                'kategori_id' => $p->kategori_id,
                'kategori' => $p->kategori?->nama_kategori,
                'foto_url' => $p->foto_url,
                'best_seller' => (bool) $p->best_seller,
            ]),
        ]);
    }

    public function show(int $id)
    {
        $p = Produk::with('kategori')->find($id);
        if (!$p) {
            return $this->respond(false, 'Produk not found', [], 404);
        }

        return $this->respond(true, 'OK', [
            'item' => [
                'id' => $p->id,
                'nama_produk' => $p->nama_produk,
                'harga' => $p->harga,
                'stok' => $p->stok,
                'kategori_id' => $p->kategori_id,
                'kategori' => $p->kategori?->nama_kategori,
                'foto_url' => $p->foto_url,
                'best_seller' => (bool) $p->best_seller,
                'deskripsi' => $p->deskripsi,
                'tersedia' => (bool) $p->tersedia,
            ],
        ]);
    }
}

