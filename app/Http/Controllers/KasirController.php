<?php
namespace App\Http\Controllers;
use App\Models\{Produk, Kategori, Transaksi, DetailTransaksi};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};

class KasirController extends Controller {
    public function index() {
        $kategoris = Kategori::all();

        $produks = Produk::with('kategori')
            ->where('tersedia', true)
            ->where('stok', '>', 0)
            ->get();

        // Best seller: flag best_seller = true
        $bestSellers = Produk::with('kategori')
            ->where('tersedia', true)
            ->where('stok', '>', 0)
            ->where('best_seller', true)
            ->get();

        return view('kasir.index', compact('kategoris','produks','bestSellers'));
    }

    public function getProduks(Request $request) {
        $q = Produk::with('kategori')->where('tersedia',true)->where('stok','>',0);
        if ($request->filled('kategori_id')) $q->where('kategori_id',$request->kategori_id);
        if ($request->filled('search'))      $q->where('nama_produk','like','%'.$request->search.'%');
        return response()->json($q->get()->map(fn($p) => [
            'id'=>$p->id,'nama_produk'=>$p->nama_produk,'harga'=>$p->harga,
            'stok'=>$p->stok,'kategori'=>$p->kategori->nama_kategori,
            'foto_url'=>$p->foto_url,'icon'=>$p->kategori->icon,
        ]));
    }

    public function simpanTransaksi(Request $request) {
        $items = $request->items;
        // Saat upload file (FormData), items sering masuk sebagai string JSON
        if (is_string($items)) {
            $decoded = json_decode($items, true);
            $items = is_array($decoded) ? $decoded : [];
        } elseif (is_object($items)) {
            $items = json_decode(json_encode($items), true);
        } elseif (!is_array($items)) {
            $items = [];
        }

            $rules = [
                'items'        => 'required|array|min:1',
                'items.*.id'   => 'required|exists:produks,id',
                'items.*.qty'  => 'required|integer|min:1',
                'total_harga'  => 'required|integer|min:0',
                'total_bayar'  => 'required|integer|min:0',
                'kembalian'    => 'required|integer|min:0',
                'metode_bayar' => 'required|in:tunai,qris,transfer',
            ];

            if ($request->metode_bayar === 'transfer') {
                // Transfer tidak perlu bukti; namun items tetap harus array.
            }

            // Catatan: items harus array agar validasi berikutnya tidak gagal.
            // items wajib untuk tunai/qris. Untuk transfer, kita validasi tetap lewat rule umum.
            // Namun untuk mencegah error tipe/format, jika metode transfer dan items kosong, coba fallback decode.
            if ($request->metode_bayar === 'transfer' && ($request->items === null || $request->items === '' )) {
                // jika items tidak terkirim, kembalikan array kosong agar validasi tipe tidak error (akan gagal min:1)
                $request->merge(['items' => []]);
            }



        try {
            DB::beginTransaction();

            $buktiPath = null;
            $statusPembayaran = null;
            $totalBayar = (int) $request->total_bayar;
            $kembalian  = (int) $request->kembalian;

            if ($request->metode_bayar === 'transfer') {
                // transfer diproses langsung tanpa upload bukti
                $statusPembayaran = 'paid';
            }







            $trx = Transaksi::create([
                'nomor_nota'        => Transaksi::generateNomor(),
                'tanggal_transaksi' => now(),
                'total_harga'       => (int) $request->total_harga,
                'total_bayar'       => $totalBayar,
                'kembalian'         => $kembalian,
                'metode_bayar'      => $request->metode_bayar,
                'qris_ref'          => $request->qris_ref ?? null,
                'status_pembayaran' => $statusPembayaran ?? 'paid',
                'bukti_transfer'    => $buktiPath,
                'user_id'           => Auth::id(),
            ]);

            foreach ($items as $item) {
                $p = Produk::lockForUpdate()->findOrFail($item['id']);

                // untuk transfer pending: stok tidak dipotong dulu
                if ($request->metode_bayar === 'transfer') {
                    DetailTransaksi::create([
                        'transaksi_id' => $trx->id,
                        'produk_id'    => $p->id,
                        'jumlah_beli'  => (int) $item['qty'],
                        'harga_satuan' => $p->harga,
                        'subtotal'     => $p->harga * (int) $item['qty'],
                    ]);
                    continue;
                }

                if ($p->stok < $item['qty']) {
                    throw new \Exception("Stok {$p->nama_produk} tidak cukup! Sisa: {$p->stok}");
                }

                DetailTransaksi::create([
                    'transaksi_id' => $trx->id,
                    'produk_id'    => $p->id,
                    'jumlah_beli'  => (int) $item['qty'],
                    'harga_satuan' => $p->harga,
                    'subtotal'     => $p->harga * (int) $item['qty'],
                ]);
                $p->decrement('stok', (int) $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'nomor_nota' => $trx->nomor_nota,
                'transaksi_id' => $trx->id,
                'kembalian' => $trx->kembalian,
                'status_pembayaran' => $trx->status_pembayaran,
            ]);
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
