# Sistem Informasi Prakerin - Role-Based Access Control

## Deskripsi
Sistem Informasi Prakerin dengan implementasi role-based access control yang memungkinkan akses menu berbeda berdasarkan role pengguna.

## Fitur Utama

### Role-Based Access Control
- **Administrator**: Akses penuh ke semua menu dan fitur
- **Siswa**: Hanya dapat mengakses logbook, pengajuan magang, dan upload laporan magang
- **Pembimbing**: Hanya dapat mengakses logbook dan laporan magang

### Keamanan
- Tidak ada fitur registrasi publik
- Hanya administrator yang dapat menambah siswa dan pembimbing
- Middleware protection untuk setiap route
- Menu dinamis berdasarkan role

## Instalasi dan Setup

### 1. Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Node.js dan NPM (untuk asset compilation)

### 2. Clone Repository
```bash
git clone <repository-url>
cd laravel-sneat
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prakerin
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Database Migration dan Seeding
```bash
php artisan migrate:fresh --seed
```

### 7. Compile Assets
```bash
npm run dev
```

### 8. Start Server
```bash
php artisan serve
```

## User Default

Setelah menjalankan seeder, tersedia user default berikut:

### Administrator
- **URL**: http://localhost:8000/login
- **Email**: admin@gmail.com
- **Username**: admin
- **Password**: 12345678
- **Akses**: Semua menu

### Siswa
- **Email**: siswa@gmail.com
- **Username**: siswa
- **Password**: 12345678
- **Akses**: Logbook, Pengajuan Magang, Upload Laporan Magang

### Pembimbing
- **Email**: pembimbing@gmail.com
- **Username**: pembimbing
- **Password**: 12345678
- **Akses**: Logbook, Laporan Magang

## Struktur Menu

### Administrator Menu
```
Beranda
├── Users Management
│   ├── Kelola Siswa
│   └── Kelola Pembimbing
├── Master Data
│   ├── Kelola Jurusan
│   ├── Kelola DUDI
│   ├── Kuota DUDI
│   └── Tahun Pelaksanaan
├── Magang Management
│   ├── Pengajuan Magang
│   ├── Lihat Pengajuan Magang
│   ├── Capaian Kompetensi
│   ├── Surat Pengantar
│   └── Atur Pembimbing
├── Logbook
├── Upload Laporan Magang
└── System Management
    └── Pengaturan
```

### Siswa Menu
```
Beranda
├── Logbook
├── Pengajuan Magang
└── Upload Laporan Magang
```

### Pembimbing Menu
```
Beranda
├── Logbook
└── Laporan Magang
```

## Cara Penggunaan

### 1. Login
1. Buka browser dan akses http://localhost:8000
2. Masukkan kredensial sesuai role yang ingin diuji
3. Setelah login, menu akan muncul sesuai role

### 2. Menambah User Baru (Administrator Only)
1. Login sebagai administrator
2. Akses menu "Kelola Siswa" atau "Kelola Pembimbing"
3. Klik tombol "Tambah" untuk menambah user baru
4. Isi form dengan data yang diperlukan
5. Pilih role yang sesuai (siswa atau pembimbing)

### 3. Testing Role Access
1. Login dengan role yang berbeda
2. Pastikan menu yang muncul sesuai dengan role
3. Coba akses URL yang tidak diizinkan untuk role tersebut
4. Pastikan mendapat error 403 (Unauthorized)

## Troubleshooting

### Database Connection Error
- Pastikan MySQL/MariaDB berjalan
- Periksa konfigurasi database di file `.env`
- Pastikan database `prakerin` sudah dibuat

### Permission Denied Error
- Pastikan folder `storage` dan `bootstrap/cache` memiliki permission write
- Jalankan: `chmod -R 775 storage bootstrap/cache`

### Role Not Working
- Pastikan seeder sudah dijalankan: `php artisan db:seed`
- Periksa apakah role sudah dibuat di database
- Pastikan user sudah diassign role yang benar

### Menu Not Showing
- Periksa apakah user sudah login
- Pastikan role user sesuai dengan yang diharapkan
- Clear cache: `php artisan cache:clear`

## Development

### Menambah Role Baru
1. Edit `database/seeders/RolePermissionSeeder.php`
2. Tambahkan role baru
3. Jalankan: `php artisan db:seed --class=RolePermissionSeeder`

### Menambah Menu Baru
1. Edit `resources/views/partials/menu.blade.php`
2. Tambahkan menu dengan directive `@role()`
3. Tambahkan route di `routes/web.php` dengan middleware yang sesuai

### Menambah Middleware Baru
1. Buat middleware baru: `php artisan make:middleware CustomMiddleware`
2. Daftarkan di `app/Http/Kernel.php`
3. Gunakan di routes yang diperlukan

## Keamanan

### Best Practices
- Selalu gunakan HTTPS di production
- Ganti password default setelah setup
- Backup database secara berkala
- Monitor log aplikasi untuk aktivitas mencurigakan

### Role Security
- Role tidak dapat diubah oleh user biasa
- Hanya administrator yang dapat mengelola user
- Setiap akses route dicek dengan middleware

## Support

Untuk bantuan teknis atau pertanyaan, silakan hubungi tim development atau buat issue di repository.

## License

Proyek ini menggunakan license yang sesuai dengan kebijakan organisasi.
