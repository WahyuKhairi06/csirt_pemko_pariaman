<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@csirt.pariamankota.go.id'],
            [
                'name' => 'Super Administrator CSIRT',
                'password' => Hash::make(env('CSIRT_SUPERADMIN_PASSWORD', 'PariamanCsirt#2026!')),
            ]
        );
        $superadmin->syncRoles(['superadmin']);

        $normalUser = User::firstOrCreate(
            ['email' => 'user@csirt.pariamankota.go.id'],
            [
                'name' => 'Pengguna Terdaftar',
                'password' => Hash::make(env('CSIRT_USER_PASSWORD', 'PariamanUser#2026!')),
            ]
        );
        $normalUser->syncRoles(['user']);
    }
}
