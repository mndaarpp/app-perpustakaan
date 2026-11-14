# Skenario Demo Aplikasi — Perpustakaan Digital Kampus (`app-perpustakaan`)

Dokumen ini berisi urutan langkah demonstrasi menyeluruh untuk memverifikasi seluruh fitur aplikasi web (Blade) maupun layanan REST API menjelang UAS.

---

## Persiapan Sebelum Demo

1. Pastikan layanan **MySQL** (XAMPP) aktif pada port `3306`.
2. Reset dan isi ulang database dengan data dummy realistis:
   ```bash
   php artisan migrate:fresh --seed
   ```
3. Jalankan **dua instance server Laravel** secara bersamaan pada dua terminal berbeda:
   - **Terminal 1 (Server Utama / Web Browser):**
     ```bash
     php artisan serve --port=8000
     ```
   - **Terminal 2 (Server Internal API untuk konsumsi `Http::get`):**
     ```bash
     php artisan serve --port=8011
     ```

---

## Urutan Skenario Demo

### 1. Autentikasi (Login)
- Buka `http://127.0.0.1:8000/login`.
- Login menggunakan akun Administrator:
  - **Email:** `admin@pens.ac.id`
  - **Password:** `password`
- **Verifikasi:** Redirect otomatis menuju halaman **Dashboard** (`/`), dan nama **Bambang Sutrisno (Admin)** tampil pada pojok kanan navbar.

### 2. Dashboard (Konsumsi Internal API `GET /api/stats`)
- Pada halaman Dashboard (`/`), periksa tiga kartu statistik utama:
  - **Total Buku:** `20`
  - **Total Anggota:** `15`
  - **Peminjaman Aktif:** sesuai jumlah transaksi berstatus `dipinjam` di database.
- **Verifikasi:** Angka statistik diambil melalui HTTP Client dari endpoint `GET /api/stats`.

### 3. Manajemen Kategori (Khusus Admin)
- Buka menu **Kategori** (`/categories`).
- Klik **+ Tambah Kategori**, masukkan kategori baru (misalnya: `Ensiklopedia`), lalu simpan.
- **Verifikasi:** Kategori baru muncul dalam daftar kategori dan tersedia pada pilihan kategori saat menambah buku.

### 4. Manajemen Buku & Pagination
- Buka menu **Buku** (`/books`), tunjukkan navigasi halaman (*pagination*) di bagian bawah tabel.
- Klik **+ Tambah Buku**, isi formulir buku baru (judul, penulis, penerbit, tahun terbit, stok, dan kategori yang baru dibuat), lalu simpan.
- **Verifikasi:** Buku baru tampil pada daftar buku dan statistik **Total Buku** di Dashboard bertambah menjadi `21`.

### 5. Manajemen Anggota
- Buka menu **Anggota** (`/members`).
- Klik **+ Tambah Anggota**, masukkan data mahasiswa baru (nama, NIM unik, email `@pens.ac.id`, nomor telepon, alamat, status `aktif`), lalu simpan.
- **Verifikasi:** Anggota baru muncul pada daftar dan statistik **Total Anggota** di Dashboard bertambah menjadi `16`.

### 6. Transaksi Peminjaman Buku
- Buka menu **Peminjaman** (`/loans`), lalu klik **+ Tambah Peminjaman**.
- Pilih anggota aktif dan buku yang memiliki stok tersedia, atur tanggal pinjam serta tanggal jatuh tempo, lalu simpan.
- **Verifikasi:**
  - Transaksi tercatat dengan status **Dipinjam** dan kode peminjaman unik (`PJM-...`).
  - Stok buku yang dipinjam otomatis berkurang sesuai jumlah pinjaman.
  - Angka **Peminjaman Aktif** di Dashboard ikut bertambah.

### 7. Daftar Peminjaman Aktif & Proses Pengembalian
- Buka detail atau daftar peminjaman yang masih berstatus **Dipinjam**.
- Klik tombol **Kembalikan** pada transaksi tersebut.
- **Verifikasi:**
  - Status transaksi berubah menjadi **Dikembalikan** dan tanggal kembali terisi otomatis.
  - Stok buku kembali bertambah seperti semula.
  - Angka **Peminjaman Aktif** di Dashboard berkurang.

### 8. Laporan Peminjaman (Konsumsi Internal API `GET /api/loans`)
- Buka menu **Laporan** (`/loans/report`) dari navbar atau tombol **Lihat Laporan Peminjaman** di Dashboard.
- **Verifikasi:** Tabel menampilkan seluruh riwayat peminjaman (anggota, petugas, daftar buku, tanggal, status) yang diambil langsung dari endpoint `GET /api/loans`.

### 9. Pengujian REST API Eksternal via Postman
- Buka aplikasi **Postman** dan uji endpoint utama dengan header `Accept: application/json`:
  - `GET http://127.0.0.1:8000/api/books` (`200 OK`)
  - `GET http://127.0.0.1:8000/api/members` (`200 OK`)
  - `GET http://127.0.0.1:8000/api/loans` (`200 OK`)
  - `POST http://127.0.0.1:8000/api/loans` (`201 Created`)
  - `PUT http://127.0.0.1:8000/api/loans/{id}/kembalikan` (`200 OK`)
  - `GET http://127.0.0.1:8000/api/stats` (`200 OK`)
- **Verifikasi:** Seluruh respons mengembalikan struktur JSON terstandar melalui API Resource.