# Role-Based Access Control Implementation

## Overview
Sistem role-based access control telah diimplementasikan untuk mengatur akses menu berdasarkan role pengguna. Sistem ini menghilangkan fitur registrasi dan hanya administrator yang dapat menambah siswa dan pembimbing.

## Role yang Tersedia

### 1. Administrator
- **Akses Penuh**: Dapat mengakses semua menu dan fitur
- **Menu yang Dapat Diakses**:
  - Beranda
  - Users Management (Kelola Siswa, Kelola Pembimbing)
  - Master Data (Jurusan, DUDI, Kuota DUDI, Tahun Pelaksanaan)
  - Magang Management (Pengajuan Magang, Lihat Pengajuan, Capaian Kompetensi, Surat Pengantar, Atur Pembimbing)
  - Logbook (View All)
  - Laporan Magang (View All)
  - System Management

### 2. Siswa
- **Akses Terbatas**: Hanya dapat mengakses menu yang diperlukan untuk magang
- **Menu yang Dapat Diakses**:
  - Beranda
  - Logbook (Manage own)
  - Pengajuan Magang (Submit own)
  - Upload Laporan Magang (Upload own)

### 3. Pembimbing
- **Akses Terbatas**: Hanya dapat mengakses menu untuk monitoring siswa
- **Menu yang Dapat Diakses**:
  - Beranda
  - Logbook (View assigned students)
  - Laporan Magang (View assigned students)

## Implementasi Teknis

### 1. Middleware
- **Custom Role Middleware**: `app/Http/Middleware/RoleMiddleware.php`
- **Registration**: Terdaftar di `app/Http/Kernel.php` sebagai `custom.role`

### 2. Routes
- **Administrator Routes**: Dikelompokkan dengan middleware `custom.role:administrator`
- **Siswa Routes**: Dikelompokkan dengan middleware `custom.role:siswa`
- **Pembimbing Routes**: Dikelompokkan dengan middleware `custom.role:pembimbing`

### 3. Menu
- **Dynamic Menu**: `resources/views/partials/menu.blade.php`
- **Role-based Display**: Menggunakan directive `@role()` untuk menampilkan menu sesuai role

### 4. Database
- **Role Column**: Ditambahkan ke tabel `users` dengan enum values: `siswa`, `pembimbing`, `administrator`
- **Migration**: `2025_08_23_114304_add_role_to_users_table.php`

### 5. Seeders
- **RolePermissionSeeder**: Membuat role `administrator`, `siswa`, `pembimbing`
- **UserSeeder**: Membuat user contoh untuk setiap role

## User Default

### Administrator
- **Email**: admin@gmail.com
- **Username**: admin
- **Password**: 12345678

### Siswa
- **Email**: siswa@gmail.com
- **Username**: siswa
- **Password**: 12345678

### Pembimbing
- **Email**: pembimbing@gmail.com
- **Username**: pembimbing
- **Password**: 12345678

## Keamanan

### 1. Route Protection
- Semua route dilindungi dengan middleware `auth`
- Route spesifik dilindungi dengan middleware `custom.role`
- Akses tidak sah akan mengembalikan error 403

### 2. Menu Protection
- Menu hanya ditampilkan sesuai role pengguna
- Menggunakan Spatie Permission package untuk role checking

### 3. No Registration
- Fitur registrasi telah dihapus
- Hanya administrator yang dapat menambah user baru

## Cara Penggunaan

### 1. Setup Database
```bash
php artisan migrate:fresh --seed
```

### 2. Login
- Gunakan kredensial default yang telah disediakan
- Setiap role akan melihat menu yang berbeda

### 3. Menambah User Baru (Administrator Only)
- Login sebagai administrator
- Akses menu "Kelola Siswa" atau "Kelola Pembimbing"
- Tambahkan user baru dengan role yang sesuai

## File yang Dimodifikasi

1. `routes/web.php` - Route grouping berdasarkan role
2. `resources/views/partials/menu.blade.php` - Menu dynamic berdasarkan role
3. `app/Http/Middleware/RoleMiddleware.php` - Custom role middleware
4. `app/Http/Kernel.php` - Middleware registration
5. `database/seeders/RolePermissionSeeder.php` - Role creation
6. `database/seeders/UserSeeder.php` - User creation
7. `database/migrations/2025_08_23_114304_add_role_to_users_table.php` - Role column

## Testing

Untuk menguji implementasi:

1. Login sebagai administrator - pastikan semua menu terlihat
2. Login sebagai siswa - pastikan hanya menu logbook, pengajuan, dan laporan terlihat
3. Login sebagai pembimbing - pastikan hanya menu logbook dan laporan terlihat
4. Coba akses route yang tidak diizinkan - pastikan mendapat error 403

## Catatan Penting

- Email verification telah dinonaktifkan untuk memudahkan testing
- Password default adalah `12345678` untuk semua user
- Pastikan database MySQL berjalan sebelum menjalankan migrasi
- Role harus dibuat terlebih dahulu sebelum user dapat diassign role
