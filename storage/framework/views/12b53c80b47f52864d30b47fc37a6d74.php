<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('breadcrumb','Ringkasan operasional hari ini'); ?>
<?php $__env->startSection('content'); ?>
<div class="g4" style="margin-bottom:1.5rem">
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid var(--gold)">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Pendapatan Hari Ini</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--gold)">Rp <?php echo e(number_format($totalPendapatan,0,',','.')); ?></div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Total omzet <?php echo e(now()->format('d/m/Y')); ?></div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid #409CFF">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Transaksi Hari Ini</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:#409CFF"><?php echo e($totalTransaksi); ?></div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Nota selesai dibayar</div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid var(--grn)">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Total Produk</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--grn)"><?php echo e($totalProduk); ?></div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Item terdaftar di menu</div>
  </div>
  <div class="card" style="padding:1.2rem 1.4rem;border-left:3px solid <?php echo e($stokRendah > 0 ? 'var(--red)' : 'var(--grn)'); ?>">
    <div style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem">Stok Rendah</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.5rem;color:<?php echo e($stokRendah > 0 ? 'var(--red)' : 'var(--grn)'); ?>"><?php echo e($stokRendah); ?></div>
    <div style="font-size:.7rem;color:var(--muted);margin-top:.2rem">Produk perlu restock</div>
  </div>
</div>
<div class="g2" style="margin-bottom:1.5rem">
  <div class="card">
    <div class="card-h" style="gap:1rem">
      <span class="card-t">📈 Pendapatan</span>
      <div style="display:flex;gap:.45rem;align-items:center;flex-wrap:wrap">
        <button type="button" class="btn btn-o btn-sm" id="btnChartDaily" style="border-color:var(--gold);color:var(--gold)">Harian</button>
        <button type="button" class="btn btn-o btn-sm" id="btnChartWeekly">Perminggu</button>
        <button type="button" class="btn btn-o btn-sm" id="btnChartMonthlyDaily">Perhari</button>
        <button type="button" class="btn btn-o btn-sm" id="btnChartMonthlyTotal">Bulanan</button>
      </div>
    </div>
    <div class="card-b"><canvas id="chartBar" height="140"></canvas></div>
  </div>
  <div class="card">
    <div class="card-h"><span class="card-t">🏆 Top 5 Produk Terlaris</span></div>
    <div class="card-b">
      <?php $__empty_1 = true; $__currentLoopData = $topProduk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div style="display:flex;align-items:center;gap:.7rem;margin-bottom:.8rem">
        <div style="width:22px;height:22px;border-radius:50%;background:var(--gdim);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:.65rem;color:var(--gold);font-weight:700;flex-shrink:0"><?php echo e($i+1); ?></div>
        <div style="flex:1"><div style="font-size:.83rem;font-weight:500"><?php echo e($item->produk->nama_produk ?? '-'); ?></div><div style="font-size:.68rem;color:var(--muted)"><?php echo e($item->total_terjual); ?> porsi terjual</div></div>
        <div style="font-size:.8rem;font-weight:700;color:var(--gold)">Rp <?php echo e(number_format(($item->produk->harga??0)*$item->total_terjual,0,',','.')); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div style="text-align:center;color:var(--muted);padding:2rem;font-size:.85rem">Belum ada data penjualan</div>
      <?php endif; ?>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-h"><span class="card-t">🧾 Transaksi Terbaru</span><a href="<?php echo e(route('admin.transactions.index')); ?>" class="btn btn-o btn-sm">Lihat Semua</a></div>
  <div class="tw">
    <table>
      <thead><tr><th>No. Nota</th><th>Waktu</th><th>Kasir</th><th>Total</th><th>Metode</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $transaksiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td style="font-family:monospace;font-size:.78rem;font-weight:600;color:var(--gold)"><?php echo e($t->nomor_nota); ?></td>
          <td style="font-size:.78rem;color:var(--muted)"><?php echo e($t->tanggal_transaksi->format('H:i')); ?></td>
          <td><?php echo e($t->user->nama_lengkap ?? $t->user->username); ?></td>
          <td style="font-weight:600">Rp <?php echo e(number_format($t->total_harga,0,',','.')); ?></td>
          <td>
            <?php if($t->metode_bayar=='tunai'): ?><span class="badge bs">💵 Tunai</span>
            <?php elseif($t->metode_bayar=='qris'): ?><span class="badge bp">📱 QRIS</span>
            <?php else: ?><span class="badge bi">🏦 Transfer</span><?php endif; ?>
          </td>
          <td><a href="<?php echo e(route('admin.transactions.show',$t)); ?>" class="btn btn-o btn-sm">Detail</a></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:2rem">Belum ada transaksi</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
