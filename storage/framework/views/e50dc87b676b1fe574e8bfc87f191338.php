<?php $__env->startSection('title','Kategori Menu'); ?>
<?php $__env->startSection('breadcrumb','Kelola kategori produk'); ?>
<?php $__env->startSection('content'); ?>
<div class="g2" style="align-items:start">
  <div class="card">
    <div class="card-h"><span class="card-t">Semua Kategori (<?php echo e($kategoris->count()); ?>)</span></div>
    <div class="tw">
      <table>
        <thead><tr><th>Icon</th><th>Nama Kategori</th><th>Produk</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="font-size:1.4rem;text-align:center"><?php echo e($k->icon); ?></td>
            <td style="font-weight:500"><?php echo e($k->nama_kategori); ?></td>
            <td><span class="badge bi"><?php echo e($k->produks_count); ?> produk</span></td>
            <td>
              <div style="display:flex;gap:.35rem">
                <button onclick="openEdit(<?php echo e($k->id); ?>,'<?php echo e($k->nama_kategori); ?>','<?php echo e($k->icon); ?>')" class="btn btn-e btn-sm">Edit</button>
                <form method="POST" action="<?php echo e(route('admin.categories.destroy',$k)); ?>" onsubmit="return confirm('Hapus kategori ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-d btn-sm">Hapus</button></form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="4" style="text-align:center;color:var(--muted);padding:2rem">Belum ada kategori</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card" id="form-card">
    <div class="card-h"><span class="card-t" id="form-title">➕ Tambah Kategori Baru</span></div>
    <div class="card-b">
      <form method="POST" id="kat-form" action="<?php echo e(route('admin.categories.store')); ?>">
        <?php echo csrf_field(); ?><div id="method-slot"></div>
        <div class="fg"><label class="fl">Icon Emoji *</label><input type="text" name="icon" id="inp-icon" class="fc" placeholder="☕" maxlength="5" required><?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><div style="font-size:.7rem;color:var(--muted);margin-top:.3rem">Contoh: ☕ 🧋 🍽️ 🥐 🍰</div></div>
        <div class="fg"><label class="fl">Nama Kategori *</label><input type="text" name="nama_kategori" id="inp-nama" class="fc" placeholder="cth: Kopi" required><?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div style="display:flex;gap:.5rem">
          <button type="submit" class="btn btn-p" id="btn-sub">Simpan</button>
          <button type="button" class="btn btn-o" onclick="resetForm()" id="btn-batal" style="display:none">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
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
  document.getElementById('kat-form').action='<?php echo e(route("admin.categories.store")); ?>';
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>