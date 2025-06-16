<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolePermissionSeeder::class,
            MenuSeeder::class,
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            PpdbSeeder::class,
            GuruSeeder::class,
            GuruMataPelajaranSeeder::class,
            GuruKelasSeeder::class,
            // UserSeeder::class,
            CalonSiswaSeeder::class,
            SiswaSeeder::class,          // Pindah sebelum BerkasCalonSeeder
            BerkasCalonSeeder::class,    // Setelah SiswaSeeder karena SiswaSeeder akan menambah calon siswa
            RiwayatKelasSeeder::class,
            UserSeeder::class,
        ]);
    }
}
