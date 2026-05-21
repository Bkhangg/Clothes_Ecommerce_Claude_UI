<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $perPage = in_array($request->per_page, [5, 10, 15]) ? (int) $request->per_page : 5;

        $sortField = match ($request->sort) {
            'oldest' => 'created_at',
            'updated' => 'updated_at',
            'oldest_updated' => 'updated_at',
            'price_asc' => 'price',
            'price_desc' => 'price',
            'name_asc' => 'name',
            'name_desc' => 'name',
            default => 'created_at',
        };

        $sortDir = match ($request->sort) {
            'oldest', 'oldest_updated', 'price_asc', 'name_asc' => 'asc',
            default => 'desc',
        };

        $products = $query->orderBy($sortField, $sortDir)->paginate($perPage)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        session(['products.index_url' => $request->fullUrl()]);

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        return view('products.create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        $galleryFiles = $request->hasFile('images') ? $request->file('images') : ($validated['images'] ?? null);
        if ($galleryFiles && is_array($galleryFiles)) {
            foreach ($galleryFiles as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image' => $path,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect(session('products.index_url', route('products.index')))->with('toast', __('messages.product_created'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        if ($request->filled('delete_images')) {
            $images = ProductImage::whereIn('id', $request->delete_images)->get();
            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        $galleryFiles = $request->hasFile('images') ? $request->file('images') : ($validated['images'] ?? null);
        if ($galleryFiles && is_array($galleryFiles)) {
            $maxOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($galleryFiles as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image' => $path,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                }
            }
        }

        return redirect(session('products.index_url', route('products.index')))->with('toast', __('messages.product_updated'));
    }

    public function destroy(Product $product)
    {
        if (!session('password_verified', false)) {
            request()->validate([
                'current_password' => ['required', 'current_password'],
            ]);
            session(['password_verified' => true]);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $product->delete();

        return redirect(session('products.index_url', route('products.index')))->with('toast', __('messages.product_deleted'));
    }

    public function bulkDestroy(Request $request)
    {
        if (!session('password_verified', false)) {
            $request->validate(['current_password' => ['required', 'current_password']]);
            session(['password_verified' => true]);
        }

        $ids = $request->validate(['ids' => ['required', 'array']])['ids'];

        $products = Product::whereIn('id', $ids)->get();
        foreach ($products as $product) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image);
            }
        }

        Product::whereIn('id', $ids)->delete();

        $count = count($ids);
        return redirect(session('products.index_url', route('products.index')))->with('toast', __('messages.products_deleted', ['count' => $count]));
    }
}
