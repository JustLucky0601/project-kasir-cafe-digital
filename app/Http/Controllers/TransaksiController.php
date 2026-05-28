<?php
namespace App\Http\Controllers;
use App\Models\{Transaksi, User};
use Illuminate\Http\Request;

class TransaksiController extends Controller {
    public function index(Request $request) {
        $query = Transaksi::with(['user','details.produk']);
        if ($request->filled('dari'))   $query->whereDate('tanggal_transaksi','>=',$request->dari);
        if ($request->filled('sampai')) $query->whereDate('tanggal_transaksi','<=',$request->sampai);
        if ($request->filled('kasir'))  $query->where('user_id',$request->kasir);
        if ($request->filled('metode')) $query->where('metode_bayar',$request->metode);
        if ($request->filled('search')) $query->where('nomor_nota','like','%'.$request->search.'%');
        $transaksis      = $query->latest()->paginate(15)->withQueryString();
        $totalPendapatan = (clone $query)->sum('total_harga');
        $kasirs          = User::where('role','kasir')->get();
        return view('admin.transactions.index', compact('transaksis','totalPendapatan','kasirs'));
    }
    public function show(Transaksi $transaksi) {
        $transaksi->load(['user','details.produk.kategori']);
        return view('admin.transactions.show', compact('transaksi'));
    }
    public function destroy(Transaksi $transaksi) {
        $transaksi->delete();
        return redirect()->route('admin.transactions.index')->with('success','Transaksi berhasil dihapus!');
    }
}
