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
                // 'route' => 'dashboard',
                // 'permission' => 'dashboard.view',
                'order' => 1,
            ],
            [
                'name' => 'PPDB',
                'icon' => 'fas fa-clipboard-list',
                'permission' => 'manage_ppdb',
                'group' => 'PPDB',
                'order' => 2,
                'children' => [
                    [
                        'name' => 'Tahun Ajaran',
                        'route' => 'tahun-ajaran.index',
                        'permission' => 'manage_tahun_ajaran',
                        'icon' => 'fas fa-calendar-alt',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Jadwal PPDB',
                        'route' => 'jadwal-ppdb.index',
                        'permission' => 'manage_jadwal_ppdb',
                        'icon' => 'fas fa-clock',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Jalur Pendaftaran',
                        'route' => 'jalur-pendaftaran.index',
                        'permission' => 'manage_jalur_pendaftaran',
                        'icon' => 'fas fa-route',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Kuota Pendaftaran',
                        'route' => 'kuota-pendaftaran.index',
                        'permission' => 'manage_kuota_pendaftaran',
                        'icon' => 'fas fa-users',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Biaya Pendaftaran',
                        'route' => 'biaya-pendaftaran.index',
                        'permission' => 'manage_biaya_pendaftaran',
                        'icon' => 'fas fa-money-bill-wave',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Calon Siswa',
                        'route' => 'calon-siswa.index',
                        'permission' => 'manage_calon_siswa',
                        'icon' => 'fas fa-user-graduate',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'Pembayaran',
                'icon' => 'fas fa-credit-card',
                'permission' => 'manage_pembayaran',
                'group' => 'PPDB',
                'order' => 3,
                'children' => [
                    [
                        'name' => 'Data Pembayaran',
                        'route' => 'pembayaran.index',
                        // 'permission' => 'pembayaran.view',
                        'icon' => 'fas fa-list',
                        'group' => 'PPDB',
                    ],
                    // [
                    //     'name' => 'Verifikasi Pembayaran',
                    //     'route' => 'pembayaran.verifikasi',
                    //     'permission' => 'pembayaran.verify',
                    //     'icon' => 'fas fa-check-circle',
                    //     'group' => 'PPDB',
                    // ],
                    [
                        'name' => 'Laporan Pembayaran',
                        'route' => 'laporan.pembayaran',
                        // 'permission' => 'pembayaran.report',
                        'icon' => 'fas fa-chart-bar',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'permission' => 'manage_laporan',
                'group' => 'PPDB',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Laporan Pendaftar',
                        // 'route' => 'laporan.pendaftar',
                        'permission' => 'manage_laporan_pendaftar',
                        'icon' => 'fas fa-user-friends',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Laporan Keuangan',
                        // 'route' => 'laporan.keuangan',
                        'permission' => 'manage_laporan_keuangan',
                        'icon' => 'fas fa-coins',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Laporan Kuota',
                        // 'route' => 'laporan.kuota',
                        'permission' => 'manage_laporan_kuota',
                        'icon' => 'fas fa-chart-pie',
                        'group' => 'PPDB',
                    ],
                ]
            ],
            [
                'name' => 'E-Learning',
                'icon' => 'fas fa-graduation-cap',
                // 'permission' => 'manage_elearning',
                'group' => 'E-Learning',
                'order' => 5,
                'children' => [
                    [
                        'name' => 'Materi',
                        'route' => 'materi.index',
                        // 'permission' => 'materi.view',
                        'icon' => 'fas fa-file-pdf',
                        'group' => 'E-Learning',
                    ],
                    [
                        'name' => 'Tugas',
                        'route' => 'tugas.index',
                        // 'permission' => 'tugas.view',
                        'icon' => 'fas fa-tasks',
                        'group' => 'E-Learning',
                    ],
                ]
            ],
            [
                'name' => 'Manajemen User',
                'icon' => 'fas fa-users-cog',
                'permission' => 'manage_user_management',
                'group' => 'Pengaturan Sistem',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'User',
                        'route' => 'users.index',
                        // 'permission' => 'users.view',
                        'icon' => 'fas fa-user',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Role',
                        'route' => 'roles.index',
                        // 'permission' => 'roles.view',
                        'icon' => 'fas fa-user-tag',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Permission',
                        'route' => 'permissions.index',
                        // 'permission' => 'permissions.view',
                        'icon' => 'fas fa-key',
                        'group' => 'Pengaturan Sistem',
                    ],
                ]
            ],
            [
                'name' => 'Data Master',
                'icon' => 'fas fa-database',
                'permission' => 'manage_data_master',
                'group' => 'Pengaturan Sistem',
                'order' => 6,
                'children' => [
                    [
                        'name' => 'Guru',
                        'route' => 'guru.index',
                        'permission' => 'manage_guru',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Kelas',
                        'route' => 'kelas.index',
                        'permission' => 'manage_kelas',
                        'icon' => 'fas fa-school',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Siswa',
                        'route' => 'siswa.index',
                        'permission' => 'manage_siswa',
                        'icon' => 'fas fa-users',
                        'group' => 'E-Learning',
                    ],
                    [
                        'name' => 'Mata Pelajaran',
                        'route' => 'mata-pelajaran.index',
                        'permission' => 'manage_mata_pelajaran',
                        'icon' => 'fas fa-book',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Guru Mata Pelajaran',
                        'route' => 'guru-mata-pelajaran.index',
                        'permission' => 'manage_guru_mata_pelajaran',
                        'icon' => 'fas fa-user-graduate',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Guru Kelas',
                        'route' => 'guru-kelas.index',
                        'permission' => 'manage_guru_kelas',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'group' => 'Pengaturan Sistem',
                    ],
                    [
                        'name' => 'Jadwal Pelajaran',
                        'route' => 'jadwal.index',
                        'permission' => 'manage_jadwal',
                        'icon' => 'fas fa-calendar-alt',
                        'group' => 'Pengaturan Sistem',
                    ],
                ]
            ],
            [
                'name' => 'Pengaturan Sistem',
                'icon' => 'fas fa-cog',
                'permission' => 'manage_pengaturan_sistem',
                'group' => 'Pengaturan Sistem',
                'order' => 100,
                'children' => [
                    [
                        'name' => 'Menu',
                        'route' => 'menus.index',
                        'permission' => 'manage_menus',
                        'icon' => 'fas fa-bars',
                        'group' => 'Pengaturan Sistem',
                    ],
                    // [
                    //     'name' => 'Konfigurasi',
                    //     'route' => 'settings.index',
                    //     'permission' => 'settings.view',
                    //     'icon' => 'fas fa-sliders-h',
                    //     'group' => 'Pengaturan Sistem',
                    // ],
                    // [
                    //     'name' => 'Backup Database',
                    //     'route' => 'backup.index',
                    //     'permission' => 'backup.view',
                    //     'icon' => 'fas fa-database',
                    //     'group' => 'Pengaturan Sistem',
                    // ],
                    // [
                    //     'name' => 'Log Aktivitas',
                    //     'route' => 'logs.index',
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
