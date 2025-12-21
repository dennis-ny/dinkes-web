<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        for ($i = 1; $i <= 5; $i++) {
            $title = "Berita Terbaru $i";
            News::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'thumbnail' => 'default.svg',
                'content' => "<p>Ini adalah konten untuk berita terbaru ke-$i. Berita ini berisi informasi terkini seputar kesehatan di wilayah kita.</p>",
                'user_id' => $admin->id,
                'views' => rand(5, 50),
            ]);
        }
    }
}
