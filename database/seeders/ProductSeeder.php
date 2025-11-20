<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Image;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy category id sẵn có
        $categories = Category::pluck('id')->toArray();

        // Nếu chưa có category thì không tạo product
        if (count($categories) === 0) {
            return;
        }

        for ($i = 1; $i <= 1000; $i++) {

            $price = $faker->numberBetween(100000, 10000000);
            $sale  = $faker->numberBetween(0, 50);

            // Tạo Product
            $product = Product::create([
                'name'        => $faker->sentence(3),
                'description' => $faker->paragraph(),
                'price'       => $price,
                'sale'        => $sale,
            ]);

            // Gắn category random (1–3 category mỗi product)
            $randomCategories = $faker->randomElements($categories, rand(1, 3));
            $product->categories()->sync($randomCategories);

            // ProductDetail
            ProductDetail::create([
                'product_id' => $product->id,
                'size' => $faker->randomElement(['S', 'M', 'L']),
                'quantity'   => $faker->numberBetween(1, 100),
            ]);

            // Ảnh (morphOne)
            Image::create([
                'imageable_id'   => $product->id,
                'imageable_type' => Product::class,
                'url'            => 'default.jpg', // hoặc fake tên file
            ]);
        }
    }
}
