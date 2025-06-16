<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Main categories with images
        $mainCategories = [
            [
                'id' => Str::uuid(),
                'name' => 'Electronics',
                'slug' => 'electronics',
                'image' => 'https://img.freepik.com/free-photo/electronic-devices-composition_23-2147786044.jpg?w=740',
                'description' => 'Devices and gadgets',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Fashion',
                'slug' => 'fashion',
                'image' => 'https://img.freepik.com/free-photo/modern-clothes-rack-with-stylish-colorful-clothes_155003-4365.jpg?w=740',
                'description' => 'Clothing and accessories',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'image' => 'https://img.freepik.com/free-photo/kitchen-ware-concept-with-utensils_23-2148795374.jpg?w=740',
                'description' => 'Furniture and appliances',
            ],
        ];

        // Insert main categories
        foreach ($mainCategories as $cat) {
            Category::create([
                'id' => $cat['id'],
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'image' => $cat['image'],
                'description' => $cat['description'],
                'parent_id' => null,
                'status' => true,
            ]);
        }

        // Child categories with parent_slug to resolve parent_id
        $childCategories = [
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile-phones',
                'image' => 'https://img.freepik.com/free-photo/smartphone-with-blue-screen-isolated-white-background-3d-rendering_1142-50806.jpg?w=740',
                'parent_slug' => 'electronics',
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'image' => 'https://img.freepik.com/free-photo/laptop-balancing-with-geometrical-shapes_23-2149309644.jpg?w=740',
                'parent_slug' => 'electronics',
            ],
            [
                'name' => 'Men',
                'slug' => 'men-fashion',
                'image' => 'https://img.freepik.com/free-photo/fashion-portrait-young-man-jeans-jacket_1303-20237.jpg?w=740',
                'parent_slug' => 'fashion',
            ],
            [
                'name' => 'Women',
                'slug' => 'women-fashion',
                'image' => 'https://img.freepik.com/free-photo/portrait-beautiful-woman-pink-blazer_23-2148514777.jpg?w=740',
                'parent_slug' => 'fashion',
            ],
        ];

        foreach ($childCategories as $child) {
            $parent = Category::where('slug', $child['parent_slug'])->first();

            if ($parent) {
                Category::create([
                    'id' => Str::uuid(),
                    'name' => $child['name'],
                    'slug' => $child['slug'],
                    'image' => $child['image'],
                    'description' => null,
                    'parent_id' => $parent->id,
                    'status' => true,
                ]);
            }
        }
    }
}
