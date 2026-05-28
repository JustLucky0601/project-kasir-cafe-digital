@extends('layouts.admin')
@section('title','Dashboard')
@section('breadcrumb','Ringkasan operasional hari ini')
@section('content')
<div class="g4" style="margin-bottom:1.5rem">
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid var(--gold)">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Pendapatan Hari Ini</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold)">Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Total omzet {{ now()->format('d/m/Y') }}</div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid #409CFF">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Transaksi Hari Ini</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:#409CFF">{{ $totalTransaksi }}</div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Nota selesai dibayar</div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid var(--grn)">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Total Produk</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--grn)">{{ $totalProduk }}</div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Item terdaftar di menu</div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid {{ $stokRendah > 0 ? 'var(--red)' : 'var(--grn)' }}">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Stok Rendah</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:{{ $stokRendah > 0 ? 'var(--red)' : 'var(--grn)' }}">{{ $stokRendah }}</div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Produk perlu restock</div>
  </div>
</div>
<div class="g2" style="margin-bottom:1.5rem">
  <div class="card">
    <div class="card-h"><span class="card-t">📈 Pendapatan 7 Hari Terakhir</span></div>
    <div class="card-b"><canvas id="chartBar" height="140"></canvas></div>
  </div>
  <div class="card">
    <div class="card-h"><span class="card-t">🏆 Top 5 Produk Terlaris</span></div>
    <div class="card-b">
      @forelse($topProduk as $i => $item)
      <div style="display:flex;align-items:center;gap:.7rem;margin-bottom:.8rem">
        <div style="width:22px;height:22px;border-radius:50%;background:var(--gdim);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:.65rem;color:var(--gold);font-weight:700;flex-shrink:0">{{ $i+1 }}</div>
        <div style="flex:1"><div style="font-size:.83rem;font-weight:500">{{ $item->produk->nama_produk ?? '-' }}</div><div style="font-size:.68rem;color:var(--muted)">{{ $item->total_terjual }} porsi terjual</div></div>
        <div style="font-size:.8rem;font-weight:700;color:var(--gold)">Rp {{ number_format(($item->produk->harga??0)*$item->total_terjual,0,',','.') }}</div>
      </div>
      @empty
      <div style="text-align:center;color:var(--muted);padding:2rem;font-size:.85rem">Belum ada data penjualan</div>
      @endforelse
    </div>
  </div>
</div>
<div class="card">
  <div class="card-h"><span class="card-t">🧾 Transaksi Terbaru</span><a href="{{ route('admin.transactions.index') }}" class="btn btn-o btn-sm">Lihat Semua</a></div>
  <div class="tw">
    <table>
      <thead><tr><th>No. Nota</th><th>Waktu</th><th>Kasir</th><th>Total</th><th>Metode</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($transaksiTerbaru as $t)
        <tr>
          <td style="font-family:monospace;font-size:.78rem;font-weight:600;color:var(--gold)">{{ $t->nomor_nota }}</td>
          <td style="font-size:.78rem;color:var(--muted)">{{ $t->tanggal_transaksi->format('H:i') }}</td>
          <td>{{ $t->user->nama_lengkap ?? $t->user->username }}</td>
          <td style="font-weight:600">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
          <td>
            @if($t->metode_bayar=='tunai')<span class="badge bs">💵 Tunai</span>
            @elseif($t->metode_bayar=='qris')<span class="badge bp">📱 QRIS</span>
            @else<span class="badge bi">🏦 Transfer</span>@endif
          </td>
          <td><a href="{{ route('admin.transactions.show',$t) }}" class="btn btn-o btn-sm">Detail</a></td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem">Belum ada transaksi</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
@push('scripts')
<script>
new Chart(document.getElementById('chartBar'),{
  type:'bar',
  data:{
    labels:{!! json_encode($chartLabels) !!},
    datasets:[{label:'Pendapatan',data:{!! json_encode($chartData) !!},
      backgroundColor:'rgba(201,168,76,.25)',borderColor:'#C9A84C',borderWidth:2,borderRadius:6}]
  },
  options:{responsive:true,plugins:{legend:{display:false}},
    scales:{x:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#7A7570',font:{size:10}}},
      y:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#7A7570',font:{size:10},callback:v=>'Rp '+(v/1000).toFixed(0)+'k'}}}}
});
</script>
@endpush
