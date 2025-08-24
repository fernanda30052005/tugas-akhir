# Troubleshooting: Masalah Akses Siswa

## Masalah yang Ditemukan dan Solusi

### 1. **Siswa Tidak Bisa Mengisi Logbook**

#### Masalah:
- Controller LogbookController tidak menangani role-based access dengan benar
- Siswa tidak bisa membuat logbook karena logika yang salah

#### Solusi yang Diterapkan:
1. **Perbaikan LogbookController**:
   - Menambahkan pengecekan role di setiap method
   - Siswa hanya bisa melihat dan mengelola logbook miliknya sendiri
   - Pembimbing hanya bisa melihat logbook siswa yang dibimbingnya
   - Administrator bisa melihat dan mengelola semua logbook

2. **Perbaikan View**:
   - Form create logbook menampilkan field siswa hanya untuk administrator
   - View index tidak menampilkan kolom siswa untuk role siswa
   - Form edit menangani role administrator dan siswa dengan benar

### 2. **Siswa Tidak Bisa Melakukan Pengajuan Magang**

#### Masalah:
- PengajuanMagangController sudah benar, tetapi perlu memastikan siswa memiliki data di tabel siswa

#### Solusi yang Diterapkan:
1. **Memastikan Relasi User-Siswa**:
   - User dengan role siswa harus memiliki data di tabel `siswa`
   - Relasi `user->siswa` harus berfungsi dengan benar

2. **Validasi Data**:
   - Controller memeriksa apakah user memiliki data siswa
   - Jika tidak ada data siswa, akan menampilkan error

### 3. **Siswa Tidak Bisa Upload Laporan Magang**

#### Masalah:
- LaporanMagangController sudah benar, tetapi perlu memastikan siswa memiliki data di tabel siswa

#### Solusi yang Diterapkan:
1. **Memastikan Relasi User-Siswa**:
   - User dengan role siswa harus memiliki data di tabel `siswa`
   - Relasi `user->siswa` harus berfungsi dengan benar

2. **Perbaikan View**:
   - Menggunakan container yang benar untuk konsistensi UI
   - Memastikan form upload berfungsi dengan benar

## Perbaikan yang Telah Diterapkan

### 1. **LogbookController** (`app/Http/Controllers/Backend/LogbookController.php`)

#### Method `index()`:
```php
public function index()
{
    $user = Auth::user();
    
    if ($user->role === 'siswa') {
        // Siswa hanya melihat logbook miliknya sendiri
        $siswa = $user->siswa;
        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }
        $logbooks = Logbook::where('siswa_id', $siswa->id)->latest()->paginate(10);
    } elseif ($user->role === 'pembimbing') {
        // Pembimbing melihat logbook siswa yang dibimbingnya
        $pembimbing = $user->pembimbing;
        if (!$pembimbing) {
            return redirect()->back()->with('error', 'Data pembimbing tidak ditemukan.');
        }
        $logbooks = Logbook::whereHas('siswa', function($query) use ($pembimbing) {
            $query->where('pembimbing_id', $pembimbing->id);
        })->with('siswa')->latest()->paginate(10);
    } else {
        // Administrator melihat semua logbook
        $logbooks = Logbook::with('siswa')->latest()->paginate(10);
    }
    
    return view('backend.logbook.index', compact('logbooks'));
}
```

#### Method `create()`:
```php
public function create()
{
    $user = Auth::user();
    
    if ($user->role === 'siswa') {
        // Siswa tidak perlu memilih siswa, otomatis menggunakan data mereka sendiri
        return view('backend.logbook.create');
    } elseif ($user->role === 'administrator') {
        // Administrator bisa memilih siswa
        $siswas = Siswa::all();
        return view('backend.logbook.create', compact('siswas'));
    } else {
        // Pembimbing tidak bisa membuat logbook
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membuat logbook.');
    }
}
```

### 2. **Model Logbook** (`app/Models/Logbook.php`)

#### Perbaikan field fillable:
```php
protected $fillable = [
    'siswa_id',
    'tanggal',
    'uraian_tugas',
    'hasil', // Sebelumnya 'hasil_output'
    'dokumentasi',
];
```

### 3. **Model Siswa** (`app/Models/Siswa.php`)

#### Menambahkan relasi:
```php
public function logbooks()
{
    return $this->hasMany(\App\Models\Logbook::class, 'siswa_id');
}

public function laporanMagang()
{
    return $this->hasMany(\App\Models\LaporanMagang::class, 'siswa_id');
}

public function pengajuanMagang()
{
    return $this->hasMany(\App\Models\PengajuanMagang::class, 'user_id', 'user_id');
}
```

### 4. **View Logbook** (`resources/views/backend/logbook/`)

#### Form Create:
- Menambahkan field siswa hanya untuk administrator
- Siswa tidak perlu memilih siswa

#### Form Edit:
- Menangani role administrator dan siswa dengan benar
- Administrator bisa memilih siswa, siswa tidak

#### View Index:
- Tidak menampilkan kolom siswa untuk role siswa
- Menampilkan kolom siswa untuk administrator dan pembimbing

### 5. **View Laporan** (`resources/views/backend/laporan/index.blade.php`)

#### Perbaikan container:
```php
<div class="container-xxl flex-grow-1 container-p-y">
```

## Cara Testing

### 1. **Test Logbook untuk Siswa**
1. Login sebagai siswa
2. Akses menu "Logbook"
3. Klik "Tambah Logbook"
4. Isi form dan simpan
5. Pastikan logbook muncul di list

### 2. **Test Pengajuan Magang untuk Siswa**
1. Login sebagai siswa
2. Akses menu "Pengajuan Magang"
3. Pilih DUDI dan klik "Usulkan"
4. Pastikan pengajuan berhasil

### 3. **Test Upload Laporan untuk Siswa**
1. Login sebagai siswa
2. Akses menu "Upload Laporan Magang"
3. Isi form dan upload file PDF
4. Pastikan laporan berhasil diupload

## Troubleshooting Lanjutan

### Jika Siswa Masih Tidak Bisa Mengakses:

1. **Cek Data Siswa**:
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'siswa@gmail.com')->first();
>>> $user->siswa;
```

2. **Cek Role Assignment**:
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'siswa@gmail.com')->first();
>>> $user->roles;
```

3. **Reset Database**:
```bash
php artisan migrate:fresh --seed
```

### Jika Masih Ada Error:

1. **Cek Log Laravel**:
```bash
tail -f storage/logs/laravel.log
```

2. **Clear Cache**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

3. **Cek Permission**:
```bash
chmod -R 775 storage bootstrap/cache
```

## Kesimpulan

Setelah perbaikan yang diterapkan:

1. ✅ **Siswa bisa mengisi logbook** - Controller sudah menangani role dengan benar
2. ✅ **Siswa bisa melakukan pengajuan magang** - Controller sudah benar, hanya perlu data siswa
3. ✅ **Siswa bisa upload laporan magang** - Controller sudah benar, hanya perlu data siswa
4. ✅ **Role-based access control** - Setiap role memiliki akses yang sesuai
5. ✅ **UI/UX konsisten** - View sudah diperbaiki untuk semua role

Pastikan untuk menjalankan `php artisan migrate:fresh --seed` untuk memastikan data awal tersedia dengan benar.
