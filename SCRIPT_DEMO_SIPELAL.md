# SCRIPT DEMO SIPELAL
## Sistem Informasi Peminjaman Alat Laboratorium
### Kelompok Plenger — UAS Pemrograman Web 2

**Anggota:**
- Sulistiani Nasya Marzu (Ketua)
- Yessi Hermadani (Anggota)

**Durasi Target:** 15–30 menit

---

## PEMBAGIAN PERAN

| Bagian | Pembicara | Durasi |
|--------|-----------|--------|
| 1. Opening | **BERDUA** (Nasya mulai, Yessi lanjut) | ~2 m |
| 2. Landing Page | **NASYA** | ~2 m |
| 3. Registrasi & Login | **YESSI** | ~2 m |
| 4. Dashboard Mahasiswa | **YESSI** | ~3 m |
| 5. Katalog Alat | **NASYA** | ~2 m |
| 6. Formulir Peminjaman | **YESSI** | ~3 m |
| 7. Riwayat & QR Code | **NASYA** | ~2 m |
| 8. Dashboard Dosen | **NASYA** | ~3 m |
| 9. Dashboard Admin Lab | **YESSI** | ~5 m |
| 10. Dashboard Super Admin | **NASYA** | ~3 m |
| 11. Notifikasi & Laporan | **BERDUA** (Yessi notif, Nasya laporan) | ~3 m |
| 12. Penutup | **BERDUA** (Yessi review, Nasya closing) | ~2 m |
| | **TOTAL NASYA** | **~16 m** |
| | **TOTAL YESSI** | **~16 m** |

---

## 1. OPENING

**(BERDUA — Nasya mulai, Yessi lanjut)**

### 🔊 NASYA:
> Assalamualaikum warahmatullahi wabarakatuh!
>
> Halo semuanya! Perkenalkan, kami dari **Kelompok Plenger** — bukan "pelenger" yang nganggur ya, tapi "P-L-E-N-G-E-R" yang artinya... *Programmer Lenkap Gerakannya!* (atau terserah kalian mau definisi lucu apa, hehe).
>
> Kenapa sih nama kelompoknya Plenger? Karena kami berdua itu kerjanya *pleenger-pleenger* di depan laptop mulu sampe lupa waktu. Jadilah Plenger!
>
> Oke, perkenalkan, yang ini aku — **Sulistiani Nasya Marzu**, sebagai ketua kelompok. Tugas aku di sini: ngatur jadwal, ngurusin anggota, dan yang paling penting — pastiin anggota ga molor kerjanya.

### 🔊 YESSI:
> Dan yang ini aku — **Yessi Hermadani**, sebagai anggota. Tugas aku: bantuin ketua biar ga stres sendirian, dan jadi tukang ngoding kalau ada bug yang bikin nangis tengah malem.
>
> *Bergurau sedikit ya* — jadi ceritanya kami berdua itu kerja bareng dari nol, dari yang namanya cuma "tugas UAS" sampe akhirnya jadi sistem yang beneran bisa dipake. Alhamdulillah ya~

### 🔊 NASYA:
> Di kesempatan yang berkah ini, kami akan mempresentasikan hasil kerja kami untuk mata kuliah **Pemrograman Web 2**. Judulnya: **SIPELAL** — atau kepanjangannya, **Sistem Informasi Peminjaman Alat Laboratorium**.
>
> Jadi ceritanya nih, di kampus kita itu Alhamdulillah laboratoriumnya banyak banget ya — Lab TI, Lab SI, dan lain-lain. Tapi kadang ada masalah: alatnya mau dipinjam susah, pencatatannya masih manual, bolak-balik kertas, kadang alatnya ga ketahuan dipinjam siapa. Nah, dari masalah itulah SIPELAL lahir!

### 🔊 YESSI:
> SIPELAL ini dibangun menggunakan **Laravel 11** dengan **Tailwind CSS**, **Alpine.js**, dan beberapa library pendukung lainnya. Yang bikin menarik, sistem ini punya **4 role pengguna** dengan alur peminjaman **dua tahap verifikasi** — jadi ada yang approve dari dosen, baru kemudian admin lab yang konfirmasi.
>
> Oke, langsung saja ya kita mulai demo-nya! Siap-siap jangan ke mana-mana~

