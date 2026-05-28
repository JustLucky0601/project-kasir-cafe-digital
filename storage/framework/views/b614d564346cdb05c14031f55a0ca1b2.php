<?php $__env->startSection('title','Edit Produk'); ?>
<?php $__env->startSection('breadcrumb','Menu & Produk / Edit'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:780px">
  <form method="POST" action="<?php echo e(route('admin.products.update',$produk)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div class="g2">
      <div>
        <div class="card" style="margin-bottom:1.25rem">
          <div class="card-h"><span class="card-t">Informasi Produk</span></div>
          <div class="card-b">
            <div class="fg"><label class="fl">Nama Produk *</label><input type="text" name="nama_produk" class="fc" value="<?php echo e(old('nama_produk',$produk->nama_produk)); ?>" required><?php $__errorArgs = ['nama_produk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="fg"><label class="fl">Kategori *</label>
              <select name="kategori_id" class="fc" required>
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k->id); ?>" <?php echo e(old('kategori_id',$produk->kategori_id)==$k->id ? 'selected':''); ?>><?php echo e($k->icon); ?> <?php echo e($k->nama_kategori); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
              <div class="fg"><label class="fl">Harga (Rp) *</label><input type="number" name="harga" class="fc" value="<?php echo e(old('harga',$produk->harga)); ?>" min="0" required></div>
              <div class="fg"><label class="fl">Stok *</label><input type="number" name="stok" class="fc" value="<?php echo e(old('stok',$produk->stok)); ?>" min="0" required></div>
            </div>
            <div class="fg"><label class="fl">Deskripsi</label><textarea name="deskripsi" class="fc"><?php echo e(old('deskripsi',$produk->deskripsi)); ?></textarea></div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br)">
              <input type="checkbox" name="tersedia" id="tersedia" value="1" <?php echo e(old('tersedia',$produk->tersedia) ? 'checked':''); ?> style="accent-color:var(--gold);width:15px;height:15px">
              <label for="tersedia" style="font-size:.85rem;cursor:pointer">Produk aktif & tersedia di kasir</label>
            </div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br);margin-top:.6rem">
              <input type="checkbox" name="best_seller" id="best_seller" value="1" <?php echo e(old('best_seller',$produk->best_seller) ? 'checked':''); ?> style="accent-color:var(--gold);width:15px;height:15px">
              <label for="best_seller" style="font-size:.85rem;cursor:pointer;color:var(--muted)">Tandai sebagai <strong style="color:var(--gold)">Best Seller</strong></label>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="card">
          <div class="card-h"><span class="card-t">Foto Produk</span></div>
          <div class="card-b">
            <div id="preview-wrap" onclick="document.getElementById('foto-inp').click()" style="width:100%;aspect-ratio:1;border-radius:10px;border:2px dashed var(--br);display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;background:var(--dark);margin-bottom:.9rem">
              <?php if($produk->foto): ?>
              <img id="preview-img" src="<?php echo e(asset('storage/products/'.$produk->foto)); ?>" style="width:100%;height:100%;object-fit:cover">
              <div id="preview-ph" style="display:none;text-align:center;padding:2rem"><div style="font-size:2.5rem">📷</div><div style="font-size:.8rem;color:var(--muted);margin-top:.4rem">Klik untuk ganti foto</div></div>
              <?php else: ?>
              <img id="preview-img" src="" style="width:100%;height:100%;object-fit:cover;display:none">
              <div id="preview-ph" style="text-align:center;padding:2rem"><div style="font-size:2.5rem">📷</div><div style="font-size:.8rem;color:var(--muted);margin-top:.4rem">Klik untuk upload foto</div></div>
              <?php endif; ?>
            </div>
            <input type="file" name="foto" id="foto-inp" accept="image/*" style="display:none" onchange="previewFoto(this)">
            <button type="button" class="btn btn-o" style="width:100%;justify-content:center;margin-bottom:.65rem" onclick="document.getElementById('foto-inp').click()">🖼️ <?php echo e($produk->foto ? 'Ganti Foto' : 'Upload Foto'); ?></button>
            <?php if($produk->foto): ?>
            <div style="display:flex;align-items:center;gap:.5rem;padding:.6rem;background:rgba(224,82,82,.07);border:1px solid rgba(224,82,82,.2);border-radius:7px">
              <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1" style="accent-color:var(--red);width:14px;height:14px" onchange="toggleHapus(this)">
              <label for="hapus_foto" style="font-size:.78rem;color:var(--red);cursor:pointer">Hapus foto saat ini</label>
            </div>
            <?php endif; ?>
            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe" style="margin-top:.4rem"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
      </div>
    </div>
    <div style="display:flex;gap:.75rem;margin-top:.5rem">
      <button type="submit" class="btn btn-p">💾 Perbarui Produk</button>
      <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-o">Batal</a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function previewFoto(inp){
  if(inp.files&&inp.files[0]){
    const r=new FileReader();
    r.onload=e=>{document.getElementById('preview-img').src=e.target.result;document.getElementById('preview-img').style.display='block';document.getElementById('preview-ph').style.display='none'};
    r.readAsDataURL(inp.files[0]);
    const cb=document.getElementById('hapus_foto');if(cb)cb.checked=false;
  }
}
function toggleHapus(cb){document.getElementById('preview-img').style.opacity=cb.checked?'0.3':'1'}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>