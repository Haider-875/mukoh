<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>@yield('title', 'Admin Dashboard') | Mukoh Tires Admin</title>

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet"/>

  <!-- Bootstrap 5.3.8 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons 1.11.3 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <!-- FontAwesome 6 Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    :root {
      --admin-bg: #09090c;
      --admin-surface: #0f0f14;
      --admin-card: #121218;
      --admin-card-header: #15151e;
      --admin-border: rgba(255, 255, 255, 0.08);
      --admin-border-subtle: rgba(255, 255, 255, 0.05);
      --admin-accent: #ef3b2d;
      --admin-accent-hover: #dc2626;
      --admin-accent-glow: rgba(239, 59, 45, 0.22);
      --admin-text: #f1f5f9;
      --admin-text-muted: #94a3b8;
      --admin-text-dim: #64748b;
      --admin-sidebar-w: 240px;
      --admin-topbar-h: 56px;
      --ease: cubic-bezier(0.16, 1, 0.3, 1);
    }

    * {
      box-sizing: border-box;
    }

    body {
      background-color: var(--admin-bg) !important;
      color: var(--admin-text) !important;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      font-size: 13px;
      line-height: 1.5;
      min-height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    a {
      text-decoration: none;
      color: inherit;
      transition: color 0.15s var(--ease), opacity 0.15s var(--ease);
    }

    /* Scrollbars */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: var(--admin-bg);
    }
    ::-webkit-scrollbar-thumb {
      background: #262633;
      border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #3a3a4c;
    }

    /* ==========================================================================
       Sidebar Architecture
       ========================================================================== */
    .admin-sidebar {
      width: var(--admin-sidebar-w);
      background: var(--admin-surface);
      border-right: 1px solid var(--admin-border);
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1040;
      display: flex;
      flex-direction: column;
      transition: transform 0.26s var(--ease), width 0.26s var(--ease);
    }

    /* Clean Aligned Brand Lockup */
    .admin-brand {
      height: var(--admin-topbar-h);
      padding: 0 16px;
      border-bottom: 1px solid var(--admin-border);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .brand-emblem {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      background: linear-gradient(135deg, #ef3b2d, #b91c1c);
      color: #ffffff;
      display: grid;
      place-items: center;
      font-weight: 900;
      font-size: 13px;
      letter-spacing: -0.02em;
      box-shadow: 0 2px 8px rgba(239, 59, 45, 0.35);
      flex-shrink: 0;
    }
    .brand-meta {
      display: flex;
      align-items: center;
      gap: 6px;
      overflow: hidden;
      white-space: nowrap;
    }
    .brand-name {
      font-size: 13px;
      font-weight: 800;
      letter-spacing: 0.04em;
      color: #ffffff;
    }
    .brand-pill {
      font-size: 9px;
      font-weight: 800;
      letter-spacing: 0.1em;
      padding: 2px 5px;
      border-radius: 3px;
      background: rgba(239, 59, 45, 0.15);
      color: #ef3b2d;
      border: 1px solid rgba(239, 59, 45, 0.3);
    }

    .sidebar-menu {
      padding: 12px 10px;
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar-section-title {
      font-size: 9.5px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--admin-text-dim);
      padding: 12px 10px 4px;
      font-weight: 700;
    }

    .nav-item-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 7px 10px;
      border-radius: 6px;
      font-size: 12.5px;
      font-weight: 500;
      color: var(--admin-text-muted);
      margin-bottom: 2px;
      transition: all 0.16s var(--ease);
      white-space: nowrap;
    }
    .nav-item-link i {
      width: 16px;
      font-size: 13px;
      text-align: center;
      color: var(--admin-text-dim);
      transition: color 0.16s var(--ease);
      flex-shrink: 0;
    }
    .nav-item-link:hover {
      background: rgba(255, 255, 255, 0.05);
      color: #ffffff;
    }
    .nav-item-link:hover i {
      color: #ffffff;
    }
    .nav-item-link.active {
      background: rgba(239, 59, 45, 0.14);
      color: #ffffff;
      font-weight: 600;
    }
    .nav-item-link.active i {
      color: var(--admin-accent);
    }
    .nav-badge {
      margin-left: auto;
      font-size: 9.5px;
      padding: 1px 6px;
      border-radius: 4px;
      font-weight: 700;
      line-height: 1.3;
    }

    /* Sidebar Footer User Card */
    .sidebar-user {
      padding: 10px 12px;
      border-top: 1px solid var(--admin-border);
      background: rgba(0, 0, 0, 0.2);
    }
    .user-pill {
      display: flex;
      align-items: center;
      gap: 9px;
      padding: 6px 8px;
      border-radius: 6px;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid var(--admin-border-subtle);
    }
    .user-avatar {
      width: 26px;
      height: 26px;
      border-radius: 5px;
      background: #22222d;
      color: #ffffff;
      display: grid;
      place-items: center;
      font-size: 11px;
      font-weight: 800;
      flex-shrink: 0;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .user-info {
      flex: 1;
      overflow: hidden;
      line-height: 1.25;
    }
    .user-name {
      font-size: 11.5px;
      font-weight: 700;
      color: #ffffff;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .user-role {
      font-size: 10px;
      color: var(--admin-text-dim);
    }

    /* ==========================================================================
       Main Wrapper & Topbar
       ========================================================================== */
    .admin-main {
      margin-left: var(--admin-sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: var(--admin-bg);
      width: calc(100% - var(--admin-sidebar-w));
      transition: margin-left 0.26s var(--ease), width 0.26s var(--ease);
    }

    .admin-topbar {
      height: var(--admin-topbar-h);
      background: var(--admin-surface);
      border-bottom: 1px solid var(--admin-border);
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 1020;
    }

    .topbar-btn {
      width: 32px;
      height: 32px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--admin-border);
      color: var(--admin-text-muted);
      cursor: pointer;
      transition: all 0.15s ease;
      font-size: 13px;
    }
    .topbar-btn:hover {
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff;
      border-color: rgba(255, 255, 255, 0.16);
    }

    .topbar-action-link {
      height: 32px;
      padding: 0 12px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid var(--admin-border);
      color: var(--admin-text-muted);
      font-size: 11.5px;
      font-weight: 600;
      transition: all 0.15s ease;
    }
    .topbar-action-link:hover {
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff;
      border-color: rgba(255, 255, 255, 0.16);
    }

    .admin-content {
      padding: 24px;
      flex: 1;
    }

    /* ==========================================================================
       Desktop Sidebar Collapse State
       ========================================================================== */
    body.sidebar-collapsed .admin-sidebar {
      transform: translateX(-100%);
    }
    body.sidebar-collapsed .admin-main {
      margin-left: 0;
      width: 100%;
    }

    /* Mobile Backdrop */
    .sidebar-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      z-index: 1030;
      opacity: 0;
      transition: opacity 0.25s ease;
    }
    .sidebar-backdrop.show {
      display: block;
      opacity: 1;
    }

    @media (max-width: 991.98px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }
      .admin-sidebar.mobile-open {
        transform: translateX(0);
      }
      .admin-main {
        margin-left: 0 !important;
        width: 100% !important;
      }
      .admin-content {
        padding: 16px;
      }
      .admin-topbar {
        padding: 0 14px;
      }
    }

    /* ==========================================================================
       Component Polish: Cards, Buttons, Tables, Form Controls
       ========================================================================== */
    .card,
    .admin-card {
      background: var(--admin-card) !important;
      border: 1px solid var(--admin-border) !important;
      border-radius: 8px !important;
      color: var(--admin-text) !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
      margin-bottom: 20px;
    }
    .card-header {
      background: var(--admin-card-header) !important;
      border-bottom: 1px solid var(--admin-border) !important;
      color: #ffffff !important;
      font-weight: 700 !important;
      font-size: 13px !important;
      padding: 12px 18px !important;
      border-radius: 7px 7px 0 0 !important;
    }
    .card-body {
      padding: 18px !important;
      color: var(--admin-text) !important;
    }
    .card-footer {
      background: #0f0f15 !important;
      border-top: 1px solid var(--admin-border) !important;
      padding: 10px 18px !important;
      border-radius: 0 0 7px 7px !important;
      font-size: 12px;
    }

    /* Stat Box (Compact & Elegant) */
    .stat-box {
      background: var(--admin-card);
      border: 1px solid var(--admin-border);
      border-radius: 8px;
      padding: 16px 18px;
      display: flex;
      align-items: center;
      gap: 14px;
      transition: transform 0.2s var(--ease), border-color 0.2s var(--ease), box-shadow 0.2s var(--ease);
      height: 100%;
    }
    .stat-box:hover {
      border-color: rgba(255, 255, 255, 0.16);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
    }
    .stat-icon {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: grid;
      place-items: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .stat-val {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.02em;
      line-height: 1.1;
      color: #ffffff;
      font-family: 'JetBrains Mono', 'Inter', monospace;
    }
    .stat-label {
      font-size: 10.5px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--admin-text-muted);
      margin-top: 3px;
      font-weight: 600;
    }

    /* Tables (Sleek SaaS Style) */
    .table,
    .admin-table {
      width: 100%;
      margin: 0;
      border-collapse: collapse;
      font-size: 12.5px;
      color: var(--admin-text);
      --bs-table-bg: transparent;
      --bs-table-hover-bg: rgba(255, 255, 255, 0.03);
    }
    .table th,
    .admin-table th {
      background: #14141a !important;
      font-size: 10px !important;
      letter-spacing: 0.1em !important;
      text-transform: uppercase !important;
      color: var(--admin-text-muted) !important;
      padding: 10px 14px !important;
      border-bottom: 1px solid var(--admin-border) !important;
      font-weight: 700 !important;
      white-space: nowrap;
    }
    .table td,
    .admin-table td {
      padding: 11px 14px !important;
      border-bottom: 1px solid var(--admin-border-subtle) !important;
      vertical-align: middle;
      color: #e2e8f0;
    }
    .table tbody tr:hover td,
    .admin-table tbody tr:hover td {
      background-color: rgba(255, 255, 255, 0.03) !important;
    }

    /* Buttons (Sleek Compact Size) */
    .btn {
      font-size: 11.5px !important;
      font-weight: 600 !important;
      border-radius: 5px !important;
      padding: 5px 12px !important;
      transition: all 0.16s var(--ease);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      line-height: 1.4;
    }
    .btn-sm {
      font-size: 11px !important;
      padding: 4px 10px !important;
      border-radius: 4px !important;
    }
    .btn-primary,
    .btn-admin-primary {
      background: var(--admin-accent) !important;
      border: 1px solid var(--admin-accent) !important;
      color: #ffffff !important;
      letter-spacing: 0.04em;
    }
    .btn-primary:hover,
    .btn-admin-primary:hover {
      background: var(--admin-accent-hover) !important;
      border-color: var(--admin-accent-hover) !important;
      color: #ffffff !important;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px var(--admin-accent-glow);
    }
    .btn-outline-secondary {
      border-color: var(--admin-border) !important;
      color: var(--admin-text-muted) !important;
      background: rgba(255, 255, 255, 0.02) !important;
    }
    .btn-outline-secondary:hover {
      background: rgba(255, 255, 255, 0.08) !important;
      color: #ffffff !important;
      border-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Form Controls */
    .form-control, .form-select {
      background-color: #14141a !important;
      border: 1px solid var(--admin-border) !important;
      color: #ffffff !important;
      font-size: 12.5px !important;
      border-radius: 5px !important;
      padding: 7px 11px !important;
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus, .form-select:focus {
      background-color: #171720 !important;
      border-color: var(--admin-accent) !important;
      color: #ffffff !important;
      box-shadow: 0 0 0 2px var(--admin-accent-glow) !important;
    }
    .form-label {
      font-size: 11px !important;
      font-weight: 600 !important;
      color: var(--admin-text-muted) !important;
      margin-bottom: 5px !important;
      letter-spacing: 0.02em;
    }

    /* Status Pills */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 2px 7px;
      font-size: 9.5px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      border-radius: 4px;
    }
    .status-pending { background: rgba(234, 179, 8, 0.12); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); }
    .status-confirmed, .status-contacted { background: rgba(56, 189, 248, 0.12); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
    .status-completed { background: rgba(74, 222, 128, 0.12); color: #4ade80; border: 1px solid rgba(74, 222, 128, 0.3); }
    .status-cancelled { background: rgba(248, 113, 113, 0.12); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.3); }

    .badge {
      font-weight: 600;
      font-size: 10px;
      padding: 3px 6px;
    }

    /* User Profile Dropdown in Topbar */
    .dropdown-menu-dark {
      background-color: #14141c !important;
      border: 1px solid var(--admin-border) !important;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5) !important;
      border-radius: 8px !important;
      padding: 6px !important;
      font-size: 12px !important;
      min-width: 200px !important;
    }
    .dropdown-item {
      border-radius: 5px !important;
      padding: 7px 10px !important;
      color: var(--admin-text-muted) !important;
      font-weight: 500 !important;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .dropdown-item:hover {
      background-color: rgba(255, 255, 255, 0.07) !important;
      color: #ffffff !important;
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Mobile Backdrop -->
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <!-- Clean, Aligned Brand Lockup -->
    <div class="admin-brand">
      <div class="brand-emblem">M</div>
      <div class="brand-meta">
        <span class="brand-name">MUKOH TIRES</span>
        <span class="brand-pill">ADMIN</span>
      </div>
    </div>

    <!-- Sidebar Menu Navigation -->
    <div class="sidebar-menu">
      <div class="sidebar-section-title">Core</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i> Dashboard
      </a>

      <div class="sidebar-section-title">Shop &amp; Catalog</div>
      <a href="{{ route('admin.products.index') }}" class="nav-item-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-circle-dot"></i> Tire Products
      </a>
      <a href="{{ route('admin.services.index') }}" class="nav-item-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
        <i class="fa-solid fa-wrench"></i> Services
      </a>

      <div class="sidebar-section-title">Customer CRM</div>
      @php
        $unreadInq = \App\Models\Inquiry::where('is_read', false)->count();
        $pendingAppt = \App\Models\Appointment::where('status', 'pending')->count();
      @endphp
      <a href="{{ route('admin.inquiries.index') }}" class="nav-item-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
        <i class="fa-solid fa-inbox"></i> Inquiries
        @if($unreadInq > 0)
          <span class="nav-badge bg-danger text-white">{{ $unreadInq }}</span>
        @endif
      </a>
      <a href="{{ route('admin.appointments.index') }}" class="nav-item-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
        <i class="fa-regular fa-calendar-check"></i> Appointments
        @if($pendingAppt > 0)
          <span class="nav-badge bg-warning text-dark">{{ $pendingAppt }}</span>
        @endif
      </a>

      <div class="sidebar-section-title">Website Content</div>
      <a href="{{ route('admin.content.index') }}" class="nav-item-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">
        <i class="fa-solid fa-sliders"></i> Site Content
      </a>
      <a href="{{ route('admin.testimonials.index') }}" class="nav-item-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
        <i class="fa-solid fa-star"></i> Testimonials
      </a>

      <div class="sidebar-section-title">Security &amp; Account</div>
      <a href="{{ route('admin.settings.index') }}" class="nav-item-link {{ request()->routeIs('admin.settings.*') && !request()->has('tab') ? 'active' : '' }}">
        <i class="fa-solid fa-gear"></i> Admin Settings
      </a>
      <a href="{{ route('admin.settings.index') }}#passwordCard" class="nav-item-link">
        <i class="fa-solid fa-key"></i> Change Password
      </a>
    </div>

    <!-- Sidebar Bottom User Status -->
    <div class="sidebar-user">
      <div class="user-pill">
        <div class="user-avatar">
          {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="user-info">
          <div class="user-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
          <div class="user-role">{{ Auth::user()->role ?? 'Super Admin' }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0 ms-auto">
          @csrf
          <button type="submit" class="btn btn-sm p-1 text-danger border-0 bg-transparent" title="Sign Out">
            <i class="fa-solid fa-power-off"></i>
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="admin-main">
    <!-- Topbar -->
    <header class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <!-- Sidebar Toggle (Works on both Desktop and Mobile) -->
        <button class="topbar-btn" id="sidebarToggle" title="Toggle sidebar menu">
          <i class="fa-solid fa-bars-staggered"></i>
        </button>

        <div class="d-none d-sm-block">
          <h5 class="mb-0 fw-bold text-white" style="font-size: 13.5px; letter-spacing: -0.01em;">
            @if(trim($__env->yieldContent('page_title')))
              @yield('page_title')
            @elseif(trim($__env->yieldContent('header-title')))
              @yield('header-title')
            @else
              Operational Dashboard
            @endif
          </h5>
          @hasSection('header-subtitle')
            <small class="text-secondary d-block" style="font-size: 11px; line-height: 1.2;">@yield('header-subtitle')</small>
          @endif
        </div>
      </div>

      <!-- Topbar Right Actions -->
      <div class="d-flex align-items-center gap-2">
        <!-- Live Site Link (Single Clean Location) -->
        <a href="{{ route('home') }}" target="_blank" class="topbar-action-link" title="Open customer website in new tab">
          <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 10px; color: var(--admin-accent);"></i>
          <span>Live Site</span>
        </a>

        <!-- Notifications -->
        <a href="{{ route('admin.inquiries.index') }}" class="topbar-btn position-relative" title="Inquiries & Notifications">
          <i class="fa-regular fa-bell"></i>
          @if($unreadInq > 0)
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-dark rounded-circle" style="transform: translate(-6px, 6px) !important;"></span>
          @endif
        </a>

        <!-- User Dropdown (Includes Profile & Change Password) -->
        <div class="dropdown">
          <button class="btn btn-sm d-flex align-items-center gap-2 p-1 px-2 border-0 bg-transparent text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="user-avatar" style="width:28px; height:28px;">
              {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <span class="d-none d-md-inline fw-semibold text-white" style="font-size: 12px;">{{ Auth::user()->name ?? 'Admin' }}</span>
            <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 9px;"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow">
            <li class="px-3 py-2 border-bottom border-secondary border-opacity-25">
              <div class="fw-bold text-white small">{{ Auth::user()->name ?? 'Administrator' }}</div>
              <div class="text-secondary small text-truncate" style="font-size: 10.5px;">{{ Auth::user()->email ?? 'admin@mukohtires.com' }}</div>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                <i class="fa-regular fa-user text-secondary"></i> My Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('admin.settings.index') }}#passwordCard">
                <i class="fa-solid fa-key text-warning"></i> Change Password
              </a>
            </li>
            <li><hr class="dropdown-divider border-secondary border-opacity-25 my-1"/></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="admin-content">
      <!-- Flash Alert Messages -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-success bg-opacity-10 border-success text-success d-flex align-items-center justify-content-between p-2 px-3 mb-3" style="font-size: 12px; border-radius: 6px;" role="alert">
          <div><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
          <button type="button" class="btn-close btn-close-white p-2" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger d-flex align-items-center justify-content-between p-2 px-3 mb-3" style="font-size: 12px; border-radius: 6px;" role="alert">
          <div><i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}</div>
          <button type="button" class="btn-close btn-close-white p-2" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show bg-danger bg-opacity-10 border-danger text-danger p-3 mb-3" style="font-size: 12px; border-radius: 6px;" role="alert">
          <strong><i class="fa-solid fa-circle-exclamation me-1"></i> Please check the following:</strong>
          <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close btn-close-white p-2" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px;"></button>
        </div>
      @endif

      @yield('content')
    </main>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Interactive Sidebar Controller (Desktop & Mobile) -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const toggleBtn = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('adminSidebar');
      const backdrop = document.getElementById('sidebarBackdrop');

      // Restore desktop sidebar collapse state from localStorage
      const isDesktop = () => window.innerWidth >= 992;
      const savedCollapsed = localStorage.getItem('mukoh_admin_sidebar_collapsed') === '1';

      if (isDesktop() && savedCollapsed) {
        document.body.classList.add('sidebar-collapsed');
      }

      function toggleSidebar() {
        if (isDesktop()) {
          const collapsed = document.body.classList.toggle('sidebar-collapsed');
          localStorage.setItem('mukoh_admin_sidebar_collapsed', collapsed ? '1' : '0');
        } else {
          const isOpen = sidebar.classList.toggle('mobile-open');
          backdrop.classList.toggle('show', isOpen);
        }
      }

      function closeMobileSidebar() {
        if (!isDesktop()) {
          sidebar.classList.remove('mobile-open');
          backdrop.classList.remove('show');
        }
      }

      toggleBtn?.addEventListener('click', toggleSidebar);
      backdrop?.addEventListener('click', closeMobileSidebar);

      // Close mobile sidebar on navigation link click
      document.querySelectorAll('.admin-sidebar .nav-item-link').forEach(link => {
        link.addEventListener('click', () => {
          if (!isDesktop()) closeMobileSidebar();
        });
      });

      // Close mobile sidebar on Escape key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('mobile-open')) {
          closeMobileSidebar();
        }
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
