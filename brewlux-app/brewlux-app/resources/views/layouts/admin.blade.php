<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Dashboard') — BrewLux Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--gold:#C9A84C;--gold-l:#E8C97A;--gdim:rgba(201,168,76,.12);--dark:#0D0D0D;--sf:#141414;--card:#1C1C1C;--br:#262626;--text:#F0EDE8;--muted:#7A7570;--red:#E05252;--grn:#4CAF7D;--sb:240px}
body{background:var(--dark);color:var(--text);font-family:'DM Sans',sans-serif;display:flex;min-height:100vh}
.sb{width:var(--sb);background:var(--sf);border-right:1px solid var(--br);display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100;overflow-y:auto}
.sb-logo{padding:1.2rem 1.25rem;border-bottom:1px solid var(--br);display:flex;align-items:center;gap:.65rem}
.sb-logo .ic{font-size:1.5rem}.sb-logo .nm{font-family:'Playfair Display',serif;color:var(--gold);font-size:1.1rem}.sb-logo .tg{font-size:.56rem;color:var(--muted);letter-spacing:2px;text-transform:uppercase}
.nav-sec{padding:.7rem 1.25rem .2rem;font-size:.58rem;letter-spacing:2px;color:var(--muted);text-transform:uppercase}
.nav-a{display:flex;align-items:center;gap:.6rem;padding:.62rem 1.25rem;color:var(--muted);text-decoration:none;font-size:.82rem;font-weight:500;border-left:2px solid transparent;transition:all .15s}
.nav-a:hover{color:var(--text);background:rgba(255,255,255,.03)}.nav-a.on{color:var(--gold);border-left-color:var(--gold);background:var(--gdim)}
.nav-a .ic{width:18px;text-align:center;font-size:.9rem}
.sb-foot{margin-top:auto;padding:1rem 1.25rem;border-top:1px solid var(--br)}
.sb-usr{display:flex;align-items:center;gap:.6rem;margin-bottom:.6rem}
.sb-av{width:30px;height:30px;border-radius:50%;background:var(--gdim);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:.7rem;color:var(--gold);font-weight:700;flex-shrink:0}
.sb-un{font-size:.78rem;font-weight:500}.sb-ur{font-size:.62rem;color:var(--muted)}
.sb-out{width:100%;padding:.52rem;background:rgba(224,82,82,.08);border:1px solid rgba(224,82,82,.2);border-radius:6px;color:var(--red);font-size:.73rem;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .15s}
.sb-out:hover{background:rgba(224,82,82,.18)}
.main{margin-left:var(--sb);flex:1;display:flex;flex-direction:column}
.topbar{padding:.8rem 1.75rem;background:var(--sf);border-bottom:1px solid var(--br);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.pg-t{font-family:'Playfair Display',serif;font-size:1.2rem}.pg-s{font-size:.7rem;color:var(--muted);margin-top:2px}
.tb-d{font-size:.7rem;color:var(--muted);background:var(--card);padding:.32rem .65rem;border-radius:6px;border:1px solid var(--br)}
.cnt{padding:1.75rem;flex:1}
.alert{padding:.78rem 1rem;border-radius:8px;font-size:.83rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:.5rem}
.al-s{background:rgba(76,175,125,.1);border:1px solid rgba(76,175,125,.25);color:#6FCF97}
.al-e{background:rgba(224,82,82,.1);border:1px solid rgba(224,82,82,.25);color:#F19393}
.card{background:var(--card);border:1px solid var(--br);border-radius:12px}
.card-h{padding:.95rem 1.4rem;border-bottom:1px solid var(--br);display:flex;align-items:center;justify-content:space-between}
.card-t{font-size:.88rem;font-weight:600}.card-b{padding:1.4rem}
.tw{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:.84rem}
thead th{padding:.62rem 1rem;text-align:left;font-size:.62rem;letter-spacing:1px;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--br)}
tbody td{padding:.82rem 1rem;border-bottom:1px solid rgba(255,255,255,.04);vertical-align:middle}
tbody tr:hover{background:rgba(255,255,255,.02)}
tbody tr:last-child td{border-bottom:none}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.52rem 1rem;border-radius:7px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;font-family:'DM Sans',sans-serif;text-decoration:none;transition:all .15s;white-space:nowrap}
.btn-p{background:linear-gradient(135deg,var(--gold),var(--gold-l));color:var(--dark)}.btn-p:hover{opacity:.9;transform:translateY(-1px)}
.btn-sm{padding:.35rem .65rem;font-size:.7rem}
.btn-o{background:transparent;border:1px solid var(--br);color:var(--muted)}.btn-o:hover{border-color:var(--gold);color:var(--gold)}
.btn-d{background:rgba(224,82,82,.08);border:1px solid rgba(224,82,82,.2);color:var(--red)}.btn-d:hover{background:rgba(224,82,82,.18)}
.btn-e{background:rgba(201,168,76,.08);border:1px solid rgba(201,168,76,.2);color:var(--gold)}.btn-e:hover{background:rgba(201,168,76,.18)}
.badge{display:inline-flex;align-items:center;padding:.2rem .55rem;border-radius:20px;font-size:.66rem;font-weight:600}
.bs{background:rgba(76,175,125,.12);color:#4CAF7D}.bw{background:rgba(255,160,0,.12);color:#FFA000}
.bd2{background:rgba(224,82,82,.12);color:#E05252}.bi{background:rgba(64,156,255,.12);color:#409CFF}
.bp{background:rgba(155,89,182,.12);color:#9B59B6}
.fg{margin-bottom:1.1rem}
.fl{display:block;font-size:.7rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase;color:var(--muted);margin-bottom:.38rem}
.fc{width:100%;background:var(--dark);border:1px solid var(--br);border-radius:8px;padding:.68rem .9rem;color:var(--text);font-family:'DM Sans',sans-serif;font-size:.88rem;outline:none;transition:border-color .2s,box-shadow .2s}
.fc:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,.1)}
.fc::placeholder{color:#333}
select.fc option{background:#1C1C1C}
textarea.fc{resize:vertical;min-height:80px}
.fe{color:#F19393;font-size:.73rem;margin-top:.28rem}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}
.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem}
@media(max-width:1024px){.g4{grid-template-columns:repeat(2,1fr)}.g3{grid-template-columns:1fr 1fr}}
</style>
@stack('styles')
</head>
<body>
<aside class="sb">
  <div class="sb-logo"><span class="ic">☕</span><div><div class="nm">BrewLux</div><div class="tg">Admin Panel</div></div></div>
  <nav>
    <div class="nav-sec">Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-a {{ request()->routeIs('admin.dashboard') ? 'on':'' }}"><span class="ic">📊</span>Dashboard</a>
    <div class="nav-sec">Manajemen</div>
    <a href="{{ route('admin.products.index') }}" class="nav-a {{ request()->routeIs('admin.products.*') ? 'on':'' }}"><span class="ic">🍽️</span>Menu & Produk</a>
    <a href="{{ route('admin.categories.index') }}" class="nav-a {{ request()->routeIs('admin.categories.*') ? 'on':'' }}"><span class="ic">📂</span>Kategori</a>
    <div class="nav-sec">Laporan</div>
    <a href="{{ route('admin.transactions.index') }}" class="nav-a {{ request()->routeIs('admin.transactions.*') ? 'on':'' }}"><span class="ic">🧾</span>Jurnal Transaksi</a>
    <div class="nav-sec">Sistem</div>
    <a href="{{ route('admin.users.index') }}" class="nav-a {{ request()->routeIs('admin.users.*') ? 'on':'' }}"><span class="ic">👥</span>Kelola User</a>
  </nav>
  <div class="sb-foot">
    <div class="sb-usr">
      <div class="sb-av">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->username,0,1)) }}</div>
      <div><div class="sb-un">{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}</div><div class="sb-ur">Administrator</div></div>
    </div>
    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sb-out">⬡ Keluar dari Sistem</button></form>
  </div>
</aside>
<main class="main">
  <div class="topbar">
    <div><div class="pg-t">@yield('title','Dashboard')</div><div class="pg-s">@yield('breadcrumb','BrewLux POS')</div></div>
    <span class="tb-d">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
  </div>
  <div class="cnt">
    @if(session('success'))<div class="alert al-s">✓ {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert al-e">✕ {{ session('error') }}</div>@endif
    @yield('content')
  </div>
</main>
@stack('scripts')
</body>
</html>
