<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
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

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'phone' => '0130579588', // Replace with desired number
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
