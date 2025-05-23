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
        $setting = Menu::create([
            'name' => 'Pengaturan Sistem',
            'icon' => 'fas fa-cog',
            'permission' => 'setting.view',
            'order' => 100,
        ]);

        // Submenu Setting
        Menu::create([
            'name' => 'Manajemen Menu',
            'icon' => 'fas fa-bars',
            'route' => 'admin.menus.index',
            'permission' => 'setting.menu.manage',
            'parent_id' => $setting->id,
            'order' => 1,
        ]);

        Menu::create([
            'name' => 'Manajemen Role',
            'icon' => 'fas fa-user-tag',
            'route' => 'admin.roles.index',
            'permission' => 'setting.role.manage',
            'parent_id' => $setting->id,
            'order' => 2,
        ]);

        Menu::create([
            'name' => 'Manajemen User',
            'icon' => 'fas fa-users',
            'route' => 'admin.users.index',
            'permission' => 'setting.user.manage',
            'parent_id' => $setting->id,
            'order' => 3,
        ]);
    }
}
