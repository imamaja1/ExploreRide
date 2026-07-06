# PRODUCT REQUIREMENT DOCUMENT (PRD)

## Homepage – ExploreRide (MVP)

| | |
|---|---|
| **Nama Produk** | ExploreRide |
| **Modul** | Homepage (Discovery Layer) |
| **Platform** | Web-based App (Laravel + Blade) |
| **Tech Stack** | Laravel, Blade, Bootstrap 5 |
| **Product Manager** | Nazmi |
| **Status** | Final Draft |

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
- Menu: Home, Paket Wisata, Sewa Mobil, Login/Register

### Hero Section
- Headline: Temukan & Rencanakan Perjalanan Wisata Anda dengan Mudah
- Subheadline: Sewa mobil, driver, dan paket wisata dalam satu platform
- CTA: Lihat Paket Wisata, Lihat Sewa Mobil

### Kategori
- Pantai
- Gunung
- Air Terjun

### Rekomendasi per Kategori
- 4–6 destinasi per kategori
- Tombol Lihat Semua

### Card Destinasi
- Foto
- Nama
- Lokasi
- Rating
- Button: Lihat Detail

---

## 5. Flow

Homepage → Detail Destinasi → Booking System → Payment & Admin

---

## 6. UI/UX

- Bootstrap 5
- Mobile-first
- Card based layout
- Fokus visual

---

## 7. Functional Requirements

- FR-H1: tampilkan kategori
- FR-H2: tampilkan destinasi
- FR-H3: redirect detail page
- FR-H4: data dari database

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
