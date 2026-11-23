<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        $settings = WebsiteSetting::pluck('value', 'key')->all();

        return view('contact', compact('services', 'settings'));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'first' => 'required|string|max:100',
            'last' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:40',
            'service' => 'required|string|max:150',
            'type' => 'nullable|string|max:80',
            'year' => 'nullable|string|max:20',
            'make' => 'nullable|string|max:80',
            'model' => 'nullable|string|max:80',
            'size' => 'nullable|string|max:60',
            'date' => 'required|date',
            'time' => 'required|string|max:50',
            'message' => 'nullable|string|max:2000',
        ]);

        $serviceModel = Service::where('title', $validated['service'])->first();

        $appointment = Appointment::create([
            'first_name' => $validated['first'],
            'last_name' => $validated['last'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'service_id' => $serviceModel?->id,
            'service_name' => $validated['service'],
            'vehicle_type' => $validated['type'] ?? null,
            'vehicle_year' => $validated['year'] ?? null,
            'vehicle_make' => $validated['make'] ?? null,
            'vehicle_model' => $validated['model'] ?? null,
            'tire_size' => $validated['size'] ?? null,
            'preferred_date' => $validated['date'],
            'preferred_time' => $validated['time'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
            'is_read' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'title' => 'SUBMITTED!',
                'message' => 'Your appointment request has been successfully submitted. Our team will contact you shortly to confirm your time slot!',
                'reference_no' => $appointment->id,
            ]);
        }

        return back()->with('success', 'Your appointment request has been submitted successfully.');
    }
}
