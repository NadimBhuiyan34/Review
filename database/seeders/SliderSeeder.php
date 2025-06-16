<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;
use Illuminate\Support\Str;
class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
        'https://img.freepik.com/free-psd/black-friday-super-sale-facebook-cover-banner-template_120329-5177.jpg?semt=ais_hybrid&w=740',
        'https://images.remotehub.com/d42c62669a7711eb91397e038280fee0/original_thumb/ec1eb042.jpg?version=1618112516',
        'https://www.biotique.com/cdn/shop/articles/chart_5.png?v=1686297920',
    ];

    foreach ($images as $index => $image) {
        Slider::create([
            'id' => Str::uuid(),
            'name' => "Slider Banner " . ($index + 1),
            'slug' => "slider-banner-" . ($index + 1),
            'description' => "Promotional slider number " . ($index + 1),
            'image' => $image,
            'status' => true,
        ]);
    }
    }
}
