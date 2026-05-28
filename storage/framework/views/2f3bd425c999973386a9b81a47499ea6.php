<?php $__env->startSection('title','Menu & Produk'); ?>
<?php $__env->startSection('breadcrumb','Kelola semua item menu kafe'); ?>
<?php $__env->startSection('content'); ?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem">
  <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="🔍 Cari produk..." class="fc" style="width:200px">
    <select name="kategori" class="fc" style="width:150px">
      <option value="">Semua Kategori</option>
      <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori')==$k->id ? 'selected':''); ?>><?php echo e($k->icon); ?> <?php echo e($k->nama_kategori); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button type="submit" class="btn btn-o">Filter</button>
    <?php if(request('search') || request('kategori')): ?><a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-o">Reset</a><?php endif; ?>
  </form>
  <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-p">+ Tambah Produk</a>
</div>
<div class="card">
  <div class="card-h"><span class="card-t">Daftar Produk (<?php echo e($produks->total()); ?>)</span></div>
  <div class="tw">
    <table>
      <thead><tr><th>Foto</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Label</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td>
            <?php if($p->foto): ?>
            <img src="<?php echo e(asset('storage/products/'.$p->foto)); ?>" style="width:46px;height:46px;object-fit:cover;border-radius:8px;border:1px solid var(--br)">
            <?php else: ?>
            <div style="width:46px;height:46px;border-radius:8px;background:var(--br);display:flex;align-items:center;justify-content:center;font-size:1.2rem"><?php echo e($p->kategori->icon); ?></div>
            <?php endif; ?>
          </td>
          <td>
            <div style="font-weight:600"><?php echo e($p->nama_produk); ?></div>
            <?php if($p->deskripsi): ?><div style="font-size:.72rem;color:var(--muted);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?php echo e($p->deskripsi); ?></div><?php endif; ?>
          </td>
          <td><span class="badge bi"><?php echo e($p->kategori->icon); ?> <?php echo e($p->kategori->nama_kategori); ?></span></td>
          <td style="font-weight:700;color:var(--gold)">Rp <?php echo e(number_format($p->harga,0,',','.')); ?></td>
          <td>
            <span class="badge <?php echo e($p->stok<=0 ? 'bd2' : ($p->stok<=5 ? 'bw' : 'bs')); ?>">
              <?php echo e($p->stok<=0 ? 'Habis' : $p->stok.' pcs'); ?>

            </span>
          </td>
          <td><span class="badge <?php echo e($p->tersedia ? 'bs' : 'bd2'); ?>"><?php echo e($p->tersedia ? '● Aktif' : '○ Nonaktif'); ?></span></td>
          <td>
            <?php if($p->best_seller): ?>
              <span class="badge bs">Best Seller</span>
            <?php endif; ?>
          </td>
          <td>
            <div style="display:flex;gap:.35rem">
              <a href="<?php echo e(route('admin.products.edit',$p)); ?>" class="btn btn-e btn-sm">Edit</a>
              <form method="POST" action="<?php echo e(route('admin.products.destroy',$p)); ?>" onsubmit="return confirm('Hapus produk ini?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-d btn-sm">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:3rem">Tidak ada produk ditemukan</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if($produks->hasPages()): ?>
  <div style="padding:1rem 1.4rem;border-top:1px solid var(--br);display:flex;justify-content:flex-end">
    <?php echo e($produks->withQueryString()->links('pagination::simple-default')); ?>

  </div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/products/index.blade.php ENDPATH**/ ?>