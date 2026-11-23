<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title', 'Admin Dashboard') | Mukoh Tires Admin</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

  <!-- Bootstrap 5.3.8 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- FontAwesome 6 Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    :root {
      --admin-bg: #09090b;
      --admin-card: #121215;
      --admin-card-border: rgba(255, 255, 255, 0.08);
      --admin-accent: #ef3b2d;
      --admin-accent-hover: #d82c1f;
      --admin-text: #f4f4f5;
      --admin-text-muted: #8b8b94;
      --admin-sidebar-w: 260px;
    }
    body {
      background-color: var(--admin-bg);
      color: var(--admin-text);
      font-family: 'Inter', system-ui, sans-serif;
      min-height: 100vh;
      display: flex;
    }
    a { text-decoration: none; }
    
    /* Sidebar */
    .admin-sidebar {
      width: var(--admin-sidebar-w);
      background: #0d0d10;
      border-right: 1px solid var(--admin-card-border);
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
    }
    .admin-brand {
      padding: 22px 24px;
      border-bottom: 1px solid var(--admin-card-border);
      display: flex;
      align-items: center;
      gap: 12px;
      color: #fff;
    }
    .admin-brand .brand-mark {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: inline-grid;
      place-items: center;
      border: 1px solid rgba(255,255,255,.3);
      font-weight: 900;
      font-size: 17px;
      background: rgba(239,59,45,.12);
      color: var(--admin-accent);
    }
    .admin-brand-text {
      font-size: 14px;
      font-weight: 800;
      letter-spacing: -0.02em;
    }
    .admin-brand-text small {
      display: block;
      font-size: 9px;
      color: var(--admin-accent);
      letter-spacing: 0.16em;
      font-weight: 700;
    }
    .sidebar-menu {
      padding: 16px 12px;
      flex: 1;
      overflow-y: auto;
    }
    .sidebar-section-title {
      font-size: 9px;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: #555560;
      padding: 12px 14px 6px;
      font-weight: 700;
    }
    .nav-item-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      color: var(--admin-text-muted);
      margin-bottom: 3px;
      transition: all 0.2s;
    }
    .nav-item-link i {
      width: 18px;
      font-size: 14px;
      text-align: center;
    }
    .nav-item-link:hover {
      background: rgba(255, 255, 255, 0.05);
      color: #fff;
    }
    .nav-item-link.active {
      background: rgba(239, 59, 45, 0.15);
      color: #fff;
      font-weight: 600;
      border-left: 3px solid var(--admin-accent);
    }
    .nav-item-link.active i {
      color: var(--admin-accent);
    }
    .nav-badge {
      margin-left: auto;
      font-size: 10px;
      padding: 2px 7px;
      border-radius: 999px;
      font-weight: 700;
    }

    /* Main Area */
    .admin-main {
      margin-left: var(--admin-sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: var(--admin-bg);
      width: calc(100% - var(--admin-sidebar-w));
    }
    .admin-topbar {
      height: 68px;
      background: #0d0d10;
      border-bottom: 1px solid var(--admin-card-border);
      padding: 0 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 999;
    }
    .admin-content {
      padding: 30px;
      flex: 1;
    }

    /* Cards & Components */
    .admin-card {
      background: var(--admin-card);
      border: 1px solid var(--admin-card-border);
      border-radius: 8px;
      padding: 24px;
      margin-bottom: 24px;
    }
    .stat-box {
      background: var(--admin-card);
      border: 1px solid var(--admin-card-border);
      border-radius: 8px;
      padding: 22px;
      display: flex;
      align-items: center;
      gap: 18px;
      transition: transform 0.2s, border-color 0.2s;
    }
    .stat-box:hover {
      border-color: rgba(239, 59, 45, 0.35);
      transform: translateY(-2px);
    }
    .stat-icon {
      width: 52px;
      height: 52px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.04);
      display: grid;
      place-items: center;
      font-size: 20px;
      color: var(--admin-accent);
      border: 1px solid rgba(255, 255, 255, 0.08);
      flex: none;
    }
    .stat-val {
      font-size: 28px;
      font-weight: 800;
      letter-spacing: -0.04em;
      line-height: 1.1;
    }
    .stat-label {
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--admin-text-muted);
      margin-top: 4px;
    }

    /* Tables */
    .admin-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }
    .admin-table th {
      background: rgba(255, 255, 255, 0.02);
      font-size: 11px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--admin-text-muted);
      padding: 12px 16px;
      border-bottom: 1px solid var(--admin-card-border);
      font-weight: 600;
    }
    .admin-table td {
      padding: 14px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
      font-size: 13px;
      vertical-align: middle;
      color: #e4e4e7;
    }
    .admin-table tr:hover td {
      background: rgba(255, 255, 255, 0.02);
    }

    /* Status Pills */
    .status-pill {
      display: inline-block;
      padding: 3px 10px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      border-radius: 999px;
    }
    .status-pending { background: rgba(234, 179, 8, 0.15); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); }
    .status-confirmed, .status-contacted { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .status-completed { background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); }
    .status-cancelled { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

    /* Form Controls */
    .form-control, .form-select {
      background: #18181c !important;
      border: 1px solid rgba(255, 255, 255, 0.12) !important;
      color: #fff !important;
      font-size: 13px;
      border-radius: 6px;
      padding: 10px 14px;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--admin-accent) !important;
      box-shadow: 0 0 0 2px rgba(239, 59, 45, 0.25) !important;
    }
    .form-label {
      font-size: 11px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--admin-text-muted);
      font-weight: 600;
      margin-bottom: 6px;
    }

    /* Action Buttons */
    .btn-admin-primary {
      background: var(--admin-accent);
      border: 1px solid var(--admin-accent);
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.08em;
      padding: 9px 18px;
      border-radius: 6px;
      text-transform: uppercase;
      transition: all 0.2s;
    }
    .btn-admin-primary:hover {
      background: var(--admin-accent-hover);
      border-color: var(--admin-accent-hover);
      color: #fff;
      transform: translateY(-1px);
    }
    .btn-admin-secondary {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.14);
      color: #fff;
      font-size: 12px;
      font-weight: 600;
      padding: 9px 16px;
      border-radius: 6px;
      transition: all 0.2s;
    }
    .btn-admin-secondary:hover {
      background: rgba(255, 255, 255, 0.12);
      color: #fff;
    }

    @media (max-width: 991.98px) {
      .admin-sidebar { transform: translateX(-100%); }
      .admin-sidebar.show { transform: translateX(0); }
      .admin-main { margin-left: 0; width: 100%; }
      .sidebar-toggle-btn { display: inline-block !important; }
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-brand">
      <span class="brand-mark">M</span>
      <div class="admin-brand-text">
        MUKOH TIRES
        <small>CONTROL PANEL</small>
      </div>
    </div>

    <div class="sidebar-menu">
      <div class="sidebar-section-title">Core</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
      </a>

      <div class="sidebar-section-title">Catalog & Services</div>
      <a href="{{ route('admin.products.index') }}" class="nav-item-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-circle-dot"></i> Tire Products
      </a>
      <a href="{{ route('admin.services.index') }}" class="nav-item-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
        <i class="fa-solid fa-wrench"></i> Services
      </a>

      <div class="sidebar-section-title">Customer Submissions</div>
      <a href="{{ route('admin.inquiries.index') }}" class="nav-item-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
        <i class="fa-solid fa-inbox"></i> Inquiries
        @php
          $unreadInq = \App\Models\Inquiry::where('is_read', false)->count();
        @endphp
        @if($unreadInq > 0)
          <span class="nav-badge bg-danger text-white">{{ $unreadInq }}</span>
        @endif
      </a>
      <a href="{{ route('admin.appointments.index') }}" class="nav-item-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
        <i class="fa-regular fa-calendar-check"></i> Appointments
        @php
          $pendingAppt = \App\Models\Appointment::where('status', 'pending')->count();
        @endphp
        @if($pendingAppt > 0)
          <span class="nav-badge bg-warning text-dark">{{ $pendingAppt }}</span>
        @endif
      </a>

      <div class="sidebar-section-title">Site Content</div>
      <a href="{{ route('admin.content.index') }}" class="nav-item-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
        <i class="fa-solid fa-sliders"></i> Website Content
      </a>
      <a href="{{ route('admin.testimonials.index') }}" class="nav-item-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
        <i class="fa-solid fa-star"></i> Testimonials
      </a>

      <div class="sidebar-section-title">System</div>
      <a href="{{ route('admin.settings.index') }}" class="nav-item-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i> Admin Settings
      </a>
      <a href="{{ route('home') }}" target="_blank" class="nav-item-link text-info">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> View Website
      </a>
    </div>

    <!-- User Profile & Logout Bottom Box -->
    <div class="p-3 border-top border-dark" style="background:#0a0a0d;">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2 overflow-hidden">
          <div class="rounded-circle bg-secondary d-grid place-items-center text-white fw-bold" style="width:32px;height:32px;font-size:12px;flex:none;">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
          </div>
          <div class="text-truncate" style="font-size:12px;">
            <div class="text-white fw-semibold text-truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
            <div class="text-secondary small text-truncate">{{ Auth::user()->email ?? 'admin' }}</div>
          </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="m-0">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Log Out">
            <i class="fa-solid fa-power-off"></i>
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="admin-main">
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-dark d-none sidebar-toggle-btn border-secondary" id="sidebarToggle">
          <i class="fa-solid fa-bars"></i>
        </button>
        <h5 class="mb-0 fw-bold fs-6">@yield('page_title', 'Dashboard')</h5>
      </div>

      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-dark position-relative border-secondary">
          <i class="fa-regular fa-bell"></i>
          @if($unreadInq > 0)
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-dark rounded-circle"></span>
          @endif
        </a>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-light d-none d-sm-inline-flex align-items-center gap-2">
          <span>Live Site</span> <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px;"></i>
        </a>
      </div>
    </header>

    <main class="admin-content">
      <!-- Flash Alert Messages -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border-success text-success d-flex align-items-center justify-content-between p-3 mb-4" role="alert">
          <div><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger d-flex align-items-center justify-content-between p-3 mb-4" role="alert">
          <div><i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}</div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger p-3 mb-4" role="alert">
          <strong><i class="fa-solid fa-circle-exclamation me-2"></i> Please correct the following errors:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const toggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('adminSidebar');
      if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
          sidebar.classList.toggle('show');
        });
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
