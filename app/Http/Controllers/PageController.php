<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Testimonial;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $settings = WebsiteSetting::pluck('value', 'key')->all();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $page = Page::where('slug', 'about')->first();

        return view('about', compact('settings', 'testimonials', 'page'));
    }

    public function privacy()
    {
        $settings = WebsiteSetting::pluck('value', 'key')->all();
        $page = Page::where('slug', 'privacy')->first();

        return view('privacy', compact('settings', 'page'));
    }

    public function terms()
    {
        $settings = WebsiteSetting::pluck('value', 'key')->all();
        $page = Page::where('slug', 'terms')->first();

        return view('terms', compact('settings', 'page'));
    }

    public function sitemap()
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => url('/tires'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => url('/services'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => url('/about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => url('/contact'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => url('/privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => url('/terms-of-service'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
