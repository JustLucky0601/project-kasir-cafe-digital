<?php $__env->startSection('title','Kelola User'); ?>
<?php $__env->startSection('breadcrumb','Manajemen akun kasir dan admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="g2" style="align-items:start">
  <div class="card">
    <div class="card-h"><span class="card-t">Daftar User (<?php echo e($users->count()); ?>)</span></div>
    <div class="tw">
      <table>
        <thead><tr><th>Nama</th><th>Username</th><th>Role</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td style="font-weight:500"><?php echo e($u->nama_lengkap); ?></td>
            <td style="font-family:monospace;font-size:.8rem;color:var(--muted)"><?php echo e($u->username); ?></td>
            <td><span class="badge <?php echo e($u->role=='admin' ? 'bw' : 'bi'); ?>"><?php echo e($u->role=='admin' ? '👑 Admin' : '🖥️ Kasir'); ?></span></td>
            <td>
              <?php if($u->id !== auth()->id()): ?>
              <form method="POST" action="<?php echo e(route('admin.users.destroy',$u)); ?>" onsubmit="return confirm('Hapus user ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="btn btn-d btn-sm">Hapus</button></form>
              <?php else: ?><span style="font-size:.75rem;color:var(--muted)">Akun aktif</span><?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-h"><span class="card-t">➕ Tambah User Baru</span></div>
    <div class="card-b">
      <form method="POST" action="<?php echo e(route('admin.users.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="fg"><label class="fl">Nama Lengkap *</label><input type="text" name="nama_lengkap" class="fc" placeholder="cth: Siti Rahayu" required><?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="fg"><label class="fl">Username *</label><input type="text" name="username" class="fc" placeholder="cth: kasir2" required><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="fg"><label class="fl">Password *</label><input type="password" name="password" class="fc" placeholder="Min. 6 karakter" required><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
        <div class="fg"><label class="fl">Role *</label>
          <select name="role" class="fc" required><option value="kasir">🖥️ Kasir</option><option value="admin">👑 Admin</option></select>
        </div>
        <button type="submit" class="btn btn-p">Simpan User</button>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/users.blade.php ENDPATH**/ ?>