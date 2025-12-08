<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            [
                'nama_menu' => 'Beranda',
                'urutan' => 1,
                'link' => '/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Profil',
                'urutan' => 2,
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Pelayanan Publik',
                'urutan' => 3,
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'UPT Dinas',
                'urutan' => 4,
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Informasi',
                'urutan' => 5,
                'link' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Kontak',
                'urutan' => 6,
                'link' => '/kontak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
