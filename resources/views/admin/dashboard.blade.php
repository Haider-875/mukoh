@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page_title', 'Operational Overview')
@section('header-subtitle', 'Real-time inquiries, bookings, catalog statistics, and activity')

@section('content')

  <!-- 1. KPI Statistics Metric Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#ef3b2d; background:rgba(239,59,45,0.12); border:1px solid rgba(239,59,45,0.25);">
          <i class="fa-solid fa-inbox"></i>
        </div>
        <div class="overflow-hidden">
          <div class="stat-val">{{ number_format($totalInquiries) }}</div>
          <div class="stat-label">Total Inquiries</div>
          @if($unreadInquiries > 0)
            <div class="text-danger fw-bold d-flex align-items-center gap-1 mt-1" style="font-size:10.5px;">
              <span class="d-inline-block rounded-circle bg-danger" style="width:6px; height:6px;"></span>
              {{ $unreadInquiries }} unread
            </div>
          @else
            <div class="text-success fw-semibold mt-1" style="font-size:10.5px;">
              <i class="fa-solid fa-check me-1"></i>All caught up
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#38bdf8; background:rgba(56,189,248,0.12); border:1px solid rgba(56,189,248,0.25);">
          <i class="fa-regular fa-calendar-check"></i>
        </div>
        <div class="overflow-hidden">
          <div class="stat-val">{{ number_format($totalAppointments) }}</div>
          <div class="stat-label">Appointments</div>
          @if($pendingAppointments > 0)
            <div class="text-warning fw-bold d-flex align-items-center gap-1 mt-1" style="font-size:10.5px;">
              <span class="d-inline-block rounded-circle bg-warning" style="width:6px; height:6px;"></span>
              {{ $pendingAppointments }} pending
            </div>
          @else
            <div class="text-secondary mt-1" style="font-size:10.5px;">Schedule current</div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#4ade80; background:rgba(74,222,128,0.12); border:1px solid rgba(74,222,128,0.25);">
          <i class="fa-solid fa-calculator"></i>
        </div>
        <div class="overflow-hidden">
          <div class="stat-val">{{ number_format($totalQuotes) }}</div>
          <div class="stat-label">Quote Requests</div>
          <div class="text-secondary mt-1" style="font-size:10.5px;">Direct customer estimates</div>
        </div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#facc15; background:rgba(250,204,21,0.12); border:1px solid rgba(250,204,21,0.25);">
          <i class="fa-solid fa-circle-dot"></i>
        </div>
        <div class="overflow-hidden">
          <div class="stat-val">{{ number_format($totalProducts) }}</div>
          <div class="stat-label">Tire Inventory</div>
          <div class="text-info mt-1" style="font-size:10.5px;">{{ $totalServices }} active shop services</div>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Streamlined Quick Actions Toolbar -->
  <div class="card mb-4">
    <div class="card-body p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-bolt text-danger" style="font-size:13px;"></i>
        <span class="fw-bold text-white" style="font-size:12.5px;">Quick Actions:</span>
        <span class="text-secondary d-none d-lg-inline" style="font-size:11.5px;">Fast navigation to key administrative tasks</span>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
          <i class="fa-solid fa-plus"></i> Add New Tire
        </a>
        <a href="{{ route('admin.services.create') }}" class="btn btn-outline-secondary btn-sm">
          <i class="fa-solid fa-wrench"></i> Add Service
        </a>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="fa-solid fa-inbox"></i> View Inquiries
        </a>
        <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="fa-solid fa-sliders"></i> Edit Content
        </a>
      </div>
    </div>
  </div>

  <!-- 3. Monthly Activity Volume Visualization -->
  <div class="card mb-4">
    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
      <div class="d-flex align-items-center gap-2">
        <i class="fa-solid fa-chart-simple text-danger" style="font-size:13px;"></i>
        <span class="fw-bold text-white" style="font-size:13px;">Submission Activity Trend</span>
        <span class="text-secondary ms-1 small d-none d-md-inline">(Past 6 Months)</span>
      </div>
      <div class="d-flex align-items-center gap-3 font-monospace" style="font-size:11px;">
        <span class="d-flex align-items-center gap-1.5 text-white">
          <span class="d-inline-block rounded" style="background:#ef3b2d; width:10px; height:10px;"></span> Inquiries
        </span>
        <span class="d-flex align-items-center gap-1.5 text-white">
          <span class="d-inline-block rounded" style="background:#38bdf8; width:10px; height:10px;"></span> Appointments
        </span>
      </div>
    </div>
    <div class="card-body p-3 pt-4">
      @php
        $maxVal = max(max($monthlyInquiries), max($monthlyAppointments), 1);
      @endphp
      <div class="row g-2 align-items-end text-center" style="height: 140px;">
        @foreach($months as $idx => $mLabel)
          @php
            $inqH = ($monthlyInquiries[$idx] / $maxVal) * 100;
            $appH = ($monthlyAppointments[$idx] / $maxVal) * 100;
          @endphp
          <div class="col d-flex flex-column align-items-center justify-content-end h-100">
            <div class="d-flex align-items-end justify-content-center gap-1.5 w-100" style="height: 100px;">
              <div style="height: {{ max(10, $inqH) }}%; width: 14px; background: #ef3b2d; border-radius: 3px 3px 0 0;" title="{{ $monthlyInquiries[$idx] }} Inquiries" class="opacity-75"></div>
              <div style="height: {{ max(10, $appH) }}%; width: 14px; background: #38bdf8; border-radius: 3px 3px 0 0;" title="{{ $monthlyAppointments[$idx] }} Appointments" class="opacity-75"></div>
            </div>
            <div class="text-secondary fw-semibold mt-2" style="font-size:10.5px; letter-spacing:0.02em;">{{ $mLabel }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- 4. Recent Submissions Split View -->
  <div class="row g-3">
    <!-- Recent Inquiries -->
    <div class="col-lg-6">
      <div class="card h-100 mb-0">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-inbox text-danger" style="font-size:13px;"></i>
            <span class="fw-bold text-white">Recent Customer Inquiries</span>
          </div>
          <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm py-0 px-2" style="height:26px; font-size:10.5px;">View All</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th>Sender</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Time</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentInquiries as $inq)
                  <tr class="{{ !$inq->is_read ? 'table-active' : '' }}">
                    <td>
                      <div class="fw-bold text-white d-flex align-items-center gap-1.5" style="font-size:12px;">
                        @if(!$inq->is_read)
                          <span class="d-inline-block rounded-circle bg-danger" style="width:6px; height:6px;" title="Unread"></span>
                        @endif
                        {{ $inq->name }}
                      </div>
                      <div class="text-secondary small" style="font-size:10.5px;">{{ $inq->email }}</div>
                    </td>
                    <td>
                      @if($inq->type == 'quote')
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">Quote</span>
                      @elseif($inq->type == 'tire_inquiry')
                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">Tire</span>
                      @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Contact</span>
                      @endif
                    </td>
                    <td>
                      <span class="status-pill status-{{ $inq->status }}">{{ $inq->status }}</span>
                    </td>
                    <td class="text-secondary small" style="font-size:10.5px;">
                      {{ $inq->created_at->diffForHumans() }}
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex align-items-center gap-1.5">
                        <a href="{{ route('admin.inquiries.show', $inq) }}" class="btn btn-action btn-action-view" title="Review Inquiry">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-secondary py-4 small">No inquiries received yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Appointments -->
    <div class="col-lg-6">
      <div class="card h-100 mb-0">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <i class="fa-regular fa-calendar-check text-info" style="font-size:13px;"></i>
            <span class="fw-bold text-white">Recent Service Bookings</span>
          </div>
          <a href="{{ route('admin.appointments.index') }}" class="btn btn-outline-secondary btn-sm py-0 px-2" style="height:26px; font-size:10.5px;">View All</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Service</th>
                  <th>Schedule</th>
                  <th>Status</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentAppointments as $appt)
                  <tr class="{{ !$appt->is_read ? 'table-active' : '' }}">
                    <td>
                      <div class="fw-bold text-white d-flex align-items-center gap-1.5" style="font-size:12px;">
                        @if(!$appt->is_read)
                          <span class="d-inline-block rounded-circle bg-danger" style="width:6px; height:6px;" title="Unread"></span>
                        @endif
                        {{ $appt->full_name }}
                      </div>
                      <div class="text-secondary small" style="font-size:10.5px;">{{ $appt->phone }}</div>
                    </td>
                    <td>
                      <div class="text-white fw-semibold small text-truncate" style="max-width:140px; font-size:11.5px;">
                        {{ $appt->service_name }}
                      </div>
                    </td>
                    <td>
                      <div class="small fw-bold text-white" style="font-size:11.5px;">
                        {{ $appt->preferred_date ? $appt->preferred_date->format('M d') : 'Flexible' }}
                      </div>
                      <div class="text-secondary" style="font-size:10px;">{{ $appt->preferred_time ?? 'Any Time' }}</div>
                    </td>
                    <td>
                      <span class="status-pill status-{{ $appt->status }}">{{ $appt->status }}</span>
                    </td>
                    <td class="text-end">
                      <div class="d-inline-flex align-items-center gap-1.5">
                        <a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-action btn-action-view" title="View Booking">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-secondary py-4 small">No appointment requests yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
