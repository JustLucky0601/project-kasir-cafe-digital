<?php
namespace App\Http\Controllers;
use App\Models\{Produk, Kategori, Transaksi, DetailTransaksi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};

class KasirController extends Controller {
    public function index() {
        $kategoris = Kategori::all();
        $produks   = Produk::with('kategori')->available()->inStock()->get();
        return view('kasir.index', compact('kategoris','produks'));
    }

    public function getProduks(Request $request) {
        $q = Produk::with('kategori')->available()->inStock();
        if ($request->filled('kategori_id')) $q->where('kategori_id',$request->kategori_id);
        if ($request->filled('search'))      $q->where('nama_produk','like','%'.$request->search.'%');
        return response()->json($q->get()->map(fn($p) => [
            'id'=>$p->id,'nama_produk'=>$p->nama_produk,'harga'=>$p->harga,
            'stok'=>$p->stok,'kategori'=>$p->kategori->nama_kategori,
            'foto_url'=>$p->foto_url,'icon'=>$p->kategori->icon,
        ]));
    }

    public function simpanTransaksi(Request $request) {
        $request->validate([
            'items'        => 'required|array|min:1',
            'items.*.id'   => 'required|exists:produks,id',
            'items.*.qty'  => 'required|integer|min:1',
            'total_harga'  => 'required|integer|min:0',
            'total_bayar'  => 'required|integer|min:0',
            'kembalian'    => 'required|integer|min:0',
            'metode_bayar' => 'required|in:tunai,qris,transfer',
        ]);
        try {
            DB::beginTransaction();
            $trx = Transaksi::create([
                'nomor_nota'        => Transaksi::generateNomor(),
                'tanggal_transaksi' => now(),
                'total_harga'       => $request->total_harga,
                'total_bayar'       => $request->total_bayar,
                'kembalian'         => $request->kembalian,
                'metode_bayar'      => $request->metode_bayar,
                'qris_ref'          => $request->qris_ref ?? null,
                'user_id'           => Auth::id(),
            ]);
            foreach ($request->items as $item) {
                $p = Produk::lockForUpdate()->findOrFail($item['id']);
                if ($p->stok < $item['qty'])
                    throw new \Exception("Stok {$p->nama_produk} tidak cukup! Sisa: {$p->stok}");
                DetailTransaksi::create([
                    'transaksi_id' => $trx->id,
                    'produk_id'    => $p->id,
                    'jumlah_beli'  => $item['qty'],
                    'harga_satuan' => $p->harga,
                    'subtotal'     => $p->harga * $item['qty'],
                ]);
                $p->decrement('stok', $item['qty']);
            }
            DB::commit();
            return response()->json(['success'=>true,'nomor_nota'=>$trx->nomor_nota,'transaksi_id'=>$trx->id,'kembalian'=>$trx->kembalian]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$e->getMessage()], 422);
        }
    }

    public function cetakNota(Transaksi $transaksi) {
        $transaksi->load(['user','details.produk']);
        return view('kasir.nota', compact('transaksi'));
    }
}
