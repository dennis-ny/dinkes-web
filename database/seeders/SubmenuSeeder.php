<?php

namespace Database\Seeders;

use App\Models\Submenu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Submenu::insert([
            [
                'nama_submenu' => 'Visi & Misi',
                'urutan' => 1,
                'menu_id' => 2,
                'link' => '/visi-dan-misi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Kedudukan & Tupoksi',
                'urutan' => 2,
                'menu_id' => 2,
                'link' => '/kedudukan-dan-tupoksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Layanan Puskesmas',
                'urutan' => 1,
                'menu_id' => 3,
                'link' => '/layanan-puskesmas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Perijinan Apotek & Obat',
                'urutan' => 2,
                'menu_id' => 3,
                'link' => '/perijinan-apotek-dan-obat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Perijinan Tenaga Kesehatan',
                'urutan' => 3,
                'menu_id' => 3,
                'link' => '/perijinan-tenaga-kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Puskesmas',
                'urutan' => 1,
                'menu_id' => 4,
                'link' => '/puskesmas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Labkesda',
                'urutan' => 2,
                'menu_id' => 4,
                'link' => '/labkesda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Berita',
                'urutan' => 1,
                'menu_id' => 5,
                'link' => '/berita',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_submenu' => 'Artikel',
                'urutan' => 2,
                'menu_id' => 5,
                'link' => '/artikel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
