<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $pages = [
            'Profil Dinas Kesehatan',
            'Visi dan Misi',
            'Struktur Organisasi',
            'Kontak Kami',
        ];

        foreach ($pages as $pageTitle) {
            Page::create([
                'title' => $pageTitle,
                'slug' => Str::slug($pageTitle),
                'content' => "<p>Ini adalah konten untuk halaman $pageTitle. Halaman ini berisi informasi mendetail mengenai topik tersebut.</p>",
                'user_id' => $admin->id,
            ]);
        }
    }
}
