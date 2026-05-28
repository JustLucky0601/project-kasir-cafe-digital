@extends('layouts.admin')
@section('title','Menu & Produk')
@section('breadcrumb','Kelola semua item menu kafe')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem">
  <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari produk..." class="fc" style="width:200px">
    <select name="kategori" class="fc" style="width:150px">
      <option value="">Semua Kategori</option>
      @foreach($kategoris as $k)<option value="{{ $k->id }}" {{ request('kategori')==$k->id ? 'selected':'' }}>{{ $k->icon }} {{ $k->nama_kategori }}</option>@endforeach
    </select>
    <button type="submit" class="btn btn-o">Filter</button>
    @if(request('search') || request('kategori'))<a href="{{ route('admin.products.index') }}" class="btn btn-o">Reset</a>@endif
  </form>
  <a href="{{ route('admin.products.create') }}" class="btn btn-p">+ Tambah Produk</a>
</div>
<div class="card">
  <div class="card-h"><span class="card-t">Daftar Produk ({{ $produks->total() }})</span></div>
  <div class="tw">
    <table>
      <thead><tr><th>Foto</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Label</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($produks as $p)
        <tr>
          <td>
            @if($p->foto)
            <img src="{{ asset('storage/products/'.$p->foto) }}" style="width:46px;height:46px;object-fit:cover;border-radius:8px;border:1px solid var(--br)">
            @else
            <div style="width:46px;height:46px;border-radius:8px;background:var(--br);display:flex;align-items:center;justify-content:center;font-size:1.2rem">{{ $p->kategori->icon }}</div>
            @endif
          </td>
          <td>
            <div style="font-weight:600">{{ $p->nama_produk }}</div>
            @if($p->deskripsi)<div style="font-size:.72rem;color:var(--muted);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p->deskripsi }}</div>@endif
          </td>
          <td><span class="badge bi">{{ $p->kategori->icon }} {{ $p->kategori->nama_kategori }}</span></td>
          <td style="font-weight:700;color:var(--gold)">Rp {{ number_format($p->harga,0,',','.') }}</td>
          <td>
            <span class="badge {{ $p->stok<=0 ? 'bd2' : ($p->stok<=5 ? 'bw' : 'bs') }}">
              {{ $p->stok<=0 ? 'Habis' : $p->stok.' pcs' }}
            </span>
          </td>
          <td><span class="badge {{ $p->tersedia ? 'bs' : 'bd2' }}">{{ $p->tersedia ? '● Aktif' : '○ Nonaktif' }}</span></td>
          <td>
            @if($p->best_seller)
              <span class="badge bs">Best Seller</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:.35rem">
              <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-e btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.products.destroy',$p) }}" onsubmit="return confirm('Hapus produk ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-d btn-sm">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:3rem">Tidak ada produk ditemukan</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($produks->hasPages())
  <div style="padding:1rem 1.4rem;border-top:1px solid var(--br);display:flex;justify-content:flex-end">
    {{ $produks->withQueryString()->links('pagination::simple-default') }}
  </div>
  @endif
</div>
@endsection
