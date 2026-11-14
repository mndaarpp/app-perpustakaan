# Aplikasi Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi web manajemen perpustakaan kampus berbasis **Laravel** yang dilengkapi fitur CRUD lengkap (Buku, Kategori, Anggota, Peminjaman), autentikasi berbasis role (`admin` dan `petugas`), RESTful API, serta konsumsi API internal untuk halaman Dashboard dan Laporan Peminjaman.

---

## Fitur Utama

- **Autentikasi & Hak Akses Role:** Login/Logout dengan pembatasan menu Kategori khusus role `admin`.
- **Manajemen Data Master:** CRUD Buku (termasuk upload sampul & pencarian/filter), Kategori, dan Anggota kampus.
- **Transaksi Sirkulasi:** Peminjaman multi-buku dengan pengurangan stok otomatis dan pengembalian buku dengan pemulihan stok otomatis.
- **RESTful API (`/api/...`):** Endpoint JSON untuk `books`, `members`, `loans`, dan `stats` (dokumentasi lengkap tersedia pada [`API.md`](./API.md)).
- **Konsumsi API Internal:** Halaman **Dashboard** (`/`) dan **Laporan Peminjaman** (`/loans/report`) mengambil data melalui Laravel `Http` Client (`GET /api/stats` dan `GET /api/loans`) dengan penanganan error `ConnectionException`.
- **Seeder & Factory Lokal Indonesia:** Data dummy realistis bergaya Indonesia menggunakan Faker locale `id_ID`.

---

## Panduan Instalasi & Setup

### 1. Clone Repository
```bash
git clone [https://github.com/mndaarpp/app-perpustakaan.git](https://github.com/mndaarpp/app-perpustakaan.git)
cd app-perpustakaan
```

### 2. Install Dependency PHP
```bash
composer install
```

### 3. Konfigurasi File Environment (`.env`)
Salin file `.env.example` menjadi `.env`, lalu generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi database MySQL serta URL server API internal:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=

APP_FAKER_LOCALE=id_ID
INTERNAL_API_URL=[http://127.0.0.1:8011](http://127.0.0.1:8011)
```

### 4. Migrasi & Seeding Database
Pastikan layanan MySQL aktif dan database `db_perpustakaan` sudah dibuat, lalu jalankan:
```bash
php artisan migrate:fresh --seed
```

### 5. Menjalankan Aplikasi (Wajib Dua Server)
Karena `php artisan serve` memproses satu request pada satu waktu, jalankan **dua instance server** di dua terminal berbeda agar Dashboard dan Laporan dapat memanggil API internal tanpa mengalami *deadlock*:

- **Terminal 1 (Server Utama untuk Browser):**
  ```bash
  php artisan serve --port=8000
  ```
- **Terminal 2 (Server Khusus API Internal):**
  ```bash
  php artisan serve --port=8011
  ```

Buka aplikasi di browser melalui alamat: `http://127.0.0.1:8000`

---

## Akun Demo (Hasil Seeder)

| Role | Nama | Email | Password |
| :--- | :--- | :--- | :--- |
| **Admin** | Bambang Sutrisno | `admin@pens.ac.id` | `password` |
| **Petugas** | Siti Rahmawati | `petugas1@pens.ac.id` | `password` |
| **Petugas** | Ahmad Fauzi | `petugas2@pens.ac.id` | `password` |

---

## Dokumentasi Tambahan

- **Dokumentasi REST API:** [`API.md`](./API.md)
- **Skenario Demo Aplikasi:** [`DEMO.md`](./DEMO.md)