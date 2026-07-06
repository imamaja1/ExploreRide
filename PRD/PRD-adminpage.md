# PRODUCT REQUIREMENT DOCUMENT (PRD)

## Admin Panel – ExploreRide (MVP)

| | |
|---|---|
| **Nama Produk** | ExploreRide |
| **Modul** | Admin Panel |
| **Platform** | Web-based App (Laravel + Blade) |
| **Tech Stack** | Laravel 11, Blade, Bootstrap 5.3, Chart.js, MySQL |
| **Product Manager** | Nazmi |
| **Status** | Final |

---

## 1. Overview

Admin Panel ExploreRide adalah back-office application untuk mengelola seluruh data dan operasional platform. Admin dapat mengelola pesanan, mobil, driver, paket wisata, destinasi, testimoni, pembayaran, dan pengaturan sistem.

---

## 2. Goals

### Business Goals
- Memonitoring dan mengelola seluruh pesanan dalam satu dashboard
- Mengontrol data master (mobil, driver, paket wisata, destinasi)
- Memvalidasi pembayaran dan menugaskan driver
- Menjaga kualitas konten (destinasi, testimoni, kategori)

### User Goals (Admin)
- Melihat ringkasan bisnis melalui dashboard dengan grafik
- Mengelola CRUD data master dengan cepat
- Memproses konfirmasi pembayaran dan penugasan driver
- Mengontrol visibilitas konten (aktif/nonaktif)

---

## 3. Target User

- Admin internal ExploreRide
- Operator yang mengelola pesanan dan data master

---

## 4. System Architecture

### Authentication & Authorization
- Login terpisah dari customer (`/admin/login`)
- Menggunakan model `User` dengan kolom `role` (admin/driver)
- Middleware `auth` + `admin` (`User::isAdmin()`)

### Layout
- Sidebar vertikal (lebar 250px, warna hijau tua `#145c32`)
- Navbar atas dengan logo, language switcher, dropdown user
- Content area dengan alert flash (success/error)
- Bootstrap 5.3.3 + Bootstrap Icons + Chart.js 4.4.7

### Localization
- Semua UI text menggunakan helper `__()` (Blade + PHP)
- 2 bahasa: Indonesia (default) dan Inggris
- Locale disimpan di session, diubah via `/lang/{locale}`

---

## 5. Sidebar Navigation

| # | Icon | Label | Route | CRUD |
|---|---|---|---|---|
| 1 | `bi-speedometer2` | Dashboard | `admin.dashboard` | Read only |
| 2 | `bi-calendar-check` | Pesanan | `admin.bookings.*` | Read, Update (confirm, assign, cancel) |
| 3 | `bi-truck` | Mobil | `admin.cars.*` | Full CRUD |
| 4 | `bi-people` | Driver | `admin.drivers.*` | Full CRUD |
| 5 | `bi-map` | Paket Wisata | `admin.tour-packages.*` | Full CRUD |
| 6 | `bi-geo-alt` | Destinasi | `admin.destinations.*` | Full CRUD |
| 7 | `bi-tags` | Kategori Destinasi | `admin.destination-categories.*` | Full CRUD + toggle |
| 8 | `bi-gear` | Layanan | `admin.services.*` | Read, Update |
| 9 | `bi-bank` | Bank | `admin.banks.*` | Full CRUD |
| 10 | `bi-chat-quote` | Testimoni | `admin.testimonials.*` | Full CRUD |
| - | `bi-box-arrow-up-right` | Ke Website | `home` | Link eksternal |

---

## 6. Dashboard

### Layout
- 4 stat cards (row, 4 kolom): Total Pesanan, Menunggu (pending + waiting_payment), Berjalan (confirmed + in_progress), Pendapatan
- Card menggunakan warna: hijau (total & revenue), kuning (waiting), biru (active)
- Setiap card memiliki icon Bootstrap di sisi kanan dengan opacity 50%

### Grafik (Chart.js)
- **Bar Chart** — jumlah pesanan per hari selama 7 hari terakhir (8 kolom lebar)
- **Doughnut Chart** — distribusi 6 status pesanan (4 kolom lebar)

### Resource Summary (2 kartu)
- **Sumber Daya**: Mobil Aktif, Driver Aktif, Destinasi (counts), Paket Wisata, Selesai
- **Ringkasan Status**: 6 status dengan progress bar perbandingan (lebar bar proporsional terhadap status terbanyak)