const chartDailyLabels = <?php echo json_encode($chartDailyLabels); ?>;
const chartDailyData = <?php echo json_encode($chartDailyData); ?>;
const chartWeeklyLabels = <?php echo json_encode($chartWeeklyLabels); ?>;
const chartWeeklyData = <?php echo json_encode($chartWeeklyData); ?>;
const chartMonthDailyLabels = <?php echo json_encode($chartMonthDailyLabels); ?>;
const chartMonthDailyData = <?php echo json_encode($chartMonthDailyData); ?>;

// Bulanan (total pendapatan per bulan pada tahun berjalan)
const chartMonthTotalLabels = <?php echo json_encode(range(1,12)); ?>;
const chartMonthTotalLabelsFormatted = chartMonthTotalLabels.map(m => formatMonthLabel(m));
const chartMonthTotalValues = <?php echo json_encode($chartMonthTotalValues ?? array_fill(0,12,0)); ?>;








const chartEl = document.getElementById('chartBar');
let chart = new Chart(chartEl,{
  type:'bar',
  data:{
    labels: chartDailyLabels,
    datasets:[{label:'Pendapatan',data: chartDailyData,
      backgroundColor:'rgba(201,168,76,.25)',borderColor:'#C9A84C',borderWidth:2,borderRadius:6}]
  },
  options:{responsive:true,plugins:{legend:{display:false}},
    scales:{x:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#7A7570',font:{size:10}}},
      y:{grid:{color:'rgba(255,255,255,.04)'},ticks:{color:'#7A7570',font:{size:10},callback:v=>'Rp '+(v/1000).toFixed(0)+'k'}}}}
});

function setChartData(labels, data){
  chart.data.labels = labels;
  chart.data.datasets[0].data = data;
  chart.update();
}

function formatMonthLabel(m){
  // m: 1..12
  const names = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  return names[m-1] ?? m;
}


const btnDaily = document.getElementById('btnChartDaily');
const btnWeekly = document.getElementById('btnChartWeekly');
const btnMonthDaily = document.getElementById('btnChartMonthlyDaily');
const btnMonthTotal = document.getElementById('btnChartMonthlyTotal');


function setActive(btn){
  [btnDaily, btnWeekly, btnMonthDaily, btnMonthTotal].forEach(b => {
    if (!b) return;
    b.style.borderColor = 'var(--br)';
    b.style.color = 'var(--muted)';
  });
  if (btn){
    btn.style.borderColor = 'var(--gold)';
    btn.style.color = 'var(--gold)';
  }
}


btnDaily && btnDaily.addEventListener('click', () => {
  setChartData(chartDailyLabels, chartDailyData);
  setActive(btnDaily);
});
btnWeekly && btnWeekly.addEventListener('click', () => {
  setChartData(chartWeeklyLabels, chartWeeklyData);
  setActive(btnWeekly);
});
btnMonthDaily && btnMonthDaily.addEventListener('click', () => {
  setChartData(chartMonthDailyLabels, chartMonthDailyData);
  setActive(btnMonthDaily);
});

btnMonthTotal && btnMonthTotal.addEventListener('click', () => {
  // Bulanan = total pendapatan per bulan pada tahun berjalan
  // dataset tahunan dihitung di controller
  setChartData(chartMonthTotalLabelsFormatted, chartMonthTotalValues);
  setActive(btnMonthTotal);
});


setActive(btnDaily);
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>