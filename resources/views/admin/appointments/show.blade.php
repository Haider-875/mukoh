@extends('admin.layouts.app')

@section('title', 'Appointment Booking #' . $appointment->id)
@section('header-title', 'Appointment Details')
@section('header-subtitle', 'Review customer booking and update appointment status')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-calendar-check text-info"></i>
                    <span>Booking: {{ $appointment->full_name }}</span>
                </div>
                <span class="badge bg-primary bg-opacity-20 text-primary border border-primary border-opacity-30" style="font-size:10.5px;">
                    {{ $appointment->service_name ?? 'General Service' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4 p-3 rounded" style="background:#0c0c10; border:1px solid rgba(255,255,255,0.06);">
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-user" style="font-size:10px;"></i> Customer Name
                        </small>
                        <strong class="text-white d-block mt-0.5" style="font-size:13px;">{{ $appointment->full_name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-envelope" style="font-size:10px;"></i> Email Address
                        </small>
                        <a href="mailto:{{ $appointment->email }}" class="text-primary text-decoration-none d-block mt-0.5" style="font-size:13px;">{{ $appointment->email }}</a>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-phone" style="font-size:10px;"></i> Phone Number
                        </small>
                        <a href="tel:{{ $appointment->phone }}" class="text-white text-decoration-none d-block mt-0.5" style="font-size:13px;">{{ $appointment->phone }}</a>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-clock" style="font-size:10px;"></i> Preferred Slot
                        </small>
                        <strong class="text-white d-block mt-0.5" style="font-size:12.5px;">
                            {{ $appointment->preferred_date ? $appointment->preferred_date->format('l, F j, Y') : 'Flexible Date' }}
                        </strong>
                        <span class="text-secondary small" style="font-size:10.5px;">({{ $appointment->preferred_time ?? 'Flexible Time' }})</span>
                    </div>
                </div>

                <div class="row g-3 mb-4 p-3 rounded" style="background:#111116; border:1px solid rgba(255,255,255,0.06);">
                    <div class="col-sm-4">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-car" style="font-size:10px;"></i> Vehicle Type
                        </small>
                        <span class="text-white fw-semibold d-block mt-0.5" style="font-size:12px;">{{ $appointment->vehicle_type ?? 'Passenger' }}</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-car-side" style="font-size:10px;"></i> Year / Make / Model
                        </small>
                        <span class="text-white fw-semibold d-block mt-0.5" style="font-size:12px;">{{ $appointment->vehicle_year }} {{ $appointment->vehicle_make }} {{ $appointment->vehicle_model }}</span>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-circle-dot" style="font-size:10px;"></i> Current Tire Size
                        </small>
                        <code class="px-2 py-0.5 rounded d-inline-block mt-0.5" style="background:#181822; font-size:11.5px; color:#ffffff;">{{ $appointment->tire_size ?? 'Not specified' }}</code>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-secondary small fw-bold text-uppercase mb-2" style="font-size:10.5px; letter-spacing:0.06em;">Customer Special Requests / Notes</h6>
                    <div class="p-3 rounded text-white lh-base" style="background:#0c0c10; border:1px solid rgba(255,255,255,0.06); font-size:12.5px; white-space: pre-wrap;">{{ $appointment->message ?? 'No specific notes provided.' }}</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Back to Appointments
                    </a>
                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa-regular fa-trash-can"></i> Delete Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa-solid fa-sliders text-danger"></i>
                <span>Booking Status &amp; Bay Notes</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Appointment Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Staff / Bay Notes</label>
                        <textarea name="notes" rows="4" class="form-control" style="font-size:12px;" placeholder="Assigned bay, technician name, or parts ordered...">{{ old('notes', $appointment->notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fa-solid fa-check"></i> Update Booking Status
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved text-secondary"></i>
                <span>Booking Audit Info</span>
            </div>
            <div class="card-body small p-3" style="font-size:11.5px;">
                <div class="d-flex justify-content-between py-1.5 border-bottom border-secondary border-opacity-15">
                    <span class="text-secondary">Submitted At:</span>
                    <span>{{ $appointment->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="d-flex justify-content-between py-1.5 border-bottom border-secondary border-opacity-15">
                    <span class="text-secondary">IP Address:</span>
                    <code>{{ $appointment->ip_address ?? '127.0.0.1' }}</code>
                </div>
                <div class="py-1.5">
                    <span class="text-secondary d-block mb-1">User Agent:</span>
                    <span class="text-muted text-break font-monospace" style="font-size: 10px;">{{ $appointment->user_agent ?? 'Mozilla/5.0' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
