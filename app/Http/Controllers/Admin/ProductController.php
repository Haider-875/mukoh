<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('brand', 'like', "%{$s}%")
                  ->orWhere('size', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_slug', $request->category);
        }

        if ($request->filled('condition') && $request->condition !== 'all') {
            $query->where('condition', $request->condition);
        }

        $products = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'brand' => 'required|string|max:100',
            'condition' => 'required|in:new,used',
            'badge' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:60',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'features' => 'nullable|string', // comma or newline separated
            'warranty' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'image_url' => 'nullable|url|max:500',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $category = Category::find($validated['category_id'] ?? null);
        $imagePath = $validated['image_url'] ?? null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = asset('uploads/products/' . $filename);
        }

        // Parse features
        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['features'])));
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'] . '-' . Str::random(5)),
            'category_id' => $category?->id,
            'category_slug' => $category?->slug ?? 'passenger',
            'brand' => $validated['brand'],
            'condition' => $validated['condition'],
            'badge' => $validated['badge'] ?? null,
            'size' => $validated['size'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'price_unit' => $validated['price_unit'] ?? '/ea',
            'description' => $validated['description'] ?? null,
            'features' => $featuresArray,
            'warranty' => $validated['warranty'] ?? null,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Tire product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'brand' => 'required|string|max:100',
            'condition' => 'required|in:new,used',
            'badge' => 'nullable|string|max:50',
            'size' => 'nullable|string|max:60',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'warranty' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
            'image_url' => 'nullable|url|max:500',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $category = Category::find($validated['category_id'] ?? null);
        $imagePath = $product->image;

        if ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = asset('uploads/products/' . $filename);
        }

        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['features'])));
        }

        $product->update([
            'name' => $validated['name'],
            'category_id' => $category?->id,
            'category_slug' => $category?->slug ?? $product->category_slug,
            'brand' => $validated['brand'],
            'condition' => $validated['condition'],
            'badge' => $validated['badge'] ?? null,
            'size' => $validated['size'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'price_unit' => $validated['price_unit'] ?? '/ea',
            'description' => $validated['description'] ?? null,
            'features' => $featuresArray,
            'warranty' => $validated['warranty'] ?? null,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Tire product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('success', "Product status changed to " . ($product->is_active ? 'Active' : 'Disabled'));
    }
}
