@extends('layouts.admin')
@section('title','Tambah Produk')
@section('breadcrumb','Menu & Produk / Tambah Baru')
@section('content')
<div style="max-width:780px">
  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="g2">
      <div>
        <div class="card" style="margin-bottom:1.25rem">
          <div class="card-h"><span class="card-t">Informasi Produk</span></div>
          <div class="card-b">
            <div class="fg"><label class="fl">Nama Produk *</label><input type="text" name="nama_produk" class="fc" value="{{ old('nama_produk') }}" placeholder="cth: Cappuccino Velvet" required>@error('nama_produk')<div class="fe">{{ $message }}</div>@enderror</div>
            <div class="fg"><label class="fl">Kategori *</label>
              <select name="kategori_id" class="fc" required>
                <option value="">— Pilih Kategori —</option>
                @foreach($kategoris as $k)<option value="{{ $k->id }}" {{ old('kategori_id')==$k->id ? 'selected':'' }}>{{ $k->icon }} {{ $k->nama_kategori }}</option>@endforeach
              </select>@error('kategori_id')<div class="fe">{{ $message }}</div>@enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
              <div class="fg"><label class="fl">Harga (Rp) *</label><input type="number" name="harga" class="fc" value="{{ old('harga') }}" placeholder="25000" min="0" required>@error('harga')<div class="fe">{{ $message }}</div>@enderror</div>
              <div class="fg"><label class="fl">Stok *</label><input type="number" name="stok" class="fc" value="{{ old('stok',0) }}" min="0" required>@error('stok')<div class="fe">{{ $message }}</div>@enderror</div>
            </div>
            <div class="fg"><label class="fl">Deskripsi</label><textarea name="deskripsi" class="fc" placeholder="Deskripsi singkat produk...">{{ old('deskripsi') }}</textarea></div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br)">
              <input type="checkbox" name="tersedia" id="tersedia" value="1" checked style="accent-color:var(--gold);width:15px;height:15px">
              <label for="tersedia" style="font-size:.85rem;cursor:pointer">Produk aktif & tersedia di kasir</label>
            </div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br);margin-top:.6rem">
              <input type="checkbox" name="best_seller" id="best_seller" value="1" {{ old('best_seller') ? 'checked':'' }} style="accent-color:var(--gold);width:15px;height:15px">
              <label for="best_seller" style="font-size:.85rem;cursor:pointer;color:var(--muted)">Tandai sebagai <strong style="color:var(--gold)">Best Seller</strong></label>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="card">
          <div class="card-h"><span class="card-t">Foto Produk</span></div>
          <div class="card-b">
            <div id="preview-wrap" onclick="document.getElementById('foto-inp').click()" style="width:100%;aspect-ratio:1;border-radius:10px;border:2px dashed var(--br);display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;background:var(--dark);transition:border-color .2s;margin-bottom:.9rem">
              <img id="preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
              <div id="preview-ph" style="text-align:center;padding:2rem">
                <div style="font-size:2.5rem;margin-bottom:.5rem">📷</div>
                <div style="font-size:.8rem;color:var(--muted)">Klik untuk upload foto</div>
                <div style="font-size:.7rem;color:var(--muted);margin-top:.25rem">JPG, PNG, WEBP · maks 2MB</div>
              </div>
            </div>
            <input type="file" name="foto" id="foto-inp" accept="image/*" style="display:none" onchange="previewFoto(this)">
            <button type="button" class="btn btn-o" style="width:100%;justify-content:center" onclick="document.getElementById('foto-inp').click()">🖼️ Pilih Foto</button>
            @error('foto')<div class="fe" style="margin-top:.4rem">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>
    </div>
    <div style="display:flex;gap:.75rem;margin-top:.5rem">
      <button type="submit" class="btn btn-p">💾 Simpan Produk</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-o">Batal</a>
    </div>
  </form>
</div>
@endsection
@push('scripts')
<script>
function previewFoto(inp){
  if(inp.files&&inp.files[0]){
    const r=new FileReader();
    r.onload=e=>{document.getElementById('preview-img').src=e.target.result;document.getElementById('preview-img').style.display='block';document.getElementById('preview-ph').style.display='none'};
    r.readAsDataURL(inp.files[0]);
  }
}
</script>
@endpush
