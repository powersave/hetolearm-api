<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'head',  'name' => 'Head',  'body_part' => 'head',  'sort_order' => 1],
            ['slug' => 'torso', 'name' => 'Torso', 'body_part' => 'torso', 'sort_order' => 2],
            ['slug' => 'legs',  'name' => 'Legs',  'body_part' => 'legs',  'sort_order' => 3],
            ['slug' => 'arm',   'name' => 'Arm',   'body_part' => 'arm',   'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
