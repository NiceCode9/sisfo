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
                'route' => 'dashboard',
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
            // [
            //     'name' => 'Pembayaran',
            //     'icon' => 'fas fa-credit-card',
            //     'permission' => 'manage_pembayaran',
            //     'group' => 'PPDB',
            //     'order' => 3,
            //     'children' => [
            //         [
            //             'name' => 'Data Pembayaran',
            //             'route' => 'pembayaran.index',
            //             // 'permission' => 'pembayaran.view',
            //             'icon' => 'fas fa-list',
            //             'group' => 'PPDB',
            //         ],
            //         // [
            //         //     'name' => 'Verifikasi Pembayaran',
            //         //     'route' => 'pembayaran.verifikasi',
            //         //     'permission' => 'pembayaran.verify',
            //         //     'icon' => 'fas fa-check-circle',
            //         //     'group' => 'PPDB',
            //         // ],
            //         [
            //             'name' => 'Laporan Pembayaran',
            //             'route' => 'laporan.pembayaran',
            //             // 'permission' => 'pembayaran.report',
            //             'icon' => 'fas fa-chart-bar',
            //             'group' => 'PPDB',
            //         ],
            //     ]
            // ],
            [
                'name' => 'Laporan',
                'icon' => 'fas fa-file-alt',
                'permission' => 'manage_laporan',
                'group' => 'PPDB',
                'order' => 4,
                'children' => [
                    [
                        'name' => 'Laporan Pendaftaran',
                        // 'route' => 'laporan.pendaftar',
                        'permission' => 'manage_laporan_pendaftar',
                        'icon' => 'fas fa-user-friends',
                        'group' => 'PPDB',
                    ],
                    [
                        'name' => 'Laporan Keuangan',
                        'route' => 'laporan.pembayaran',
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
                        // 'group' => 'E-Learning',
                    ],
                    [
                        'name' => 'Data Pengumpulan Tugas',
                        'route' => 'pengumpulan-tugas.index',
                        // 'permission' => 'tugas.view',
                        'icon' => 'fas fa-tasks',
                        'group' => 'E-Learning',
                    ],
                ]
            ],
            [
                'name' => 'Ekstrakurikuler',
                'icon' => 'fas fa-futbol',
                'group' => 'E-Learning', // Dashboard tidak masuk ke group manapun
                'route' => 'ekstrakurikuler.index',
                'permission' => 'manage_ekstrakurikuler',
                'order' => 6,
            ],
            [
                'name' => 'Kenaikan Kelas',
                'icon' => 'fas fa-graduation-cap',
                'group' => 'E-Learning',
                'route' => 'kenaikan-kelas.index',
                'permission' => 'manage_ekstrakurikuler',
                'order' => 6,
            ],
            [
                'name' => 'Manajemen User',
                'icon' => 'fas fa-users-cog',
                'permission' => 'manage_user_management',
                'group' => 'General',
                'order' => 7,
                'children' => [
                    [
                        'name' => 'User',
                        'route' => 'users.index',
                        // 'permission' => 'users.view',
                        'icon' => 'fas fa-user',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Role',
                        'route' => 'roles.index',
                        // 'permission' => 'roles.view',
                        'icon' => 'fas fa-user-tag',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Permission',
                        'route' => 'permissions.index',
                        // 'permission' => 'permissions.view',
                        'icon' => 'fas fa-key',
                        'group' => 'General',
                    ],
                ]
            ],
            [
                'name' => 'Data Master',
                'icon' => 'fas fa-database',
                'permission' => 'manage_data_master',
                'group' => 'General',
                'order' => 8,
                'children' => [
                    [
                        'name' => 'Guru',
                        'route' => 'guru.index',
                        'permission' => 'manage_guru',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Kelas',
                        'route' => 'kelas.index',
                        'permission' => 'manage_kelas',
                        'icon' => 'fas fa-school',
                        'group' => 'General',
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
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Guru Mata Pelajaran',
                        'route' => 'guru-mata-pelajaran.index',
                        'permission' => 'manage_guru_mata_pelajaran',
                        'icon' => 'fas fa-user-graduate',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Guru Kelas',
                        'route' => 'guru-kelas.index',
                        'permission' => 'manage_guru_kelas',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Jadwal Pelajaran',
                        'route' => 'jadwal.index',
                        'permission' => 'manage_jadwal',
                        'icon' => 'fas fa-calendar-alt',
                        'group' => 'General',
                    ],
                ]
            ],
            [
                'name' => 'Artikel',
                'icon' => 'fas fa-newspaper',
                'permission' => 'manage_module_artikel',
                'group' => 'General',
                'order' => 9,
                'children' => [
                    [
                        'name' => 'Kategori',
                        'route' => 'artikel.kategori.index',
                        'permission' => 'manage_kategori',
                        'icon' => 'fas fa-bars',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Tags',
                        'route' => 'artikel.tags.index',
                        'permission' => 'manage_tags',
                        'icon' => 'fas fa-bars',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Daftar Artikel',
                        'route' => 'artikel.artikel.index',
                        'permission' => 'manage_artikel',
                        'icon' => 'fas fa-bars',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Komentar',
                        'route' => 'artikel.komentar.index',
                        'permission' => 'manage_komentar',
                        'icon' => 'fas fa-bars',
                        'group' => 'General',
                    ],
                ]
            ],
            [
                'name' => 'Pengaturan Sistem',
                'icon' => 'fas fa-cog',
                'permission' => 'manage_pengaturan_sistem',
                'group' => 'General',
                'order' => 100,
                'children' => [
                    [
                        'name' => 'Menu',
                        'route' => 'menus.index',
                        'permission' => 'manage_menus',
                        // 'icon' => 'fas fa-bars',
                        'group' => 'General',
                    ],
                    [
                        'name' => 'Konfigurasi',
                        'route' => 'general-profile.index',
                        'permission' => 'manage_general_profile',
                        // 'icon' => 'fas fa-sliders-h',
                        'group' => 'General',
                    ],
                    // [
                    //     'name' => 'Backup Database',
                    //     'route' => 'backup.index',
                    //     'permission' => 'backup.view',
                    //     'icon' => 'fas fa-database',
                    //     'group' => 'General',
                    // ],
                    // [
                    //     'name' => 'Log Aktivitas',
                    //     'route' => 'logs.index',
                    //     'permission' => 'logs.view',
                    //     'icon' => 'fas fa-history',
                    //     'group' => 'General',
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
