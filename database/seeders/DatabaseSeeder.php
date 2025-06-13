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
            GuruSeeder::class,
            GuruMataPelajaranSeeder::class,
            // SiswaSeeder::class,
            UserSeeder::class,
            PpdbSeeder::class,
            CalonSiswaSeeder::class,
            BerkasCalonSeeder::class,
            SiswaSeeder::class,
            RiwayatKelasSeeder::class,
        ]);
    }
}
