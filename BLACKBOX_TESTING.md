# BLACK BOX TESTING — SIPELAL
## Sistem Informasi Peminjaman Alat Laboratorium
### Kelompok Plenger — UAS Pemrograman Web 2

---

## Tabel 3. Pengujian Sistem dengan Black Box Testing

| No | Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|-----------|-----------|----------------------|-----------------|------------|
| 1 | Login Mahasiswa | Mahasiswa memasukkan email dan password yang valid | Sistem mengarahkan ke Dashboard Mahasiswa | Sesuai harapan | Berhasil |
| 2 | Login Mahasiswa | Mahasiswa memasukkan email atau password yang salah | Sistem menampilkan pesan error "These credentials do not match our records." | Sesuai harapan | Berhasil |
| 3 | Registrasi Akun Baru | Pengguna mengisi form registrasi (nama, email, NIM, prodi, angkatan, password) dengan lengkap dan valid | Akun berhasil dibuat dengan role "Mahasiswa" dan pengguna diarahkan ke halaman login | Sesuai harapan | Berhasil |
| 4 | Registrasi Akun Duplikat | Pengguna mencoba mendaftar dengan email yang sudah terdaftar | Sistem menolak registrasi dan menampilkan pesan "The email has already been taken." | Sesuai harapan | Berhasil |
| 5 | Lihat Katalog Alat | Mahasiswa membuka halaman katalog dan mengetik kata kunci "Arduino" pada kolom pencarian | Sistem menampilkan daftar alat yang mengandung kata "Arduino" | Sesuai harapan | Berhasil |
| 6 | Lihat Detail Alat | Mahasiswa mengklik salah satu alat di katalog | Sistem menampilkan halaman detail alat berupa merk, model, spesifikasi, kondisi tiap unit, dan jumlah unit tersedia | Sesuai harapan | Berhasil |
| 7 | Ajukan Peminjaman | Mahasiswa mengisi form peminjaman (tanggal ambil, tanggal kembali, memilih unit alat, tujuan, mata kuliah, dosen) dan mengklik "Pinjam" | Peminjaman berhasil disimpan dengan status "PENDING" dan dosen yang dipilih menerima notifikasi | Sesuai harapan | Berhasil |
| 8 | Validasi Form Peminjaman Kosong | Mahasiswa mengklik tombol "Pinjam" tanpa mengisi form sama sekali | Sistem menampilkan pesan validasi "Field ini wajib diisi" pada setiap kolom yang kosong | Sesuai harapan | Berhasil |
| 9 | Batas Maksimal Item Peminjaman | Mahasiswa memilih lebih dari 5 unit alat dalam satu pengajuan peminjaman | Sistem menampilkan pesan "Maksimal 5 item per peminjaman" dan mencegah pengajuan | Sesuai harapan | Berhasil |
| 10 | Verifikasi Peminjaman oleh Dosen | Dosen login, membuka menu Approval, lalu mengklik "Setuju" pada peminjaman mahasiswa | Status peminjaman berubah menjadi "DISETUJUI_DOSEN" dan admin lab menerima notifikasi | Sesuai harapan | Berhasil |
| 11 | Penolakan Peminjaman oleh Dosen | Dosen mengklik "Tolak" pada peminjaman mahasiswa dan memberikan alasan penolakan | Status peminjaman berubah menjadi "DITOLAK" dan mahasiswa menerima notifikasi penolakan | Sesuai harapan | Berhasil |
| 12 | Approval Peminjaman oleh Admin Lab | Admin Lab login, membuka menu Approval, lalu mengklik "Setuju" pada peminjaman yang sudah disetujui dosen | Status peminjaman berubah menjadi "DIPINJAM" dan mahasiswa menerima notifikasi persetujuan | Sesuai harapan | Berhasil |
| 13 | Serah Terima Alat oleh Admin Lab | Admin Lab mengklik tombol "Serah Terima" pada peminjaman yang sudah disetujui | Status serah terima tercatat dan waktu penyerahan alat tersimpan di sistem | Sesuai harapan | Berhasil |
| 14 | Pengembalian Alat oleh Admin Lab | Admin Lab membuka menu Pengembalian, memilih kondisi alat "BAIK", lalu mengklik "Proses Pengembalian" | Peminjaman status berubah menjadi "DIKEMBALIKAN" dan kondisi alat tercatat | Sesuai harapan | Berhasil |
| 15 | Perhitungan Denda Otomatis | Admin Lab memproses pengembalian alat yang dikembalikan 2 hari melewati tanggal rencana kembali | Sistem otomatis menghitung denda sebesar Rp 10.000 (2 hari × Rp 5.000/hari) dan data denda tersimpan | Sesuai harapan | Berhasil |
| 16 | Tambah Alat oleh Admin Lab | Admin Lab mengisi form tambah alat (kode, nama, kategori, merk, model, spesifikasi, foto) dan mengklik "Simpan" | Alat baru berhasil ditambahkan dan muncul di daftar katalog | Sesuai harapan | Berhasil |
| 17 | Tambah Unit Alat oleh Admin Lab | Admin Lab mengisi form tambah unit (kode unit, pilih alat, kondisi, lokasi) dan mengklik "Simpan" | Unit baru berhasil ditambahkan dan jumlah unit pada alat terkait bertambah | Sesuai harapan | Berhasil |
| 18 | CRUD Kategori oleh Admin Lab | Admin Lab menambahkan kategori baru bernama "Robotika", lalu mengedit namanya menjadi "Robotika & IoT", lalu menghapusnya | Kategori berhasil ditambah, diubah, dan dihapus sesuai urutan aksi | Sesuai harapan | Berhasil |
| 19 | Kelola User oleh Super Admin | Super Admin login, membuka menu Users, lalu mengklik "Create User" untuk membuat akun dosen baru | Akun dosen baru berhasil dibuat dan muncul di daftar user dengan role "dosen" | Sesuai harapan | Berhasil |
| 20 | Toggle Status User oleh Super Admin | Super Admin mengklik tombol "Toggle Status" pada akun mahasiswa yang berstatus ACTIVE | Status akun berubah menjadi "SUSPENDED" dan pengguna tersebut tidak dapat login | Sesuai harapan | Berhasil |
| 21 | Lihat Semua Peminjaman oleh Super Admin | Super Admin membuka menu Loans | Sistem menampilkan seluruh peminjaman dari semua laboratorium (tidak terbatas satu lab) | Sesuai harapan | Berhasil |
| 22 | Tandai Denda Sebagai Sudah Dibayar | Super Admin membuka menu Fines, lalu mengklik "Mark Paid" pada dunda yang belum dibayar | Status denda berubah menjadi "Sudah Dibayar" | Sesuai harapan | Berhasil |
| 23 | Lihat Activity Log oleh Super Admin | Super Admin membuka menu Activity Log | Sistem menampilkan log aktivitas perubahan data alat beserta informasi siapa yang mengubah, kapan, dan perubahan apa | Sesuai harapan | Berhasil |
| 24 | Notifikasi Masuk | Mahasiswa mengajukan peminjaman, lalu dosen yang ditunjuk membuka halaman notifikasi | Dosen menerima notifikasi dengan judul dan pesan yang sesuai berisi informasi peminjaman baru | Sesuai harapan | Berhasil |
| 25 | Tandai Semua Notifikasi Sudah Dibaca | Pengguna mengklik tombol "Tandai Semua Sudah Dibaca" pada halaman notifikasi | Semua notifikasi ditandai sudah dibaca dan badge angka di header hilang | Sesuai harapan | Berhasil |
| 26 | Export Laporan PDF oleh Admin Lab | Admin Lab membuka menu Laporan, memilih rentang tanggal, lalu mengklik "Export PDF" | File PDF berhasil diunduh berisi tabel data peminjaman dengan kop surat resmi dan total peminjaman | Sesuai harapan | Berhasil |
| 27 | Export Laporan Excel oleh Admin Lab | Admin Lab mengklik "Export Excel" pada halaman laporan | File spreadsheet (.xlsx) berhasil diunduh berisi 13 kolom data peminjaman yang terformat | Sesuai harapan | Berhasil |
| 28 | Filter Laporan Berdasarkan Tanggal | Admin Lab memilih tanggal awal "2025-01-01" dan tanggal akhir "2025-06-30" pada filter laporan | Sistem menampilkan hanya data peminjaman dalam rentang tanggal 1 Januari – 30 Juni 2025 | Sesuai harapan | Berhasil |
| 29 | Scan QR Code Peminjaman | Pengguna membuka halaman Scan, lalu memindai QR code milik suatu peminjaman | Sistem menampilkan detail peminjaman berdasarkan UUID yang discan | Sesuai harapan | Berhasil |
| 30 | Akses Halaman Tanpa Login | Pengguna mengakses URL `/dashboard` tanpa sesi login aktif | Sistem mengalihkan pengguna ke halaman login | Sesuai harapan | Berhasil |
| 31 | Akses Halaman Admin oleh Mahasiswa | Mahasiswa mencoba mengakses URL `/admin/dashboard` | Sistem menampilkan pesan "403 Forbidden — Unauthorized" | Sesuai harapan | Berhasil |
| 32 | Akses Halaman Super Admin oleh Admin Lab | Admin Lab mencoba mengakses URL `/super-admin/dashboard` | Sistem menampilkan pesan "403 Forbidden — Unauthorized" | Sesuai harapan | Berhasil |

---

## Ringkasan Hasil Pengujian

| Kategori Pengujian | Jumlah Test Case | Berhasil | Gagal |
|---------------------|-----------------|----------|-------|
| Autentikasi & Otorisasi | 6 | 6 | 0 |
| Katalog & Detail Alat | 2 | 2 | 0 |
| Peminjaman (Mahasiswa) | 3 | 3 | 0 |
| Verifikasi Dosen | 2 | 2 | 0 |
| Approval & Pengembalian Admin Lab | 4 | 4 | 0 |
| Manajemen Alat/Unit/Kategori | 3 | 3 | 0 |
| Super Admin (User, Denda, Log) | 4 | 4 | 0 |
| Notifikasi | 2 | 2 | 0 |
| Laporan & Export | 3 | 3 | 0 |
| QR Code | 1 | 1 | 0 |
| Keamanan Akses | 2 | 2 | 0 |
| **TOTAL** | **32** | **32** | **0** |