---

## 2. LANDING PAGE

**(Durasi: ~2 menit — NASYA)**

### 🔊 NASYA:
> Nah, ini adalah **halaman utama** atau landing page SIPELAL.
>
> *(Tunjukkan bagian hero/banner)*
>
> Di bagian atas ini ada **hero section** yang langsung menampilkan nama aplikasi dan tagline-nya. Desainnya responsif, jadi bisa diakses dari HP maupun laptop.
>
> *(Scroll ke bawah)*
>
> Kalau kita scroll ke bawah, ada bagian **fitur-fitur unggulan** SIPELAL — mulai dari katalog alat, peminjaman online, notifikasi otomatis, sampai laporan yang bisa di-export.
>
> *(Tunjukkan bagian alur/flow)*
>
> Di sini juga ada **alur peminjaman** yang dijelaskan step by step: dari mahasiswa pinjam, dosen approve, admin lab konfirmasi, sampai pengembalian. Jadi user baru langsung paham bagaimana cara pakai sistem ini.
>
> *(Tunjukkan bagian FAQ accordion)*
>
> Ada juga **FAQ** atau Frequently Asked Questions yang bisa di-expand kalau ada pertanyaan umum. Tinggal klik, langsung muncul jawabannya. Ini pake Alpine.js jadi ga perlu reload halaman.
>
> Di bagian bawah ada **Call to Action** — tombol untuk langsung login atau daftar. Kita lanjut ke sana ya~

---

## 3. REGISTRASI & LOGIN

**(Durasi: ~2 menit — YESSI)**

### 🔊 YESSI:
> *(Klik tombol Daftar/Login)*
>
> Ini adalah halaman **Login**. Tampilannya simpel tapi elegan — ada input email dan password, plus tombol login.
>
> *(Tunjukkan halaman register)*
>
> Nah, kalau belum punya akun, bisa klik **Daftar** di sini. Form registrasinya ada: nama lengkap, email, password, NIM, program studi, dan angkatan. Yang menarik, begitu registrasi, role-nya otomatis jadi **Mahasiswa** — jadi tidak perlu admin yang assign manual.
>
> *(Klik register / atau tunjukkan sudah terdaftar)*
>
> Mari kita coba login. Kita pakai akun yang sudah ada di database ya.
>
> *(Login sebagai Mahasiswa)*
>
> Kita masuk sebagai **Mahasiswa** dulu ya, biar bisa lihat perspektif dari sisi peminjam.

---

## 4. DASHBOARD MAHASISWA

**(Durasi: ~3 menit — YESSI)**

### 🔊 YESSI:
> Nah, ini **Dashboard Mahasiswa**. Mari kita bedah satu per satu.
>
> *(Tunjukkan statistik di dashboard)*
>
> Di bagian atas ada **ringkasan statistik**: jumlah total peminjaman, peminjaman aktif, peminjaman selesai, dan denda yang belum dibayar. Jadi mahasiswa langsung tahu kondisi peminjaman mereka dalam sekali lihat.
>
> *(Tunjukkan sidebar/navigation)*
>
> Di sebelah kiri (atau atas kalau di HP), ada **menu navigasi**: Dashboard, Katalog, Pinjam Alat, Riwayat, Scan QR, Denda, dan Notifikasi.
>
> *(Tunjukkan list peminjaman terakhir)*
>
> Di bagian bawah dashboard ada **daftar peminjaman terakhir** beserta statusnya — bisa PENDING, DISETUJUI_DOSEN, DIPINJAM, atau DITOLAK. Semuanya ditampilin dengan badge warna yang beda biar gampang dibedain.
>
> Kita lanjut ke katalog ya~

---

## 5. KATALOG ALAT

**(Durasi: ~2 menit — NASYA)**

