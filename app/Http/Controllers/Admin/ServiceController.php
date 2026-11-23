<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order', 'asc')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'price_starting_at' => 'nullable|string|max:50',
            'price_subtext' => 'nullable|string|max:50',
            'features' => 'nullable|string',
            'action_text' => 'nullable|string|max:50',
            'action_link' => 'nullable|string|max:150',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['features'])));
        }

        Service::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'short_description' => $validated['short_description'] ?? null,
            'full_description' => $validated['full_description'] ?? null,
            'price_starting_at' => $validated['price_starting_at'] ?? 'Starting at',
            'price_subtext' => $validated['price_subtext'] ?? 'Starting at',
            'features' => $featuresArray,
            'action_text' => $validated['action_text'] ?? 'Book ↗',
            'action_link' => $validated['action_link'] ?? '/contact',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'price_starting_at' => 'nullable|string|max:50',
            'price_subtext' => 'nullable|string|max:50',
            'features' => 'nullable|string',
            'action_text' => 'nullable|string|max:50',
            'action_link' => 'nullable|string|max:150',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $featuresArray = [];
        if (!empty($validated['features'])) {
            $featuresArray = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['features'])));
        }

        $service->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'full_description' => $validated['full_description'] ?? null,
            'price_starting_at' => $validated['price_starting_at'] ?? null,
            'price_subtext' => $validated['price_subtext'] ?? 'Starting at',
            'features' => $featuresArray,
            'action_text' => $validated['action_text'] ?? 'Book ↗',
            'action_link' => $validated['action_link'] ?? '/contact',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service)
    {
        $service->is_active = !$service->is_active;
        $service->save();

        return back()->with('success', "Service status changed to " . ($service->is_active ? 'Active' : 'Disabled'));
    }
}
