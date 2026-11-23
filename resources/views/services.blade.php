@extends('layouts.app')

@section('title', 'Services | Mukoh Tires LLC')
@section('meta_description', 'Tire installation, balancing, repair, rotation and safety inspection services from Mukoh Tires in Baltimore, MD.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>Services
      </div>
      <div class="page-hero-grid">
        <div class="page-hero-main">
          <div class="page-kicker">Expert Care</div>
          <h1 class="page-title">OUR<br/><span>SERVICES.</span></h1>
        </div>
        <div class="page-hero-aside">
          <p class="page-lead">
            From choosing tires to mounting, balancing, repairs and safety checks, our service lineup is built to keep your vehicle road-ready.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Complete Tire Care Service List -->
  <section class="section-pad">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="section-label">Complete tire care</div>
      <h2 class="inner-title">ONE SHOP. <span>FULL SUPPORT.</span></h2>

      <div class="service-list">
        @foreach($services as $index => $srv)
          <article class="service-detail compact-service">
            <div class="service-detail-copy">
              <div class="service-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
              <h3>{{ $srv->title }}</h3>
              <p>{{ $srv->full_description ?? $srv->short_description }}</p>

              @if(!empty($srv->features))
                <ul class="check-list">
                  @foreach($srv->features as $feat)
                    <li>{{ $feat }}</li>
                  @endforeach
                </ul>
              @endif
            </div>

            <aside class="service-detail-side">
              <div>
                <small>{{ $srv->price_subtext ?? 'Starting at' }}</small>
                <div class="service-price">{{ $srv->price_starting_at }}</div>
              </div>
              <a class="dark-btn" href="{{ route('contact') }}?service={{ urlencode($srv->title) }}" style="background:#ef3b2d;color:#111!important">
                Book Now
              </a>
            </aside>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Process Section -->
  <section class="section-pad section-soft">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="section-label">How it works</div>
      <h2 class="inner-title">OUR <span>PROCESS.</span></h2>

      <div class="process-grid">
        <article class="process-card">
          <span>01</span>
          <h3>Schedule</h3>
          <p>Book online or call and choose a time that suits you.</p>
        </article>
        <article class="process-card">
          <span>02</span>
          <h3>Inspect</h3>
          <p>We review the vehicle and discuss practical options for your needs.</p>
        </article>
        <article class="process-card">
          <span>03</span>
          <h3>Service</h3>
          <p>Work is completed using suitable equipment and careful procedures.</p>
        </article>
        <article class="process-card">
          <span>04</span>
          <h3>Drive</h3>
          <p>Leave with the work completed and your tire setup ready for the road.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- Trusted Expertise & Hours Section -->
  <section class="section-pad trusted-expertise">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="trust-grid">
        <div>
          <div class="section-label">Why Choose Us</div>
          <h2 class="inner-title">TRUSTED <span>EXPERTISE.</span></h2>
          <p class="trust-copy">
            Experienced tire service, practical recommendations and a straightforward approach built around safe, dependable results.
          </p>
        </div>

        <div class="trust-stats">
          <div><strong>15+</strong><span>Years in Business</span></div>
          <div><strong>10K+</strong><span>Happy Customers</span></div>
          <div><strong>100%</strong><span>Satisfaction Goal</span></div>
          <div><strong>Same</strong><span>Day Service</span></div>
        </div>
      </div>

      <div class="hours-panel">
        <div>
          <small>BUSINESS HOURS</small>
          <strong>Monday - Sunday</strong>
          <span>{{ $settings['business_hours'] ?? '8:00 AM - 7:30 PM' }}</span>
        </div>
        <a class="dark-btn red-btn" href="{{ route('contact') }}">Schedule Service</a>
      </div>
    </div>
  </section>

  <!-- Inner CTA -->
  <section class="inner-cta">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row align-items-end g-4">
        <div class="col-lg-8">
          <div class="section-label text-dark">Ready for service?</div>
          <h2>SCHEDULE YOUR<br/>APPOINTMENT.</h2>
        </div>
        <div class="col-lg-4">
          <p>Most common tire needs can be handled promptly. Contact the shop for availability and a quote.</p>
          <div class="d-flex gap-2">
            <a class="dark-btn" href="{{ route('contact') }}">Book Online</a>
            <a class="dark-btn" href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">Call Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="difference-section content-section inner-about" id="about">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row g-5 align-items-end">
        <div class="col-lg-6">
          <div class="micro-label reveal">ABOUT MUKOH TIRES</div>
          <h2 class="section-title xl reveal">LOCAL SERVICE.<br/><span>REAL VALUE.</span></h2>
        </div>
        <div class="col-lg-6">
          <div class="difference-list">
            <div class="difference-row reveal">
              <span>01</span>
              <div>
                <h3>Quality Tire Selection</h3>
                <p>New and used tire options matched to your vehicle, your budget and your driving needs.</p>
              </div>
            </div>
            <div class="difference-row reveal">
              <span>02</span>
              <div>
                <h3>Fast Professional Service</h3>
                <p>Mounting, balancing, repair and inspection handled carefully so you get back on the road quickly.</p>
              </div>
            </div>
            <div class="difference-row reveal">
              <span>03</span>
              <div>
                <h3>Honest Local Support</h3>
                <p>Straightforward help, competitive pricing and a team focused on practical solutions.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="stats-grid mt-5 pt-4">
        <div class="stat reveal">
          <strong data-count="{{ $settings['stat_years'] ?? '15' }}">0</strong><span>+</span>
          <p>Years Experience</p>
        </div>
        <div class="stat reveal">
          <strong data-count="{{ $settings['stat_customers'] ?? '10' }}">0</strong><span>K+</span>
          <p>Happy Customers</p>
        </div>
        <div class="stat reveal">
          <strong data-count="{{ $settings['stat_brands'] ?? '50' }}">0</strong><span>+</span>
          <p>Tire Brands</p>
        </div>
        <div class="stat reveal">
          <strong data-count="{{ $settings['stat_rating'] ?? '4.9' }}">0</strong><span>/5</span>
          <p>Customer Rating</p>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
