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
        // Define menu structure
        $menuStructure = [
            [
                'name' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                // 'route' => 'admin.dashboard',
                // 'permission' => 'dashboard.view',
                'order' => 1,
            ],
            [
                'name' => 'PPDB',
                'icon' => 'fas fa-clipboard-list',
                // 'permission' => 'ppdb.view',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'Tahun Ajaran',
                        'route' => 'admin.tahun-ajaran.index',
                        // 'permission' => 'tahun-ajaran.view',
                        'icon' => 'fas fa-calendar-alt',
                    ],
                    [
                        'name' => 'Jadwal PPDB',
                        'route' => 'admin.jadwal-ppdb.index',
                        // 'permission' => 'jadwal-ppdb.view',
                        'icon' => 'fas fa-clock',
                    ],
                    [
                        'name' => 'Jalur Pendaftaran',
                        'route' => 'admin.jalur-pendaftaran.index',
                        // 'permission' => 'jalur-pendaftaran.view',
                        'icon' => 'fas fa-route',
                    ],
                    [
                        'name' => 'Kuota Pendaftaran',
                        'route' => 'admin.kuota-pendaftaran.index',
                        // 'permission' => 'kuota-pendaftaran.view',
                        'icon' => 'fas fa-users',
                    ],
                    [
                        'name' => 'Biaya Pendaftaran',
                        'route' => 'admin.biaya-pendaftaran.index',
                        // 'permission' => 'biaya-pendaftaran.view',
                        'icon' => 'fas fa-money-bill-wave',
                    ],
                    [
                        'name' => 'Calon Siswa',
                        'route' => 'admin.calon-siswa.index',
                        // 'permission' => 'calon-siswa.view',
                        'icon' => 'fas fa-user-graduate',
                    ],
                ]
            ],
            [
                'name' => 'Pembayaran',
                'icon' => 'fas fa-credit-card',
                'permission' => 'pembayaran.view',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'Data Pembayaran',
                        // 'route' => 'admin.pembayaran.index',
                        'permission' => 'pembayaran.view',
                        'icon' => 'fas fa-list',
                    ],
                    // [
                    //     'name' => 'Verifikasi Pembayaran',
                    //     'route' => 'admin.pembayaran.verifikasi',
                    //     'permission' => 'pembayaran.verify',
                    //     'icon' => 'fas fa-check-circle',
                    // ],
                    [
                        'name' => 'Laporan Pembayaran',
                        // 'route' => 'admin.pembayaran.laporan',
                        'permission' => 'pembayaran.report',
                        'icon' => 'fas fa-chart-bar',
                    ],
                ]
            ],
            [
                'name' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'permission' => 'laporan.view',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Laporan Pendaftar',
                        // 'route' => 'admin.laporan.pendaftar',
                        'permission' => 'laporan.pendaftar',
                        'icon' => 'fas fa-user-friends',
                    ],
                    [
                        'name' => 'Laporan Keuangan',
                        // 'route' => 'admin.laporan.keuangan',
                        'permission' => 'laporan.keuangan',
                        'icon' => 'fas fa-coins',
                    ],
                    [
                        'name' => 'Laporan Kuota',
                        // 'route' => 'admin.laporan.kuota',
                        'permission' => 'laporan.kuota',
                        'icon' => 'fas fa-chart-pie',
                    ],
                ]
            ],
            [
                'name' => 'Manajemen User',
                'icon' => 'fas fa-users-cog',
                'permission' => 'user-management.view',
                'order' => 5,
                'children' => [
                    [
                        'name' => 'User',
                        'route' => 'admin.users.index',
                        'permission' => 'users.view',
                        'icon' => 'fas fa-user',
                    ],
                    [
                        'name' => 'Role',
                        'route' => 'admin.roles.index',
                        'permission' => 'roles.view',
                        'icon' => 'fas fa-user-tag',
                    ],
                    [
                        'name' => 'Permission',
                        'route' => 'admin.permissions.index',
                        'permission' => 'permissions.view',
                        'icon' => 'fas fa-key',
                    ],
                ]
            ],
            [
                'name' => 'Pengaturan Sistem',
                'icon' => 'fas fa-cog',
                'permission' => 'setting.view',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'Menu',
                        'route' => 'admin.menus.index',
                        'permission' => 'menus.view',
                        'icon' => 'fas fa-bars',
                    ],
                    // [
                    //     'name' => 'Konfigurasi',
                    //     'route' => 'admin.settings.index',
                    //     'permission' => 'settings.view',
                    //     'icon' => 'fas fa-sliders-h',
                    // ],
                    // [
                    //     'name' => 'Backup Database',
                    //     'route' => 'admin.backup.index',
                    //     'permission' => 'backup.view',
                    //     'icon' => 'fas fa-database',
                    // ],
                    // [
                    //     'name' => 'Log Aktivitas',
                    //     'route' => 'admin.logs.index',
                    //     'permission' => 'logs.view',
                    //     'icon' => 'fas fa-history',
                    // ],
                ]
            ],
        ];

        // Create menus recursively
        $this->createMenus($menuStructure);
    }

    /**
     * Create menus recursively
     */
    private function createMenus(array $menus, $parentId = null, $parentOrder = 0): void
    {
        foreach ($menus as $index => $menuData) {
            // Prepare menu data
            $menu = [
                'name' => $menuData['name'],
                'icon' => $menuData['icon'] ?? null,
                'route' => $menuData['route'] ?? null,
                'permission' => $menuData['permission'] ?? null,
                'parent_id' => $parentId,
                'order' => $menuData['order'] ?? ($parentOrder * 100 + $index + 1),
                'is_active' => $menuData['is_active'] ?? true,
            ];

            // Create the menu
            $createdMenu = Menu::create($menu);

            // Create children if exists
            if (isset($menuData['children']) && is_array($menuData['children'])) {
                $this->createMenus($menuData['children'], $createdMenu->id, $menu['order']);
            }
        }
    }
}
