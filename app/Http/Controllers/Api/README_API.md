Untuk penggunaan endpoint API Sanctum.

- Public:
  - POST /api/login
  - GET  /api/produk
  - GET  /api/produk/{id}
  - GET  /api/kategori

- Protected (Bearer token):
  - POST /api/logout
  - GET  /api/transaksi
  - GET  /api/transaksi/{id}
  - POST /api/transaksi
  - GET  /api/dashboard/stats

Format response:
{ "success": true, "message": "string", "data": {} }

Token didapat dari response login.

