@extends('admin.layouts.app')

@section('title', 'Manage Service Appointments')
@section('header-title', 'Service Appointments')
@section('header-subtitle', 'Customer bookings for installation, balancing, alignment & repair')

@section('content')
<!-- Appointment Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index') }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ !request('status') ? 'border-primary' : '' }}">
            <div class="fs-2 text-primary"><i class="bi bi-calendar3"></i></div>
            <div>
                <div class="text-secondary small">Total Bookings</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['all'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('status') == 'pending' ? 'border-warning' : '' }}">
            <div class="fs-2 text-warning"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="text-secondary small">Pending Review</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['pending'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('status') == 'confirmed' ? 'border-info' : '' }}">
            <div class="fs-2 text-info"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="text-secondary small">Confirmed</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['confirmed'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('status') == 'completed' ? 'border-success' : '' }}">
            <div class="fs-2 text-success"><i class="bi bi-check-circle"></i></div>
            <div>
                <div class="text-secondary small">Completed</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['completed'] }}</div>
            </div>
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="row g-3 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by customer, vehicle, phone or service...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.appointments.export', request()->query()) }}" class="btn btn-outline-success w-100"><i class="bi bi-download me-1"></i> Export CSV</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-calendar-event me-2 text-primary"></i> Booking Requests ({{ $appointments->total() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Vehicle</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                    <tr class="{{ !$apt->is_read ? 'table-active' : '' }}">
                        <td>
                            @if(!$apt->is_read)
                                <span class="d-inline-block rounded-circle bg-danger" style="width: 8px; height: 8px;" title="Unread"></span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold {{ !$apt->is_read ? 'text-white' : 'text-light' }}">{{ $apt->full_name }}</div>
                            <small class="text-secondary">{{ $apt->email }} &bull; {{ $apt->phone }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-primary">{{ $apt->service_name ?? 'Custom Service' }}</span>
                        </td>
                        <td>
                            <div class="text-white">{{ $apt->vehicle_year }} {{ $apt->vehicle_make }} {{ $apt->vehicle_model }}</div>
                            @if($apt->tire_size)
                                <small class="text-secondary">Tire: <code>{{ $apt->tire_size }}</code></small>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $apt->preferred_date ? $apt->preferred_date->format('M d, Y') : 'Flexible' }}</div>
                            <small class="text-secondary">{{ $apt->preferred_time ?? 'Any Time' }}</small>
                        </td>
                        <td>
                            @if($apt->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($apt->status == 'confirmed')
                                <span class="badge bg-info text-dark">Confirmed</span>
                            @elseif($apt->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.appointments.show', $apt) }}" class="btn btn-primary" title="View Details"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.appointments.toggle-read', $apt) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary" title="{{ $apt->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                        <i class="bi {{ $apt->is_read ? 'bi-envelope' : 'bi-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointments.destroy', $apt) }}" method="POST" onsubmit="return confirm('Delete this appointment permanently?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            No appointments found matching your search.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $appointments->links() }}
    </div>
    @endif
</div>
@endsection
