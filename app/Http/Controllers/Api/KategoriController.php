<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategori;

class KategoriController extends BaseApiController
{
    public function index()
    {
        $kategoris = Kategori::query()->orderBy('nama_kategori')->get();

        return $this->respond(true, 'OK', [
            'items' => $kategoris->map(fn($k) => [
                'id' => $k->id,
                'nama_kategori' => $k->nama_kategori,
                'icon' => $k->icon,
            ]),
        ]);
    }
}

