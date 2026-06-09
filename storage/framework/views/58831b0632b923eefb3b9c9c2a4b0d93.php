<?php $__env->startSection('title','Jurnal Transaksi'); ?>
<?php $__env->startSection('breadcrumb','Histori semua penjualan'); ?>
<?php $__env->startSection('content'); ?>
<div class="card" style="padding:1.2rem 1.4rem;margin-bottom:1.25rem">
  <form method="GET" style="display:flex;gap:.6rem;flex-wrap:wrap;align-items:flex-end">
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Dari</div><input type="date" name="dari" value="<?php echo e(request('dari')); ?>" class="fc" style="width:148px"></div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Sampai</div><input type="date" name="sampai" value="<?php echo e(request('sampai')); ?>" class="fc" style="width:148px"></div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Kasir</div>
      <select name="kasir" class="fc" style="width:140px"><option value="">Semua Kasir</option><?php $__currentLoopData = $kasirs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k->id); ?>" <?php echo e(request('kasir')==$k->id ? 'selected':''); ?>><?php echo e($k->nama_lengkap); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
    </div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">Metode</div>
      <select name="metode" class="fc" style="width:120px"><option value="">Semua</option><option value="tunai" <?php echo e(request('metode')=='tunai'?'selected':''); ?>>Tunai</option><option value="qris" <?php echo e(request('metode')=='qris'?'selected':''); ?>>QRIS</option><option value="transfer" <?php echo e(request('metode')=='transfer'?'selected':''); ?>>Transfer</option></select>
    </div>
    <div><div style="font-size:.62rem;color:var(--muted);margin-bottom:.3rem;text-transform:uppercase;letter-spacing:.5px">No. Nota</div><input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="TRX-..." class="fc" style="width:150px"></div>
    <button type="submit" class="btn btn-p">Filter</button>
    <?php if(request()->hasAny(['dari','sampai','kasir','metode','search'])): ?><a href="<?php echo e(route('admin.transactions.index')); ?>" class="btn btn-o">Reset</a><?php endif; ?>
  </form>
</div>
<div class="card">
  <div class="card-h">
    <span class="card-t">Jurnal Penjualan (<?php echo e($transaksis->total()); ?> entri)</span>
    <div style="font-size:.85rem;color:var(--gold);font-weight:700">Total: Rp <?php echo e(number_format($totalPendapatan,0,',','.')); ?></div>
  </div>
  <div class="tw">
    <table>
      <thead><tr><th>No. Nota</th><th>Tanggal</th><th>Kasir</th><th>Total</th><th>Bayar</th><th>Kembalian</th><th>Metode</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td style="font-family:monospace;font-size:.75rem;font-weight:700;color:var(--gold)"><?php echo e($t->nomor_nota); ?></td>
          <td style="font-size:.78rem;color:var(--muted)"><?php echo e($t->tanggal_transaksi->format('d/m/Y H:i')); ?></td>
          <td style="font-size:.83rem"><?php echo e($t->user->nama_lengkap ?? $t->user->username); ?></td>
          <td style="font-weight:700">Rp <?php echo e(number_format($t->total_harga,0,',','.')); ?></td>
          <td style="color:var(--muted)">Rp <?php echo e(number_format($t->total_bayar,0,',','.')); ?></td>
          <td style="color:var(--grn);font-weight:600">Rp <?php echo e(number_format($t->kembalian,0,',','.')); ?></td>
          <td>
            <?php if($t->metode_bayar=='tunai'): ?><span class="badge bs">💵 Tunai</span>
            <?php elseif($t->metode_bayar=='qris'): ?><span class="badge bp">📱 QRIS</span>
            <?php else: ?><span class="badge bi">🏦 Transfer</span><?php endif; ?>
          </td>
          <td>
            <div style="display:flex;gap:.3rem">
              <a href="<?php echo e(route('admin.transactions.show',$t)); ?>" class="btn btn-o btn-sm">Detail</a>
              <form method="POST" action="<?php echo e(route('admin.transactions.destroy',$t)); ?>" onsubmit="return confirm('Hapus transaksi ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-d btn-sm">✕</button></form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:3rem">Tidak ada transaksi</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if($transaksis->hasPages()): ?>
  <div style="padding:1rem 1.4rem;border-top:1px solid var(--br)"><?php echo e($transaksis->withQueryString()->links('pagination::simple-default')); ?></div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>