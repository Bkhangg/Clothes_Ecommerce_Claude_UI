<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'sku', 'description', 'price', 'sale_price',
        'size', 'color', 'stock', 'image', 'is_active',
        'category_id', 'brand_id',
    ];

    protected $with = ['images'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'stock' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
}
