<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'siswa_id' => null,
            'guru_id' => null,
        ]);
        $admin->assignRole('admin');

        // Guru Users
        $guruUsers = [
            [
                'name' => 'Drs. Suprayogi, M.Pd',
                'username' => 'suprayogi',
                'email' => 'suprayogi@sekolah.com',
                'guru_id' => 1,
            ],
            [
                'name' => 'Dra. Sri Mulyani, M.Pd',
                'username' => 'srimulyani',
                'email' => 'srimulyani@sekolah.com',
                'guru_id' => 2,
            ],
            [
                'name' => 'John Anderson, S.Pd',
                'username' => 'johnanderson',
                'email' => 'john@sekolah.com',
                'guru_id' => 3,
            ],
            [
                'name' => 'Dr. Bambang Sutrisno, M.Si',
                'username' => 'bambangsutrisno',
                'email' => 'bambang@sekolah.com',
                'guru_id' => 4,
            ],
            [
                'name' => 'Dra. Ratna Sari, M.Si',
                'username' => 'ratnasari',
                'email' => 'ratna@sekolah.com',
                'guru_id' => 5,
            ],
            [
                'name' => 'Dr. Eko Prasetyo, M.Pd',
                'username' => 'ekoprasetyo',
                'email' => 'eko@sekolah.com',
                'guru_id' => 6,
            ],
            [
                'name' => 'Drs. Agus Salim, M.Hum',
                'username' => 'agussalim',
                'email' => 'agus@sekolah.com',
                'guru_id' => 7,
            ],
            [
                'name' => 'Dra. Wulan Dari, M.Si',
                'username' => 'wulandari',
                'email' => 'wulan@sekolah.com',
                'guru_id' => 8,
            ],
        ];

        foreach ($guruUsers as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'siswa_id' => null,
                'guru_id' => $userData['guru_id'],
            ]);
            $user->assignRole('guru');
        }
    }
}
