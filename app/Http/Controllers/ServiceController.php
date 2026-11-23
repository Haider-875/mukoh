<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $settings = WebsiteSetting::pluck('value', 'key')->all();

        return view('services', compact('services', 'settings'));
    }
}
