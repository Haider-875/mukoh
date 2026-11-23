<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class TireController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::where('is_active', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category_slug', $request->category);
        }

        if ($request->filled('condition') && $request->condition !== 'all') {
            $query->where('condition', $request->condition);
        }

        if ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('price', 'asc');
        }

        $tires = $query->get();
        $settings = WebsiteSetting::pluck('value', 'key')->all();

        return view('tires', compact('categories', 'tires', 'settings'));
    }
}
