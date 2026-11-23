@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page_title', 'Operational Overview')

@section('content')

  <!-- 1. Stats Cards Grid -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#ef3b2d; background:rgba(239,59,45,0.12);">
          <i class="fa-solid fa-inbox"></i>
        </div>
        <div>
          <div class="stat-val">{{ $totalInquiries }}</div>
          <div class="stat-label">Total Inquiries</div>
          @if($unreadInquiries > 0)
            <small class="text-danger fw-bold"><i class="fa-solid fa-bell me-1"></i>{{ $unreadInquiries }} unread</small>
          @else
            <small class="text-success"><i class="fa-solid fa-check me-1"></i>All read</small>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#3b82f6; background:rgba(59,130,246,0.12);">
          <i class="fa-regular fa-calendar-check"></i>
        </div>
        <div>
          <div class="stat-val">{{ $totalAppointments }}</div>
          <div class="stat-label">Appointments</div>
          @if($pendingAppointments > 0)
            <small class="text-warning fw-bold"><i class="fa-solid fa-clock me-1"></i>{{ $pendingAppointments }} pending</small>
          @else
            <small class="text-success"><i class="fa-solid fa-check me-1"></i>Updated</small>
          @endif
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#10b981; background:rgba(16,185,129,0.12);">
          <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <div>
          <div class="stat-val">{{ $totalQuotes }}</div>
          <div class="stat-label">Quote Requests</div>
          <small class="text-muted">Live estimates</small>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-box">
        <div class="stat-icon" style="color:#f59e0b; background:rgba(245,158,11,0.12);">
          <i class="fa-solid fa-circle-dot"></i>
        </div>
        <div>
          <div class="stat-val">{{ $totalProducts }}</div>
          <div class="stat-label">Tire Products</div>
          <small class="text-info">{{ $totalServices }} active services</small>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. Quick Actions Banner -->
  <div class="admin-card mb-4" style="background:linear-gradient(90deg, #181414, #121217); border-color:rgba(239,59,45,0.25);">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
      <div>
        <h5 class="fw-bold mb-1"><i class="fa-solid fa-bolt text-danger me-2"></i>Quick Actions</h5>
        <p class="text-secondary small mb-0">Jump directly to common shop management tasks.</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn-admin-primary">
          <i class="fa-solid fa-plus me-1"></i> Add New Tire
        </a>
        <a href="{{ route('admin.services.create') }}" class="btn-admin-secondary">
          <i class="fa-solid fa-plus me-1"></i> Add Service
        </a>
        <a href="{{ route('admin.inquiries.index') }}" class="btn-admin-secondary">
          <i class="fa-solid fa-envelope me-1"></i> View Inquiries
        </a>
        <a href="{{ route('admin.content.index') }}" class="btn-admin-secondary">
          <i class="fa-solid fa-sliders me-1"></i> Edit Website Content
        </a>
      </div>
    </div>
  </div>

  <!-- 3. Monthly Activity Visual Chart -->
  <div class="admin-card mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h6 class="fw-bold mb-0">Monthly Inquiry &amp; Appointment Volume</h6>
        <small class="text-secondary">Customer submissions over the past 6 months</small>
      </div>
      <div class="d-flex align-items-center gap-3 font-monospace small">
        <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#ef3b2d;">&nbsp;</span> Inquiries</span>
        <span class="d-flex align-items-center gap-1"><span class="badge rounded-circle p-1" style="background:#3b82f6;">&nbsp;</span> Appointments</span>
      </div>
    </div>

    <div class="row g-2 align-items-end pt-3" style="min-height: 140px;">
      @php
        $maxVal = max(max($monthlyInquiries), max($monthlyAppointments), 1);
      @endphp
      @foreach($months as $idx => $mLabel)
        @php
          $inqH = ($monthlyInquiries[$idx] / $maxVal) * 100;
          $appH = ($monthlyAppointments[$idx] / $maxVal) * 100;
        @endphp
        <div class="col text-center">
          <div class="d-flex align-items-end justify-content-center gap-1" style="height: 100px;">
            <div style="height: {{ max(8, $inqH) }}%; width: 14px; background: #ef3b2d; border-radius: 3px 3px 0 0;" title="{{ $monthlyInquiries[$idx] }} Inquiries"></div>
            <div style="height: {{ max(8, $appH) }}%; width: 14px; background: #3b82f6; border-radius: 3px 3px 0 0;" title="{{ $monthlyAppointments[$idx] }} Appointments"></div>
          </div>
          <div class="text-secondary small mt-2" style="font-size:10px;">{{ $mLabel }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- 4. Recent Submissions Tables -->
  <div class="row g-4">
    <!-- Recent Inquiries -->
    <div class="col-lg-6">
      <div class="admin-card h-100 mb-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-bold mb-0"><i class="fa-solid fa-inbox text-danger me-2"></i>Recent Inquiries</h6>
          <a href="{{ route('admin.inquiries.index') }}" class="text-secondary small">View All ↗</a>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Customer</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentInquiries as $inq)
                <tr>
                  <td>
                    <div class="fw-semibold text-white">{{ $inq->name }}</div>
                    <div class="text-secondary small">{{ $inq->phone ?? $inq->email }}</div>
                  </td>
                  <td>
                    <span class="badge bg-dark border border-secondary text-light">
                      {{ ucfirst(str_replace('_', ' ', $inq->type)) }}
                    </span>
                  </td>
                  <td>
                    <span class="status-pill status-{{ $inq->status }}">{{ $inq->status }}</span>
                  </td>
                  <td class="text-secondary small">{{ $inq->created_at->diffForHumans() }}</td>
                  <td>
                    <a href="{{ route('admin.inquiries.show', $inq) }}" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size:11px;">
                      View
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-secondary py-3">No inquiries received yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Appointments -->
    <div class="col-lg-6">
      <div class="admin-card h-100 mb-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-bold mb-0"><i class="fa-regular fa-calendar-check text-info me-2"></i>Recent Appointments</h6>
          <a href="{{ route('admin.appointments.index') }}" class="text-secondary small">View All ↗</a>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>Client</th>
                <th>Service</th>
                <th>Preferred</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentAppointments as $appt)
                <tr>
                  <td>
                    <div class="fw-semibold text-white">{{ $appt->full_name }}</div>
                    <div class="text-secondary small">{{ $appt->phone }}</div>
                  </td>
                  <td class="small">{{ $appt->service_name }}</td>
                  <td>
                    <div class="small fw-semibold">{{ $appt->preferred_date->format('M d') }}</div>
                    <div class="text-secondary" style="font-size:10px;">{{ $appt->preferred_time }}</div>
                  </td>
                  <td>
                    <span class="status-pill status-{{ $appt->status }}">{{ $appt->status }}</span>
                  </td>
                  <td>
                    <a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size:11px;">
                      View
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-secondary py-3">No appointment requests yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
