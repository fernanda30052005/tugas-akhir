<?php

namespace Database\Seeders;

use App\Models\User;
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
                $admin = User::create([
                    'name'              => 'TATA USAHA',
                    'username'          => 'TU',
                    'email'             => 'tu@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('12345678'),
                ]);
                $admin->assignRole('Administrator');
            } catch (\Throwable $e) {
                throw $e;
            }
        });
    }
}