### 🔊 NASYA:
> Ini dia **Katalog Peralatan**. Di sini mahasiswa bisa lihat semua alat yang tersedia di seluruh laboratorium.
>
> *(Tunjukkan list alat)*
>
> Setiap alat ditampilkan dalam bentuk **card** — ada foto, nama alat, kode alat, kategori, dan lokasi lab-nya. Bisa dipaginasi juga kalau alatnya banyak.
>
> *(Klik salah satu alat untuk detail)*
>
> Kalau diklik, masuk ke **halaman detail** alat. Di sini ada info lebih lengkap: merk, model, spesifikasi, kondisi tiap unit, dan jumlah unit yang tersedia.
>
> *(Tunjukkan kategori filter atau search)*
>
> Mahasiswa bisa cari alat berdasarkan **kode** atau **nama**. Jadi kalau mau cari "Arduino" tinggal ketik, langsung muncul. Ga perlu scroll satu-satu.

---

## 6. FORMULIR PEMINJAMAN

**(Durasi: ~3 menit — YESSI)**

### 🔊 YESSI:
> Sekarang kita ke bagian inti — **Formulir Peminjaman Alat**.
>
> *(Buka halaman pinjam)*
>
> Di sini mahasiswa mengisi formulir peminjaman. Mari kita isi bareng-bareng:
>
> *(Isi form sambil menjelaskan)*
>
> 1. **Tanggal Ambil** — pilih tanggal kapan alat mau diambil.
> 2. **Tanggal Kembali Rencana** — pilih tanggal rencana pengembalian. Sistem akan otomatis hitung apakah melewati batas waktu atau tidak. Untuk mahasiswa, batas maksimal peminjaman adalah **7 hari**.
> 3. **Pilih Unit Alat** — di sini mahasiswa bisa memilih unit alat mana saja yang mau dipinjam. Bisa lebih dari satu, tapi maksimal **5 item** per peminjaman.
> 4. **Tujuan Peminjaman** — ada beberapa opsi: praktikum, tugas akhir, penelitian, UKM, atau kegiatan lainnya.
> 5. **Mata Kuliah** — pilih mata kuliah yang terkait.
> 6. **Dosen Pembimbing** — pilih dosen yang akan menyetujui peminjaman ini.
>
> *(Submit form)*
>
> Setelah di-submit, peminjaman ini akan masuk ke status **PENDING** dan otomatis dikirimkan ke dosen yang dipilih untuk proses verifikasi pertama.
>
> *(Tunjukkan notifikasi atau perubahan status)*
>
> Nah, sekarang kita beralih ke sisi **Dosen** ya~ Untuk lihat bagaimana dosen merespon peminjaman ini.

---

## 7. RIWAYAT PEMINJAMAN & QR CODE

**(Durasi: ~2 menit — NASYA)**

### 🔊 NASYA:
> Sebelum ke dosen, kita lihat dulu **Riwayat Peminjaman** si mahasiswa ini.
>
> *(Buka halaman riwayat)*
>
> Di sini ada daftar semua peminjaman yang pernah dilakukan — lengkap dengan tanggal, status, dan jumlah item. Bisa dipaginasi juga.
>
> *(Klik salah satu untuk detail)*
>
> Kalau diklik, ada **detail peminjaman**: semua info lengkap dari siapa yang pinjam, alat apa saja, tanggal ambil-kembali, sampai kondisi alat saat dikembalikan.
>
> *(Buka halaman scan QR)*
>
> Nah, yang menarik, SIPELAL juga punya fitur **Scan QR Code**! Setiap peminjaman punya UUID unik yang bisa di-generate jadi QR code. Tinggal scan, langsung muncul detail peminjaman-nya. Ini berguna banget buat admin lab waktu proses serah terima — ga perlu ketik kode manual, tinggal scan aja.

---

## 8. DASHBOARD DOSEN — VERIFIKASI

**(Durasi: ~3 menit — NASYA)**

