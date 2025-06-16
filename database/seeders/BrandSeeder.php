<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $brands = [
            [
                'name' => 'Walton',
                'logo' => 'https://upload.wikimedia.org/wikipedia/en/5/5d/Walton_Group_Logo.png',
                'description' => 'Bangladeshi electronics and appliances brand.',
            ],
            [
                'name' => 'Samsung',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
                'description' => 'Global leader in smartphones, TVs, and electronics.',
            ],
            [
                'name' => 'Apple',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
                'description' => 'Innovative technology company behind iPhone, Mac, and more.',
            ],
            [
                'name' => 'Sony',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/5f/Sony_Logo.svg',
                'description' => 'Japanese multinational focused on electronics, gaming, and entertainment.',
            ],
            [
                'name' => 'Xiaomi',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/29/Xiaomi_logo.svg',
                'description' => 'Popular electronics brand known for smartphones and smart devices.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'id' => Str::uuid(),
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'logo' => $brand['logo'],
                'status' => true,
            ]);
        }
    }
}
