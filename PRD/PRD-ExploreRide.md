# PRODUCT REQUIREMENT DOCUMENT (PRD)

## Project: ExploreRide (MVP Version)

| | |
|---|---|
| **Nama Produk** | ExploreRide |
| **Platform** | Web-based App (Laravel + Blade) |
| **Tech Stack** | Laravel, Blade, SSE, Bootstrap, kstmostofa/laravel-whatsapp |
| **Product Manager** | Nazmi |
| **Status** | Draft / Ready for Review |

---

## 1. Overview & Ringkasan Produk

### 1.1 Latar Belakang

Wisatawan domestik maupun asing sering kali menghadapi kesulitan dalam merencanakan transportasi saat berlibur. Proses pemesanan rental mobil, pencarian sopir yang andal, hingga penyusunan rute wisata sering kali terpisah-pisah, manual, dan tidak efisien.

ExploreRide hadir sebagai **one-stop solution** yang mengintegrasikan penyewaan mobil harian, layanan sopir, sekaligus paket perjalanan wisata dalam satu platform yang mudah digunakan oleh orang awam sekalipun.

Homepage ExploreRide berfungsi sebagai **discovery layer** yang menampilkan rekomendasi destinasi wisata per kategori (Pantai, Gunung, Air Terjun) tanpa search — Netflix-style — untuk menginspirasi pengguna sebelum melakukan booking.

### 1.2 Tujuan (Objectives)

- Menyediakan platform pemesanan rental mobil dan paket wisata berbasis harian yang andal tanpa kendala teknis (bug-free).
- Mempermudah operasional Admin dalam mengelola armada, menetapkan sopir, serta mengaktifkan/menonaktifkan layanan secara fleksibel.
- Menyajikan antarmuka pengguna (UI/UX) yang ramah untuk pengguna awam agar proses booking berjalan mulus.

### 1.3 Warna & Tema Desain

- **Base Color:** Putih (`#FFFFFF`)
- **Primary Color:** Hijau (`#198754` / Bootstrap `success`)
- **Framework CSS:** Bootstrap 5

---

## 2. Target Pengguna & Persona

### User Persona: Wisatawan Domestik & Asing

- Backpacker, Keluarga, atau Group Traveler
- Pengguna awam teknologi yang membutuhkan kepraktisan
- Tidak perlu memikirkan rute jalan atau menyetir sendiri

### Layanan Terfavorit (Prioritas):

1. **Paket Lengkap** (Mobil + Sopir + Tujuan Wisata) — Paling Favorit
2. **Sewa Mobil + Sopir** (Harian)
3. **Sewa Mobil Lepas Kunci**

---

## 3. Cakupan Fitur (Scope & Requirements)

| ID Fitur | Komponen | Deskripsi | Prioritas |
|---|---|---|---|
| FR-01 | Layanan Utama | 3 Fitur Utama (bisa dinonaktifkan Admin): Sewa Mobil Lepas Kunci, Sewa Mobil + Sopir, Paket Wisata | Must Have |
| FR-02 | Katalog & Detail | Pengguna lihat pilihan mobil (Avanza, Innova, Hiace, dll) + paket wisata dengan foto | Must Have |
| FR-03 | Penjadwalan | Kalender untuk pilih tanggal mulai dan durasi sewa (harian) | Must Have |
| FR-04 | Pembayaran Manual | Transfer Bank, upload bukti transfer di web | Must Have |
| FR-05 | Panel Admin | Admin ubah status bayar, input sopir, tugaskan sopir ke pesanan | Must Have |
| FR-06 | Integrasi WA & Email | Notifikasi otomatis via WhatsApp & Email ke Sopir & Pelanggan | Must Have |
| FR-07 | Real-Time (SSE) | Info sopir muncul real-time di halaman pelanggan tanpa refresh | Must Have |
| FR-08 | Homepage Discovery | Halaman utama menampilkan rekomendasi destinasi per kategori (Pantai, Gunung, Air Terjun) dengan card berisi foto, nama, lokasi, rating. Tanpa search — Netflix-style. | Must Have |

