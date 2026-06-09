<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>BrewLux POS — Kasir</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--gold:#C9A84C;--gold-l:#E8C97A;--gdim:rgba(201,168,76,.12);--dark:#0D0D0D;--sf:#141414;--card:#1C1C1C;--br:#252525;--text:#F0EDE8;--muted:#7A7570;--grn:#4CAF7D;--red:#E05252}
body{background:var(--dark);color:var(--text);font-family:'DM Sans',sans-serif;height:100vh;display:flex;flex-direction:column;overflow:hidden}
/* TOP */
.top{background:var(--sf);border-bottom:1px solid var(--br);padding:.65rem 1.4rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.top-brand{display:flex;align-items:center;gap:.6rem}
.top-nm{font-family:'Playfair Display',serif;color:var(--gold);font-size:1.05rem}
.top-badge{font-size:.58rem;background:var(--gdim);border:1px solid rgba(201,168,76,.3);color:var(--gold);padding:.18rem .45rem;border-radius:4px;letter-spacing:1px;text-transform:uppercase}
.top-mid{font-size:.75rem;color:var(--muted)}
.top-right{display:flex;align-items:center;gap:.65rem}
.kasir-chip{font-size:.78rem;color:var(--text);background:var(--card);padding:.32rem .7rem;border-radius:6px;border:1px solid var(--br)}
.btn-out{padding:.38rem .8rem;background:rgba(224,82,82,.08);border:1px solid rgba(224,82,82,.2);border-radius:6px;color:var(--red);font-size:.72rem;cursor:pointer;font-family:'DM Sans',sans-serif}
/* LAYOUT */
.pos{display:grid;grid-template-columns:1fr 320px;flex:1;overflow:hidden}
/* CATALOG */
.cat-panel{display:flex;flex-direction:column;overflow:hidden;border-right:1px solid var(--br)}
.cat-bar{padding:.65rem 1rem;background:var(--sf);border-bottom:1px solid var(--br);display:flex;gap:.6rem}
.search-inp{flex:1;background:var(--dark);border:1px solid var(--br);border-radius:7px;padding:.52rem .85rem .52rem 2rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:.83rem;outline:none;transition:border-color .2s;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='13' height='13' viewBox='0 0 24 24' fill='none' stroke='%237A7570' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:.65rem center}
.search-inp:focus{border-color:var(--gold)}.search-inp::placeholder{color:#333}
.cat-tabs{display:flex;gap:.35rem;padding:.6rem 1rem;background:var(--sf);border-bottom:1px solid var(--br);overflow-x:auto;flex-shrink:0}
.cat-tabs::-webkit-scrollbar{height:0}
.tab{white-space:nowrap;padding:.38rem .82rem;border-radius:20px;background:var(--card);border:1px solid var(--br);color:var(--muted);font-size:.72rem;font-weight:500;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .15s}
.tab:hover{color:var(--text);border-color:var(--gold)}.tab.on{background:var(--gold);color:var(--dark);border-color:var(--gold);font-weight:700;box-shadow:0 2px 8px rgba(201,168,76,.2)}.tab[data-id=""]{min-width:90px}.tab[data-id=""].on{background:linear-gradient(135deg,var(--gold),var(--gold-l));font-weight:800;letter-spacing:.3px}
.menu-grid{flex:1;overflow-y:auto;padding:1rem;display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1rem;align-content:start}
.menu-grid::-webkit-scrollbar{width:4px}.menu-grid::-webkit-scrollbar-thumb{background:var(--br);border-radius:2px}
.mk{background:var(--card);border:1px solid var(--br);border-radius:11px;overflow:hidden;cursor:pointer;transition:all .15s;user-select:none;display:flex;flex-direction:column;min-height:220px}
.mk:hover{border-color:var(--gold);transform:translateY(-2px);box-shadow:0 4px 16px rgba(201,168,76,.1)}
.mk.oos{opacity:.4;cursor:not-allowed}.mk.oos:hover{transform:none;border-color:var(--br);box-shadow:none}
.mk-img{width:100%;aspect-ratio:1;background:#222;display:flex;align-items:center;justify-content:center;font-size:1.8rem;overflow:hidden;flex-shrink:0}
.mk-img img{width:100%;height:100%;object-fit:cover}
.mk-info{padding:.6rem;flex:1;display:flex;flex-direction:column;gap:.2rem;justify-content:flex-start;overflow:hidden}
.mk-name{font-size:.82rem;font-weight:600;line-height:1.2;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.mk-price{font-size:.92rem;color:var(--gold);font-weight:700;line-height:1.1}
.mk-stok{font-size:.73rem;color:var(--muted);overflow:hidden;text-overflow:ellipsis;line-height:1.1}
.mk-stok.low{color:var(--red)}
/* CART */
.cart-panel{display:flex;flex-direction:column;background:var(--sf);overflow:hidden}
.cart-head{padding:.85rem 1rem;border-bottom:1px solid var(--br);display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.cart-title{font-family:'Playfair Display',serif;font-size:.95rem}
.cart-cnt{background:var(--gold);color:var(--dark);font-size:.62rem;font-weight:700;padding:.15rem .48rem;border-radius:10px;min-width:20px;text-align:center}
.cart-clear{background:none;border:none;color:var(--muted);cursor:pointer;font-size:.7rem;font-family:'DM Sans',sans-serif}
.cart-items{flex:1;overflow-y:auto;padding:.6rem}
.cart-items::-webkit-scrollbar{width:3px}.cart-items::-webkit-scrollbar-thumb{background:var(--br);border-radius:2px}
.empty-cart{height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--muted);gap:.4rem}
.ci{display:flex;align-items:center;gap:.6rem;padding:.6rem;background:var(--card);border:1px solid var(--br);border-radius:9px;margin-bottom:.4rem}
.ci-info{flex:1;min-width:0}
.ci-name{font-size:.78rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.ci-price{font-size:.72rem;color:var(--gold);margin-top:.12rem}
.ci-ctrl{display:flex;align-items:center;gap:.3rem}
.qb{width:24px;height:24px;border-radius:5px;border:1px solid var(--br);background:var(--dark);color:var(--text);font-size:.9rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;font-family:'DM Sans',sans-serif}
.qb:hover{border-color:var(--gold);color:var(--gold)}.qb.minus:hover{border-color:var(--red);color:var(--red)}
.qn{font-size:.82rem;font-weight:700;min-width:18px;text-align:center}
/* CHECKOUT */
.checkout{padding:.85rem 1rem;border-top:1px solid var(--br);flex-shrink:0}
.total-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem}
.total-lbl{font-size:.75rem;color:var(--muted)}
.total-amt{font-family:'Playfair Display',serif;font-size:1.25rem;color:var(--gold)}
/* METODE */
.metode-row{display:flex;gap:.35rem;margin-bottom:.75rem}
.mb{flex:1;padding:.48rem .3rem;border-radius:6px;border:1px solid var(--br);background:var(--card);color:var(--muted);font-size:.65rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;transition:all .15s;text-transform:uppercase;letter-spacing:.5px}
.mb.on{background:var(--gdim);border-color:var(--gold);color:var(--gold)}
/* BAYAR INPUT */
.bayar-lbl{font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:.35rem}
.bayar-inp{width:100%;background:var(--dark);border:1px solid var(--br);border-radius:7px;padding:.65rem .85rem;color:var(--text);font-size:.95rem;font-weight:700;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s;margin-bottom:.65rem}
.bayar-inp:focus{border-color:var(--gold)}
/* KEMBALIAN */
.kemb-row{display:flex;justify-content:space-between;align-items:center;padding:.55rem .8rem;background:rgba(76,175,125,.07);border:1px solid rgba(76,175,125,.18);border-radius:7px;margin-bottom:.75rem}
.kemb-lbl{font-size:.72rem;color:var(--muted)}
.kemb-amt{font-size:.95rem;font-weight:700;color:var(--grn)}
.kemb-amt.err{color:var(--red)}
/* NOMINAL CEPAT */
.quick-row{display:flex;gap:.3rem;margin-bottom:.65rem}
.qp{flex:1;padding:.38rem;background:var(--card);border:1px solid var(--br);border-radius:6px;font-size:.62rem;font-weight:600;color:var(--muted);cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;transition:all .15s}
.qp:hover{border-color:var(--gold);color:var(--gold)}
/* BTN BAYAR */
.btn-bayar{width:100%;padding:.82rem;background:linear-gradient(135deg,var(--gold),var(--gold-l));border:none;border-radius:9px;font-family:'Playfair Display',serif;font-size:.95rem;color:var(--dark);font-weight:700;cursor:pointer;transition:all .15s;letter-spacing:.5px}
.btn-bayar:hover:not(:disabled){opacity:.9;transform:translateY(-1px)}
.btn-bayar:disabled{opacity:.3;cursor:not-allowed;transform:none}
/* MODAL SUKSES */
.overlay{position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:1000;display:none;align-items:center;justify-content:center;backdrop-filter:blur(4px)}
.overlay.show{display:flex}
.modal{background:var(--card);border:1px solid var(--br);border-radius:16px;padding:2rem;text-align:center;max-width:340px;width:90%;animation:up .3s ease}
@keyframes up{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.modal-icon{font-size:3rem;margin-bottom:1rem}
.modal-title{font-family:'Playfair Display',serif;font-size:1.3rem;margin-bottom:.5rem}
.modal-nota{font-family:monospace;font-size:.82rem;color:var(--gold);background:var(--gdim);padding:.38rem .7rem;border-radius:6px;display:inline-block;margin-bottom:1rem}
.modal-info{font-size:.85rem;color:var(--muted);margin-bottom:1.5rem;line-height:1.65}
.modal-kemb{font-size:1.3rem;font-weight:700;color:var(--grn)}
.modal-acts{display:flex;gap:.65rem}
.m-btn{flex:1;padding:.72rem;border-radius:8px;font-size:.82rem;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;border:none;transition:all .15s}
.m-cetak{background:linear-gradient(135deg,var(--gold),var(--gold-l));color:var(--dark)}
.m-lanjut{background:var(--dark);border:1px solid var(--br)!important;color:var(--muted)}
.m-btn:hover{opacity:.85}
/* MODAL QRIS */
.qris-modal{background:var(--card);border:1px solid var(--br);border-radius:16px;padding:2rem;text-align:center;max-width:360px;width:90%;animation:up .3s ease}
.qris-box{background:#fff;border-radius:12px;padding:1.25rem;margin:1rem 0;display:inline-block}
.qris-box img{width:180px;height:180px;display:block}
.qris-amount{font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--gold);margin-bottom:.25rem}
.qris-info{font-size:.78rem;color:var(--muted);margin-bottom:1.2rem;line-height:1.5}
.qris-timer{font-size:.88rem;font-weight:600;color:var(--red);margin-bottom:1rem}
/* LOADING */
.loading{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:2000;display:none;align-items:center;justify-content:center}
.loading.show{display:flex}
.spinner{width:38px;height:38px;border:3px solid var(--br);border-top-color:var(--gold);border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
/* FLASH */
.flash{position:fixed;top:65px;right:1rem;z-index:9999;padding:.7rem 1.1rem;border-radius:8px;font-size:.82rem;font-weight:500;box-shadow:0 4px 16px rgba(0,0,0,.3);animation:up .2s ease;display:flex;align-items:center;gap:.5rem}

@media (max-width:1024px) {
  body{height:auto;}
  .pos{grid-template-columns:1fr;}
  .cat-panel{border-right:none;border-bottom:1px solid var(--br);}
  .cart-panel{min-height:320px;}
  .cat-bar,.cat-tabs,.checkout{padding-left:1rem;padding-right:1rem;}
  .menu-grid{padding:1rem;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));}
  .mk{min-height:200px;}
  .cart-head{flex-wrap:wrap;gap:.5rem;}
  .cart-title{width:100%;}
  .cart-clear{order:2;width:100%;text-align:left;}
}

@media (max-width:680px) {
  .top{flex-wrap:wrap;gap:.5rem;justify-content:flex-start;}
  .top-right{width:100%;justify-content:flex-start;}
  .top-mid{width:100%;font-size:.72rem;}
  .cat-bar{padding:.6rem .8rem;}
  .cat-tabs{padding:.5rem .8rem;gap:.3rem;}
  .tab{font-size:.65rem;padding:.35rem .7rem;}
  .menu-grid{grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:.8rem;}
  .mk{min-height:180px;}
  .mk-name{font-size:.76rem;}
  .mk-price{font-size:.82rem;}
  .cart-head{padding:.7rem .9rem;}
  .cart-title{font-size:.9rem;}
  .ci{padding:.55rem;}
  .qb{width:22px;height:22px;font-size:.8rem;}
  .bayar-inp{font-size:.9rem;padding:.6rem .75rem;}
  .kemb-row{padding:.5rem .7rem;}
  .modal,.qris-modal{padding:1.5rem;}
  .modal-icon{font-size:2.5rem;}
  .modal-title{font-size:1.1rem;}
}
</style>
</head>
<body>
<div class="top">
  <div class="top-brand">
    <span style="font-size:1.25rem">☕</span>
    <div class="top-nm">BrewLux</div>
    <span class="top-badge">POS Kasir</span>
  </div>
  <div class="top-mid" id="clock-display"><?php echo e(now()->format('H:i')); ?> · <?php echo e(now()->locale('id')->isoFormat('dddd, D MMMM YYYY')); ?></div>
  <div class="top-right">
    <span class="kasir-chip">👤 <?php echo e(auth()->user()->nama_lengkap ?? auth()->user()->username); ?></span>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline"><?php echo csrf_field(); ?><button type="submit" class="btn-out">Keluar</button></form>
  </div>
</div>

<div class="pos">
  <!-- CATALOG -->
  <div class="cat-panel">
    <div class="cat-bar">
      <input type="text" class="search-inp" id="searchBox" placeholder="Cari menu..." oninput="filterMenu()">
    </div>
    <div class="cat-tabs" id="tabsContainer">
      <button class="tab on" data-id="">🍽️ Semua</button>
      <button class="tab" data-id="best">⭐ Best Seller</button>
      <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <button class="tab" data-id="<?php echo e($k->id); ?>"><?php echo e($k->icon); ?> <?php echo e($k->nama_kategori); ?></button>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="menu-grid" id="menuGrid">
      <?php $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="mk <?php echo e($p->stok==0 ? 'oos':''); ?>"
           data-id="<?php echo e($p->id); ?>" data-nama="<?php echo e($p->nama_produk); ?>"
           data-harga="<?php echo e($p->harga); ?>" data-stok="<?php echo e($p->stok); ?>"
           data-kat="<?php echo e($p->kategori_id); ?>"
           data-best="<?php echo e($p->best_seller ? 1 : 0); ?>"
           onclick="addToCart(this)">
        <div class="mk-img">
          <?php if($p->foto): ?><img src="<?php echo e(asset('storage/products/'.$p->foto)); ?>" alt="<?php echo e($p->nama_produk); ?>" loading="lazy">
          <?php else: ?><span><?php echo e($p->kategori->icon); ?></span><?php endif; ?>
        </div>
        <div class="mk-info">
          <div class="mk-name"><?php echo e($p->nama_produk); ?></div>
          <div class="mk-price">Rp <?php echo e(number_format($p->harga,0,',','.')); ?></div>
          <div class="mk-stok <?php echo e($p->stok<=5 ? 'low':''); ?>"><?php echo e($p->stok==0 ? '⚠ Habis' : 'Stok: '.$p->stok); ?></div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>

  <!-- CART -->
  <div class="cart-panel">
    <div class="cart-head">
      <span class="cart-title">Keranjang</span>
      <div style="display:flex;align-items:center;gap:.5rem">
        <span class="cart-cnt" id="cartCount">0</span>
        <button class="cart-clear" onclick="clearCart()">✕ Kosongkan</button>
      </div>
    </div>

    <div class="cart-items" id="cartItems">
      <div class="empty-cart">
        <span style="font-size:2.2rem;opacity:.35">🛒</span>
        <span style="font-size:.82rem">Keranjang kosong</span>
        <span style="font-size:.72rem">Pilih menu di sebelah kiri</span>
      </div>
    </div>

    <div class="checkout">
      <div class="total-row">
        <span class="total-lbl">Total Tagihan</span>
        <span class="total-amt" id="totalAmt">Rp 0</span>
      </div>

      <!-- METODE BAYAR -->
      <div class="metode-row" id="metodeRow">
        <button class="mb on" data-v="tunai" onclick="setMetode(this)">💵 Tunai</button>
        <button class="mb" data-v="qris" onclick="setMetode(this)">📱 QRIS</button>
        <button class="mb" data-v="transfer" onclick="setMetode(this)">🏦 Transfer</button>
      </div>

      <!-- BAYAR TUNAI -->
      <div id="tunai-section">
        <div class="quick-row" id="quickRow"></div>
        <div class="bayar-lbl">Uang Diterima</div>
        <input type="number" class="bayar-inp" id="bayarInp" placeholder="0" min="0" oninput="hitungKembalian()">
        <div class="kemb-row">
          <span class="kemb-lbl">Kembalian</span>
          <span class="kemb-amt" id="kembAmt">Rp 0</span>
        </div>
      </div>

      <!-- INFO QRIS / TRANSFER -->
      <div id="nontunai-section" style="display:none">
        <div style="padding:.65rem .85rem;background:rgba(64,156,255,.07);border:1px solid rgba(64,156,255,.2);border-radius:8px;margin-bottom:.75rem;font-size:.8rem;color:#409CFF;text-align:center">
          <span id="nontunai-info">Pembayaran akan dikonfirmasi via QRIS</span>
        </div>


      </div>

      <button class="btn-bayar" id="btnBayar" disabled onclick="prosesTransaksi()">
        Selesaikan Transaksi
      </button>
    </div>
  </div>
</div>

<!-- MODAL QRIS -->
<div class="overlay" id="qrisOverlay">
  <div class="qris-modal">
    <div style="font-size:1.5rem;margin-bottom:.5rem">📱</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:.5rem">Pembayaran QRIS</div>
    <div class="qris-amount" id="qrisAmount"></div>
    <div class="qris-box">
      <img src="<?php echo e(asset('storage/qris/qris.jpg')); ?>" alt="QRIS Code">
    </div>
    <div class="qris-info">Scan QR code di atas menggunakan<br>aplikasi e-wallet atau mobile banking Anda.<br><strong style="color:var(--text)">Merchant: BrewLux Café</strong></div>
    <div class="qris-timer" id="qrisTimer">Menunggu pembayaran...</div>
    <div style="display:flex;gap:.65rem">
      <button class="m-btn m-cetak" onclick="konfirmasiQris()">✓ Pembayaran Diterima</button>
      <button class="m-btn m-lanjut" onclick="batalQris()">Batal</button>
    </div>
  </div>
</div>

<!-- MODAL SUKSES -->
<div class="overlay" id="suksesOverlay">
  <div class="modal">
    <div class="modal-icon">✅</div>
    <div class="modal-title">Transaksi Berhasil!</div>
    <div class="modal-nota" id="modalNota"></div>
    <div class="modal-info">
      <span id="modalMetode"></span><br>
      Kembalian:<br>
      <span class="modal-kemb" id="modalKemb"></span>
    </div>
    <div class="modal-acts">
      <button class="m-btn m-cetak" id="btnCetak">🖨️ Cetak Nota</button>
      <button class="m-btn m-lanjut" onclick="transaksiSelanjutnya()">Transaksi Baru</button>
    </div>
  </div>
</div>

<!-- LOADING -->
<div class="loading" id="loadingOverlay"><div class="spinner"></div></div>

<script>
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
let cart = [], metode = 'tunai', lastId = null, qrisInterval = null;

// ─── CART ────────────────────────────────────
function addToCart(el) {
  if (el.classList.contains('oos')) return;
  const id = +el.dataset.id, nama = el.dataset.nama, harga = +el.dataset.harga, maxStok = +el.dataset.stok;
  const idx = cart.findIndex(i => i.id === id);
  if (idx >= 0) {
    if (cart[idx].qty >= maxStok) { flash('Stok maksimal!','red'); return; }
    cart[idx].qty++;
  } else {
    cart.push({ id, nama, harga, qty: 1, maxStok });
  }
  renderCart();
}

function changeQty(idx, d) {
  cart[idx].qty += d;
  if (cart[idx].qty <= 0) cart.splice(idx, 1);
  else if (cart[idx].qty > cart[idx].maxStok) { cart[idx].qty = cart[idx].maxStok; flash('Stok maksimal!','red'); }
  renderCart();
}

function clearCart() {
  if (!cart.length) return;
  if (!confirm('Kosongkan keranjang?')) return;
  cart = [];
  document.getElementById('bayarInp').value = '';
  renderCart();
}

function renderCart() {
  const total = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  const count = cart.reduce((s,i) => s+i.qty, 0);
  document.getElementById('cartCount').textContent = count;
  document.getElementById('totalAmt').textContent = rp(total);
  buildQuickNominal(total);

  const el = document.getElementById('cartItems');
  if (!cart.length) {
    el.innerHTML = '<div class="empty-cart"><span style="font-size:2.2rem;opacity:.35">🛒</span><span style="font-size:.82rem">Keranjang kosong</span></div>';
    document.getElementById('btnBayar').disabled = true;
    return;
  }
  el.innerHTML = cart.map((item,i) => `
    <div class="ci">
      <div class="ci-info">
        <div class="ci-name">${item.nama}</div>
        <div class="ci-price">${rp(item.harga*item.qty)}</div>
      </div>
      <div class="ci-ctrl">
        <button class="qb minus" onclick="changeQty(${i},-1)">−</button>
        <span class="qn">${item.qty}</span>
        <button class="qb" onclick="changeQty(${i},1)">+</button>
      </div>
    </div>
  `).join('');
  hitungKembalian();
}

// ─── METODE ───────────────────────────────────
function setMetode(btn) {
  document.querySelectorAll('.mb').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  metode = btn.dataset.v;
  const tunai = document.getElementById('tunai-section');
  const nontunai = document.getElementById('nontunai-section');
  const info = document.getElementById('nontunai-info');

  if (metode === 'tunai') {
    tunai.style.display = 'block'; nontunai.style.display = 'none';
    hitungKembalian();
  } else {
    tunai.style.display = 'none'; nontunai.style.display = 'block';
    if (metode === 'qris') {
      info.textContent = 'Scan QRIS — kembalian Rp 0';
    } else {
      info.textContent = 'Transfer bank — kembalian Rp 0';
    }
    document.getElementById('btnBayar').disabled = cart.length === 0;
  }
}


// ─── KEMBALIAN ────────────────────────────────
function hitungKembalian() {
  if (metode !== 'tunai') return;
  const total = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  const bayar = parseInt(document.getElementById('bayarInp').value) || 0;
  const kemb  = bayar - total;
  const el    = document.getElementById('kembAmt');
  const btn   = document.getElementById('btnBayar');
  if (bayar > 0 && bayar < total) {
    el.textContent = 'Kurang ' + rp(total - bayar);
    el.classList.add('err'); btn.disabled = true;
  } else {
    el.textContent = rp(Math.max(0, kemb));
    el.classList.remove('err');
    btn.disabled = cart.length === 0 || bayar < total;
  }
}

function buildQuickNominal(total) {
  const row = document.getElementById('quickRow');
  if (!total) { row.innerHTML = ''; return; }
  const opts = [total, Math.ceil(total/10000)*10000, Math.ceil(total/50000)*50000, Math.ceil(total/100000)*100000];
  const uniq = [...new Set(opts)].slice(0, 4);
  row.innerHTML = uniq.map(v => `<button class="qp" onclick="setNominal(${v})">${rp(v)}</button>`).join('');
}

function setNominal(v) {
  document.getElementById('bayarInp').value = v;
  hitungKembalian();
}

// ─── FILTER ───────────────────────────────────
document.getElementById('tabsContainer').addEventListener('click', e => {
  const btn = e.target.closest('.tab');
  if (!btn) return;
  document.querySelectorAll('.tab').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  filterMenu();
});





function filterMenu() {
  const search = document.getElementById('searchBox').value.toLowerCase();
  const tabId = document.querySelector('.tab.on').dataset.id;

  document.querySelectorAll('.mk').forEach(card => {
    const matchSearch = card.dataset.nama.toLowerCase().includes(search);

    // Semua
    const matchAll = !tabId || tabId === '';

    // Best Seller
    const matchBest = tabId === 'best' && String(card.dataset.best) === '1';

    // Kategori
    const matchKat = !matchAll && tabId !== 'best' && card.dataset.kat === tabId;

    card.style.display = (matchAll || matchBest || matchKat) && matchSearch ? '' : 'none';
  });
}

// ─── PROSES TRANSAKSI ─────────────────────────
async function prosesTransaksi() {
  if (!cart.length) return;
  const total = cart.reduce((s,i) => s+i.harga*i.qty, 0);

  if (metode === 'qris') {
    // Tampilkan modal QRIS
    document.getElementById('qrisAmount').textContent = rp(total);
    document.getElementById('qrisOverlay').classList.add('show');
    startQrisTimer();
    return;
  }

  if (metode === 'transfer') {
    // transfer: langsung proses tanpa upload bukti transfer
    await kirimTransaksi(total, 0, 0, null);
    return;
  }

  const bayar = metode === 'tunai' ? (parseInt(document.getElementById('bayarInp').value)||0) : total;
  if (metode === 'tunai' && bayar < total) { flash('Uang bayar kurang!','red'); return; }
  const kemb = Math.max(0, bayar - total);
  await kirimTransaksi(total, bayar, kemb, null);
}

// ─── QRIS TIMER ───────────────────────────────
function startQrisTimer() {
  let sisa = 120;
  clearInterval(qrisInterval);
  qrisInterval = setInterval(() => {
    sisa--;
    const m = String(Math.floor(sisa/60)).padStart(2,'0');
    const s = String(sisa%60).padStart(2,'0');
    document.getElementById('qrisTimer').textContent = `Batas waktu: ${m}:${s}`;
    if (sisa <= 0) { clearInterval(qrisInterval); batalQris(); flash('Waktu habis, transaksi dibatalkan','red'); }
  }, 1000);
}

function konfirmasiQris() {
  clearInterval(qrisInterval);
  document.getElementById('qrisOverlay').classList.remove('show');
  const total = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  kirimTransaksi(total, total, 0, null);
}

function batalQris() {
  clearInterval(qrisInterval);
  document.getElementById('qrisOverlay').classList.remove('show');
}

async function kirimTransaksi(total, bayar, kembalian, gatewayOrderId) {
  document.getElementById('loadingOverlay').classList.add('show');
  document.getElementById('btnBayar').disabled = true;
  try {
    let res;
    if (metode === 'transfer') {
      const fd = new FormData();
      // Kirim items tetap sebagai JSON string supaya backend dapat decode & validasi
      fd.append('items', JSON.stringify(cart.map(i => ({ id: i.id, qty: i.qty }))));
      fd.append('total_harga', String(total));
      fd.append('total_bayar', String(total));
      fd.append('kembalian', '0');
      fd.append('metode_bayar', metode);

      res = await fetch('<?php echo e(route("kasir.transaksi")); ?>', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
        },
        body: fd
      });
    } else { 

      res = await fetch('<?php echo e(route("kasir.transaksi")); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          items: cart.map(i => ({ id: i.id, qty: i.qty })),
          total_harga: total, total_bayar: bayar, kembalian: kembalian, metode_bayar: metode,
        })
      });
    }

    const data = await res.json();
    if (data.success) {
      lastId = data.transaksi_id;
      document.getElementById('modalNota').textContent = data.nomor_nota;
      document.getElementById('modalKemb').textContent = rp(data.kembalian ?? 0);
      document.getElementById('modalMetode').textContent = metode === 'tunai' ? '💵 Tunai' : metode === 'qris' ? '📱 QRIS' : '🏦 Transfer';
      document.getElementById('btnCetak').onclick = () => window.open('<?php echo e(url("nota")); ?>/'+lastId,'_blank');
      document.getElementById('suksesOverlay').classList.add('show');

      // Update stok di UI hanya untuk metode final (tunai/qris)
      if (metode !== 'transfer') {
        cart.forEach(item => {
          const card = document.querySelector(`.mk[data-id="${item.id}"]`);
          if (card) {
            const newStok = Math.max(0, +card.dataset.stok - item.qty);
            card.dataset.stok = newStok;
            const stokEl = card.querySelector('.mk-stok');
            if (newStok <= 0) { card.classList.add('oos'); if(stokEl) stokEl.textContent='⚠ Habis'; }
            else if(stokEl) stokEl.textContent='Stok: '+newStok;
          }
        });
      }
    } else {
      flash(data.message || 'Transaksi gagal!', 'red');
      document.getElementById('btnBayar').disabled = false;
    }
  } catch (e) {
    flash('Koneksi bermasalah, coba lagi.', 'red');
    document.getElementById('btnBayar').disabled = false;
  } finally {
    document.getElementById('loadingOverlay').classList.remove('show');
  }
}


function transaksiSelanjutnya() {
  document.getElementById('suksesOverlay').classList.remove('show');
  cart = [];
  document.getElementById('bayarInp').value = '';
  renderCart();
  document.getElementById('kembAmt').textContent = rp(0);
  document.getElementById('kembAmt').classList.remove('err');
  // Reset metode ke tunai
  document.querySelectorAll('.mb').forEach(b => b.classList.remove('on'));
  document.querySelector('.mb[data-v="tunai"]').classList.add('on');
  metode = 'tunai';
  document.getElementById('tunai-section').style.display='block';
  document.getElementById('nontunai-section').style.display='none';
}

function flash(msg, type) {
  const el = document.createElement('div');
  el.className = 'flash';
  el.style.cssText = `background:${type==='red'?'rgba(224,82,82,.92)':'rgba(76,175,125,.92)'};color:#fff`;
  el.innerHTML = (type==='red'?'⚠ ':'✓ ') + msg;
  document.body.appendChild(el);
  setTimeout(()=>el.remove(), 2800);
}
</script>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\brewlux-pos\brewlux-pos\resources\views/kasir/index.blade.php ENDPATH**/ ?>