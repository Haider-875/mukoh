@extends('admin.layouts.app')

@section('title', 'Inquiry Details #' . $inquiry->id)
@section('header-title', 'Inquiry Details')
@section('header-subtitle', 'Review customer submission and update status')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-envelope-open me-2 text-primary"></i> Message from {{ $inquiry->name }}</span>
                <span class="badge bg-dark border border-secondary">{{ strtoupper(str_replace('_', ' ', $inquiry->type)) }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4 p-3 bg-black rounded border border-secondary">
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Sender Name</small>
                        <strong class="text-white fs-6">{{ $inquiry->name }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Email Address</small>
                        <a href="mailto:{{ $inquiry->email }}" class="text-primary text-decoration-none">{{ $inquiry->email }}</a>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Phone Number</small>
                        @if($inquiry->phone)
                            <a href="tel:{{ $inquiry->phone }}" class="text-light text-decoration-none">{{ $inquiry->phone }}</a>
                        @else
                            <span class="text-secondary">Not provided</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Received Date & Time</small>
                        <span class="text-light">{{ $inquiry->created_at->format('M d, Y h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</span>
                    </div>
                </div>

                @if($inquiry->vehicle_info || $inquiry->tire_size)
                <div class="row g-3 mb-4 p-3 bg-dark rounded border border-secondary">
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Vehicle Information</small>
                        <span class="text-white">{{ $inquiry->vehicle_info ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-secondary d-block">Requested Tire Size</small>
                        <code class="fs-6">{{ $inquiry->tire_size ?? 'N/A' }}</code>
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <h6 class="text-secondary text-uppercase small fw-bold">Subject</h6>
                    <div class="fs-5 text-white mb-3">{{ $inquiry->subject ?? 'No subject' }}</div>

                    <h6 class="text-secondary text-uppercase small fw-bold">Customer Message</h6>
                    <div class="p-3 bg-black rounded border border-secondary text-light lh-lg" style="white-space: pre-wrap;">{{ $inquiry->message ?? 'No message body provided.' }}</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary">
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back to Inquiries</a>
                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Delete Submission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-gear me-2 text-primary"></i> Status & Actions
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Submission Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Internal Admin Notes</label>
                        <textarea name="notes" rows="4" class="form-control" placeholder="Add follow-up notes, phone call summaries, or customer preferences...">{{ old('notes', $inquiry->notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-1"></i> Update Status & Notes</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-shield-check me-2 text-primary"></i> Submission Audit Info
            </div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                    <span class="text-secondary">IP Address:</span>
                    <code>{{ $inquiry->ip_address ?? '127.0.0.1' }}</code>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-secondary">
                    <span class="text-secondary">Read Status:</span>
                    <span>{{ $inquiry->is_read ? 'Read' : 'Unread' }}</span>
                </div>
                <div class="py-1">
                    <span class="text-secondary d-block mb-1">User Agent:</span>
                    <span class="text-muted text-break" style="font-size: 0.75rem;">{{ $inquiry->user_agent ?? 'Mozilla/5.0' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
