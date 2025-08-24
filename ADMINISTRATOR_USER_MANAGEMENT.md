# Administrator User Management System

## Overview
Sistem ini memungkinkan administrator untuk menambah siswa dan pembimbing dengan membuat akun login (email dan password) yang dapat digunakan oleh user tersebut untuk login ke sistem.

## Cara Kerja Sistem

### 1. Administrator Menambah User
- Administrator login ke sistem dengan role administrator
- Mengakses menu "Kelola Siswa" atau "Kelola Pembimbing"
- Mengisi form dengan data lengkap termasuk email dan password
- Sistem otomatis membuat user account dengan role yang sesuai

### 2. User Login
- Siswa dan pembimbing dapat login menggunakan email dan password yang dibuat oleh administrator
- Setelah login, menu yang ditampilkan sesuai dengan role masing-masing

## Fitur Utama

### ✅ Yang Sudah Diimplementasikan

1. **Form Input Lengkap**:
   - Nama lengkap
   - NIS/NIP
   - Jurusan (untuk siswa)
   - Jenis kelamin
   - No HP (untuk siswa)
   - Email (untuk login)
   - Password (untuk login)

2. **Automatic User Creation**:
   - Sistem otomatis membuat user di tabel `users`
   - Role otomatis diassign sesuai jenis user (siswa/pembimbing)
   - Data detail disimpan di tabel `siswa` atau `pembimbing`

3. **Role-Based Access**:
   - Siswa: Logbook, Pengajuan Magang, Upload Laporan Magang
   - Pembimbing: Logbook, Laporan Magang
   - Administrator: Semua menu

## Cara Penggunaan

### 1. Menambah Siswa Baru

#### Login sebagai Administrator
```
Email: admin@gmail.com
Password: 12345678
```

#### Langkah-langkah:
1. Akses menu "Users Management" → "Kelola Siswa"
2. Klik tombol "Tambah" atau "Create"
3. Isi form dengan data lengkap:
   - **Nama**: Nama lengkap siswa
   - **NIS**: Nomor Induk Siswa
   - **Jurusan**: Pilih jurusan dari dropdown
   - **Jenis Kelamin**: Laki-laki/Perempuan
   - **No HP**: Nomor telepon siswa
   - **Email**: Email yang akan digunakan untuk login
   - **Password**: Password untuk login
4. Klik "Simpan"

#### Hasil:
- User account otomatis dibuat dengan role "siswa"
- Siswa dapat login menggunakan email dan password yang dibuat
- Siswa akan melihat menu: Logbook, Pengajuan Magang, Upload Laporan Magang

### 2. Menambah Pembimbing Baru

#### Langkah-langkah:
1. Akses menu "Users Management" → "Kelola Pembimbing"
2. Klik tombol "Tambah" atau "Create"
3. Isi form dengan data lengkap:
   - **Nama**: Nama lengkap pembimbing
   - **NIP**: Nomor Induk Pegawai
   - **Jenis Kelamin**: Laki-laki/Perempuan
   - **Email**: Email yang akan digunakan untuk login
   - **Password**: Password untuk login
4. Klik "Simpan"

#### Hasil:
- User account otomatis dibuat dengan role "pembimbing"
- Pembimbing dapat login menggunakan email dan password yang dibuat
- Pembimbing akan melihat menu: Logbook, Laporan Magang

## Struktur Database

### Tabel `users`
```sql
- id (primary key)
- name (nama lengkap)
- email (untuk login)
- password (hashed)
- role (siswa/pembimbing/administrator)
- email_verified_at
- created_at
- updated_at
```

### Tabel `siswa`
```sql
- id (primary key)
- user_id (foreign key ke users)
- nama
- nis
- jurusan_id (foreign key ke jurusan)
- jenis_kelamin
- no_hp
- pembimbing_id (foreign key ke pembimbing)
- created_at
- updated_at
```

### Tabel `pembimbing`
```sql
- id (primary key)
- user_id (foreign key ke users)
- nama
- nip
- jenis_kelamin
- created_at
- updated_at
```

## Keamanan

### 1. Password Security
- Password di-hash menggunakan bcrypt
- Minimum 6 karakter
- Tidak dapat dilihat oleh administrator setelah dibuat

### 2. Email Uniqueness
- Email harus unik di seluruh sistem
- Validasi email format
- Tidak dapat duplikat

### 3. Role Assignment
- Role otomatis diassign saat user dibuat
- Menggunakan Spatie Permission package
- Role tidak dapat diubah oleh user biasa

## Contoh Penggunaan

### Menambah Siswa
```
Nama: Ahmad Fadillah
NIS: 2024001
Jurusan: Teknik Komputer dan Jaringan
Jenis Kelamin: Laki-laki
No HP: 081234567890
Email: ahmad.fadillah@email.com
Password: siswa123
```

**Hasil**: Siswa dapat login dengan email `ahmad.fadillah@email.com` dan password `siswa123`

### Menambah Pembimbing
```
Nama: Dr. Siti Nurhaliza, M.Pd
NIP: 198501012010012001
Jenis Kelamin: Perempuan
Email: siti.nurhaliza@email.com
Password: pembimbing123
```

**Hasil**: Pembimbing dapat login dengan email `siti.nurhaliza@email.com` dan password `pembimbing123`

## Troubleshooting

### Email Sudah Terdaftar
- Pastikan email belum digunakan oleh user lain
- Gunakan email yang berbeda

### Password Terlalu Pendek
- Password minimal 6 karakter
- Gunakan kombinasi huruf dan angka

### Role Tidak Muncul
- Pastikan seeder sudah dijalankan
- Jalankan: `php artisan db:seed --class=RolePermissionSeeder`

### User Tidak Bisa Login
- Pastikan email dan password benar
- Pastikan user sudah dibuat dengan benar
- Cek apakah role sudah diassign

## Best Practices

### 1. Password Policy
- Gunakan password yang kuat (minimal 8 karakter)
- Kombinasi huruf besar, huruf kecil, angka, dan simbol
- Jangan gunakan password yang mudah ditebak

### 2. Email Management
- Gunakan email yang valid dan aktif
- Pastikan siswa/pembimbing dapat mengakses email tersebut
- Pertimbangkan menggunakan email institusi

### 3. Data Validation
- Pastikan semua data yang dimasukkan valid
- NIS/NIP harus unik
- No HP harus dalam format yang benar

## Monitoring

### 1. User Activity
- Monitor login activity
- Cek apakah user aktif menggunakan sistem
- Backup data user secara berkala

### 2. Security Audit
- Review user permissions secara berkala
- Update password policy jika diperlukan
- Monitor failed login attempts

## Support

Untuk bantuan teknis atau pertanyaan tentang user management, silakan hubungi administrator sistem atau tim IT.
