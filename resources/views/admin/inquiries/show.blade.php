@extends('admin.layouts.app')

@section('title', 'Inquiry Details #' . $inquiry->id)
@section('header-title', 'Inquiry Details')
@section('header-subtitle', 'Review customer submission and update response status')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-envelope-open text-danger"></i>
                    <span>Message from {{ $inquiry->name }}</span>
                </div>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-30" style="font-size:10px;">
                    {{ strtoupper(str_replace('_', ' ', $inquiry->type)) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4 p-3 rounded" style="background:#0c0c10; border:1px solid rgba(255,255,255,0.06);">
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-user" style="font-size:10px;"></i> Sender Name
                        </small>
                        <strong class="text-white d-block mt-0.5" style="font-size:13px;">{{ $inquiry->name }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-envelope" style="font-size:10px;"></i> Email Address
                        </small>
                        <a href="mailto:{{ $inquiry->email }}" class="text-primary text-decoration-none d-block mt-0.5" style="font-size:13px;">{{ $inquiry->email }}</a>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-phone" style="font-size:10px;"></i> Phone Number
                        </small>
                        @if($inquiry->phone)
                            <a href="tel:{{ $inquiry->phone }}" class="text-white text-decoration-none d-block mt-0.5" style="font-size:13px;">{{ $inquiry->phone }}</a>
                        @else
                            <span class="text-secondary d-block mt-0.5" style="font-size:13px;">Not provided</span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-regular fa-clock" style="font-size:10px;"></i> Received Date
                        </small>
                        <span class="text-white d-block mt-0.5" style="font-size:12.5px;">{{ $inquiry->created_at->format('M d, Y h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</span>
                    </div>
                </div>

                @if($inquiry->vehicle_info || $inquiry->tire_size)
                <div class="row g-3 mb-4 p-3 rounded" style="background:#111116; border:1px solid rgba(255,255,255,0.06);">
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-car-side" style="font-size:10px;"></i> Vehicle Information
                        </small>
                        <span class="text-white fw-semibold d-block mt-0.5" style="font-size:12.5px;">{{ $inquiry->vehicle_info ?? 'N/A' }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-secondary d-flex align-items-center gap-1.5" style="font-size:11px;">
                            <i class="fa-solid fa-circle-dot" style="font-size:10px;"></i> Requested Tire Size
                        </small>
                        <code class="px-2 py-0.5 rounded d-inline-block mt-0.5" style="background:#181822; font-size:12px; color:#ffffff;">{{ $inquiry->tire_size ?? 'N/A' }}</code>
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <h6 class="text-secondary small fw-bold text-uppercase mb-1" style="font-size:10.5px; letter-spacing:0.06em;">Subject</h6>
                    <div class="text-white fw-bold mb-3" style="font-size:14px;">{{ $inquiry->subject ?? 'General Inquiry' }}</div>

                    <h6 class="text-secondary small fw-bold text-uppercase mb-2" style="font-size:10.5px; letter-spacing:0.06em;">Customer Message Body</h6>
                    <div class="p-3 rounded text-white lh-base" style="background:#0c0c10; border:1px solid rgba(255,255,255,0.06); font-size:12.5px; white-space: pre-wrap;">{{ $inquiry->message ?? 'No message body provided.' }}</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-arrow-left"></i> Back to Inquiries
                    </a>
                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" onsubmit="return confirm('Delete this inquiry permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fa-regular fa-trash-can"></i> Delete Submission
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
                <span>Status &amp; Staff Notes</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.inquiries.status', $inquiry) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">Submission Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Internal Follow-Up Notes</label>
                        <textarea name="notes" rows="4" class="form-control" style="font-size:12px;" placeholder="Add follow-up notes, phone call summaries, or customer preferences...">{{ old('notes', $inquiry->notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fa-solid fa-check"></i> Update Status &amp; Notes
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved text-secondary"></i>
                <span>Audit &amp; Meta Info</span>
            </div>
            <div class="card-body small p-3" style="font-size:11.5px;">
                <div class="d-flex justify-content-between py-1.5 border-bottom border-secondary border-opacity-15">
                    <span class="text-secondary">IP Address:</span>
                    <code>{{ $inquiry->ip_address ?? '127.0.0.1' }}</code>
                </div>
                <div class="d-flex justify-content-between py-1.5 border-bottom border-secondary border-opacity-15">
                    <span class="text-secondary">Read Status:</span>
                    <span>{{ $inquiry->is_read ? 'Read' : 'Unread' }}</span>
                </div>
                <div class="py-1.5">
                    <span class="text-secondary d-block mb-1">User Agent:</span>
                    <span class="text-muted text-break font-monospace" style="font-size: 10px;">{{ $inquiry->user_agent ?? 'Mozilla/5.0' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