---

## 4. Alur Pengguna & Sistem

### 4.1 Alur Pemesanan & Pembayaran (Sisi Pelanggan)

1. Pelanggan buka web, pilih jenis layanan yang aktif
2. Pelanggan pilih tanggal, mobil, booking
3. Pelanggan transfer bank, upload bukti transfer

### 4.2 Alur Verifikasi & Penugasan Sopir (Sisi Admin & Sistem)

1. Admin terima upload bukti transfer di panel admin
2. Admin validasi pembayaran → ubah status "Confirmed"
3. Admin pilih & tugaskan sopir
4. **Trigger 1:** WhatsApp & Email otomatis ke Sopir & Pelanggan
5. **Trigger 2:** SSE → halaman pelanggan update real-time (nama sopir, plat nomor)

---

## 5. Struktur Database

### Tabel Utama

| Tabel | Keterangan |
|---|---|
| `users` | Admin & Driver (role: admin/driver) |
| `customers` | Data pelanggan |
| `cars` | Data mobil (Avanza, Innova, Hiace, dll) |
| `services` | Jenis layanan (bisa diaktifkan/nonaktifkan) |
| `banks` | Data bank untuk transfer (bisa diaktifkan/nonaktifkan) |
| `tour_packages` | Paket wisata |
| `tour_destinations` | Destinasi dalam paket wisata |
| `destinations` | Destinasi wisata untuk homepage discovery (name, slug, category, location, rating, main_photo, is_active) |
| `bookings` | Pesanan utama |
| `payments` | Riwayat pembayaran + bukti transfer |

---

## 6. Kriteria Penerimaan (Acceptance Criteria)

### Skenario 1: Admin Nonaktifkan Layanan

> **Given:** Admin di Dashboard Pengaturan Layanan
> **When:** Admin ubah status layanan menjadi Inactive
> **Then:** Opsi layanan otomatis hilang dari halaman utama pelanggan

### Skenario 2: Validasi Pembayaran + SSE Real-Time

> **Given:** Pelanggan di halaman detail pesanan, Admin di panel kontrol
> **When:** Admin klik "Konfirmasi & Tugaskan Sopir"
> **Then:** SSE berjalan, halaman pelanggan update < 2 detik tanpa reload

---

## 7. Halaman & Route

### Customer (Frontend)

| Route | Halaman |
|---|---|---|
| `/` | Landing page + rekomendasi destinasi per kategori |
| `/destinasi/kategori/{category}` | Listing destinasi per kategori |
| `/destinasi/{slug}` | Detail destinasi |
| `/booking` | Form booking (pilih layanan, mobil, tanggal) |
| `/booking/{id}/payment` | Upload bukti transfer |
| `/booking/{id}` | Status pesanan + info sopir (SSE real-time) |

### Admin Panel

| Route | Halaman |
|---|---|
| `/admin/dashboard` | Dashboard admin |
| `/admin/bookings` | Daftar & detail pesanan |
| `/admin/cars` | CRUD mobil |
| `/admin/drivers` | CRUD driver |
| `/admin/services` | Aktif/nonaktif layanan |
| `/admin/banks` | CRUD bank |
| `/admin/tour-packages` | CRUD paket wisata |
| `/admin/destinations` | CRUD destinasi wisata |

### Driver Panel

| Route | Halaman |
|---|---|
| `/driver/dashboard` | Jadwal tugas driver |

---

## 8. Metrik Keberhasilan

- **Zero Bug:** Tidak ada error 500 atau crash pada alur booking & upload bukti bayar
- **Usability:** Pengguna awam bisa selesaikan booking secara mandiri
- **Konversi:** Transaksi organik setelah deploy
- **CTR Destinasi:** High click-through rate dari homepage ke detail destinasi
- **Bounce Rate:** Rendah di homepage (<40%)
- **Conversion Path:** User lanjut dari detail destinasi ke booking

---

*Dibuat oleh Nazmi — 06 Juli 2026*
