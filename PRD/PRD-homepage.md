# PRODUCT REQUIREMENT DOCUMENT (PRD)

## Homepage – ExploreRide (MVP)

| | |
|---|---|
| **Nama Produk** | ExploreRide |
| **Modul** | Homepage (Discovery Layer) |
| **Platform** | Web-based App (Laravel + Blade) |
| **Tech Stack** | Laravel 13, Blade, Bootstrap 5, AOS.js, SweetAlert2 |
| **Product Manager** | Nazmi |
| **Status** | Final |

---

## 1. Overview

Homepage ExploreRide adalah halaman utama yang berfungsi sebagai discovery layer untuk membantu pengguna menemukan inspirasi destinasi wisata sebelum melakukan booking layanan.

Homepage tidak menyediakan search, tetapi fokus pada rekomendasi berbasis kategori.

---

## 2. Goals

### Business Goals
- Meningkatkan engagement user
- Mengarahkan user ke detail destinasi
- Meningkatkan conversion booking

### User Goals
- Menemukan inspirasi destinasi wisata
- Melihat rekomendasi berdasarkan kategori
- Masuk ke detail destinasi

---

## 3. Target User

- Wisatawan umum
- User awam teknologi
- Mobile & desktop user

---

## 4. Homepage Structure

### Navbar
- Logo ExploreRide
- Menu: Home, Destinasi (dropdown per kategori), Paket Wisata, Sewa Mobil, Login/Register
- Language switcher (ID/EN)
- User dropdown (Pesanan Saya, Logout) jika sudah login

### Hero Section
- Headline: Temukan & Rencanakan Perjalanan Wisata Anda dengan Mudah
- Subheadline: Sewa mobil, driver, dan paket wisata dalam satu platform
- CTA: Lihat Paket Wisata, Lihat Sewa Mobil
- CTA disembunyikan jika user sudah login

### Kategori Destinasi
- Dynamis dari database (destination_categories)
- Hanya kategori dengan is_active = true yang ditampilkan
- Default: Pantai, Gunung, Air Terjun

### Rekomendasi per Kategori
- 4–6 destinasi per kategori
- Tombol "Lihat Semua" di sebelah kanan judul kategori
- Judul kategori rata kiri dengan accent bar hijau

### Card Destinasi
- Foto
- Nama
- Lokasi
- Rating (bintang)
- Button: Lihat Detail

### Paket Wisata
- Carousel horizontal
- Card: Foto, Nama, Harga (Rp), Durasi (hari)

### Testimoni
- Section "Apa Kata Mereka"
- Card: Nama, Rating (bintang), Pesan, Foto
- Tombol "Kirim Testimoni" ( AJAX modal, muncul jika user login)

### CTA Section
- Headline: Siap untuk Petualangan?
- Subheadline: Pesan sekarang dan dapatkan pengalaman wisata terbaik
- Tombol: Mulai Sekarang

### Footer
- 4 kolom: ExploreRide (deskripsi), Layanan, Bantuan, Hubungi Kami
- Social media links
- Copyright

### Bottom Navigation (Mobile)
- Fixed bottom bar: Beranda, Destinasi (dropup), Mobil (link), Paket (link), Profile (dropup)
- Profile: Pesanan Saya + Logout (jika login), Masuk (jika guest)

### WhatsApp Floating Button
- Fixed bottom-right
- Link ke wa.me/6281234567890

---

## 5. Flow

Homepage → Detail Destinasi → Booking System → Payment & Admin

---

## 6. UI/UX

- Bootstrap 5
- Mobile-first
- Card based layout
- Fokus visual
- AOS.js (Animate On Scroll) untuk animasi section
- SweetAlert2 untuk konfirmasi testimoni
- Font: Inter (body), Poppins (hero heading)
- Solid colors only (no gradients)
- Green primary (#198754)

---

## 7. Functional Requirements

- FR-H1: Tampilkan kategori destinasi dari database
- FR-H2: Tampilkan destinasi per kategori aktif
- FR-H3: Redirect ke detail destinasi
- FR-H4: Data dari database (destination_categories, destinations, packages, testimonials)
- FR-H5: Bottom navigation bar (mobile)
- FR-H6: Language switcher (ID/EN)
- FR-H7: Testimoni submission (AJAX)
- FR-H8: WhatsApp floating button
- FR-H9: AOS.js scroll animations
- FR-H10: User-specific content (CTA hidden when logged in, profile dropdown)

---

## 8. Performance

- Load < 2.5 detik
- Lazy loading image
- Cache query

---

## 9. Success Metrics

- High CTR ke detail
- Low bounce rate
- User lanjut ke booking

---

## 10. Concept

Netflix-style travel discovery tanpa search
