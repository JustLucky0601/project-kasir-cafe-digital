<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Nota <?php echo e($transaksi->nomor_nota); ?></title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
@page{size:80mm auto;margin:0}
body{font-family:'Courier New',monospace;font-size:11px;background:#fff;color:#000;width:80mm;padding:4mm}
.center{text-align:center}
.bold{font-weight:bold}
.dline{border-top:2px solid #000;margin:5px 0}
.sline{border-top:1px dashed #999;margin:4px 0}
.row{display:flex;justify-content:space-between;margin:2px 0;font-size:10px}
.item{margin:3px 0}
.iname{font-weight:bold;font-size:11px}
.idet{display:flex;justify-content:space-between;font-size:9.5px;color:#333}
.grand{font-size:14px;font-weight:900}
.kemb{font-size:13px;font-weight:700}
.footer{text-align:center;font-size:9px;color:#555;margin-top:6px;line-height:1.6}
.ty{font-size:12px;font-weight:bold;margin-bottom:2px}
.no-print{display:block;margin-bottom:12px;text-align:center}
@media print{.no-print{display:none}body{width:80mm}}
</style>
</head>
<body>
<div class="no-print" style="display:flex;justify-content:center;gap:8px;padding:12px">
  <button onclick="window.print()" style="padding:8px 20px;background:#C9A84C;color:#000;border:none;border-radius:6px;font-weight:bold;cursor:pointer;font-size:13px">🖨️ Cetak Nota</button>
  <button onclick="window.close()" style="padding:8px 16px;background:#eee;color:#333;border:none;border-radius:6px;cursor:pointer;font-size:13px">✕ Tutup</button>
</div>

<div class="center">
  <div style="font-size:16px;font-weight:900;letter-spacing:2px">☕ BrewLux</div>
  <div style="font-size:9px;letter-spacing:1px;color:#555">CAFÉ & BISTRO</div>
  <div style="font-size:8px;color:#666;margin-top:2px">Jl. Merdeka No. 88, Balikpapan</div>
  <div style="font-size:8px;color:#666">Telp: (0542) 123-4567</div>
</div>

<div class="dline" style="margin:6px 0"></div>

<div class="row"><span>No. Nota</span><span class="bold"><?php echo e($transaksi->nomor_nota); ?></span></div>
<div class="row"><span>Tanggal</span><span><?php echo e($transaksi->tanggal_transaksi->format('d/m/Y H:i:s')); ?></span></div>
<div class="row"><span>Kasir</span><span><?php echo e($transaksi->user->nama_lengkap ?? $transaksi->user->username); ?></span></div>
<div class="row"><span>Metode</span><span class="bold"><?php echo e(strtoupper($transaksi->metode_bayar)); ?></span></div>

<div class="sline"></div>

<?php $__currentLoopData = $transaksi->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="item">
  <div class="iname"><?php echo e($d->produk->nama_produk); ?></div>
  <div class="idet">
    <span><?php echo e($d->jumlah_beli); ?> x Rp <?php echo e(number_format($d->harga_satuan,0,',','.')); ?></span>
    <span>Rp <?php echo e(number_format($d->subtotal,0,',','.')); ?></span>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="sline"></div>

<div class="row"><span>Subtotal</span><span>Rp <?php echo e(number_format($transaksi->total_harga,0,',','.')); ?></span></div>
<div class="row"><span>Diskon</span><span>Rp 0</span></div>
<div class="dline"></div>
<div class="row grand"><span>TOTAL</span><span>Rp <?php echo e(number_format($transaksi->total_harga,0,',','.')); ?></span></div>
<div class="row" style="margin-top:3px"><span>Bayar (<?php echo e(strtoupper($transaksi->metode_bayar)); ?>)</span><span>Rp <?php echo e(number_format($transaksi->total_bayar,0,',','.')); ?></span></div>
<div class="row kemb"><span>KEMBALIAN</span><span>Rp <?php echo e(number_format($transaksi->kembalian,0,',','.')); ?></span></div>

<div class="dline" style="margin:6px 0"></div>

<div class="footer">
  <div class="ty">Terima Kasih! ☕</div>
  <div>Selamat menikmati sajian BrewLux</div>
  <div>Simpan struk sebagai bukti pembelian</div>
  <div style="margin-top:4px;font-size:8px">**** STRUK INI BUKTI PEMBAYARAN SAH ****</div>
</div>
<div style="margin-bottom:8mm"></div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/kasir/nota.blade.php ENDPATH**/ ?>