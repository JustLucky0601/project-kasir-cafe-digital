@extends('layouts.admin')
@section('title','Kategori Menu')
@section('breadcrumb','Kelola kategori produk')
@section('content')
<div class="g2" style="align-items:start">
  <div class="card">
    <div class="card-h"><span class="card-t">Semua Kategori ({{ $kategoris->count() }})</span></div>
    <div class="tw">
      <table>
        <thead><tr><th>Icon</th><th>Nama Kategori</th><th>Produk</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($kategoris as $k)
          <tr>
            <td style="font-size:1.4rem;text-align:center">{{ $k->icon }}</td>
            <td style="font-weight:500">{{ $k->nama_kategori }}</td>
            <td><span class="badge bi">{{ $k->produks_count }} produk</span></td>
            <td>
              <div style="display:flex;gap:.35rem">
                <button onclick="openEdit({{ $k->id }},'{{ $k->nama_kategori }}','{{ $k->icon }}')" class="btn btn-e btn-sm">Edit</button>
                <form method="POST" action="{{ route('admin.categories.destroy',$k) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button type="submit" class="btn btn-d btn-sm">Hapus</button></form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:2rem">Belum ada kategori</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="card" id="form-card">
    <div class="card-h"><span class="card-t" id="form-title">➕ Tambah Kategori Baru</span></div>
    <div class="card-b">
      <form method="POST" id="kat-form" action="{{ route('admin.categories.store') }}">
        @csrf<div id="method-slot"></div>
        <div class="fg"><label class="fl">Icon Emoji *</label><input type="text" name="icon" id="inp-icon" class="fc" placeholder="☕" maxlength="5" required>@error('icon')<div class="fe">{{ $message }}</div>@enderror<div style="font-size:.7rem;color:var(--muted);margin-top:.3rem">Contoh: ☕ 🧋 🍽️ 🥐 🍰</div></div>
        <div class="fg"><label class="fl">Nama Kategori *</label><input type="text" name="nama_kategori" id="inp-nama" class="fc" placeholder="cth: Kopi" required>@error('nama_kategori')<div class="fe">{{ $message }}</div>@enderror</div>
        <div style="display:flex;gap:.5rem">
          <button type="submit" class="btn btn-p" id="btn-sub">Simpan</button>
          <button type="button" class="btn btn-o" onclick="resetForm()" id="btn-batal" style="display:none">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function openEdit(id,nama,icon){
  document.getElementById('form-title').textContent='✏️ Edit Kategori';
  document.getElementById('inp-nama').value=nama;
  document.getElementById('inp-icon').value=icon;
  document.getElementById('btn-sub').textContent='Perbarui';
  document.getElementById('btn-batal').style.display='inline-flex';
  document.getElementById('kat-form').action='/admin/categories/'+id;
  document.getElementById('method-slot').innerHTML='<input type="hidden" name="_method" value="PUT">';
  document.getElementById('form-card').scrollIntoView({behavior:'smooth'});
}
function resetForm(){
  document.getElementById('form-title').textContent='➕ Tambah Kategori Baru';
  document.getElementById('inp-nama').value='';document.getElementById('inp-icon').value='';
  document.getElementById('btn-sub').textContent='Simpan';
  document.getElementById('btn-batal').style.display='none';
  document.getElementById('method-slot').innerHTML='';
  document.getElementById('kat-form').action='{{ route("admin.categories.store") }}';
}
</script>
@endpush
