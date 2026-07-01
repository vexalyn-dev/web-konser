# Concert Ticket Management - Setup Guide

## System Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- SQLite (atau database lainnya)

## Installation Steps

### 1. Clone Repository
```bash
git clone <repository-url>
cd concert-ticket-management
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
# Create database file
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build

# Or for development
npm run dev
```

### 6. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## QR Code Generation

### Overview
Proyek ini menggunakan **SimpleSoftwareIO\QrCode** untuk generate QR code. Imagick adalah optional dependency dan **TIDAK diperlukan** sebagai requirement wajib.

### Implementation Details

#### Controller (PublicController.php)
```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Generate QR code ke Base64
$qrCodeBase64 = 'data:image/png;base64,' . base64_encode(
    QrCode::format('png')
          ->size(300)
          ->margin(1)
          ->generate($ticket->ticket_code)
);
```

#### Views
- **public/ticket.blade.php** - Display QR code di public ticket page
- **admin/tickets/show.blade.php** - Display QR code di admin dashboard
- **pdf/ticket.blade.php** - Generate QR code untuk PDF export

Semua menggunakan Base64 encoded data URI, tidak memerlukan PHP Image extension.

---

## Features

- ✅ Create tickets dengan automatic QR code generation
- ✅ View ticket details dengan QR code
- ✅ Download ticket sebagai PDF dengan QR code
- ✅ Check-in system dengan QR code scanning
- ✅ Admin dashboard untuk manage tickets
- ✅ Activity logging untuk audit trail
- ✅ Excel export functionality

---

## Development Commands

```bash
# Run development server with hot reload
npm run dev

# Build for production
npm run build

# Run tests
php artisan test

# Laravel Tinker (REPL)
php artisan tinker

# Clear cache
php artisan cache:clear
php artisan config:clear
```

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── PublicController.php     # Ticket CRUD operations
│   ├── AdminController.php      # Admin dashboard
│   └── CheckInController.php    # QR code check-in
├── Models/
│   ├── Ticket.php
│   ├── User.php
│   └── ActivityLog.php
└── Services/
    ├── TicketService.php
    └── CheckInService.php

resources/views/
├── public/                      # Public pages
├── admin/                       # Admin pages
├── pdf/                         # PDF templates
└── components/                  # Reusable components

database/
├── migrations/                  # Database schema
├── factories/                   # Model factories
└── seeders/                     # Data seeders
```

---

## Important Notes

⚠️ **Imagick NOT Required**
- Proyek ini menggunakan SimpleSoftwareIO\QrCode
- QR code di-generate sebagai Base64 PNG, bukan file
- Tidak memerlukan PHP Image extension (GD atau Imagick)
- Lebih ringan dan lebih cepat untuk production

✅ **Supported Formats**
- PNG (Base64 embedded)
- SVG (dalam PDF)
- URL-safe Base64 untuk display

---

## Troubleshooting

### QR Code tidak muncul
- Pastikan SimpleSoftwareIO\QrCode sudah diinstall: `composer install`
- Clear cache: `php artisan cache:clear`
- Refresh browser

### Database errors
- Pastikan database.sqlite ada atau konfigurasi database connection
- Jalankan migrations: `php artisan migrate`

### PDF export error
- Pastikan barryvdh/laravel-dompdf terinstall
- Check storage permissions untuk write PDF files

---

## License

MIT License - See LICENSE file for details
