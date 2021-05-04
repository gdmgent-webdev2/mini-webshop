<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(10)->create();
        Tag::factory()->count(50)->create();
        Product::factory()->count(120)->create();

        foreach(Product::get() as $product) {
            $randomIds = Tag::inRandomOrder()->limit(3)->pluck('id')->toArray();
            $product->tags()->sync($randomIds);
        }
    }
}