### Tabel
- 10 pesanan terbaru dengan kolom: Kode, Pelanggan, Mobil/Paket, Status (badge), Driver, Aksi (link detail)

---

## 7. Bookings (Pesanan)

### Index (`/admin/bookings`)
- Paginated (15/page), 7 kolom
- Kolom: Kode Booking (link ke detail), Pelanggan, Mobil/Paket, Tanggal (range), Total (format Rp), Status (color-coded badge), Aksi (tombol eye)
- 6 status dengan warna badge: pending (secondary), waiting_payment (warning), confirmed (primary), in_progress (info), completed (success), cancelled (danger)
- Tidak ada search/filter (belum diimplementasikan)

### Detail (`/admin/bookings/{id}`)
- Layout 2 kolom

#### Left Column
- **Info Pesanan**: kode, status badge, tanggal mulai/selesai, durasi, lokasi jemput, jam jemput, catatan, total harga
- **Info Pelanggan**: nama, email, no. HP
- **Info Kendaraan / Paket**: mobil (nama + plat) atau paket wisata (nama)

#### Right Column
- **Pembayaran**: status (verified/pending), jumlah, bank tujuan, bukti transfer (link), tombol **Konfirmasi Pembayaran** (muncul hanya jika `waiting_payment`)
- **Driver**: driver yang ditugaskan (nama + telepon) atau "Belum ada driver ditugaskan", form dropdown assignment dengan tombol **Tugaskan** (muncul untuk status pending/waiting_payment/confirmed)
- **Aksi**: tombol **Batalkan Pesanan** (muncul untuk semua status kecuali completed/cancelled)

### Actions
- `confirmPayment` — verifikasi payment + update booking status ke confirmed + kirim email `BookingConfirmed` ke customer
- `assignDriver` — assign driver + update status ke confirmed + kirim email `DriverAssigned` ke driver
- `cancel` — update status ke cancelled

### Notifications (Email)
- `BookingConfirmed` — ke Customer: subject "Pesanan Dikonfirmasi - ExploreRide", berisi kode booking, detail mobil, tanggal, total, link "Lihat Pesanan"
- `DriverAssigned` — ke Driver (User): subject "Anda Ditugaskan - ExploreRide", berisi kode booking, nama customer, detail mobil, tanggal, info jemput, link dashboard driver

---

## 8. Cars (Mobil)

### Index (`/admin/cars`)
- Paginated (10/page), 7 kolom
- Kolom: Foto (thumbnail 60x40), Nama + Brand, Plat Nomor, Harga/hari (format Rp), Transmisi (badge Manual/Matic), Status (badge Aktif/Nonaktif), Aksi (edit/delete)
- `with_driver` boolean (tidak ditampilkan di tabel)

### Form (Create/Edit)
- Layout row g-3 (2 kolom per baris)
- Fields: name, brand, model, year (number), plate_number, color, transmission (select: Manual/Matic), fuel_type (select: Bensin/Diesel), seats (number), price_per_day (number), main_photo (file upload, jpg/png, max 2MB), description (textarea), is_active (checkbox), with_driver (checkbox)
- Edit: photo tidak required, tampil teks "Biarkan kosong jika tidak ganti foto"
- Submitted via POST/PUT, redirect ke index dengan flash success

### Controller Logic
- `store`: validasi + upload foto ke `storage/app/public/cars/` + create
- `update`: validasi + upload opsional + delete foto lama jika diganti + update
- `destroy`: hapus record (hard delete)

---

## 9. Drivers (Driver)

### Index (`/admin/drivers`)
- Paginated (10/page), 6 kolom
- Kolom: Nama, Email, No. HP, Plat Nomor, Status (badge Aktif/Nonaktif), Aksi (edit/delete)

### Form (Create/Edit)
- Fields: name, email, phone, whatsapp, address (textarea), plate_number, password (create: required, edit: optional), sim_photo (file upload), is_active (checkbox)
- Password di-hash sebelum disimpan

### Notes
- Menggunakan model `User` dengan `role = 'driver'`
- SIM photo disimpan di `storage/app/public/sim/`

---

## 10. Services (Layanan)

### Index (`/admin/services`)
- No pagination (hanya 3 record)
- Kolom: No, Nama Layanan, Deskripsi, Status (badge), Aksi (edit)
- Informasi: "Nonaktifkan layanan untuk menyembunyikannya dari halaman utama pelanggan."

