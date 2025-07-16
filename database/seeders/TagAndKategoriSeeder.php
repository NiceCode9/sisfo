<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagAndKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk Kategori
        $kategoris = [
            [
                'name' => 'Teknologi',
                'description' => 'Artikel tentang perkembangan teknologi terbaru',
                'meta_title' => 'Teknologi Terkini | Blog Kami',
                'meta_description' => 'Temukan artikel terbaru tentang teknologi dan inovasi',
                'meta_keywords' => 'teknologi, gadget, inovasi, IT',
                'image' => 'tech.jpg',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Tips dan informasi seputar kesehatan',
                'meta_title' => 'Kesehatan | Blog Kami',
                'meta_description' => 'Artikel bermanfaat tentang kesehatan dan gaya hidup',
                'meta_keywords' => 'kesehatan, medis, tips sehat',
                'image' => 'health.jpg',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Bisnis',
                'description' => 'Berita dan analisis bisnis terkini',
                'meta_title' => 'Bisnis dan Ekonomi | Blog Kami',
                'meta_description' => 'Update terbaru seputar dunia bisnis dan ekonomi',
                'meta_keywords' => 'bisnis, ekonomi, keuangan, investasi',
                'image' => 'business.jpg',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Berita dan tips olahraga',
                'meta_title' => null, // Akan diisi otomatis dengan name
                'meta_description' => null, // Akan diisi otomatis dengan description
                'meta_keywords' => 'olahraga, fitness, latihan',
                'image' => 'sports.jpg',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Hiburan',
                'description' => 'Berita hiburan dan selebriti',
                'meta_title' => 'Hiburan | Blog Kami',
                'meta_description' => 'Update terbaru dunia hiburan dan film',
                'meta_keywords' => 'hiburan, film, musik, selebriti',
                'image' => 'entertainment.jpg',
                'is_active' => false,
                'sort_order' => 5
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // Data untuk Tag
        $tags = [
            [
                'name' => 'Laravel',
                'description' => 'Artikel tentang framework Laravel',
                'meta_title' => 'Laravel Tutorial | Blog Kami',
                'meta_description' => 'Belajar Laravel dengan tutorial lengkap',
                'is_active' => true
            ],
            [
                'name' => 'PHP',
                'description' => 'Artikel tentang bahasa pemrograman PHP',
                'meta_title' => 'PHP Programming | Blog Kami',
                'meta_description' => 'Tutorial dan tips pemrograman PHP',
                'is_active' => true
            ],
            [
                'name' => 'JavaScript',
                'description' => 'Artikel tentang JavaScript dan framework-nya',
                'meta_title' => 'JavaScript Tutorial | Blog Kami',
                'meta_description' => 'Belajar JavaScript dari dasar hingga mahir',
                'is_active' => true
            ],
            [
                'name' => 'Kebugaran',
                'description' => 'Tips dan tutorial kebugaran',
                'meta_title' => null, // Akan diisi otomatis dengan name
                'meta_description' => null, // Akan diisi otomatis dengan description
                'is_active' => true
            ],
            [
                'name' => 'Diet',
                'description' => 'Tips dan resep diet sehat',
                'meta_title' => 'Diet Sehat | Blog Kami',
                'meta_description' => 'Panduan diet sehat dan alami',
                'is_active' => false
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        $this->command->info('Seeder untuk Kategori dan Tag berhasil dijalankan!');
    }
}
