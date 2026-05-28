@extends('layouts.admin')
@section('title','Detail Transaksi')
@section('breadcrumb','Jurnal Transaksi / '.$transaksi->nomor_nota)
@section('content')
<div style="max-width:680px">
  <div style="display:flex;gap:.65rem;margin-bottom:1.25rem">
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-o btn-sm">← Kembali</a>
    <a href="{{ route('nota',$transaksi) }}" target="_blank" class="btn btn-p btn-sm">🖨️ Cetak Nota</a>
  </div>
  <div class="card" style="margin-bottom:1.25rem">
    <div class="card-h"><span class="card-t">Informasi Transaksi</span></div>
    <div class="card-b">
      <div class="g2">
        <div><div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:.3rem">No. Nota</div><div style="font-family:monospace;font-size:1rem;font-weight:700;color:var(--gold)">{{ $transaksi->nomor_nota }}</div></div>
        <div><div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:.3rem">Waktu</div><div style="font-size:.88rem">{{ $transaksi->tanggal_transaksi->format('d M Y, H:i:s') }}</div></div>
        <div><div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:.3rem">Kasir</div><div style="font-weight:500">{{ $transaksi->user->nama_lengkap ?? $transaksi->user->username }}</div></div>
        <div><div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:.3rem">Metode Bayar</div>
          @if($transaksi->metode_bayar=='tunai')<span class="badge bs" style="font-size:.8rem">💵 Tunai</span>
          @elseif($transaksi->metode_bayar=='qris')<span class="badge bp" style="font-size:.8rem">📱 QRIS</span>
          @else<span class="badge bi" style="font-size:.8rem">🏦 Transfer</span>@endif
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><span class="card-t">Item Terjual</span></div>
    <div class="tw">
      <table>
        <thead><tr><th>#</th><th>Produk</th><th>Harga Satuan</th><th>Qty</th><th>Subtotal</th></tr></thead>
        <tbody>
          @foreach($transaksi->details as $i => $d)
          <tr>
            <td style="color:var(--muted)">{{ $i+1 }}</td>
            <td style="font-weight:500">{{ $d->produk->nama_produk }}</td>
            <td style="color:var(--muted)">Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
            <td style="font-weight:700;color:var(--gold)">× {{ $d->jumlah_beli }}</td>
            <td style="font-weight:700">Rp {{ number_format($d->subtotal,0,',','.') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div style="padding:1.2rem 1.4rem;border-top:1px solid var(--br)">
      <div style="max-width:260px;margin-left:auto">
        <div style="display:flex;justify-content:space-between;font-size:.85rem;color:var(--muted);margin-bottom:.4rem"><span>Total Tagihan</span><span style="font-weight:700;color:var(--text)">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span></div>
        <div style="display:flex;justify-content:space-between;font-size:.85rem;color:var(--muted);margin-bottom:.4rem"><span>Dibayar</span><span>Rp {{ number_format($transaksi->total_bayar,0,',','.') }}</span></div>
        <div style="display:flex;justify-content:space-between;font-size:.95rem;font-weight:700;padding-top:.5rem;border-top:1px solid var(--br)"><span>Kembalian</span><span style="color:var(--grn)">Rp {{ number_format($transaksi->kembalian,0,',','.') }}</span></div>
      </div>
    </div>
  </div>
</div>
@endsection
