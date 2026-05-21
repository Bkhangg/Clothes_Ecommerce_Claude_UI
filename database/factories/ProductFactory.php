<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $adjective = fake()->randomElement([
            'Classic', 'Slim Fit', 'Relaxed', 'Vintage', 'Modern',
            'Premium', 'Essential', 'Signature', 'Urban', 'Heritage',
            'Sport', 'Casual', 'Formal', 'Elegant', 'Rustic',
        ]);

        $noun = fake()->randomElement([
            'Cotton T-Shirt', 'Chinos', 'Denim Jacket', 'Wool Blazer',
            'Crossbody Bag', 'Sneakers', 'Cashmere Sweater', 'Linen Shirt',
            'Cargo Pants', 'Puffer Vest', 'Silk Blouse', 'Tailored Trousers',
            'Canvas Backpack', 'Aviator Sunglasses', 'Leather Belt',
            'Wool Scarf', 'Sport Watch', 'Canvas Sneakers',
            'Bomber Jacket', 'Pleated Skirt', 'Maxi Dress',
            'Polo Shirt', 'Hoodie', 'Oxford Shoes',
        ]);

        $name = "{$adjective} {$noun}";
        $price = fake()->numberBetween(50000, 5000000);
        $hasSale = fake()->boolean(30);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->randomNumber(4),
            'sku' => strtoupper(fake()->unique()->bothify('???-####')),
            'description' => fake()->optional(0.8)->paragraph(),
            'price' => $price,
            'sale_price' => $hasSale ? (int) round($price * fake()->randomFloat(2, 0.5, 0.9)) : null,
            'size' => fake()->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
            'color' => fake()->randomElement(['Black', 'White', 'Navy', 'Red', 'Blue', 'Green', 'Gray', 'Beige']),
            'stock' => fake()->numberBetween(0, 200),
            'image' => null,
            'is_active' => fake()->boolean(85),
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? 1,
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()?->id,
        ];
    }
}
