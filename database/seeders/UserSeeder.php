<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);

        $admin->assignRole('admin');

        $guru = \App\Models\Guru::create([
            'nip' => '999888',
            'biografi' => 'Guru Biografi',
            'bidang_keahlian' => 'Matematika',
        ]);
        $guru = \App\Models\User::create([
            'name' => 'Mukhamad Ilham Hidayat',
            'email' => 'nicecode9@gmail.com ',
            'username' => '999888',
            'guru_id' => $guru->id,
            'password' => bcrypt('guru'),
        ]);
        $guru->assignRole('guru');
    }
}
