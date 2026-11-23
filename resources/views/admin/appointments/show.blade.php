@extends('admin.layouts.app')

@section('title', 'Appointment Booking #' . $appointment->id)
@section('header-title', 'Appointment Details')
@section('header-subtitle', 'Review customer booking and update appointment status')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-check me-2 text-primary"></i> Booking: {{ $appointment->full_name }}</span>
                <span class="badge bg-primary">{{ $appointment->service_name ?? 'General Service' }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4 p-3 bg-black rounded border border-secondary">
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Customer Name</small>
                        <strong class="text-white fs-6">{{ $appointment->full_name }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Email Address</small>
                        <a href="mailto:{{ $appointment->email }}" class="text-primary text-decoration-none">{{ $appointment->email }}</a>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Phone Number</small>
                        <a href="tel:{{ $appointment->phone }}" class="text-light text-decoration-none">{{ $appointment->phone }}</a>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Preferred Appointment Time</small>
                        <strong class="text-white">{{ $appointment->preferred_date ? $appointment->preferred_date->format('l, F j, Y') : 'Flexible Date' }}</strong>
                        <span class="text-secondary">({{ $appointment->preferred_time ?? 'Flexible Time' }})</span>
                    </div>
                </div>

                <div class="row g-3 mb-4 p-3 bg-dark rounded border border-secondary">
                    <div class="col-md-4">
                        <small class="text-secondary d-block">Vehicle Type</small>
                        <span class="text-white">{{ $appointment->vehicle_type ?? 'Passenger / Sedan' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-secondary d-block">Vehicle Year / Make / Model</small>
                        <span class="text-white">{{ $appointment->vehicle_year }} {{ $appointment->vehicle_make }} {{ $appointment->vehicle_model }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-secondary d-block">Current Tire Size</small>
                        <code>{{ $appointment->tire_size ?? 'Not specified' }}</code>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-secondary text-uppercase small fw-bold">Customer Notes & Special Requests</h6>
                    <div class="p-3 bg-black rounded border border-secondary text-light lh-lg" style="white-space: pre-wrap;">{{ $appointment->message ?? 'No specific notes provided.' }}</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary">
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back to Appointments</a>
                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Delete Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-gear me-2 text-primary"></i> Booking Status & Staff Notes
            </div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Appointment Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Staff / Bay Notes</label>
                        <textarea name="notes" rows="4" class="form-control" placeholder="Assigned bay, technician name, or parts ordered...">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-1"></i> Update Booking</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle me-2 text-primary"></i> Booking Audit Info
            </div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                    <span class="text-secondary">Submitted At:</span>
                    <span>{{ $appointment->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                    <span class="text-secondary">IP Address:</span>
                    <code>{{ $appointment->ip_address ?? '127.0.0.1' }}</code>
                </div>
                <div class="py-1">
                    <span class="text-secondary d-block mb-1">User Agent:</span>
                    <span class="text-muted text-break" style="font-size: 0.75rem;">{{ $appointment->user_agent ?? 'Mozilla/5.0' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