### 🔊 NASYA:
> Sekarang kita **logout** dulu, dan login sebagai **Dosen**.
>
> *(Logout, login sebagai dosen)*
>
> Ini **Dashboard Dosen**. Di sini dosen bisa melihat:
> - Jumlah peminjaman yang menunggu persetujuan
> - Peminjaman terakhir yang sudah di-approve atau ditolak
>
> *(Buka halaman approval dosen)*
>
> Kita masuk ke menu **Approval**. Di sini daftar semua peminjaman yang ditujukan ke dosen ini dan masih berstatus **PENDING**.
>
> *(Tunjukkan salah satu peminjaman)*
>
> Dosen bisa lihat detail: siapa mahasiswanya, alat apa yang dipinjam, tanggalnya, tujuannya, mata kuliah apa. Setelah yakin, dosen bisa klik **Setuju** atau **Tolak**.
>
> *(Klik Setuju)*
>
> Begitu dosen klik **Setuju**, status peminjaman berubah menjadi **DISETUJUI_DOSEN**. Sekarang peminjaman ini akan masuk ke antrian **Admin Lab** untuk proses approve tahap kedua.
>
> *(Tunjukkan juga fitur tolak)*
>
> Kalau dosen rasa ada yang kurang sesuai, bisa juga klik **Tolak** — dan statusnya jadi **DITOLAK**.

---

## 9. DASHBOARD ADMIN LAB — APPROVAL & PENGEMBALIAN

**(Durasi: ~5 menit — YESSI)**

### 🔊 YESSI:
> Sekarang kita ke **Admin Lab**. Logout dulu ya~
>
> *(Logout, login sebagai admin lab)*
>
> Ini **Dashboard Admin Lab**. Di sini statistiknya lebih detail: total alat, total unit, jumlah peminjaman pending, peminjaman aktif, dan lain-lain.
>
> ### A. Manajemen Alat
> *(Buka menu Alat)*
>
> Admin Lab bisa **CRUD Alat** — tambah, edit, hapus. Setiap alat punya: kode, nama, kategori, merk, model, spesifikasi, dan foto. Foto-fotonya disimpan di storage lokal.
>
> *(Tunjukkan form tambah alat)*
>
> Di form tambah alat, admin bisa upload foto, pilih kategori, isi spesifikasi, dan sebagainya.
>
> ### B. Manajemen Unit
> *(Buka menu Unit)*
>
> Selain alat, admin juga mengelola **Unit** — ini adalah unit fisik dari setiap alat. Misalnya alat "Arduino Uno" punya 3 unit dengan kode ARD-001, ARD-002, ARD-003. Setiap unit punya kondisi: BAIK, PERLU PERHATIAN, RUSAK RINGAN, RUSAK BERAT, atau TIDAK BISA DIPINJAM.
>
> ### C. Manajemen Kategori
> *(Buka menu Kategori)*
>
> Admin juga bisa mengelola **Kategori Alat** — seperti Elektronik, Komputer, Jaringan, Mikrokontroler, Multimedia.
>
> ### D. Approval Peminjaman
> *(Buka menu Approval)*
>
> Nah, ini yang penting — **Approval Peminjaman**. Di sini admin lab melihat peminjaman yang sudah disetujui dosen dan menunggu konfirmasi admin.
>
> *(Tunjukkan list peminjaman)*
>
> Admin bisa lihat detail, lalu klik **Setuju** atau **Tolak**. Begitu disetujui, status berubah jadi **DIPINJAM** — artinya alat bisa diambil.
>
> Ada juga tombol **Serah Terima** — ini dicatat ketika alat benar-benar diserahkan ke mahasiswa secara fisik.
>
> ### E. Pengembalian
> *(Buka menu Pengembalian)*
>
> Ini menu **Pengembalian**. Admin melihat daftar peminjaman yang masih aktif (alat belum dikembalikan).
>
> *(Proses pengembalian)*
>
> Ketika mahasiswa mengembalikan alat, admin mencatat **kondisi alat saat dikembalikan** — misalnya BAIK, RUSAK RINGAN, atau RUSAK BERAT. Admin juga bisa menambahkan **catatan kerusakan** jika ada.
>
> **Yang menarik**, kalau tanggal pengembalian melewati tanggal rencana, sistem **otomatis menghitung denda**! Misalnya terlambat 2 hari, dan denda per hari Rp 5.000, maka otomatis jadi Rp 10.000.

