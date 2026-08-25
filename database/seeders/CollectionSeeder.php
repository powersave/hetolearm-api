<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        Collection::updateOrCreate(
            ['slug' => 'first'],
            [
                'name' => 'First Collection',
                'description' => 'The debut collection by hetolearm.',
                'released_at' => '2026-08-05',
                'is_active' => true,
            ]
        );
    }
}
