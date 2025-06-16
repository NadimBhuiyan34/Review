<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $shops = [
        [
            'name' => 'Amazon',
            'slug' => 'amazon',
            'logo' => 'https://cdn.iconscout.com/icon/free/png-256/amazon-1869030-1583154.png',
        ],
        [
            'name' => 'Daraz',
            'slug' => 'daraz',
            'logo' => 'https://seeklogo.com/images/D/daraz-logo-8D154DC053-seeklogo.com.png',
        ],
        [
            'name' => 'eBay',
            'slug' => 'ebay',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/EBay_logo.svg/2560px-EBay_logo.svg.png',
        ],
    ];

    foreach ($shops as $shop) {
        Shop::create([
            'id' => Str::uuid(),
            'name' => $shop['name'],
            'slug' => $shop['slug'],
            'logo' => $shop['logo'],
            'status' => true,
        ]);
    }
    }
}