### Form (Edit)
- Fields: name, description (textarea), is_active (checkbox)

### Notes
- Read/Update only (tidak bisa create/delete)
- 3 service default: Sewa Mobil Lepas Kunci, Sewa Mobil + Sopir, Paket Wisata

---

## 11. Banks (Bank)

### Index (`/admin/banks`)
- Paginated (10/page), 5 kolom
- Kolom: Nama Bank, No. Rekening, Atas Nama, Status (badge), Aksi (edit/delete)

### Form (Create/Edit)
- Fields: name, account_number, account_name, logo (file upload), is_active (checkbox)
- Logo disimpan di `storage/app/public/banks/`

---

## 12. Tour Packages (Paket Wisata)

### Index (`/admin/tour-packages`)
- Paginated (10/page), 7 kolom
- Kolom: Foto (thumbnail), Nama, Harga (Rp), Durasi (hari), Destinasi (count), Status (badge), Aksi (edit/delete)

### Form (Create/Edit)
- Fields: name, slug, description (textarea), price, duration_days (number), main_photo, includes (text), excludes (text)
- Edit view juga menampilkan sub-tabel destinasi dalam paket (relasi `TourDestination`): order, nama, estimasi tiba, estimasi pulang

### Notes
- `route` field adalah JSON (disimpan di database, tidak ada UI editor di form)
- Relasi `destinations()` diurutkan berdasarkan kolom `order`

---

## 13. Destinations (Destinasi)

### Index (`/admin/destinations`)
- Paginated (15/page), 7 kolom
- Kolom: Foto (thumbnail 60x40), Nama, Kategori (badge, translated), Lokasi, Rating (bintang), Status (badge), Aksi (edit/delete)

### Form (Create/Edit)
- Fields: name, slug (manual input, contoh: "nama-destinasi"), category (select: Pantai/Gunung/Air Terjun), location, rating (number 0-5, step 0.1), main_photo, description (textarea), is_active (checkbox)
- Foto disimpan di `storage/app/public/destinations/`
- Old photo dihapus saat update (jika diganti) dan saat delete

---

## 14. Destination Categories (Kategori Destinasi)

### Index (`/admin/destination-categories`)
- No pagination (3 record: Pantai, Gunung, Air Terjun)
- Kolom: No, Nama, Slug (code style), Status (badge), Aksi (toggle + edit + delete)
- Informasi: "Kategori yang dinonaktifkan tidak akan tampil di halaman utama."

### Actions
- **Toggle** — POST request, flips `is_active`, redirect back dengan flash message
- **Edit** — form nama, slug, checkbox is_active
- **Delete** — konfirmasi "Hapus kategori ini? Destinasi dengan kategori ini tidak akan terhapus."

### Notes
- Mempengaruhi tampilan homepage (HomeController filter `$activeCategories`)
- Fungsi utama: mengontrol kategori mana yang muncul di homepage tanpa menghapus destinasi

---

## 15. Testimonials (Testimoni)

### Index (`/admin/testimonials`)
- Paginated (15/page), 6 kolom
- Kolom: No, Nama, Rating (bintang kuning 1-5), Pesan (truncated 80 chars), Status (badge Aktif/Pending), Aksi (edit/delete)

### Form (Create/Edit)
- Fields: name, rating (select dropdown 5-1), photo (file upload), message (textarea), is_active (checkbox)
- Foto disimpan di `storage/app/public/testimonials/`

---

## 16. Functional Requirements Summary

| FR-ID | Deskripsi | Prioritas |
|---|---|---|
| FR-A1 | Login admin dengan email & password | High |
| FR-A2 | Dashboard dengan stat cards, grafik, dan tabel pesanan terbaru | High |
| FR-A3 | Manajemen pesanan: lihat daftar, detail, konfirmasi pembayaran, assign driver, batalkan | High |
| FR-A4 | CRUD Mobil (dengan foto, status aktif/nonaktif) | High |
| FR-A5 | CRUD Driver (menggunakan User model, dengan foto SIM) | High |
| FR-A6 | Edit Layanan (aktif/nonaktif) | Medium |
| FR-A7 | CRUD Bank (dengan logo, untuk tujuan transfer) | High |
| FR-A8 | CRUD Paket Wisata (dengan foto, durasi, include/exclude) | High |
| FR-A9 | CRUD Destinasi (dengan foto, kategori, rating, lokasi) | High |
| FR-A10 | CRUD + Toggle Kategori Destinasi (mengontrol visibilitas homepage) | High |
| FR-A11 | CRUD Testimoni (dengan rating bintang, foto, aktif/pending) | Medium |
| FR-A12 | Language switcher (Indonesia/Inggris) | Medium |
| FR-A13 | Notifikasi email: konfirmasi booking (ke customer) & penugasan driver (ke driver) | High |
| FR-A14 | Logout admin | High |

