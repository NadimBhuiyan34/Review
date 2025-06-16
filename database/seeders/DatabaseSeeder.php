<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->call([
            SliderSeeder::class,
                ]);

        $this->call([
            ShopSeeder::class,
        ]);


         $this->call([
            CategorySeeder::class,
        ]);
         $this->call([
            BrandSeeder::class,
        ]);
         $this->call([
            ProductSeeder::class,
        ]);
        $this->call(ProductImageSeeder::class);

    }
}
