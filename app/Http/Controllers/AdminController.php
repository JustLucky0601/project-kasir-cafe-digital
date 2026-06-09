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

        // -----------------------
        // Daily (last 7 days)
        // -----------------------
        $rawDaily = Transaksi::selectRaw('DATE(tanggal_transaksi) as tgl, SUM(total_harga) as total')
            ->whereBetween('tanggal_transaksi',[now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->groupBy('tgl')->orderBy('tgl')->get()->keyBy('tgl');

        $chartDailyLabels = $chartDailyData = [];
        for ($i=6; $i>=0; $i--) {
            $dt = now()->subDays($i);
            $d  = $dt->format('Y-m-d');
            $chartDailyLabels[] = $dt->locale('id')->isoFormat('ddd D/M');
            $chartDailyData[]   = $rawDaily->has($d) ? (int)$rawDaily[$d]->total : 0;
        }

        // -----------------------
        // Weekly (same as daily labels/data, but provide separate vars)
        // -----------------------
        $chartWeeklyLabels = $chartWeeklyData = [];
        // Use last 7 days as 1 point per day
        foreach ($chartDailyLabels as $idx => $lbl) {
            $chartWeeklyLabels[] = $lbl;
            $chartWeeklyData[] = $chartDailyData[$idx] ?? 0;
        }

        // -----------------------
        // Monthly daily (current month, per day)
        // Provide 0..(days in month) points.
        // If you want only 1..12 points, adjust accordingly.
        // -----------------------
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $rawMonthDaily = Transaksi::selectRaw('DATE(tanggal_transaksi) as tgl, SUM(total_harga) as total')
            ->whereBetween('tanggal_transaksi', [$monthStart->startOfDay(), $monthEnd->endOfDay()])
            ->groupBy('tgl')->orderBy('tgl')->get()->keyBy('tgl');

        $daysInMonth = (int)$monthStart->daysInMonth;
        $chartMonthDailyLabels = $chartMonthDailyData = [];
        for ($day=1; $day<=$daysInMonth; $day++) {
            $dt = $monthStart->copy()->day($day);
            $d  = $dt->format('Y-m-d');
            $chartMonthDailyLabels[] = $dt->format('d'); // 01..31
            $chartMonthDailyData[]   = $rawMonthDaily->has($d) ? (int)$rawMonthDaily[$d]->total : 0;
        }

        // -----------------------
        // Monthly totals (current year, 12 months)
        // -----------------------
        $year = now()->year;
        $rawMonthTotal = Transaksi::selectRaw('MONTH(tanggal_transaksi) as m, SUM(total_harga) as total')
            ->whereYear('tanggal_transaksi', $year)
            ->groupBy('m')->get()->keyBy('m');

        $chartMonthTotalValues = [];
        for ($m=1; $m<=12; $m++) {
            $chartMonthTotalValues[] = isset($rawMonthTotal[$m]) ? (int)$rawMonthTotal[$m]->total : 0;
        }

        $topProduk = DetailTransaksi::selectRaw('produk_id, SUM(jumlah_beli) as total_terjual')
            ->with('produk')->groupBy('produk_id')->orderByDesc('total_terjual')->limit(5)->get();

        $transaksiTerbaru = Transaksi::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan', 'totalTransaksi', 'totalProduk', 'stokRendah',
            'pendapatanBulan',

            'chartDailyLabels', 'chartDailyData',
            'chartWeeklyLabels', 'chartWeeklyData',
            'chartMonthDailyLabels', 'chartMonthDailyData',
            'chartMonthTotalValues',

            'topProduk', 'transaksiTerbaru'
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
