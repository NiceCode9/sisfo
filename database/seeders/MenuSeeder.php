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
        // Define menu structure with groups
        $menuStructure = [
            [
                'name' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'group' => null, // Dashboard tidak masuk ke group manapun
                // 'route' => 'admin.dashboard',
                // 'permission' => 'dashboard.view',
                'order' => 1,
            ],
            [
                'name' => 'PPDB',
                'icon' => 'fas fa-clipboard-list',
                'group' => 'PPDB',
                // 'permission' => 'ppdb.view',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'Tahun Ajaran',
                        'route' => 'admin.tahun-ajaran.index',
                        // 'permission' => 'tahun-ajaran.view',
                        'icon' => 'fas fa-calendar-alt',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Jadwal PPDB',
                        'route' => 'admin.jadwal-ppdb.index',
                        // 'permission' => 'jadwal-ppdb.view',
                        'icon' => 'fas fa-clock',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Jalur Pendaftaran',
                        'route' => 'admin.jalur-pendaftaran.index',
                        // 'permission' => 'jalur-pendaftaran.view',
                        'icon' => 'fas fa-route',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Kuota Pendaftaran',
                        'route' => 'admin.kuota-pendaftaran.index',
                        // 'permission' => 'kuota-pendaftaran.view',
                        'icon' => 'fas fa-users',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Biaya Pendaftaran',
                        'route' => 'admin.biaya-pendaftaran.index',
                        // 'permission' => 'biaya-pendaftaran.view',
                        'icon' => 'fas fa-money-bill-wave',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Calon Siswa',
                        'route' => 'admin.calon-siswa.index',
                        // 'permission' => 'calon-siswa.view',
                        'icon' => 'fas fa-user-graduate',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'Pembayaran',
                'icon' => 'fas fa-credit-card',
                'permission' => 'pembayaran.view',
                'group' => 'PPDB',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'Data Pembayaran',
                        'route' => 'admin.pembayaran.index',
                        'permission' => 'pembayaran.view',
                        'icon' => 'fas fa-list',
                        'group' => 'PPDB',
                    ],
                    // [
                    //     'name' => 'Verifikasi Pembayaran',
                    //     'route' => 'admin.pembayaran.verifikasi',
                    //     'permission' => 'pembayaran.verify',
                    //     'icon' => 'fas fa-check-circle',
                    //     'group' => 'PPDB',
                    // ],
                    [
                        'name' => 'Laporan Pembayaran',
                        'route' => 'admin.laporan.pembayaran',
                        'permission' => 'pembayaran.report',
                        'icon' => 'fas fa-chart-bar',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'permission' => 'laporan.view',
                'group' => 'PPDB',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Laporan Pendaftar',
                        // 'route' => 'admin.laporan.pendaftar',
                        'permission' => 'laporan.pendaftar',
                        'icon' => 'fas fa-user-friends',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Laporan Keuangan',
                        // 'route' => 'admin.laporan.keuangan',
                        'permission' => 'laporan.keuangan',
                        'icon' => 'fas fa-coins',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Laporan Kuota',
                        // 'route' => 'admin.laporan.kuota',
                        'permission' => 'laporan.kuota',
                        'icon' => 'fas fa-chart-pie',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'E-Learning',
                'icon' => 'fas fa-graduation-cap',
                'permission' => 'elearning.view',
                'group' => 'E-Learning',
                'order' => 5,
                'children' => [
                    [
                        'name' => 'Materi',
                        'route' => 'admin.materi.index',
                        // 'permission' => 'materi.view',
                        'icon' => 'fas fa-file-pdf',
                        'group' => 'E-Learning',
                    ],
                    [
                        'name' => 'Tugas',
                        'route' => 'admin.tugas.index',
                        // 'permission' => 'tugas.view',
                        'icon' => 'fas fa-tasks',
                        'group' => 'E-Learning',
                    ],
                ]
            ],
            [
                'name' => 'Manajemen User',
                'icon' => 'fas fa-users-cog',
                'permission' => 'user-management.view',
                'group' => 'Pengaturan Sistem',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'User',
                        'route' => 'admin.users.index',
                        'permission' => 'users.view',
                        'icon' => 'fas fa-user',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Role',
                        'route' => 'admin.roles.index',
                        'permission' => 'roles.view',
                        'icon' => 'fas fa-user-tag',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Permission',
                        'route' => 'admin.permissions.index',
                        'permission' => 'permissions.view',
                        'icon' => 'fas fa-key',
                        'group' => 'Pengaturan Sistem',
                    ],
                ]
            ],
            [
                'name' => 'Data Master',
                'icon' => 'fas fa-database',
                'permission' => 'data-master.view',
                'group' => 'Pengaturan Sistem',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'Guru',
                        'route' => 'admin.guru.index',
                        // 'permission' => 'guru.view',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Kelas',
                        'route' => 'admin.kelas.index',
                        // 'permission' => 'kelas.view',
                        'icon' => 'fas fa-school',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Siswa',
                        'route' => 'admin.siswa.index',
                        // 'permission' => 'siswa.view',
                        'icon' => 'fas fa-users',
                        'group' => 'E-Learning',
                    ],
                    [
                        'name' => 'Mata Pelajaran',
                        'route' => 'admin.mata-pelajaran.index',
                        // 'permission' => 'mata-pelajaran.view',
                        'icon' => 'fas fa-book',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Guru Mata Pelajaran',
                        'route' => 'admin.guru-mata-pelajaran.index',
                        // 'permission' => 'mata-pelajaran.view',
                        'icon' => 'fas fa-user-graduate',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Jadwal Pelajaran',
                        'route' => 'admin.jadwal.index',
                        // 'permission' => 'jadwal.view',
                        'icon' => 'fas fa-calendar-alt',
                        'group' => 'Pengaturan Sistem',
                    ],
                ]
            ],
            [
                'name' => 'Pengaturan Sistem',
                'icon' => 'fas fa-cog',
                'permission' => 'setting.view',
                'group' => 'Pengaturan Sistem',
                'order' => 100,
                'children' => [
                    [
                        'name' => 'Menu',
                        'route' => 'admin.menus.index',
                        'permission' => 'menus.view',
                        'icon' => 'fas fa-bars',
                        'group' => 'Pengaturan Sistem',
                    ],
                    // [
                    //     'name' => 'Konfigurasi',
                    //     'route' => 'admin.settings.index',
                    //     'permission' => 'settings.view',
                    //     'icon' => 'fas fa-sliders-h',
                    //     'group' => 'Pengaturan Sistem',
                    // ],
                    // [
                    //     'name' => 'Backup Database',
                    //     'route' => 'admin.backup.index',
                    //     'permission' => 'backup.view',
                    //     'icon' => 'fas fa-database',
                    //     'group' => 'Pengaturan Sistem',
                    // ],
                    // [
                    //     'name' => 'Log Aktivitas',
                    //     'route' => 'admin.logs.index',
                    //     'permission' => 'logs.view',
                    //     'icon' => 'fas fa-history',
                    //     'group' => 'Pengaturan Sistem',
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
                'group' => $menuData['group'] ?? null,
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
