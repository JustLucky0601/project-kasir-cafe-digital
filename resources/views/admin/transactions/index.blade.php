@extends('layouts.admin')
@section('title','Jurnal Transaksi')
@section('breadcrumb','Histori semua penjualan')
@section('content')
<div class="card" style="padding:1.2rem 1.4rem;margin-bottom:1.25rem">
  <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:flex-end">
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Dari</div><input type="date" name="dari" value="{{ request('dari') }}" class="fc" style="width:148px"></div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Sampai</div><input type="date" name="sampai" value="{{ request('sampai') }}" class="fc" style="width:148px"></div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Kasir</div>
      <select name="kasir" class="fc" style="width:140px"><option value="">Semua Kasir</option>@foreach($kasirs as $k)<option value="{{ $k->id }}" {{ request('kasir')==$k->id ? 'selected':'' }}>{{ $k->nama_lengkap }}</option>@endforeach</select>
    </div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Metode</div>
      <select name="metode" class="fc" style="width:120px"><option value="">Semua</option><option value="tunai" {{ request('metode')=='tunai'?'selected':'' }}>Tunai</option><option value="qris" {{ request('metode')=='qris'?'selected':'' }}>QRIS</option><option value="transfer" {{ request('metode')=='transfer'?'selected':'' }}>Transfer</option></select>
    </div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">No. Nota</div><input type="text" name="search" value="{{ request('search') }}" placeholder="TRX-..." class="fc" style="width:150px"></div>
    <button type="submit" class="btn btn-p">Filter</button>
    @if(request()->hasAny(['dari','sampai','kasir','metode','search']))<a href="{{ route('admin.transactions.index') }}" class="btn btn-o">Reset</a>@endif
  </form>
</div>
<div class="card">
  <div class="card-h">
    <span class="card-t">Jurnal Penjualan ({{ $transaksis->total() }} entri)</span>
    <div style="font-size:.85rem;color:var(--gold);font-weight:700">Total: Rp {{ number_format($totalPendapatan,0,',','.') }}</div>
  </div>
  <div class="tw">
    <table>
      <thead><tr><th>No. Nota</th><th>Tanggal</th><th>Kasir</th><th>Total</th><th>Bayar</th><th>Kembalian</th><th>Metode</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($transaksis as $t)
        <tr>
          <td style="font-family:monospace;font-size:.75rem;font-weight:700;color:var(--gold)">{{ $t->nomor_nota }}</td>
          <td style="font-size:.78rem;color:var(--muted)">{{ $t->tanggal_transaksi->format('d/m/Y H:i') }}</td>
          <td style="font-size:.83rem">{{ $t->user->nama_lengkap ?? $t->user->username }}</td>
          <td style="font-weight:700">Rp {{ number_format($t->total_harga,0,',','.') }}</td>
          <td style="color:var(--muted)">Rp {{ number_format($t->total_bayar,0,',','.') }}</td>
          <td style="color:var(--grn);font-weight:600">Rp {{ number_format($t->kembalian,0,',','.') }}</td>
          <td>
            @if($t->metode_bayar=='tunai')<span class="badge bs">💵 Tunai</span>
            @elseif($t->metode_bayar=='qris')<span class="badge bp">📱 QRIS</span>
            @else<span class="badge bi">🏦 Transfer</span>@endif
          </td>
          <td>
            <div style="display:flex;gap:.3rem">
              <a href="{{ route('admin.transactions.show',$t) }}" class="btn btn-o btn-sm">Detail</a>
              <form method="POST" action="{{ route('admin.transactions.destroy',$t) }}" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-d btn-sm">✕</button></form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:3rem">Tidak ada transaksi</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($transaksis->hasPages())
  <div style="padding:1rem 1.4rem;border-top:1px solid var(--br)">{{ $transaksis->withQueryString()->links('pagination::simple-default') }}</div>
  @endif
</div>
@endsection
