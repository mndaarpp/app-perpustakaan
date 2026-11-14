# Dokumentasi REST API — Aplikasi Perpustakaan Digital (`app-perpustakaan`)

- **Base URL:** `http://127.0.0.1:8000/api`
- **Header Wajib:** `Accept: application/json` (dan `Content-Type: application/json` untuk request `POST` / `PUT`)

---

## Ringkasan Endpoint

| No | Modul | Method | Endpoint | Deskripsi | Status Uji |
| :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | Books | `GET` | `/books` | Menampilkan daftar semua buku | `200 OK` |
| 2 | Books | `GET` | `/books?judul={keyword}` | Filter daftar buku berdasarkan judul | `200 OK` |
| 3 | Books | `GET` | `/books/{id}` | Menampilkan detail buku berdasarkan ID | `200 OK` / `404 Not Found` |
| 4 | Books | `POST` | `/books` | Menambahkan data buku baru | `201 Created` / `422 Unprocessable` |
| 5 | Books | `PUT` | `/books/{id}` | Memperbarui data buku berdasarkan ID | `200 OK` |
| 6 | Books | `DELETE` | `/books/{id}` | Menghapus data buku berdasarkan ID | `200 OK` |
| 7 | Members | `GET` | `/members` | Menampilkan daftar semua anggota | `200 OK` |
| 8 | Members | `GET` | `/members/{id}` | Menampilkan detail anggota berdasarkan ID | `200 OK` |
| 9 | Loans | `GET` | `/loans` | Menampilkan daftar semua peminjaman | `200 OK` |
| 10 | Loans | `POST` | `/loans` | Membuat transaksi peminjaman buku baru | `201 Created` |
| 11 | Loans | `PUT` | `/loans/{id}/kembalikan` | Memproses pengembalian buku | `200 OK` |
| 12 | Stats | `GET` | `/stats` | Menampilkan ringkasan statistik perpustakaan | `200 OK` |

---

## Detail Request & Response Hasil Pengujian

### 1. Books (`/api/books`)

#### A. `GET /api/books` — Daftar Semua Buku (`200 OK`)
**Response (`200 OK`):**
```json
{
    "data": [
        {
            "id": 1,
            "judul": "terliye",
            "penulis": "penulis",
            "penerbit": "penerbit",
            "tahun_terbit": "2012",
            "isbn": null,
            "stok": 1,
            "sampul": null,
            "category": {
                "id": 1,
                "nama_kategori": "Novel"
            },
            "created_at": "2026-11-06T17:57:46.000000Z",
            "updated_at": "2026-11-13T13:11:29.000000Z"
        }
    ]
}
```

#### B. `GET /api/books?judul=laravel` — Filter Buku (`200 OK`)
**Response (`200 OK`):**
```json
{
    "data": [
        {
            "id": 2,
            "judul": "pemograman laravel",
            "penulis": "manda",
            "penerbit": "manda",
            "tahun_terbit": "2026",
            "isbn": null,
            "stok": 3,
            "sampul": null,
            "category": {
                "id": 3,
                "nama_kategori": "Cerpen"
            },
            "created_at": "2026-11-13T13:06:48.000000Z",
            "updated_at": "2026-11-13T13:06:48.000000Z"
        }
    ]
}
```

#### C. `GET /api/books/999` — Detail Buku Tidak Ditemukan (`404 Not Found`)
**Response (`404 Not Found`):**
```json
{
    "message": "No query results for model [App\\Models\\Book] 999"
}
```

#### D. `POST /api/books` — Tambah Buku Baru (`201 Created`)
**Request Body:**
```json
{
    "judul": "Clean Code",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "stok": 4,
    "category_id": 1
}
```
**Response (`201 Created`):**
```json
{
    "data": {
        "id": 3,
        "judul": "Clean Code",
        "penulis": "Robert C. Martin",
        "penerbit": "Prentice Hall",
        "tahun_terbit": 2008,
        "isbn": null,
        "stok": 4,
        "sampul": null
    }
}
```

#### E. `POST /api/books` — Uji Validasi Gagal (`422 Unprocessable Content`)
**Request Body:** `{}`  
**Response (`422 Unprocessable Content`):**
```json
{
    "message": "The judul field is required. (and 5 more errors)",
    "errors": {
        "judul": ["The judul field is required."],
        "penulis": ["The penulis field is required."],
        "penerbit": ["The penerbit field is required."]
    }
}
```

#### F. `PUT /api/books/3` — Update Data Buku (`200 OK`)
**Request Body:**
```json
{
    "judul": "Clean Code Edisi Revisi",
    "penulis": "Robert C. Martin",
    "penerbit": "Prentice Hall",
    "tahun_terbit": 2008,
    "stok": 4,
    "category_id": 1
}
```
**Response (`200 OK`):**
```json
{
    "data": {
        "id": 3,
        "judul": "Clean Code Edisi Revisi",
        "penulis": "Robert C. Martin",
        "penerbit": "Prentice Hall",
        "tahun_terbit": 2008,
        "isbn": null,
        "stok": 4,
        "sampul": null,
        "category": {
            "id": 1
        }
    }
}
```

#### G. `DELETE /api/books/3` — Hapus Buku (`200 OK`)
**Response (`200 OK`):**
```json
{
    "message": "Buku berhasil dihapus."
}
```

---

### 2. Members (`/api/members`)

#### `GET /api/members` & `GET /api/members/1` (`200 OK`)
Mengembalikan daftar anggota maupun detail satu anggota beserta informasi relasinya.

---

### 3. Loans (`/api/loans`)

#### A. `POST /api/loans` — Transaksi Peminjaman Baru (`201 Created`)
**Request Body:**
```json
{
    "member_id": 1,
    "user_id": 1,
    "tanggal_pinjam": "2026-11-14",
    "tanggal_kembali": "2026-11-21",
    "book_ids": [1]
}
```
**Response (`201 Created`):**