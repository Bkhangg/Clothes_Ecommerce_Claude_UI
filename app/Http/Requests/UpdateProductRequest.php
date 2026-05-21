<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => str_replace('.', '', $this->price),
            'sale_price' => $this->sale_price ? str_replace('.', '', $this->sale_price) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($this->route('product'))],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'sale_price' => ['nullable', 'integer', 'min:0', 'lt:price'],
            'size' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:product_images,id'],
            'is_active' => ['boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
        ];
    }
}
