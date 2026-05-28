# ☕ BrewLux POS — Sistem Kasir Digital

## 🚀 CARA INSTALL (Ikuti urutan ini!)

### Syarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- XAMPP / Laragon

---

### LANGKAH 1 — Buat project Laravel baru

```bash
composer create-project laravel/laravel brewlux-app
cd brewlux-app
```

---

### LANGKAH 2 — Copy semua isi folder `src/` ke dalam project

Salin **semua file & folder** dari folder `src/` ini ke folder `brewlux-app/`.
Pilih **Replace/Timpa** jika ada yang konflik.

> File yang perlu di-copy:
> - `app/` → Controllers, Models, Middleware
> - `bootstrap/app.php`
> - `config/` → auth.php, filesystems.php, session.php
> - `database/` → migrations, seeders
> - `resources/views/` → semua blade template
> - `routes/web.php`, `routes/console.php`
> - `.env.example`

---

### LANGKAH 3 — Setup .env

```bash
cd brewlux-app
cp .env.example .env
php artisan key:generate
```

Edit file `.env` sesuaikan database:
```
DB_DATABASE=brewlux_pos
DB_USERNAME=root
DB_PASSWORD=        ← isi password MySQL kamu
```

---

### LANGKAH 4 — Buat database

Buka **phpMyAdmin** → buat database baru:
```sql
CREATE DATABASE brewlux_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### LANGKAH 5 — Jalankan migration & seeder

```bash
php artisan migrate --seed
```

---

### LANGKAH 6 — Buat symlink storage (untuk foto produk)

```bash
php artisan storage:link
```

---

### LANGKAH 7 — Jalankan server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 👤 Akun Default

| Role  | Username | Password  |
|-------|----------|-----------|
| Admin | admin    | admin123  |
| Kasir | kasir1   | kasir123  |
| Kasir | kasir2   | kasir123  |

---

## ✨ Fitur Lengkap

### Kasir (POS)
- Katalog menu dengan foto + filter kategori + pencarian
- Keranjang belanja (tambah/kurang/hapus item)
- Pilihan metode bayar: Tunai, QRIS, Transfer
- Hitung kembalian otomatis + tombol nominal cepat
- ACID transaction — stok aman tidak korupt
- Cetak nota thermal 80mm

### Admin Dashboard
- Statistik pendapatan hari ini, transaksi, stok rendah
- Grafik bar pendapatan 7 hari
- Top 5 produk terlaris

### Manajemen Produk
- CRUD produk + upload/ganti/hapus foto
- Preview foto sebelum upload
- Filter kategori & pencarian
- Toggle aktif/nonaktif

### Kategori & User
- CRUD kategori dengan emoji icon
- Kelola akun kasir (tambah/hapus)

### Jurnal Transaksi
- Filter by tanggal, kasir, metode, nomor nota
- Detail per transaksi
- Cetak ulang nota

---

## ❗ Troubleshooting

**Foto tidak muncul?**
```bash
php artisan storage:link
```

**Error 500 setelah copy file?**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Halaman kosong / redirect loop?**
Pastikan `APP_KEY` sudah ter-generate di `.env`
```bash
php artisan key:generate
```
