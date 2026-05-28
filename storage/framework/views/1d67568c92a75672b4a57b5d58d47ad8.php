<?php $__env->startSection('title','Tambah Produk'); ?>
<?php $__env->startSection('breadcrumb','Menu & Produk / Tambah Baru'); ?>
<?php $__env->startSection('content'); ?>
<div style="max-width:780px">
  <form method="POST" action="<?php echo e(route('admin.products.store')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="g2">
      <div>
        <div class="card" style="margin-bottom:1.25rem">
          <div class="card-h"><span class="card-t">Informasi Produk</span></div>
          <div class="card-b">
            <div class="fg"><label class="fl">Nama Produk *</label><input type="text" name="nama_produk" class="fc" value="<?php echo e(old('nama_produk')); ?>" placeholder="cth: Cappuccino Velvet" required><?php $__errorArgs = ['nama_produk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            <div class="fg"><label class="fl">Kategori *</label>
              <select name="kategori_id" class="fc" required>
                <option value="">— Pilih Kategori —</option>
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k->id); ?>" <?php echo e(old('kategori_id')==$k->id ? 'selected':''); ?>><?php echo e($k->icon); ?> <?php echo e($k->nama_kategori); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select><?php $__errorArgs = ['kategori_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
              <div class="fg"><label class="fl">Harga (Rp) *</label><input type="number" name="harga" class="fc" value="<?php echo e(old('harga')); ?>" placeholder="25000" min="0" required><?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
              <div class="fg"><label class="fl">Stok *</label><input type="number" name="stok" class="fc" value="<?php echo e(old('stok',0)); ?>" min="0" required><?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
            </div>
            <div class="fg"><label class="fl">Deskripsi</label><textarea name="deskripsi" class="fc" placeholder="Deskripsi singkat produk..."><?php echo e(old('deskripsi')); ?></textarea></div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br)">
              <input type="checkbox" name="tersedia" id="tersedia" value="1" checked style="accent-color:var(--gold);width:15px;height:15px">
              <label for="tersedia" style="font-size:.85rem;cursor:pointer">Produk aktif & tersedia di kasir</label>
            </div>
            <div style="display:flex;align-items:center;gap:.6rem;padding:.7rem;background:var(--dark);border-radius:8px;border:1px solid var(--br);margin-top:.6rem">
              <input type="checkbox" name="best_seller" id="best_seller" value="1" <?php echo e(old('best_seller') ? 'checked':''); ?> style="accent-color:var(--gold);width:15px;height:15px">
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
      <button type="submit" class="btn btn-p">💾 Simpan Produk</button>
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
  }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/products/create.blade.php ENDPATH**/ ?>