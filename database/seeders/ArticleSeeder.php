<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 5; $i++) {
            $title = "Artikel Contoh $i";
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'thumbnail' => 'default.svg',
                'content' => "<p>Ini adalah konten untuk artikel contoh ke-$i. Konten ini dihasilkan secara otomatis oleh seeder untuk tujuan testing.</p>",
                'category_id' => $categories->random()->id,
                'user_id' => $admin->id,
                'status' => 'published',
                'is_guest' => false,
                'views' => rand(10, 100),
            ]);
        }
    }
}
