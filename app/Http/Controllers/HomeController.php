<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        // Fallback if no featured flagged
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::where('is_active', true)
                ->orderBy('sort_order')
                ->take(3)
                ->get();
        }

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $settings = WebsiteSetting::pluck('value', 'key')->all();

        return view('home', compact('featuredProducts', 'services', 'testimonials', 'settings'));
    }
}
