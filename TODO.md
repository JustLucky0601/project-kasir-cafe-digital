# TODO - Perbaikan Menu Best Seller di Halaman Kasir

## Rencana perubahan (berdasarkan temuan)
- [ ] Update `KasirController@index` untuk juga menyiapkan produk best seller (hanya yang `tersedia=true` dan `stok>0`)
- [ ] Update `resources/views/kasir/index.blade.php` untuk menambahkan tab “Best Seller”
- [x] Update JavaScript filter `filterMenu()` agar tab “Best Seller” dapat memfilter produk berdasarkan flag `best_seller`
- [x] Pastikan elemen produk punya atribut `data-best` (atau sejenis) untuk kebutuhan filter
- [ ] Uji cepat: buka halaman kasir, klik tab “Best Seller”, pastikan kartu produk yang tampil sesuai
- [ ] Perbaiki gangguan logout/maupun koneksi jika masih terjadi (cek JS & route logout di layout)



