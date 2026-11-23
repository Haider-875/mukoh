<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta name="theme-color" content="#090909"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <title>@yield('title', $settings['meta_title'] ?? 'Mukoh Tires LLC | Quality Tires You Can Trust')</title>
  <meta name="description" content="@yield('meta_description', $settings['meta_description'] ?? 'Mukoh Tires LLC quality new and used tires, installation, balancing, repair and inspections.')"/>
  <meta name="keywords" content="{{ $settings['meta_keywords'] ?? 'Mukoh tires, tire shop Baltimore, new tires, used tires' }}"/>

  <!-- Open Graph / SEO -->
  <meta property="og:title" content="@yield('title', $settings['meta_title'] ?? 'Mukoh Tires LLC')"/>
  <meta property="og:description" content="@yield('meta_description', $settings['meta_description'] ?? 'Quality Tires You Can Trust')"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="{{ url()->current() }}"/>

  <!-- Google Fonts: Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

  <!-- Bootstrap 5.3.8 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>

  <!-- Original Reference CSS + Enhanced Custom Styles -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/pages.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
  <link href="{{ asset('favicon.svg') }}" rel="icon" type="image/svg+xml"/>

  @stack('styles')
</head>
<body class="@yield('body_class', '')">

  <!-- Scroll Progress Indicator -->
  <div class="scroll-progress" id="scrollProgress"></div>

  <!-- Header Navigation -->
  @if(View::hasSection('is_home'))
    <header class="site-header" id="top">
  @else
    <header class="inner-header" id="top">
  @endif
    <nav class="navbar navbar-expand-lg py-0">
      <div class="container-fluid nav-shell px-3 px-md-4 px-xl-5">
        <a aria-label="Mukoh Tires home" class="brand d-flex align-items-center gap-3 text-decoration-none" href="{{ route('home') }}">
          <span class="brand-mark">M</span>
          <span class="brand-copy"><strong>MUKOH TIRES</strong><small>LLC</small></span>
        </a>

        <!-- Sound Toggle & Hamburger Button for Mobile -->
        <div class="d-flex align-items-center gap-2 d-lg-none">
          <button class="sound-toggle-btn p-2" type="button" aria-label="Toggle Sound">
            <div class="sound-waves">
              <span></span><span></span><span></span><span></span>
            </div>
          </button>
          <button aria-controls="mobileNav" aria-label="Open menu" class="navbar-toggler border-0 shadow-none p-0" data-bs-target="#mobileNav" data-bs-toggle="offcanvas" type="button">
            <span class="menu-lines"><i></i><i></i></span>
          </button>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="collapse navbar-collapse justify-content-center d-none d-lg-flex">
          <ul class="navbar-nav gap-xl-4 align-items-center">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('tires') ? 'active' : '' }}" href="{{ route('tires') }}">Tires</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            </li>
          </ul>
        </div>

        <!-- Desktop Actions: Sound Toggle + Book Appointment Button -->
        <div class="d-none d-lg-flex align-items-center gap-3">
          <button class="sound-toggle-btn" type="button" aria-label="Toggle Sound">
            <div class="sound-waves">
              <span></span><span></span><span></span><span></span>
            </div>
            <span class="sound-label">SOUND ON</span>
          </button>

          <a class="btn btn-accent" href="{{ route('contact') }}">Book Appointment</a>
        </div>
      </div>
    </nav>
  </header>

  <!-- Mobile Offcanvas Menu -->
  <div aria-labelledby="mobileNavLabel" class="offcanvas offcanvas-end mobile-panel" id="mobileNav" tabindex="-1">
    <div class="offcanvas-header">
      <div class="brand d-flex align-items-center gap-3" id="mobileNavLabel">
        <span class="brand-mark">M</span>
        <span class="brand-copy"><strong>MUKOH TIRES</strong><small>LLC</small></span>
      </div>
      <button aria-label="Close" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" type="button"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
      <a class="mobile-link {{ request()->routeIs('home') ? 'active' : '' }}" data-bs-dismiss="offcanvas" href="{{ route('home') }}">Home</a>
      <a class="mobile-link {{ request()->routeIs('tires') ? 'active' : '' }}" data-bs-dismiss="offcanvas" href="{{ route('tires') }}">Tires</a>
      <a class="mobile-link {{ request()->routeIs('services') ? 'active' : '' }}" data-bs-dismiss="offcanvas" href="{{ route('services') }}">Services</a>
      <a class="mobile-link {{ request()->routeIs('about') ? 'active' : '' }}" data-bs-dismiss="offcanvas" href="{{ route('about') }}">About</a>
      <a class="mobile-link {{ request()->routeIs('contact') ? 'active' : '' }}" data-bs-dismiss="offcanvas" href="{{ route('contact') }}">Contact</a>

      <div class="mt-4 pt-3 border-top border-secondary">
        <button class="sound-toggle-btn w-100 justify-content-center py-2 mb-3" type="button">
          <div class="sound-waves">
            <span></span><span></span><span></span><span></span>
          </div>
          <span class="sound-label">SOUND ON</span>
        </button>
        <a class="btn btn-accent w-100" href="{{ route('contact') }}">Book Appointment</a>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  @yield('content')

  <!-- Global Footer -->
  <footer class="site-footer">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row gy-5">
        <div class="col-lg-5">
          <div class="brand footer-brand">
            <span class="brand-mark">M</span>
            <span class="brand-copy"><strong>MUKOH TIRES</strong><small>LLC</small></span>
          </div>
          <p class="footer-copy">
            {{ $settings['footer_about'] ?? 'Your trusted partner for quality tires and professional automotive services. Serving our community with excellence.' }}
          </p>
        </div>

        <div class="col-6 col-lg-2">
          <h4>QUICK LINKS</h4>
          <a href="{{ route('home') }}">Home</a>
          <a href="{{ route('tires') }}">Tires</a>
          <a href="{{ route('services') }}">Services</a>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div class="col-6 col-lg-2">
          <h4>SERVICES</h4>
          <span>New Tires</span>
          <span>Used Tires</span>
          <span>Installation</span>
          <span>Balancing</span>
          <span>Repair</span>
        </div>

        <div class="col-lg-3">
          <h4>CONTACT US</h4>
          <div class="footer-contact-item">
            <span class="footer-contact-icon">
              <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0z"></path>
                <circle cx="12" cy="10" r="2.5"></circle>
              </svg>
            </span>
            <a href="{{ $settings['maps_directions_url'] ?? 'https://www.google.com/maps/dir/?api=1&destination=3415+Berwyn+Ave%2C+Baltimore%2C+MD+21207' }}" rel="noopener" target="_blank">
              {!! nl2br(e($settings['address'] ?? "3415 Berwyn Ave\nBaltimore, MD 21207")) !!}
            </a>
          </div>

          <div class="footer-contact-item">
            <span class="footer-contact-icon">
              <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.9a2 2 0 0 1-.5 2.1L8 10a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.9.6 2.9.7a2 2 0 0 1 1.7 2z"></path>
              </svg>
            </span>
            <a href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">{{ $settings['phone_display'] ?? '(240) 854-0273' }}</a>
          </div>

          <div class="footer-contact-item">
            <span class="footer-contact-icon">
              <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <rect height="14" rx="1" width="18" x="3" y="5"></rect>
                <path d="m3 7 9 6 9-6"></path>
              </svg>
            </span>
            <a href="mailto:{{ $settings['email'] ?? 'mukohtires@gmail.com' }}?subject=Mukoh%20Tires%20Website%20Inquiry">{{ $settings['email'] ?? 'mukohtires@gmail.com' }}</a>
          </div>

          <div class="footer-contact-item">
            <span class="footer-contact-icon">
              <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9"></circle>
                <path d="M12 7v5l3 2"></path>
              </svg>
            </span>
            <span class="footer-contact-text">{{ $settings['business_hours'] ?? 'Daily: 8:00 AM - 7:30 PM' }}</span>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <span>© {{ date('Y') }} MUKOH TIRES LLC</span>
        <span>Designed By <a class="azora-credit" href="{{ $settings['footer_credit_url'] ?? 'https://azorasolution.com' }}" rel="noopener" target="_blank">{{ $settings['footer_credit'] ?? 'Azora Solution' }}</a></span>
        <div class="footer-legal-links">
          <a href="{{ route('privacy') }}">Privacy Policy</a>
          <a href="{{ route('terms') }}">Terms of Service</a>
          @auth
            <a href="{{ route('admin.dashboard') }}" class="text-danger fw-bold ms-2">Admin Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="text-secondary ms-2">Staff Login</a>
          @endauth
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <button aria-label="Back to top" class="back-to-top" id="backToTop">↑</button>

  <!-- Quick Quote Request Modal -->
  <div class="quote-modal-overlay" id="quickQuoteModal" tabindex="-1">
    <div class="quote-modal-card">
      <button class="celebration-close-btn" id="closeQuoteModalBtn" aria-label="Close quote modal">&times;</button>
      <div class="section-label">INSTANT QUOTE</div>
      <h3 class="inner-title mb-2">REQUEST A <span style="color:var(--red);">QUOTE</span></h3>
      <p class="text-secondary small mb-4" id="quoteModalSubtext">Get accurate pricing on new & used tires or services.</p>

      <form action="{{ route('inquiry.quote') }}" method="POST" data-ajax-form id="quickQuoteForm">
        @csrf
        <input type="hidden" name="tire_name" id="quoteTireNameInput" value=""/>

        <div class="field mb-3">
          <label for="quoteName">Full Name *</label>
          <input type="text" id="quoteName" name="name" placeholder="John Doe" required/>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-md-6 field">
            <label for="quotePhone">Phone Number *</label>
            <input type="tel" id="quotePhone" name="phone" placeholder="(240) 854-0273" required/>
          </div>
          <div class="col-md-6 field">
            <label for="quoteEmail">Email Address *</label>
            <input type="email" id="quoteEmail" name="email" placeholder="john@example.com" required/>
          </div>
        </div>

        <div class="row g-2 mb-3">
          <div class="col-md-6 field">
            <label for="quoteVehicle">Vehicle Make/Model</label>
            <input type="text" id="quoteVehicle" name="vehicle_info" placeholder="e.g. 2021 Toyota Camry"/>
          </div>
          <div class="col-md-6 field">
            <label for="quoteTireSize">Tire Size (if known)</label>
            <input type="text" id="quoteTireSize" name="tire_size" placeholder="e.g. 205/55R16"/>
          </div>
        </div>

        <div class="field mb-4">
          <label for="quoteMessage">Notes / Quantities</label>
          <textarea id="quoteMessage" name="message" rows="2" placeholder="Tell us if you need 2 or 4 tires, installation, etc."></textarea>
        </div>

        <button type="submit" class="submit-btn w-100">SUBMIT QUOTE REQUEST</button>
      </form>
    </div>
  </div>

  <!-- Celebratory Success Modal Placeholder (Auto-mounted by form-handler.js) -->

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Vite / Bundled JS -->
  @vite(['resources/js/app.js'])

  <!-- Quick Quote Modal Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const quoteModal = document.getElementById('quickQuoteModal');
      const closeBtn = document.getElementById('closeQuoteModalBtn');
      const tireNameInput = document.getElementById('quoteTireNameInput');
      const subtext = document.getElementById('quoteModalSubtext');

      window.openQuoteModal = function(tireName = '', size = '') {
        if (!quoteModal) return;
        if (tireNameInput) tireNameInput.value = tireName;
        if (subtext) {
          subtext.textContent = tireName ? `Requesting quote for: ${tireName}` : 'Get accurate pricing on new & used tires or services.';
        }
        const sizeInput = document.getElementById('quoteTireSize');
        if (sizeInput && size) sizeInput.value = size;
        quoteModal.classList.add('active');
      };

      if (closeBtn) closeBtn.addEventListener('click', () => quoteModal.classList.remove('active'));
      if (quoteModal) {
        quoteModal.addEventListener('click', (e) => {
          if (e.target === quoteModal) quoteModal.classList.remove('active');
        });
      }

      // Universal quote button click handler using event delegation
      document.addEventListener('click', (e) => {
        const btn = e.target.closest('.quote-button, .quote-main-link, [data-open-quote]');
        if (!btn) return;
        e.preventDefault();
        const card = btn.closest('.product-card, .tire-card');
        const title = btn.dataset.tire || (card ? card.querySelector('h3')?.textContent?.trim() : '');
        const size = btn.dataset.size || (card ? card.querySelector('.tire-size')?.textContent?.trim() : '');
        window.openQuoteModal(title, size);
      });
    });
  </script>

  @stack('scripts')
</body>
</html>
