<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            try {
                // Create roles
                Role::create(['name' => 'administrator']);
                Role::create(['name' => 'siswa']);
                Role::create(['name' => 'pembimbing']);
                
                $this->command->info('Roles created successfully!');
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->command->error('Error creating roles: ' . $th->getMessage());
            }
        });
    }
}
