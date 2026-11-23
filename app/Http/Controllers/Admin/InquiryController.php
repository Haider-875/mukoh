<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquiry::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $inquiries = $query->orderBy('is_read', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => Inquiry::count(),
            'contact' => Inquiry::where('type', 'contact')->count(),
            'quote' => Inquiry::where('type', 'quote')->count(),
            'tire_inquiry' => Inquiry::where('type', 'tire_inquiry')->count(),
            'unread' => Inquiry::where('is_read', false)->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    public function show(Inquiry $inquiry)
    {
        if (!$inquiry->is_read) {
            $inquiry->is_read = true;
            $inquiry->save();
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $inquiry->update($validated);
        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function toggleRead(Inquiry $inquiry)
    {
        $inquiry->is_read = !$inquiry->is_read;
        $inquiry->save();

        return back()->with('success', 'Inquiry read state updated.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $query = Inquiry::query();
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $records = $query->orderBy('created_at', 'desc')->get();
        $filename = 'mukoh_inquiries_' . date('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($records) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Type', 'Name', 'Email', 'Phone', 'Subject', 'Vehicle', 'Tire Size', 'Message', 'Status', 'Read', 'Date']);

            foreach ($records as $row) {
                fputcsv($handle, [
                    $row->id,
                    ucfirst(str_replace('_', ' ', $row->type)),
                    $row->name,
                    $row->email,
                    $row->phone ?? 'N/A',
                    $row->subject ?? 'N/A',
                    $row->vehicle_info ?? 'N/A',
                    $row->tire_size ?? 'N/A',
                    $row->message,
                    ucfirst($row->status),
                    $row->is_read ? 'Yes' : 'No',
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