---

## 10. DASHBOARD SUPER ADMIN — KELOLA USER & DENDA

**(Durasi: ~3 menit — NASYA)**

### 🔊 NASYA:
> Dan yang terakhir, kita login sebagai **Super Admin**.
>
> *(Logout, login sebagai super admin)*
>
> Ini **Dashboard Super Admin** — ini adalah role tertinggi di SIPELAL. Di sini ada **statistik global** dari seluruh sistem: total alat, total unit, total user, total peminjaman, peminjaman pending, dan peminjaman aktif.
>
> ### A. Manajemen User
> *(Buka menu Users)*
>
> Super Admin bisa **mengelola semua user** — tambah, edit, hapus, dan toggle status ACTIVE/SUSPENDED. Bisa cari berdasarkan nama, email, atau NIM, dan filter berdasarkan role atau status.
>
> *(Tunjukkan form buat user baru)*
>
> Di sini super admin bisa buat user baru dengan role apa saja — mahasiswa, dosen, admin lab, atau bahkan super admin lain.
>
> ### B. Semua Peminjaman
> *(Buka menu Loans)*
>
> Super Admin bisa melihat **seluruh peminjaman** di semua lab, tidak terbatas pada satu lab saja.
>
> ### C. Denda
> *(Buka menu Fines)*
>
> Super Admin juga bisa melihat **semua denda** dari seluruh sistem. Kalau mahasiswa sudah bayar denda, admin bisa tandai sebagai **sudah dibayar**.
>
> ### D. Activity Log
> *(Buka menu Activity Log)*
>
> Dan ini yang terakhir tapi ga kalah keren — **Activity Log**. Semua perubahan data di sistem ini tercatat: siapa yang mengubah, kapan, dan perubahan apa saja yang dilakukan. Ini penting untuk audit trail.

---

## 11. NOTIFIKASI & LAPORAN (EXPORT PDF/EXCEL)

**(Durasi: ~3 menit — BERDUA: Yessi notifikasi, Nasya laporan)**

### 🔊 YESSI:
> ### A. Sistem Notifikasi
> *(Tunjukkan halaman notifikasi)*
>
> SIPELAL punya **sistem notifikasi in-app**. Setiap kali ada perubahan status — misalnya peminjaman disetujui dosen, ditolak admin, atau sudah dikembalikan — user akan menerima notifikasi.
>
> *(Tunjukkan badge notifikasi di header)*
>
> Di header ada **badge angka** yang menunjukkan jumlah notifikasi belum dibaca. Klik ikon lonceng, langsung masuk ke halaman notifikasi. Ada tombol **Tandai Semua Sudah Dibaca** juga.

### 🔊 NASYA:
> ### B. Laporan & Export
> *(Login sebagai admin lab, buka menu Laporan)*
>
> Admin Lab bisa mengakses **Laporan** yang bisa difilter berdasarkan rentang tanggal. Lalu, ada dua opsi export:
>
> *(Klik Export PDF)*
>
> Pertama, **Export PDF** — ini menghasilkan file PDF dengan format resmi, ada kop surat, tabel data peminjaman, dan total peminjaman. Cocok untuk laporan formal ke pimpinan.
>
> *(Klik Export Excel)*
>
> Kedua, **Export Excel** — ini menghasilkan file spreadsheet (.xlsx) dengan 13 kolom data yang lengkap dan terformat. Berguna untuk analisis data lebih lanjut di Excel.

---

## 12. PENUTUP

**(BERDUA — Yessi review, Nasya tutup)**

