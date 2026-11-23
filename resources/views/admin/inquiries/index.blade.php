@extends('admin.layouts.app')

@section('title', 'Manage Customer Inquiries')
@section('header-title', 'Customer Inquiries')
@section('header-subtitle', 'Contact requests, quote inquiries, and tire inquiries')

@section('content')
<!-- Filter & Stat Badges -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index') }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ !request('type') ? 'border-primary' : '' }}">
            <div class="fs-2 text-primary"><i class="bi bi-chat-left-dots"></i></div>
            <div>
                <div class="text-secondary small">All Inquiries</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['all'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'quote']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('type') == 'quote' ? 'border-warning' : '' }}">
            <div class="fs-2 text-warning"><i class="bi bi-calculator"></i></div>
            <div>
                <div class="text-secondary small">Quick Quotes</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['quote'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'tire_inquiry']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('type') == 'tire_inquiry' ? 'border-info' : '' }}">
            <div class="fs-2 text-info"><i class="bi bi-disc"></i></div>
            <div>
                <div class="text-secondary small">Tire Inquiries</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['tire_inquiry'] }}</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.inquiries.index', ['type' => 'contact']) }}" class="card text-decoration-none p-3 d-flex flex-row align-items-center gap-3 border {{ request('type') == 'contact' ? 'border-success' : '' }}">
            <div class="fs-2 text-success"><i class="bi bi-envelope"></i></div>
            <div>
                <div class="text-secondary small">Contact Messages</div>
                <div class="fs-4 fw-bold text-white">{{ $counts['contact'] }}</div>
            </div>
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-3 align-items-center">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, email, phone, or message...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i> Filter</button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.inquiries.export', request()->query()) }}" class="btn btn-outline-success w-100"><i class="bi bi-download me-1"></i> Export CSV</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-inbox me-2 text-primary"></i> Submissions List ({{ $inquiries->total() }})</span>
        @if($counts['unread'] > 0)
            <span class="badge bg-danger">{{ $counts['unread'] }} Unread</span>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Sender</th>
                        <th>Type</th>
                        <th>Subject / Vehicle</th>
                        <th>Tire Size</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr class="{{ !$inquiry->is_read ? 'table-active' : '' }}">
                        <td>
                            @if(!$inquiry->is_read)
                                <span class="d-inline-block rounded-circle bg-danger" style="width: 8px; height: 8px;" title="Unread"></span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold {{ !$inquiry->is_read ? 'text-white' : 'text-light' }}">{{ $inquiry->name }}</div>
                            <small class="text-secondary">{{ $inquiry->email }} &bull; {{ $inquiry->phone ?? 'No phone' }}</small>
                        </td>
                        <td>
                            @if($inquiry->type == 'quote')
                                <span class="badge bg-warning text-dark">Quick Quote</span>
                            @elseif($inquiry->type == 'tire_inquiry')
                                <span class="badge bg-info text-dark">Tire Inquiry</span>
                            @else
                                <span class="badge bg-secondary">Contact</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-white">{{ $inquiry->subject ?? 'General Inquiry' }}</div>
                            @if($inquiry->vehicle_info)
                                <small class="text-secondary"><i class="bi bi-car-front me-1"></i>{{ $inquiry->vehicle_info }}</small>
                            @endif
                        </td>
                        <td>
                            @if($inquiry->tire_size)
                                <code>{{ $inquiry->tire_size }}</code>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            @if($inquiry->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($inquiry->status == 'contacted')
                                <span class="badge bg-info text-dark">Contacted</span>
                            @elseif($inquiry->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <span class="small text-secondary">{{ $inquiry->created_at->format('M d, Y') }}</span>
                            <small class="d-block text-muted">{{ $inquiry->created_at->diffForHumans() }}</small>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-primary" title="View Details"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.inquiries.toggle-read', $inquiry) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary" title="{{ $inquiry->is_read ? 'Mark Unread' : 'Mark Read' }}">
                                        <i class="bi {{ $inquiry->is_read ? 'bi-envelope' : 'bi-envelope-open' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry permanently?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-secondary">
                            <i class="bi bi-chat-left-dots fs-1 d-block mb-2"></i>
                            No inquiries found matching your filters.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($inquiries->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $inquiries->links() }}
    </div>
    @endif
</div>
@endsection
