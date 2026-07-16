# SIPELAL - Sistem Informasi Peminjaman Alat Laboratorium

<div align="center">

**STMIK Lombok**

**Program Studi Sistem Informasi**

---

**Mata Kuliah: Pemrograman Web 2**

**Dosen Pengampu: Jihadul Akbar, S.Kom**

---

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

</div>

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Langkah Instalasi](#langkah-instalasi)
- [Cara Menjalankan Aplikasi](#cara-menjalankan-aplikasi)
- [Akun Demo](#akun-demo)
- [Struktur Database](#struktur-database)
- [Screenshot Aplikasi](#screenshot-aplikasi)
- [Identitas Mahasiswa](#identitas-mahasiswa)
- [Lisensi](#lisensi)

</div>

---

## Tentang Proyek

**SIPELAL** (Sistem Informasi Peminjaman Alat Laboratorium) adalah aplikasi web berbasis Laravel 11 yang menyediakan sistem digital untuk pengelolaan peminjaman dan inventaris alat laboratorium. Aplikasi ini dirancang untuk menggantikan proses peminjaman manual berbasis kertas dengan alur kerja digital yang efisien, memiliki sistem verifikasi dua tingkat, pelacakan kondisi alat, perhitungan denda otomatis, dan manajemen peran berbasis role.

---

## Fitur Utama

### Autentikasi & Otorisasi
- Registrasi dan login dengan verifikasi email
- 4 level peran: **Super Admin**, **Admin Lab**, **Dosen**, dan **Mahasiswa**
- Akses terkontrol berdasarkan role menggunakan middleware kustom
- Status pengguna: Aktif, Pending, dan Suspended

### Katalog & Inventaris Alat
- Katalog alat laboratorium dengan pencarian berdasarkan kode atau nama
- Detail alat lengkap: spesifikasi, merk, model, dan foto
- Manajemen unit alat dengan pelacakan kondisi (Baik, Perlu Perhatian, Rusak Ringan, Rusak Berat)
- CRUD alat, unit, dan kategori oleh Admin Lab (ter Scoped per lab)
- Tersedia 5 kategori: Elektronik, Komputer, Jaringan, Mikrokontroler, Multimedia

### Alur Peminjaman Dua Tingkat
1. **Mahasiswa** mengajukan peminjaman (pilih unit, tanggal, tujuan, dosen pembimbing)
2. **Dosen** menyetujui atau menolak (approval tingkat pertama)
3. **Admin Lab** menyetujui atau menolak (approval tingkat kedua)
4. **Admin Lab** melakukan serah terima fisik alat
5. **Admin Lab** memproses pengembalian dengan pencatatan kondisi

### Denda & Pengembalian
- Perhitungan denda otomatis untuk pengembalian terlambat (Rp 5.000/hari)
- Command otomatis (`denda:hitung`) berjalan setiap hari
- Reminder pengembalian H-1 via notifikasi (`notif:h1-deadline`)
- Pencatatan kondisi alat saat pinjam dan kembali

### Laporan & Ekspor
- Laporan peminjaman dengan filter tanggal
- Ekspor PDF (DomPDF) dan Excel (Maatwebsite/Excel)
- Kop surat otomatis untuk cetakan PDF

### Fitur Lainnya
- Sistem notifikasi in-app dengan badge counter
- QR Code scanning untuk identifikasi peminjaman
- Activity log / audit trail (Spatie Activity Log)
- Dashboard kustom per role dengan statistik relevan
- Konfigurasi parameter: max hari pinjam, max item per pinjam, max pinjam aktif, dll

---

## Teknologi yang Digunakan

### Backend
| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| PHP | ^8.2 | Bahasa pemrograman utama |
| Laravel | ^11.31 | Framework MVC |
| Laravel Breeze | ^2.4 | Autentikasi scaffolding |
| Laravel Sanctum | ^4.3 | API token authentication |
| Spatie Laravel Permission | ^6.25 | Manajemen role & permission |
| Spatie Laravel Activity Log | ^4.12 | Audit trail / activity logging |
| DomPDF | ^3.1 | Generate laporan PDF |
| Maatwebsite Excel | * | Export laporan Excel |
| Simple QRCode | * | Generate QR Code |

### Frontend
| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| Tailwind CSS | ^3.4.13 | CSS utility-first framework |
| Alpine.js | ^3.15.12 | JavaScript lightweight framework |
| Vite | ^6.0.11 | Build tool & dev server |
| Axios | ^1.7.4 | HTTP client |

### Infrastructure
| Komponen | Keterangan |
|----------|------------|
| Database | SQLite (default) / MySQL / MariaDB |
| Session | Database driver |
| Queue | Database driver |
| Cache | Database driver |

---

## Persyaratan Sistem

- **PHP** >= 8.2 (dengan ekstensi: Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
- **Composer** (dependency manager PHP)
- **Node.js** >= 18.x dan **npm** (untuk build aset frontend)
- **SQLite** (default, sudah tersedia) atau **MySQL/MariaDB** (opsional)
- **Git** (untuk clone repository)

---

## Langkah Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/sulistiani-coder/sipelal.git
   cd sipelal
   ```

2. **Install dependensi PHP**

   ```bash
   composer install
   ```

3. **Install dependensi frontend**

   ```bash
   npm install
   ```

4. **Salin file environment**

   ```bash
   cp .env.example .env
   ```

5. **Generate application key**

   ```bash
   php artisan key:generate
   ```

6. **Jalankan migrasi dan seed database**

   ```bash
   php artisan migrate --seed
   ```

7. **Build aset frontend**

   ```bash
   npm run dev
   ```

---

## Cara Menjalankan Aplikasi

1. **Jalankan development server Laravel** (terminal pertama):

   ```bash
   php artisan serve
   ```

2. **Jalankan Vite dev server** (terminal kedua):

   ```bash
   npm run dev
   ```

3. Buka browser dan akses:

   ```
   http://localhost:8000
   ```

4. Login menggunakan akun demo yang tersedia (lihat bagian Akun Demo di bawah).

### Perintah Penting Lainnya

| Perintah | Keterangan |
|----------|------------|
| `php artisan migrate:fresh --seed` | Reset dan seed ulang database |
| `php artisan test` | Jalankan unit test |
| `php artisan db:seed --class=SipelalSeeder --force` | Seed ulang data awal |
| `php artisan denda:hitung` | Hitung denda terlambat (otomatis via scheduler) |
| `php artisan notif:h1-deadline` | Kirim notifikasi H-1 deadline (otomatis via scheduler) |

### Konfigurasi Database (MySQL/MariaDB)

Jika menggunakan MySQL/MariaDB, edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipelal
DB_USERNAME=root
DB_PASSWORD=
```

---

## Akun Demo

### Video Demo

[![Watch on YouTube](https://img.shields.io/badge/Watch_on_YouTube-FF0000?style=for-the-badge&logo=youtube&logoColor=white)](https://youtube.com/@sulistianinasyamarzu?si=ZIxWm7TP6dZVqnes)

### Akun Login

| Role | Email | Password | Keterangan |
|------|-------|----------|------------|
| Super Admin | `admin@sipelal.test` | `password` | Akses penuh ke seluruh sistem |
| Admin Lab TI | `admin1@sipelal.test` | `password` | Kelola alat Lab-TI, approval, pengembalian |
| Admin Lab SI | `admin2@sipelal.test` | `password` | Kelola alat Lab-SI, approval, pengembalian |
| Dosen | `dosen1@sipelal.test` | `password` | Approval peminjaman mahasiswa |
| Dosen | `dosen2@sipelal.test` | `password` | Approval peminjaman mahasiswa |
| Mahasiswa | `mahasiswa1@sipelal.test` | `password` | Ajukan peminjaman, lihat riwayat |
| Mahasiswa | *(register baru)* | - | Registrasi akun baru melalui halaman register |

---

## Struktur Database

### Diagram Relasi

```
┌──────────────┐     ┌──────────────────┐     ┌─────────────────┐
│     users    │────<│      loans       │>────│ equipment_units │
│              │     │                  │     │                 │
│ - id         │     │ - id             │     │ - id            │
│ - role       │     │ - uuid           │     │ - equipment_id  │
│ - status     │     │ - kode_pinjam    │     │ - unit_code     │
│ - nim        │     │ - user_id (FK)   │     │ - kondisi       │
│ - prodi      │     │ - dosen_id (FK)  │     │ - lokasi        │
│ - angkatan   │     │ - tgl_ambil      │     │ - is_active     │
│ - name       │     │ - tgl_kembali_*  │     └─────────────────┘
│ - email      │     │ - tujuan         │              │
│ - password   │     │ - mata_kuliah    │              │
│ - lab_id(FK) │     │ - status         │              │
└──────────────┘     └──────────────────┘              │
       │                    │                           │
       │              ┌─────┴──────┐              ┌─────┴──────┐
       │              │ loan_items │              │ equipments │
       │              │            │              │            │
       │              │ - loan_id  │<─────────────│ - id       │
       │              │ - unit_id  │              │ - kode     │
       │              │ - kondisi_ │              │ - name     │
       │              │   pinjam   │              │ - merk     │
       │              │ - kondisi_ │              │ - model    │
       │              │   kembali  │              │ - foto     │
       │              └────────────┘              │ - cat.*    │
       │                                         └────────────┘
       │                                                 │
  ┌────┴─────┐                                  ┌────────┴───────┐
  │   labs   │                                  │ equip_categories│
  │          │                                  │                │
  │ - id     │                                  │ - id           │
  │ - nama   │                                  │ - name         │
  │ - kode   │                                  │ - description  │
  │ - lokasi │                                  └────────────────┘
  └──────────┘

  ┌──────────┐        ┌─────────────┐
  │  fines   │        │notifications│
  │          │        │             │
  │ - loan_id│        │ - user_id   │
  │ - jumlah │        │ - title     │
  │   _hari  │        │ - message   │
  │ - jumlah │        │ - read_at   │
  │   _denda │        └─────────────┘
  │ - is_paid│
  └──────────┘
```

### Daftar Tabel

| Tabel | Keterangan |
|-------|------------|
| `users` | Data pengguna (4 role: super_admin, admin_lab, dosen, mahasiswa) |
| `labs` | Data laboratorium (kode, nama, lokasi) |
| `equipment_categories` | Kategori alat (Elektronik, Komputer, Jaringan, dll) |
| `equipments` | Data alat laboratorium (kode, nama, merk, spesifikasi, foto) |
| `equipment_units` | Unit/unit alat (kode unit, kondisi, lokasi fisik) |
| `loans` | Data peminjaman (kode, tanggal, status, tujuan) |
| `loan_items` | Detail item peminjaman (pivot: loan ↔ unit, kondisi pinjam/kembali) |
| `fines` | Data denda (jumlah hari, nominal, status bayar) |
| `notifications` | Notifikasi in-app per pengguna |
| `activity_log` | Audit trail perubahan data (Spatie Activity Log) |
| `roles` | Daftar role (Spatie Permission) |
| `permissions` | Daftar permission (Spatie Permission) |

### Status Alur Peminjaman

```
PENDING → DISETUJUI_DOSEN → DISETUJUI_ADMIN → DIPINJAM → DIKEMBALIKAN
   │              │                                              
   └→ DITOLAK     └→ DITOLAK                                   
                                                       
DIPINJAM → TERLAMBAT (jika melewati tanggal kembali)
DIPINJAM → DIBATALKAN (dibatalkan)
```

---

## Screenshot Aplikasi

### 1. Landing Page
![Landing Page](landingpage.png)
*Halaman utama dengan hero section, fitur unggulan, dan CTA*

### 2. Halaman Login
![Login](formlogin.png)
*Form login dengan validasi dan pesan error*

### 3. Halaman Register
![Register](formregistrasi.png)
*Form registrasi mahasiswa (NIM, prodi, angkatan)*

### 4. Dashboard Mahasiswa
![Dashboard Mahasiswa](dashboardmahasiswa.png)
*Statistik pribadi: jumlah pinjam, aktif, dan denda*

### 5. Katalog Alat
![Katalog Alat](katalogalat.png)
*Grid card alat dengan pencarian dan detail*

### 6. Detail Alat
![Detail Alat](detailalat.png)
*Spesifikasi lengkap, unit tersedia, dan kondisi*

### 7. Form Peminjaman
![Form Peminjaman](formpeminjaman.png)
*Pemilihan unit, tanggal, tujuan, dan dosen pembimbing*

### 8. Riwayat Peminjaman
![Riwayat Peminjaman](riwayatpeminjaman.png)
*Daftar riwayat peminjaman dengan status badge*

### 9. Detail Peminjaman & QR Code
![Detail Pinjam QR](detailpeminjaman&qrcode.png)
*Detail peminjaman lengkap beserta QR Code*

### 10. Dashboard Admin Lab
![Dashboard Admin Lab](dashboardadminlab.png)
*Statistik lab, jumlah alat, unit, dan peminjaman*

### 11. Manajemen Alat (Admin)
![Manajemen Alat](manajemenalat.png)
*CRUD alat dengan foto dan kondisi unit*

### 12. Approval Dosen
![Approval Dosen](appropaldosen.png)
*Daftar peminjaman yang menunggu persetujuan dosen*

### 13. Approval Admin Lab
![Approval Admin](appropaladmin.png)
*Daftar peminjaman yang sudah disetujui dosen, menunggu admin*

### 14. Proses Pengembalian
![Pengembalian](prosespengembalian.png)
*Pencatatan kondisi alat saat pengembalian*

### 15. Dashboard Super Admin
![Dashboard Super Admin](dashboardsuperadmin.png)
*Statistik global, manajemen pengguna, dan monitoring*

### 16. Manajemen Pengguna (Super Admin)
![Manajemen User](manajemenuser.png)
*CRUD pengguna, toggle status aktif/suspended*

### 17. Laporan & Ekspor
![Laporan](laporan&ekspor.png)
*Halaman laporan dengan filter tanggal dan tombol export PDF/Excel*

### 18. Sistem Notifikasi
![Notifikasi](systemnotifikasi.png)
*Daftar notifikasi in-app dengan badge counter*

### 19. QR Code Scanner
![QR Scanner](qrcodescanner.png)
*Halaman scan QR Code untuk identifikasi peminjaman*

### 20. Activity Log
![Activity Log](activitylog.png)
*Log audit perubahan data oleh seluruh pengguna*

---

## Identitas Mahasiswa

| No | Nama | NIM | Prodi | Angkatan | GitHub |
|----|------|-----|-------|----------|--------|
| 1 | **Sulistiani Nasya Marzu** | SI21240018 | Sistem Informasi | 2024 | [sulistiani-coder](https://github.com/sulistiani-coder) |
| 2 | **Yessi Hermadani** | SI21240019 | Sistem Informasi | 2024 | - |

| | |
|---|---|
| **Mata Kuliah** | Pemrograman Web 2 |
| **Dosen Pengampu** | Jihadul Akbar, S.Kom |
| **Semester** | 4 |
| **Tahun Akademik** | 2026 |

---

## Lisensi

Proyek ini dilisensikan di bawah **MIT License**.

```
MIT License

Copyright (c) 2025 Kelompok Plenger

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

<div align="center">

**SIPELAL** - Sistem Informasi Peminjaman Alat Laboratorium

Dibuat oleh Kelompok Plenger - Sulistiani Nasya Marzu & Yessi Hermadani

</div>
