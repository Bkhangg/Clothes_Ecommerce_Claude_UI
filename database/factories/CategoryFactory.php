<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Áo thun', 'Áo sơ mi', 'Áo khoác', 'Áo len', 'Áo vest',
            'Quần jean', 'Quần tây', 'Quần short', 'Quần thể thao',
            'Váy đầm', 'Chân váy', 'Đầm suông', 'Đầm dạ hội',
            'Đồ thể thao', 'Đồ ngủ', 'Đồ bơi', 'Đồ lót',
            'Đồ công sở', 'Đồ trẻ em', 'Đồ sơ sinh', 'Đồ đôi',
            'Giày thể thao', 'Giày cao gót', 'Giày lười', 'Dép',
            'Túi xách', 'Ba lô', 'Ví da', 'Túi đeo chéo',
            'Phụ kiện thời trang', 'Đồng hồ', 'Kính mát', 'Mũ nón',
            'Thắt lưng', 'Khăn choàng', 'Tất vớ', 'Vải',
            'Đồ da', 'Trang sức', 'Bông tai', 'Nhẫn',
            'Áo phao', 'Áo mưa', 'Áo dài', 'Áo khoác jean',
            'Quần baggy', 'Quần ống rộng', 'Váy midi', 'Đầm maxi',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional(0.7)->sentence(),
            'is_active' => fake()->boolean(85),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