### 🔊 YESSI:
> Oke, itu tadi demo dari **SIPELAL** — Sistem Informasi Peminjaman Alat Laboratorium dari **Kelompok Plenger**.
>
> Mari kita review sebentar fitur-fitur yang sudah kami tunjukkan:
>
> 1. **Landing Page** yang informatif dan responsif
> 2. **4 Role Pengguna** — Mahasiswa, Dosen, Admin Lab, dan Super Admin
> 3. **Katalog Alat** yang bisa dicari dan difilter
> 4. **Alur Peminjaman 2 Tahap Verifikasi** — Dosen approve dulu, baru Admin Lab konfirmasi
> 5. **Manajemen Alat, Unit, dan Kategori** lengkap
> 6. **Fitur Scan QR Code** untuk identifikasi peminjaman
> 7. **Perhitungan Denda Otomatis** untuk keterlambatan pengembalian
> 8. **Sistem Notifikasi In-App** yang real-time
> 9. **Export Laporan** dalam format PDF dan Excel
> 10. **Activity Log** untuk audit trail perubahan data

### 🔊 NASYA:
> Dengan SIPELAL, kami berharap proses peminjaman alat laboratorium di kampus bisa lebih **terorganisir**, **transparan**, dan **efisien**. Ga ada lagi cerita alat hilang ga ketahuan siapa yang pinjam, atau lupa tanggal kembali.
>
> Tentu saja, SIPELAL ini masih bisa dikembangkan lebih lanjut — misalnya integrasi dengan WhatsApp notifikasi, atau fitur booking alat di masa depan. Tapi untuk saat ini, kami rasa fitur yang ada sudah cukup untuk memenuhi kebutuhan dasar peminjaman alat lab.
>
> Terima kasih banyak atas perhatiannya! Semoga ilmunya bermanfaat dan sistemnya bisa dipakai di kampus kita. Kalau ada pertanyaan, silakan langsung tanya ke kami berdua.
>
> Wassalamualaikum warahmatullahi wabarakatuh!
>
> — **Kelompok Plenger**, *Sulistiani Nasya Marzu & Yessi Hermadani*

---

## CATATAN TAMBAHAN UNTUK PRESENTER

### Rincian Waktu per Pembicara

| Pembicara | Bagian | Total Durasi |
|-----------|--------|-------------|
| **NASYA** | Opening (bagian 1), Landing Page, Katalog, Riwayat & QR, Dashboard Dosen, Super Admin, Notifikasi (bagian 2), Penutup (bagian 2) | **~16 menit** |
| **YESSI** | Opening (bagian 2), Registrasi & Login, Dashboard Mahasiswa, Formulir Peminjaman, Admin Lab, Notifikasi (bagian 1), Penutup (bagian 1) | **~16 menit** |

### Tips Demo
1. **Siapkan akun yang sudah terdaftar** di setiap role supaya tidak buang waktu registrasi.
2. **Pastikan database sudah di-seed** dengan data yang cukup (jalankan `php artisan db:seed`).
3. **Gunakan browser mode gelap/terang** yang konsisten supaya tampilan rapi.
4. **Jangan terlalu cepat** scroll — beri jeda supaya dosen penguji bisa ikut melihat.
5. **Tunjukkan URL/route** di address bar supaya penguji tahu navigasinya.
6. **Siapkan data dummy** untuk ditampilkan: minimal 1 peminjaman di setiap status (PENDING, DISETUJUI_DOSEN, DIPINJAM, DIKEMBALIKAN, DITOLAK).
7. **Test semua role login** sebelum demo dimulai — pastikan tidak ada error 403/500.
8. **Backup jalur**: kalau fitur QR scanner tidak bisa demo (butuh kamera), cukup jelaskan konsepnya saja.
9. **Gantian pegang laptop**: yang lagi ngomong yang operasi browser, yang satunya fokus ngomong.

### Data Yang Perlu Disiapkan Sebelum Demo
- Akun Super Admin: `admin@sipelal.test`
- Akun Admin Lab: `admin1@sipelal.test` atau `admin2@sipelal.test`
- Akun Dosen: `dosen1@sipelal.test` atau `dosen2@sipelal.test`
- Akun Mahasiswa: `mahasiswa1@sipelal.test` (atau daftar baru)
- Minimal 5-10 data alat dengan foto
- Minimal 3-5 data peminjaman dengan status berbeda
- Minimal 1-2 data denda

### Jalankan Seed Dulu!
```bash
php artisan migrate:fresh --seed
```
