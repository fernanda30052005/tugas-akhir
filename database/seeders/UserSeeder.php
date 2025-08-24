<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pembimbing;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            try {
                // Create Administrator
                $admin = User::create([
                    'name'              => 'Administrator',
                    'username'          => 'admin',
                    'email'             => 'admin@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('12345678'),
                    'role'              => 'administrator',
                ]);
                $admin->assignRole('administrator');
                
                // Create sample Jurusan first
                $jurusan = Jurusan::create([
                    'jurusan' => 'Teknik Komputer dan Jaringan',
                ]);
                
                // Create sample Pembimbing first
                $pembimbingUser = User::create([
                    'name'              => 'Pembimbing Contoh',
                    'username'          => 'pembimbing',
                    'email'             => 'pembimbing@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('12345678'),
                    'role'              => 'pembimbing',
                ]);
                $pembimbingUser->assignRole('pembimbing');
                
                // Create pembimbing data
                $pembimbing = Pembimbing::create([
                    'user_id'       => $pembimbingUser->id,
                    'nama'          => 'Pembimbing Contoh',
                    'nip'           => '198501012010012001',
                    'jenis_kelamin' => 'Laki-laki',
                ]);
                
                // Create sample Siswa
                $siswaUser = User::create([
                    'name'              => 'Siswa Contoh',
                    'username'          => 'siswa',
                    'email'             => 'siswa@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('12345678'),
                    'role'              => 'siswa',
                ]);
                $siswaUser->assignRole('siswa');
                
                // Create siswa data
                $siswa = Siswa::create([
                    'user_id'       => $siswaUser->id,
                    'nama'          => 'Siswa Contoh',
                    'nis'           => '2024001',
                    'jurusan_id'    => $jurusan->id,
                    'jenis_kelamin' => 'L',
                    'no_hp'         => '081234567890',
                    'pembimbing_id' => $pembimbing->id,
                ]);
                
                $this->command->info('Users, Siswa, and Pembimbing created successfully!');
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->command->error('Error creating users: ' . $e->getMessage());
                throw $e;
            }
        });
    }
}
