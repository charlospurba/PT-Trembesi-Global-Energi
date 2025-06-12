<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone_number' => '0800000001',
            'npwp' => '-',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Procurement',
            'email' => 'procurement@example.com',
            'phone_number' => '0800000002',
            'npwp' => '-',
            'username' => 'procurement',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'role' => 'procurement',
        ]);

        User::create([
            'name' => 'Product Manager',
            'email' => 'pm@example.com',
            'phone_number' => '0800000003',
            'npwp' => '-',
            'username' => 'productmanager',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'role' => 'product_manager',
        ]);
    }
}

