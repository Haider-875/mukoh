@extends('admin.layouts.app')

@section('title', 'Manage Customer Inquiries')
@section('header-title', 'Customer Inquiries & Notifications')
@section('header-subtitle', 'Real-time contact messages, quick quotes, and tire inquiries')

@section('content')
<!-- Filter & Metric Badges -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index') }}" class="stat-box text-decoration-none {{ !request('type') ? 'border-danger' : '' }}" style="{{ !request('type') ? 'border-color: var(--admin-accent) !important; background: rgba(239,59,45,0.06);' : '' }}">
            <div class="stat-icon" style="color:#ef3b2d; background:rgba(239,59,45,0.12); border:1px solid rgba(239,59,45,0.25);">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['all']) }}</div>
                <div class="stat-label">All Inquiries</div>
                @if($counts['unread'] > 0)
                    <div class="text-danger fw-bold d-flex align-items-center gap-1 mt-1" style="font-size:10px;">
                        <span class="d-inline-block rounded-circle bg-danger" style="width:6px; height:6px;"></span>
                        {{ $counts['unread'] }} Unread
                    </div>
                @else
                    <div class="text-success mt-1" style="font-size:10px;"><i class="fa-solid fa-check me-1"></i>All Read</div>
                @endif
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'quote']) }}" class="stat-box text-decoration-none {{ request('type') == 'quote' ? 'border-warning' : '' }}" style="{{ request('type') == 'quote' ? 'border-color: #facc15 !important; background: rgba(250,204,21,0.06);' : '' }}">
            <div class="stat-icon" style="color:#facc15; background:rgba(250,204,21,0.12); border:1px solid rgba(250,204,21,0.25);">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['quote']) }}</div>
                <div class="stat-label">Quick Quotes</div>
                <div class="text-secondary mt-1" style="font-size:10px;">Instant price requests</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'tire_inquiry']) }}" class="stat-box text-decoration-none {{ request('type') == 'tire_inquiry' ? 'border-info' : '' }}" style="{{ request('type') == 'tire_inquiry' ? 'border-color: #38bdf8 !important; background: rgba(56,189,248,0.06);' : '' }}">
            <div class="stat-icon" style="color:#38bdf8; background:rgba(56,189,248,0.12); border:1px solid rgba(56,189,248,0.25);">
                <i class="fa-solid fa-circle-dot"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['tire_inquiry']) }}</div>
                <div class="stat-label">Tire Inquiries</div>
                <div class="text-secondary mt-1" style="font-size:10px;">Catalog specific leads</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'contact']) }}" class="stat-box text-decoration-none {{ request('type') == 'contact' ? 'border-success' : '' }}" style="{{ request('type') == 'contact' ? 'border-color: #4ade80 !important; background: rgba(74,222,128,0.06);' : '' }}">
            <div class="stat-icon" style="color:#4ade80; background:rgba(74,222,128,0.12); border:1px solid rgba(74,222,128,0.25);">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="overflow-hidden">
                <div class="stat-val">{{ number_format($counts['contact']) }}</div>
                <div class="stat-label">Direct Contact</div>
                <div class="text-secondary mt-1" style="font-size:10px;">Customer messages</div>
            </div>
        </a>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-2 align-items-center">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-25 text-secondary" style="background:#14141a !important;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by sender, email, phone, or keywords...">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
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
                <a href="{{ route('admin.inquiries.export', request()->query()) }}" class="btn btn-outline-secondary btn-sm w-100" title="Export matching inquiries to CSV spreadsheet">
                    <i class="fa-solid fa-download text-success"></i> Export CSV
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Submissions Table Card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-inbox text-danger"></i>
            <span>Submissions List ({{ number_format($inquiries->total()) }})</span>
        </div>
        @if($counts['unread'] > 0)
            <span class="badge bg-danger bg-opacity-20 text-danger border border-danger border-opacity-30">
                {{ $counts['unread'] }} Unread
            </span>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 28px;"></th>
                        <th>Sender</th>
                        <th>Type</th>
                        <th>Subject / Vehicle</th>
                        <th>Tire Fitment</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr class="{{ !$inquiry->is_read ? 'table-active' : '' }}">
                        <td class="text-center">
                            @if(!$inquiry->is_read)
                                <span class="d-inline-block rounded-circle bg-danger" style="width: 7px; height: 7px;" title="Unread inquiry"></span>
                            @else
                                <span class="text-secondary opacity-25" style="font-size:10px;">&bull;</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white d-flex align-items-center gap-1.5" style="font-size:12px;">
                                {{ $inquiry->name }}
                            </div>
                            <div class="text-secondary small" style="font-size:11px;">
                                {{ $inquiry->email }} &bull; {{ $inquiry->phone ?? 'No phone' }}
                            </div>
                        </td>
                        <td>
                            @if($inquiry->type == 'quote')
                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Quick Quote</span>
                            @elseif($inquiry->type == 'tire_inquiry')
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">Tire Lead</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Contact</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-white" style="font-size:12px;">{{ $inquiry->subject ?? 'General Inquiry' }}</div>
                            @if($inquiry->vehicle_info)
                                <div class="text-secondary small d-flex align-items-center gap-1 mt-0.5" style="font-size:11px;">
                                    <i class="fa-solid fa-car-side" style="font-size:10px;"></i>
                                    <span>{{ $inquiry->vehicle_info }}</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($inquiry->tire_size)
                                <code class="small text-white px-1.5 py-0.5 rounded" style="background:#181822; font-size:11px;">{{ $inquiry->tire_size }}</code>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-pill status-{{ $inquiry->status }}">{{ $inquiry->status }}</span>
                        </td>
                        <td>
                            <div class="text-white small" style="font-size:11.5px;">{{ $inquiry->created_at->format('M d, Y') }}</div>
                            <div class="text-secondary" style="font-size:10px;">{{ $inquiry->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-outline-secondary" style="height:28px; padding:0 8px;" title="View Details">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.inquiries.toggle-read', $inquiry) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary" style="height:28px; padding:0 8px;" title="{{ $inquiry->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                        <i class="fa-regular {{ $inquiry->is_read ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry permanently?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" style="height:28px; padding:0 8px;" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-secondary">
                            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                <div class="rounded-circle d-grid place-items-center" style="width:44px; height:44px; background:#181822; border:1px solid rgba(255,255,255,0.08);">
                                    <i class="fa-solid fa-inbox text-secondary" style="font-size:16px;"></i>
                                </div>
                                <span class="small">No customer inquiries found matching your filters.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($inquiries->hasPages())
    <div class="card-footer d-flex justify-content-end p-2 px-3">
        {{ $inquiries->links() }}
    </div>
    @endif
</div>
@endsection
