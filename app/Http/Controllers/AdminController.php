<?php
namespace App\Http\Controllers;
use App\Models\{Produk, Transaksi, DetailTransaksi, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {
    public function dashboard() {
        $totalPendapatan = Transaksi::whereDate('tanggal_transaksi', today())->sum('total_harga');
        $totalTransaksi  = Transaksi::whereDate('tanggal_transaksi', today())->count();
        $totalProduk     = Produk::count();
        $stokRendah      = Produk::where('stok','<=',10)->count();
        $pendapatanBulan = Transaksi::whereMonth('tanggal_transaksi', now()->month)->whereYear('tanggal_transaksi', now()->year)->sum('total_harga');

        $raw = Transaksi::selectRaw('DATE(tanggal_transaksi) as tgl, SUM(total_harga) as total')
            ->whereBetween('tanggal_transaksi',[now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('tgl')->orderBy('tgl')->get()->keyBy('tgl');

        $chartLabels = $chartData = [];
        for ($i=6; $i>=0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->locale('id')->isoFormat('ddd D/M');
            $chartData[]   = $raw->has($d) ? (int)$raw[$d]->total : 0;
        }

        $topProduk = DetailTransaksi::selectRaw('produk_id, SUM(jumlah_beli) as total_terjual')
            ->with('produk')->groupBy('produk_id')->orderByDesc('total_terjual')->limit(5)->get();

        $transaksiTerbaru = Transaksi::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan','totalTransaksi','totalProduk','stokRendah',
            'pendapatanBulan','chartLabels','chartData','topProduk','transaksiTerbaru'
        ));
    }

    public function users() {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request) {
        $request->validate([
            'username'     => 'required|string|max:50|unique:users,username',
            'nama_lengkap' => 'required|string|max:100',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,kasir',
        ]);
        User::create([
            'username'     => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);
        return redirect()->route('admin.users.index')->with('success','User berhasil ditambahkan!');
    }

    public function destroyUser(User $user) {
        if ($user->id === auth()->id())
            return redirect()->route('admin.users.index')->with('error','Tidak bisa menghapus akun sendiri!');
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User berhasil dihapus!');
    }
}
