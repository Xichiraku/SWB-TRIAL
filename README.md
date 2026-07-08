# 🗑️ SWB-TRIAL — Smart Waste Bin Monitoring System

Sistem monitoring tempat sampah pintar berbasis web yang terintegrasi dengan sensor ESP32. Memantau kapasitas sampah secara real-time, mengelola jadwal pengangkutan, dan memberikan notifikasi otomatis kepada operator.

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | [Laravel 12](https://laravel.com) (PHP 8.2+) |
| Database | [MongoDB](https://www.mongodb.com/) via `mongodb/laravel-mongodb` |
| Frontend | Tailwind CSS 4, Vite 7 |
| PDF Export | `barryvdh/laravel-dompdf` |
| Hardware | ESP32 + sensor ultrasonik (API endpoint) |

## Fitur

### Admin
- **Dashboard** — monitoring status semua tempat sampah (kapasitas, lokasi, kondisi)
- **Detail Bin** — lihat detail per titik sampah
- **Pengaturan** — konfigurasi threshold & pengaturan sistem
- **History Log** — riwayat aktivitas pengangkutan
- **Laporan & Export** — cetak/export data bin, homebase, peringatan (PDF)

### Operator
- **Dashboard** — ringkasan tugas harian
- **Daftar Bin** — lihat status tempat sampah yang ditugaskan
- **Notifikasi** — peringatan otomatis saat kapasitas penuh
- **Task Update** — mulai & selesaikan tugas pengangkutan

### API Sensor (ESP32)
- `POST /api/bins/update-sensor` — terima data kapasitas dari sensor ESP32
- `GET /api/bins/test` — endpoint test koneksi sensor

## Persyaratan

- PHP >= 8.2
- Composer
- Node.js & npm
- MongoDB (local atau Atlas)

## Instalasi

```bash
# 1. Clone & masuk ke direktori
git clone <repo-url> && cd SWB-TRIAL

# 2. Install dependency PHP & JS
composer install
npm install

# 3. Buat file .env
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
#    DB_CONNECTION=mongodb
#    MONGO_URI=mongodb://localhost:27017
#    MONGO_DATABASE=swb_trial

# 5. Jalankan migrasi & seeder
php artisan migrate --seed

# 6. Build asset
npm run build
```

## Menjalankan Aplikasi

```bash
# Development (jalankan semua sekaligus: server, queue, logs, vite)
composer dev

# Atau manual
php artisan serve
npm run dev
```

Aplikasi berjalan di `http://localhost:8000`.

## Struktur Database

| Collection | Keterangan |
|------------|------------|
| `users` | Data admin & operator |
| `homebases` | Lokasi basecamp operator |
| `vacuums` (bins) | Data tempat sampah & status sensor |
| `peringatans` | Log peringatan kapasitas penuh |
| `historylogs` | Riwayat pengangkutan |
| `settings` | Konfigurasi sistem |

## Role & Akses

| Role | Prefix URL | Akses |
|------|-----------|-------|
| `admin` | `/admin/*` | Full dashboard, settings, history, export |
| `operator` | `/operator/*` | Bins, notifikasi, task update |

## API Endpoints

### Sensor (tanpa auth)
| Method | Endpoint | Keterangan |
|--------|----------|------------|
| POST | `/api/bins/update-sensor` | Terima data dari ESP32 |
| GET | `/api/bins/test` | Test koneksi |

### Admin (AJAX)
| Method | Endpoint | Keterangan |
|--------|----------|------------|
| GET | `/api/admin/bins` | Ambil semua data bin |
| GET | `/api/admin/stats` | Statistik dashboard |
| POST | `/api/admin/bins/update` | Update status bin |

## Struktur Project

```
app/
├── Http/Controllers/
│   ├── Admin/           # DashboardController, ExportController
│   ├── Api/             # BinSensorController (ESP32)
│   ├── AuthController.php
│   ├── BinController.php
│   ├── DashboardOperController.php
│   ├── HistoryController.php
│   └── SettingController.php
├── Http/Middleware/      # Role middleware
└── Models/              # Bin, Homebase, Notification, Peringatan, Setting, User
resources/views/
├── admin/               # Dashboard, settings, history, report, export
├── auth/                # Login
├── layouts/             # Template admin
└── operator/            # Dashboard, bins, notifikasi, task update
```

## License

MIT License.
