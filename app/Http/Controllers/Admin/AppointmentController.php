<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('service_name', 'like', "%{$s}%")
                  ->orWhere('vehicle_make', 'like', "%{$s}%")
                  ->orWhere('vehicle_model', 'like', "%{$s}%");
            });
        }

        $appointments = $query->orderBy('preferred_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'counts'));
    }

    public function show(Appointment $appointment)
    {
        if (!$appointment->is_read) {
            $appointment->is_read = true;
            $appointment->save();
        }

        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);
        return back()->with('success', 'Appointment updated successfully.');
    }

    public function toggleRead(Appointment $appointment)
    {
        $appointment->is_read = !$appointment->is_read;
        $appointment->save();

        return back()->with('success', 'Appointment read state toggled.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $query = Appointment::query();
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $records = $query->orderBy('preferred_date', 'asc')->get();
        $filename = 'mukoh_appointments_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($records) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Service',
                'Vehicle Type', 'Year', 'Make', 'Model', 'Tire Size',
                'Preferred Date', 'Preferred Time', 'Message', 'Status', 'Notes', 'Created At'
            ]);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->id,
                    $row->first_name,
                    $row->last_name,
                    $row->email,
                    $row->phone,
                    $row->service_name,
                    $row->vehicle_type ?? 'N/A',
                    $row->vehicle_year ?? 'N/A',
                    $row->vehicle_make ?? 'N/A',
                    $row->vehicle_model ?? 'N/A',
                    $row->tire_size ?? 'N/A',
                    $row->preferred_date->format('Y-m-d'),
                    $row->preferred_time,
                    $row->message ?? 'N/A',
                    ucfirst($row->status),
                    $row->notes ?? '',
                    $row->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
