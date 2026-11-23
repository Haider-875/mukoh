<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:40',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:3000',
            'vehicle_info' => 'nullable|string|max:150',
            'tire_size' => 'nullable|string|max:60',
        ]);

        $inquiry = Inquiry::create([
            'type' => 'contact',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'General Inquiry',
            'message' => $validated['message'],
            'vehicle_info' => $validated['vehicle_info'] ?? null,
            'tire_size' => $validated['tire_size'] ?? null,
            'status' => 'pending',
            'is_read' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'title' => 'SUBMITTED!',
                'message' => 'Thank you for contacting Mukoh Tires! Our team has received your message and will reply shortly.',
                'reference_no' => $inquiry->id,
            ]);
        }

        return back()->with('success', 'Your inquiry has been submitted successfully.');
    }

    public function storeQuote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:40',
            'vehicle_info' => 'nullable|string|max:150',
            'tire_size' => 'nullable|string|max:60',
            'tire_name' => 'nullable|string|max:150',
            'message' => 'nullable|string|max:2000',
        ]);

        $subject = !empty($validated['tire_name'])
            ? "Quote Request for {$validated['tire_name']}"
            : "Tire Quote Request";

        $inquiry = Inquiry::create([
            'type' => 'quote',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $subject,
            'message' => $validated['message'] ?? "Requesting pricing and availability for {$subject}",
            'vehicle_info' => $validated['vehicle_info'] ?? null,
            'tire_size' => $validated['tire_size'] ?? null,
            'status' => 'pending',
            'is_read' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'title' => 'SUBMITTED!',
                'message' => 'Your quote request has been submitted! We will check our live inventory and contact you with the best available price.',
                'reference_no' => $inquiry->id,
            ]);
        }

        return back()->with('success', 'Your quote request has been submitted successfully.');
    }
}
