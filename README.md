# DESA HUB SYSTEM - DEVELOPMENT COMPLETED

## About The Project

DesaHub adalah sebuah sistem informasi desa terintegrasi berbasis Laravel 12 yang menyediakan manajemen konten desa, pengaduan masyarakat, publikasi, dan berbagai fitur lainnya dengan antarmuka yang modern dan responsif.

## Tech Stack

- **Laravel 12**: Backend framework
- **Jetstream**: Authentication & team management
- **Filament**: Admin panel dan form builder
- **TailwindCSS**: Utility-first CSS framework
- **Alpine.js**: JavaScript framework
- **Livewire**: Full-stack framework untuk interaktivitas
- **PostgreSQL**: Database
- **Spatie Permissions**: Role-based access control

## Fitur

### Frontend (Publik)

- Beranda desa dengan customizable sections
- Portal berita desa
- Layanan publik dan link terkait
- Profil desa (struktur organisasi, visi misi, dll)
- Publikasi dokumen desa
- Data sektoral
- Metadata statistik
- PPID (Pejabat Pengelola Informasi dan Dokumentasi)
- Galeri foto dan video
- Form pengaduan masyarakat
- Statistik pengunjung
- Dark mode & responsive design
- Toast notifications

### Backend (Admin)

- Dashboard dengan statistik dan overview
- Manajemen user dan peran (superadmin, admin desa, operator)
- Manajemen desa dan customisasi UI per desa
- Manajemen konten (berita, publikasi, layanan publik, dll)
- Manajemen media (foto, video, dokumen)
- Manajemen pengaduan masyarakat
- Statistik pengunjung website

## UI/UX Features

- Light/Dark mode toggle
- Responsive design for all devices
- Skeleton loading pada halaman
- Toast notifications untuk feedback
- Modern & clean interface
- Custom fonts dan warna per desa
- Parallax effects

## Email Notifications

- Notifikasi welcome untuk user baru
- Notifikasi pengaduan baru untuk admin
- Notifikasi update status pengaduan untuk pelapor
- Notifikasi untuk admin desa baru

## Installasi

1. Clone repository

```bash
git clone [repo-url]
```

2. Install dependencies

```bash
composer install
npm install
```

3. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in .env

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_desa_hub
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations dan seeders

```bash
php artisan migrate --seed
```

6. Build assets

```bash
npm run build
```

7. Start development server

```bash
php artisan serve
```

## User Login

- **Superadmin**
  - Email: <superadmin@mail.com>
  - Password: password

- **Admin Desa**
  - Email: <admin@mail.id>
  - Password: password

- **Operator Desa**
  - Email: <operator@mail.id>
  - Password: password

## Contributors

- Jstfire

## Recent Updates

### 9 Juli 2025

- Fixed Alpine.js sidebar errors (`groupIsCollapsed` and `toggleCollapsedGroup` functions)
- Enhanced sidebar navigation UI dengan group collapsible
- Diupdate tema dan UI komponen sidebar di Filament dashboard
- Optimasi loading dan cache untuk improve performance

## License

DesaHub - Copyright © 2025. Made with ☕ by Jstfire.
