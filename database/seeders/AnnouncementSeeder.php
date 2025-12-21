<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        for ($i = 1; $i <= 3; $i++) {
            $title = "Pengumuman Penting $i";
            Announcement::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "<p>Harap diperhatikan pengumuman nomor $i ini. Segala instruksi di dalamnya bersifat wajib bagi seluruh staf.</p>",
                'expires_at' => now()->addDays(30),
                'user_id' => $admin->id,
            ]);
        }
    }
}
