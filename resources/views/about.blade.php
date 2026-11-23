@extends('layouts.app')

@section('title', 'About Us | Mukoh Tires LLC')
@section('meta_description', 'Learn about Mukoh Tires LLC - local tire service, expert technicians, and honest value in Baltimore, MD.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>About
      </div>
      <div class="page-hero-grid">
        <div class="page-hero-main">
          <div class="page-kicker">Who We Are</div>
          <h1 class="page-title">LOCAL SERVICE.<br/><span>REAL VALUE.</span></h1>
        </div>
        <div class="page-hero-aside">
          <p class="page-lead">
            Mukoh Tires LLC is your trusted community automotive tire specialist in Baltimore, Maryland. We deliver dependable new and pre-owned tires, certified installation, computer wheel balancing, and professional repairs with honest pricing and fast turnaround.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- About Company Narrative Section -->
  <section class="section-pad section-dark">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <div class="section-label">Our Mission</div>
          <h2 class="inner-title">KEEPING YOU SAFE ON <span>EVERY ROAD.</span></h2>
          <p class="section-copy text-secondary mt-4" style="font-size:15px;line-height:1.75;">
            At Mukoh Tires, we believe that high-quality tires and expert installation shouldn't come with exorbitant price tags or long waiting times. Whether you need a single replacement tire to get through the month or a full set of premium ultra-high performance tires for the track or highway, our technicians provide straightforward advice and meticulous craftsmanship.
          </p>
          <p class="section-copy text-secondary mt-3" style="font-size:15px;line-height:1.75;">
            Every tire in our shop—both new and inspected pre-owned—undergoes rigorous inspection for tread depth, bead integrity, and sidewall safety before it is fitted to your vehicle.
          </p>
        </div>

        <div class="col-lg-6">
          <div class="cap-panel glass p-4">
            <div class="cap-row">
              <span class="num">01</span>
              <div>
                <h3>Safety First Approach</h3>
                <p>We treat every wheel mounting and balancing with the highest safety standards to protect you and your family.</p>
              </div>
            </div>
            <div class="cap-row">
              <span class="num">02</span>
              <div>
                <h3>No Hidden Charges</h3>
                <p>Transparent upfront quotes on all new tires, used tires, valve services, and disposal fees.</p>
              </div>
            </div>
            <div class="cap-row">
              <span class="num">03</span>
              <div>
                <h3>State-Of-The-Art Equipment</h3>
                <p>Precision computerized wheel balancing and rim-guard tire changers to safeguard your alloy wheels.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Difference Section -->
  <section class="difference-section content-section inner-about" id="about">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row g-5 align-items-end">
        <div class="col-lg-6">
          <div class="micro-label reveal">ABOUT MUKOH TIRES</div>
          <h2 class="section-title xl reveal">THE MUKOH<br/><span>ADVANTAGE.</span></h2>
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

      <!-- Animated Stats Grid -->
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

  <!-- Inner CTA Section -->
  <section class="inner-cta">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row align-items-end g-4">
        <div class="col-lg-8">
          <div class="section-label text-dark">Ready to experience the difference?</div>
          <h2>SCHEDULE YOUR<br/>APPOINTMENT TODAY.</h2>
        </div>
        <div class="col-lg-4">
          <p>Stop by our shop or schedule an appointment in advance. Walk-ins are always welcome!</p>
          <div class="d-flex gap-2">
            <a class="dark-btn" href="{{ route('contact') }}">Book Online ↗</a>
            <a class="dark-btn" href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">Call Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
