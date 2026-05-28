<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>BrewLux POS — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--gold:#C9A84C;--gold-l:#E8C97A;--dark:#0D0D0D;--surface:#1A1A1A;--border:#2E2E2E;--text:#F0EDE8;--muted:#8A8478}
body{background:var(--dark);font-family:'DM Sans',sans-serif;min-height:100vh;display:grid;grid-template-columns:1fr 1fr}
.left{position:relative;background:linear-gradient(135deg,#1A0E00,#0D0D0D 50%,#1A1205);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:4rem;overflow:hidden}
.left::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 60% 40% at 30% 40%,rgba(201,168,76,.12),transparent)}
.cup{font-size:4rem;margin-bottom:1.5rem;filter:drop-shadow(0 0 20px rgba(201,168,76,.4));animation:fl 4s ease-in-out infinite}
@keyframes fl{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
.bn{font-family:'Playfair Display',serif;font-size:3rem;color:var(--gold);letter-spacing:2px}
.bt{font-size:.85rem;color:var(--muted);letter-spacing:4px;text-transform:uppercase;margin-top:.5rem}
.bd{width:60px;height:1px;background:linear-gradient(90deg,transparent,var(--gold),transparent);margin:2rem auto}
.desc{color:var(--muted);font-size:.9rem;text-align:center;line-height:1.7;max-width:280px;position:relative}
.right{display:flex;align-items:center;justify-content:center;padding:4rem;background:var(--surface)}
.card{width:100%;max-width:400px}
h1{font-family:'Playfair Display',serif;font-size:1.8rem;color:var(--text);margin-bottom:.3rem}
.sub{color:var(--muted);font-size:.9rem;margin-bottom:2rem}
.err-box{background:rgba(220,38,38,.1);border:1px solid rgba(220,38,38,.3);color:#FCA5A5;padding:.85rem 1rem;border-radius:8px;font-size:.875rem;margin-bottom:1.25rem}
.fg{margin-bottom:1.25rem}
.fg label{display:block;font-size:.75rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.45rem}
.fg input{width:100%;background:var(--dark);border:1px solid var(--border);border-radius:8px;padding:.8rem 1rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:.95rem;outline:none;transition:border-color .2s,box-shadow .2s}
.fg input:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.12)}
.fg input::placeholder{color:#3D3D3D}
.fe{color:#FCA5A5;font-size:.78rem;margin-top:.35rem}
.rem{display:flex;align-items:center;gap:.5rem;margin-bottom:1.75rem}
.rem input{accent-color:var(--gold);width:14px;height:14px}
.rem label{color:var(--muted);font-size:.85rem;cursor:pointer}
.btn{width:100%;background:linear-gradient(135deg,var(--gold),var(--gold-l));border:none;border-radius:8px;padding:.9rem;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:700;color:var(--dark);cursor:pointer;letter-spacing:.5px;transition:opacity .2s,transform .1s}
.btn:hover{opacity:.9;transform:translateY(-1px)}
.foot{text-align:center;margin-top:2rem;color:var(--muted);font-size:.75rem}
@media(max-width:768px){body{grid-template-columns:1fr}.left{display:none}}
</style>
</head>
<body>
<div class="left">
  <span class="cup">☕</span>
  <div class="bn">BrewLux</div>
  <div class="bt">Café & Bistro</div>
  <div class="bd"></div>
  <p class="desc">Sistem Point of Sale premium untuk mengelola transaksi kafe Anda dengan elegan dan efisien.</p>
</div>
<div class="right">
  <div class="card">
    <h1>Selamat Datang</h1>
    <p class="sub">Masuk ke sistem kasir digital BrewLux</p>
    <?php if($errors->any()): ?><div class="err-box"><?php echo e($errors->first('username')); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('login.post')); ?>">
      <?php echo csrf_field(); ?>
      <div class="fg">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Masukkan username" autofocus autocomplete="username">
        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="fe"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="fg">
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan password" autocomplete="current-password">
      </div>
      <div class="rem">
        <input type="checkbox" name="remember" id="rem">
        <label for="rem">Ingat saya</label>
      </div>
      <button type="submit" class="btn">Masuk ke Sistem</button>
    </form>
    <div class="foot">BrewLux POS &copy; <?php echo e(date('Y')); ?></div>
  </div>
</div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/auth/login.blade.php ENDPATH**/ ?>