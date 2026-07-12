# ExploreRide

Platform booking rental mobil & paket wisata all-in-one. One-stop solution untuk transportasi dan travel.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3+
- **Frontend:** Blade, Bootstrap 5.3, Tailwind CSS 4, AOS.js, SweetAlert2, Chart.js
- **Database:** MySQL
- **Notifikasi:** WhatsApp API, Email (SMTP)
- **Auth:** Google OAuth (Socialite)
- **Real-time:** Server-Sent Events (SSE)

## Fitur Utama

- **3 Role:** Admin, Driver, Customer (dengan guard terpisah)
- **Booking System:** Rental mobil (lepas kunci / dengan sopir) + paket wisata
- **Notifikasi Real-time:** WhatsApp & Email di setiap tahap booking
- **SSE:** Live update status booking tanpa reload
- **Multi-language:** Bahasa Indonesia & English
- **Google OAuth:** Login customer via Google

## Setup

```bash
# Clone & install dependencies
git clone <repo-url>
cd ExploreRide
composer install
npm install && npm run build

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Storage link
php artisan storage:link

# Queue worker (untuk notifikasi)
php artisan queue:work

# Development server
composer run dev
```

## Akun Default

| Role   | Email                     | Password |
|--------|---------------------------|----------|
| Admin  | admin@exploreride.com     | password |
| Driver | driver1@exploreride.com   | password |

## Struktur Direktori

```
app/
├── Http/Controllers/   # Admin, Frontend, Driver, Auth
├── Models/             # 13 Eloquent models
├── Notifications/      # WhatsApp & Email notifications
├── Services/           # WhatsAppService, EmailService
└── Jobs/               # Queue jobs
```

## Testing

```bash
php artisan test
```
