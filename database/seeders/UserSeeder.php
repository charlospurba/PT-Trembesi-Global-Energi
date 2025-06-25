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
            'status' => 'active',
            'phone_number' => '0800000001',
            'project_kode' => '-',
            'store_name' => '-',
            'npwp' => '-',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'profile_picture' => '-',
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Procurement',
            'email' => 'procurement@example.com',
            'status' => 'active',
            'phone_number' => '0800000002',
            'project_kode' => '-',
            'store_name' => '-',
            'npwp' => '-',
            'username' => 'procurement',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'profile_picture' => '-',
            'role' => 'procurement',
        ]);

        User::create([
            'name' => 'Project Manager',
            'email' => 'pm@example.com',
            'status' => 'active',
            'phone_number' => '0800000003',
            'project_kode' => '-',
            'store_name' => '-',
            'npwp' => '-',
            'username' => 'projectmanager',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'profile_picture' => '-',
            'role' => 'project_manager',
        ]);

        User::create([
            'name' => 'Vendor',
            'email' => 'vendor@example.com',
            'status' => 'active',
            'phone_number' => '0800000007',
            'project_kode' => '-',
            'store_name' => 'PT Cempaka Putih',
            'npwp' => '-',
            'username' => 'vendor',
            'password' => Hash::make('password123'),
            'nib' => '-',
            'comp_profile' => '-',
            'izin_perusahaan' => '-',
            'sppkp' => '-',
            'struktur_organisasi' => '-',
            'daftar_pengalaman' => '-',
            'profile_picture' => '-',
            'role' => 'vendor',
        ]);
    }
}