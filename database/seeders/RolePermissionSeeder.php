<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $guru = Role::create(['name' => 'guru']);
        $siswa = Role::create(['name' => 'siswa']);


        $permissions = [
            'manage_pengaturan_sistem',
            'manage_data_master',
            'manage_ppdb',
            'manage_calon_siswa',
            'manage_users',
            'manage_menus',
            'manage_roles',
            'manage_permissions',
            'manage_kelas',
            'manage_tahun_ajaran',
            'manage_jalur_pendaftaran',
            'manage_biaya_pendaftaran',
            'manage_jadwal_ppdb',
            'manage_kuota_pendaftaran',
            'manage_pembayaran',
            'manage_laporan',
            'manage_laporan_pendaftar',
            'manage_laporan_keuangan',
            'manage_laporan_kuota',
            'manage_guru',
            'manage_siswa',
            'manage_mata_pelajaran',
            'manage_guru_mata_pelajaran',
            'manage_guru_kelas',
            'manage_jadwal',
            'view_tugas',
            'manage_tugas',
            'view_materi',
            'manage_materi',
            'view_soal',
            'manage_soal',
            'view_jawaban',
            // 'manage_jawaban',
            // 'manage_pengumpulan_tugas',
            // 'manage_jawaban_siswa',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $guruPermissions = [
            'view_tugas',
            'manage_tugas',
            'view_materi',
            'manage_materi',
            'view_soal',
            'manage_soal',
            'view_jawaban',
        ];
        $siswaPermissions = [
            'view_tugas',
            'manage_tugas',
            'view_materi',
            'manage_materi',
            'view_soal',
            'manage_soal',
            'view_jawaban',
        ];

        $guru->givePermissionTo($guruPermissions);
        $siswa->givePermissionTo($siswaPermissions);
    }
}
