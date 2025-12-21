<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Slider::create([
                'image' => 'default.svg',
                'title' => "Slider $i",
                'caption' => "Deskripsi singkat untuk slider ke-$i yang menonjolkan fitur unggulan.",
                'urutan' => $i,
            ]);
        }
    }
}
