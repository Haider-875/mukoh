<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        Testimonial::create([
            'author_name' => strtoupper($validated['author_name']),
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $testimonial->update([
            'author_name' => strtoupper($validated['author_name']),
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial removed successfully.');
    }

    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->save();

        return back()->with('success', 'Testimonial status changed.');
    }
}
