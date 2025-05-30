<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main menus
        $setting = Menu::create([
            'name' => 'Pengaturan Sistem',
            'icon' => 'fas fa-cog',
            'permission' => 'setting.view',
            'order' => 100,
        ]);

        $master = Menu::create([
            'name' => 'Master',
            'icon' => 'fas fa-database',
            'permission' => 'master.view',
            'order' => 200,
        ]);

        // Create master submenus
        $masterMenus = ['Tahun Ajaran', 'Jadwal PPDB', 'Jalur Pendaftaran', 'Kuota Pendaftaran', 'Biaya Pendaftaran', 'Calon Siswa'];
        foreach ($masterMenus as $index => $name) {
            Menu::create([
                'name' => $name,
                'parent_id' => $master->id,
                'order' => $index + 1,
            ]);
        }

        // Create setting submenus
        $settingMenus = [
            ['Menu', 'admin.menus.index'],
            ['Role', 'admin.roles.index'],
            ['Permission', 'admin.permissions.index'],
            ['User', 'admin.users.index'],
        ];

        foreach ($settingMenus as $index => $menu) {
            Menu::create([
                'name' => $menu[0],
                'route' => $menu[1],
                'parent_id' => $setting->id,
                'order' => $index + 1,
            ]);
        }
    }
}