---

## 17. Non-Functional Requirements

### Performance
- Dashboard load < 2 detik (termasuk Chart.js)
- Pagination pada semua index view
- Image upload max 2MB, format JPG/PNG

### Security
- Middleware `auth` + `admin` di semua route (kecuali login)
- Password di-hash (bcrypt)
- Validasi server-side untuk semua input
- File upload divalidasi (image type, max size)

### Usability
- Flash messages (success/error) di setiap action
- Confirm dialog untuk delete dan cancel
- Status badges dengan color-coding konsisten
- Tampilan responsive (Bootstrap 5)

### Maintainability
- Localization via `__()` helper
- Route model binding untuk resource controllers
- Storage disk `public` untuk semua file upload
- Views extend `layouts.admin`

---

## 18. Pages & Routes Summary

| Metode | URL | Nama Route | Controller | View |
|---|---|---|---|---|
| GET | `/admin/login` | `admin.login` | `AdminAuthController@showLogin` | `admin.auth.login` |
| POST | `/admin/login` | — | `AdminAuthController@login` | — |
| POST | `/admin/logout` | `admin.logout` | `AdminAuthController@logout` | — |
| GET | `/admin/dashboard` | `admin.dashboard` | `DashboardController@index` | `admin.dashboard` |
| GET | `/admin/bookings` | `admin.bookings.index` | `BookingController@index` | `admin.bookings.index` |
| GET | `/admin/bookings/{id}` | `admin.bookings.show` | `BookingController@show` | `admin.bookings.show` |
| POST | `/admin/bookings/{id}/confirm-payment` | `admin.bookings.confirm-payment` | `BookingController@confirmPayment` | — |
| POST | `/admin/bookings/{id}/assign-driver` | `admin.bookings.assign-driver` | `BookingController@assignDriver` | — |
| POST | `/admin/bookings/{id}/cancel` | `admin.bookings.cancel` | `BookingController@cancel` | — |
| GET/POST/PUT/DELETE | `/admin/cars` | `admin.cars.*` | `CarController` | `admin.cards.*` |
| GET/POST/PUT/DELETE | `/admin/drivers` | `admin.drivers.*` | `DriverController` | `admin.drivers.*` |
| GET/PUT | `/admin/services` | `admin.services.*` | `ServiceController` | `admin.services.*` |
| GET/POST/PUT/DELETE | `/admin/banks` | `admin.banks.*` | `BankController` | `admin.banks.*` |
| GET/POST/PUT/DELETE | `/admin/tour-packages` | `admin.tour-packages.*` | `TourPackageController` | `admin.tour-packages.*` |
| GET/POST/PUT/DELETE | `/admin/destinations` | `admin.destinations.*` | `DestinationController` | `admin.destinations.*` |
| GET/POST/PUT/DELETE | `/admin/destination-categories` | `admin.destination-categories.*` | `DestinationCategoryController` | `admin.destination-categories.*` |
| POST | `/admin/destination-categories/{id}/toggle` | `admin.destination-categories.toggle` | `DestinationCategoryController@toggle` | — |
| GET/POST/PUT/DELETE | `/admin/testimonials` | `admin.testimonials.*` | `TestimonialController` | `admin.testimonials.*` |

---

## 19. Future Considerations

- **Search & Filter**: Tambahkan search/filter di index bookings dan data master
- **Bulk Actions**: Delete/activate multiple records sekaligus
- **Export Data**: CSV/Excel export untuk bookings, revenue, dan data master
- **Activity Log**: Catat semua perubahan data oleh admin
- **Roles & Permissions**: Bedakan super admin dan operator
- **Dashboard Charts Tambahan**: Revenue trend, popular destinations, driver performance
- **Notifikasi Database**: Simpan notifikasi di database selain email (in-app notification)
- **Soft Deletes**: Gunakan soft deletes untuk mencegah kehilangan data
