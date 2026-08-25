<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Collection;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $collection = Collection::where('slug', 'first')->first();
        $head = Category::where('slug', 'head')->first();
        $torso = Category::where('slug', 'torso')->first();

        $products = [
            [
                'slug' => 'cap-origin',
                'name' => 'Cap Origin',
                'description' => 'Minimalist cap from the First Collection.',
                'category_id' => $head->id,
                'collection_id' => $collection->id,
                'gender' => 'unisex',
                'price' => 8900,
                'is_new' => true,
                'variants' => [
                    ['size' => 'S', 'stock' => 5],
                    ['size' => 'M', 'stock' => 10],
                    ['size' => 'L', 'stock' => 8],
                    ['size' => 'XL', 'stock' => 4],
                    ['size' => 'XXL', 'stock' => 2],
                ],
            ],
            [
                'slug' => 'tee-blank',
                'name' => 'Tee Blank',
                'description' => 'Oversized tee, heavy cotton.',
                'category_id' => $torso->id,
                'collection_id' => $collection->id,
                'gender' => 'unisex',
                'price' => 6500,
                'is_new' => true,
                'variants' => [
                    ['size' => 'S', 'stock' => 6],
                    ['size' => 'M', 'stock' => 12],
                    ['size' => 'L', 'stock' => 9],
                    ['size' => 'XL', 'stock' => 5],
                    ['size' => 'XXL', 'stock' => 3],
                ],
            ],
        ];

        foreach ($products as $data) {
            $variants = $data['variants'];
            unset($data['variants']);

            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            foreach ($variants as $v) {
                ProductVariant::updateOrCreate(
                    ['product_id' => $product->id, 'size' => $v['size']],
                    ['stock' => $v['stock'], 'color' => 'black']
                );
            }
        }
    }
}
