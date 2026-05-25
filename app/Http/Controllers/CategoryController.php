<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                Gate::authorize('manage-categories');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $perPage = in_array($request->per_page, [5, 10, 15]) ? (int) $request->per_page : 5;

        $sortField = match ($request->sort) {
            'oldest' => 'created_at',
            'updated' => 'updated_at',
            'oldest_updated' => 'updated_at',
            default => 'created_at',
        };

        $sortDir = match ($request->sort) {
            'oldest', 'oldest_updated' => 'asc',
            default => 'desc',
        };

        $categories = $query->orderBy($sortField, $sortDir)->paginate($perPage)->withQueryString();

        session(['categories.index_url' => $request->fullUrl()]);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect(session('categories.index_url', route('categories.index')))->with('toast', __('messages.category_created'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect(session('categories.index_url', route('categories.index')))->with('toast', __('messages.category_updated'));
    }

    public function destroy(Category $category)
    {
        request()->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        $category->delete();

        return redirect(session('categories.index_url', route('categories.index')))->with('toast', __('messages.category_deleted'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => ['required', 'array']])['ids'];

        Category::whereIn('id', $ids)->delete();

        $count = count($ids);
        return redirect(session('categories.index_url', route('categories.index')))->with('toast', __('messages.categories_deleted', ['count' => $count]));
    }
}
