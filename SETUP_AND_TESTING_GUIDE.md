# Setup dan Testing Guide - Sistem Role-Based Access Control

## Overview
Panduan lengkap untuk setup dan testing sistem role-based access control dimana administrator dapat menambah siswa dan pembimbing dengan email dan password.

## Prerequisites
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Setup Aplikasi

### 1. Clone dan Install Dependencies
```bash
git clone <repository-url>
cd laravel-sneat
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prakerin
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration dan Seeding
```bash
php artisan migrate:fresh --seed
```

### 5. Compile Assets
```bash
npm run dev
```

### 6. Start Server
```bash
php artisan serve
```

## User Default untuk Testing

Setelah menjalankan seeder, tersedia user default:

### Administrator
- **Email**: admin@gmail.com
- **Password**: 12345678
- **Akses**: Semua menu

### Siswa (Contoh)
- **Email**: siswa@gmail.com
- **Password**: 12345678
- **Akses**: Logbook, Pengajuan Magang, Upload Laporan Magang

### Pembimbing (Contoh)
- **Email**: pembimbing@gmail.com
- **Password**: 12345678
- **Akses**: Logbook, Laporan Magang

## Testing Scenarios

### Scenario 1: Administrator Menambah Siswa Baru

#### Langkah-langkah:
1. **Login sebagai Administrator**
   ```
   URL: http://localhost:8000/login
   Email: admin@gmail.com
   Password: 12345678
   ```

2. **Akses Menu Kelola Siswa**
   - Klik menu "Users Management" → "Kelola Siswa"
   - Pastikan semua data siswa terlihat

3. **Tambah Siswa Baru**
   - Klik tombol "Tambah" atau "Create"
   - Isi form dengan data:
     ```
     Nama: Test Siswa
     NIS: 2024001
     Jurusan: Teknik Komputer dan Jaringan
     Jenis Kelamin: Laki-laki
     No HP: 081234567890
     Email: test.siswa@email.com
     Password: siswa123
     ```
   - Klik "Simpan"

4. **Verifikasi Hasil**
   - Siswa baru muncul di list
   - User account otomatis dibuat dengan role "siswa"

5. **Test Login Siswa Baru**
   - Logout dari administrator
   - Login dengan kredensial siswa baru:
     ```
     Email: test.siswa@email.com
     Password: siswa123
     ```
   - Pastikan hanya menu siswa yang muncul

### Scenario 2: Administrator Menambah Pembimbing Baru

#### Langkah-langkah:
1. **Login sebagai Administrator**
   ```
   Email: admin@gmail.com
   Password: 12345678
   ```

2. **Akses Menu Kelola Pembimbing**
   - Klik menu "Users Management" → "Kelola Pembimbing"
   - Pastikan semua data pembimbing terlihat

3. **Tambah Pembimbing Baru**
   - Klik tombol "Tambah" atau "Create"
   - Isi form dengan data:
     ```
     Nama: Test Pembimbing
     NIP: 198501012010012001
     Jenis Kelamin: Perempuan
     Email: test.pembimbing@email.com
     Password: pembimbing123
     ```
   - Klik "Simpan"

4. **Verifikasi Hasil**
   - Pembimbing baru muncul di list
   - User account otomatis dibuat dengan role "pembimbing"

5. **Test Login Pembimbing Baru**
   - Logout dari administrator
   - Login dengan kredensial pembimbing baru:
     ```
     Email: test.pembimbing@email.com
     Password: pembimbing123
     ```
   - Pastikan hanya menu pembimbing yang muncul

### Scenario 3: Testing Role-Based Access Control

#### Test 1: Siswa Access
1. Login sebagai siswa
2. Pastikan menu yang muncul:
   - ✅ Beranda
   - ✅ Logbook
   - ✅ Pengajuan Magang
   - ✅ Upload Laporan Magang
3. Pastikan menu yang TIDAK muncul:
   - ❌ Users Management
   - ❌ Master Data
   - ❌ System Management

#### Test 2: Pembimbing Access
1. Login sebagai pembimbing
2. Pastikan menu yang muncul:
   - ✅ Beranda
   - ✅ Logbook
   - ✅ Laporan Magang
3. Pastikan menu yang TIDAK muncul:
   - ❌ Users Management
   - ❌ Master Data
   - ❌ Pengajuan Magang
   - ❌ System Management

#### Test 3: Administrator Access
1. Login sebagai administrator
2. Pastikan semua menu muncul:
   - ✅ Beranda
   - ✅ Users Management
   - ✅ Master Data
   - ✅ Magang Management
   - ✅ Logbook
   - ✅ Upload Laporan Magang
   - ✅ System Management

### Scenario 4: Testing Unauthorized Access

#### Test 1: Direct URL Access
1. Login sebagai siswa
2. Coba akses URL yang tidak diizinkan:
   ```
   http://localhost:8000/backend/siswa
   http://localhost:8000/backend/pembimbing
   http://localhost:8000/backend/jurusan
   ```
3. Pastikan mendapat error 403 (Unauthorized)

#### Test 2: Cross-Role Access
1. Login sebagai siswa
2. Coba akses menu pembimbing
3. Pastikan menu tidak muncul dan tidak bisa diakses

## Expected Results

### ✅ Success Indicators
- Administrator dapat menambah siswa dan pembimbing
- User baru dapat login dengan email dan password yang dibuat
- Menu muncul sesuai role masing-masing
- Unauthorized access ditolak dengan error 403
- Data tersimpan dengan benar di database

### ❌ Failure Indicators
- User tidak bisa login setelah dibuat
- Menu tidak muncul sesuai role
- Error saat menambah user baru
- Unauthorized access tidak ditolak
- Data tidak tersimpan di database

## Troubleshooting

### Database Connection Error
```bash
# Pastikan MySQL berjalan
# Cek konfigurasi .env
# Buat database jika belum ada
mysql -u root -p
CREATE DATABASE prakerin;
```

### Migration Error
```bash
# Reset database
php artisan migrate:fresh --seed

# Jika masih error, cek log
tail -f storage/logs/laravel.log
```

### Role Not Working
```bash
# Jalankan seeder ulang
php artisan db:seed --class=RolePermissionSeeder

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### User Cannot Login
```bash
# Cek apakah user ada di database
php artisan tinker
>>> App\Models\User::where('email', 'test@email.com')->first();

# Cek role assignment
>>> $user = App\Models\User::where('email', 'test@email.com')->first();
>>> $user->roles;
```

## Performance Testing

### Load Testing
```bash
# Test dengan multiple users
# Monitor response time
# Cek memory usage
```

### Security Testing
```bash
# Test SQL injection
# Test XSS
# Test CSRF
# Test authentication bypass
```

## Monitoring

### Log Monitoring
```bash
# Monitor application logs
tail -f storage/logs/laravel.log

# Monitor error logs
tail -f storage/logs/error.log
```

### Database Monitoring
```bash
# Monitor database performance
# Check slow queries
# Monitor connection pool
```

## Cleanup

### Remove Test Data
```bash
# Hapus user test jika diperlukan
php artisan tinker
>>> App\Models\User::where('email', 'like', 'test%')->delete();
```

### Reset Database
```bash
# Reset ke kondisi awal
php artisan migrate:fresh --seed
```

## Support

Jika mengalami masalah:
1. Cek log aplikasi
2. Verifikasi konfigurasi database
3. Pastikan semua dependencies terinstall
4. Hubungi tim development

## Next Steps

Setelah testing berhasil:
1. Deploy ke production
2. Setup monitoring
3. Backup strategy
4. User training
5. Documentation update
