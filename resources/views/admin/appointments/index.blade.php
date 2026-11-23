@extends('admin.layouts.app')

@section('title', 'Manage Service Appointments')
@section('header-title', 'Service Appointments')
@section('header-subtitle', 'Customer bookings for installation, balancing, alignment & repair')

@section('content')
<!-- Appointment Metric Badges -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index') }}" class="stat-box text-decoration-none {{ !request('status') ? 'border-danger' : '' }}" style="{{ !request('status') ? 'border-color: var(--admin-accent) !important; background: rgba(239,59,45,0.06);' : '' }}">
            <div class="stat-icon" style="color:#ef3b2d; background:rgba(239,59,45,0.12); border:1px solid rgba(239,59,45,0.25);">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['all']) }}</div>
                <div class="stat-label">Total Bookings</div>
                <div class="text-secondary mt-1" style="font-size:10px;">All-time scheduled</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="stat-box text-decoration-none {{ request('status') == 'pending' ? 'border-warning' : '' }}" style="{{ request('status') == 'pending' ? 'border-color: #facc15 !important; background: rgba(250,204,21,0.06);' : '' }}">
            <div class="stat-icon" style="color:#facc15; background:rgba(250,204,21,0.12); border:1px solid rgba(250,204,21,0.25);">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['pending']) }}</div>
                <div class="stat-label">Pending Review</div>
                @if($counts['pending'] > 0)
                    <div class="text-warning fw-bold d-flex align-items-center gap-1 mt-1" style="font-size:10px;">
                        <span class="d-inline-block rounded-circle bg-warning" style="width:6px; height:6px;"></span>
                        Requires Confirmation
                    </div>
                @else
                    <div class="text-success mt-1" style="font-size:10px;"><i class="fa-solid fa-check me-1"></i>All Caught Up</div>
                @endif
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="stat-box text-decoration-none {{ request('status') == 'confirmed' ? 'border-info' : '' }}" style="{{ request('status') == 'confirmed' ? 'border-color: #38bdf8 !important; background: rgba(56,189,248,0.06);' : '' }}">
            <div class="stat-icon" style="color:#38bdf8; background:rgba(56,189,248,0.12); border:1px solid rgba(56,189,248,0.25);">
                <i class="fa-regular fa-circle-check"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['confirmed']) }}</div>
                <div class="stat-label">Confirmed</div>
                <div class="text-secondary mt-1" style="font-size:10px;">Ready for service bays</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="stat-box text-decoration-none {{ request('status') == 'completed' ? 'border-success' : '' }}" style="{{ request('status') == 'completed' ? 'border-color: #4ade80 !important; background: rgba(74,222,128,0.06);' : '' }}">
            <div class="stat-icon" style="color:#4ade80; background:rgba(74,222,128,0.12); border:1px solid rgba(74,222,128,0.25);">
                <i class="fa-solid fa-flag-checkered"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['completed']) }}</div>
                <div class="stat-label">Completed</div>
                <div class="text-secondary mt-1" style="font-size:10px;">Serviced &amp; released</div>
            </div>
        </a>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-25 text-secondary" style="background:#14141a !important;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by customer, vehicle, phone or service...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="fa-solid fa-filter"></i> Apply Filter
                </button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.appointments.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm w-100" title="Export matching appointments to CSV">
                    <i class="fa-solid fa-download text-success"></i> Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Appointments Table Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-regular fa-calendar-check text-info"></i>
            <span>Booking Requests ({{ number_format($appointments->total()) }})</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 28px;"></th>
                        <th>Customer</th>
                        <th>Requested Service</th>
                        <th>Vehicle Fitment</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $apt)
                    <tr class="{{ !$apt->is_read ? 'table-active' : '' }}">
                        <td class="text-center">
                            @if(!$apt->is_read)
                                <span class="d-inline-block rounded-circle bg-danger" style="width: 7px; height: 7px;" title="Unread booking"></span>
                            @else
                                <span class="text-secondary opacity-25" style="font-size:10px;">&bull;</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white d-flex align-items-center gap-1.5" style="font-size:12px;">
                                {{ $apt->full_name }}
                            </div>
                            <div class="text-secondary small" style="font-size:11px;">
                                {{ $apt->email }} &bull; {{ $apt->phone }}
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-primary" style="font-size:11px;">
                                {{ $apt->service_name ?? 'Custom Service' }}
                            </span>
                        </td>
                        <td>
                            <div class="text-white" style="font-size:12px;">{{ $apt->vehicle_year }} {{ $apt->vehicle_make }} {{ $apt->vehicle_model }}</div>
                            @if($apt->tire_size)
                                <div class="text-secondary small mt-0.5" style="font-size:11px;">
                                    Tire: <code class="text-white px-1 py-0.5 rounded" style="background:#181822; font-size:10.5px;">{{ $apt->tire_size }}</code>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white small" style="font-size:11.5px;">
                                {{ $apt->preferred_date ? $apt->preferred_date->format('M d, Y') : 'Flexible Date' }}
                            </div>
                            <div class="text-secondary" style="font-size:10px;">{{ $apt->preferred_time ?? 'Any Time' }}</div>
                        </td>
                        <td>
                            <span class="status-pill status-{{ $apt->status }}">{{ $apt->status }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-2">
                                <a href="{{ route('admin.appointments.show', $apt) }}" class="btn btn-action btn-action-view" title="View Details">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.appointments.toggle-read', $apt) }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-action btn-action-email" title="{{ $apt->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                        <i class="fa-regular {{ $apt->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointments.destroy', $apt) }}" method="POST" onsubmit="return confirm('Delete this appointment permanently?');" class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-action-delete" title="Delete Appointment">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                <div class="rounded-circle d-grid place-items-center" style="width:44px; height:44px; background:#181822; border:1px solid rgba(255,255,255,0.08);">
                                    <i class="fa-regular fa-calendar-xmark text-secondary" style="font-size:16px;"></i>
                                </div>
                                <span class="small">No service appointments found matching your search.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer d-flex justify-content-end p-2 px-3">
        {{ $appointments->links() }}
    </div>
    @endif
</div>
@endsection
