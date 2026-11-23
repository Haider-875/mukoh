@extends('layouts.app')

@section('title', 'Contact | Mukoh Tires LLC')
@section('meta_description', 'Book a tire appointment or contact Mukoh Tires in Baltimore, Maryland.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>Contact
      </div>
      <div class="page-hero-grid">
        <div class="page-hero-main">
          <div class="page-kicker">Get In Touch</div>
          <h1 class="page-title">CONTACT<br/><span>US.</span></h1>
        </div>
        <div class="page-hero-aside">
          <p class="page-lead">
            Ready to schedule tire service? Send your details through the form or contact us directly. We aim to respond to appointment requests promptly.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Appointment & Contact Layout -->
  <section class="section-pad">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="contact-layout">

        <!-- Appointment Form with Celebratory AJAX Submission -->
        <form class="form-card" id="appointmentForm" action="{{ route('contact.appointment') }}" method="POST" data-ajax-form>
          @csrf
          <h2>BOOK AN APPOINTMENT</h2>
          <p>Fill out the form below and we'll confirm availability for your preferred appointment time.</p>

          <!-- 1. Personal Information -->
          <div class="form-section">
            <h3>Personal Information</h3>
            <div class="form-grid">
              <div class="field">
                <label for="first">First Name *</label>
                <input id="first" name="first" placeholder="John" required type="text"/>
              </div>
              <div class="field">
                <label for="last">Last Name *</label>
                <input id="last" name="last" placeholder="Doe" required type="text"/>
              </div>
              <div class="field">
                <label for="email">Email *</label>
                <input id="email" name="email" placeholder="john@example.com" required type="email"/>
              </div>
              <div class="field">
                <label for="phone">Phone *</label>
                <input id="phone" name="phone" placeholder="(123) 456-7890" required type="tel"/>
              </div>
            </div>
          </div>

          <!-- 2. Service Required -->
          <div class="form-section">
            <h3>Service Required</h3>
            <div class="form-grid">
              <div class="field full">
                <label for="service">Select Service *</label>
                <select id="service" name="service" required>
                  <option value="">Choose a service</option>
                  <option value="New Tires" {{ request('service') == 'New Tires' ? 'selected' : '' }}>New Tires</option>
                  <option value="Used Tires" {{ request('service') == 'Used Tires' ? 'selected' : '' }}>Used Tires</option>
                  <option value="Tire Installation" {{ request('service') == 'Tire Installation' ? 'selected' : '' }}>Tire Installation</option>
                  <option value="Wheel Balancing" {{ request('service') == 'Wheel Balancing' ? 'selected' : '' }}>Wheel Balancing</option>
                  <option value="Tire Repair" {{ request('service') == 'Tire Repair' ? 'selected' : '' }}>Tire Repair</option>
                  <option value="Tire Rotation" {{ request('service') == 'Tire Rotation' ? 'selected' : '' }}>Tire Rotation</option>
                  <option value="Safety Inspection" {{ request('service') == 'Safety Inspection' ? 'selected' : '' }}>Safety Inspection</option>
                </select>
              </div>
            </div>
          </div>

          <!-- 3. Vehicle Information -->
          <div class="form-section">
            <h3>Vehicle Information</h3>
            <div class="form-grid">
              <div class="field">
                <label for="type">Vehicle Type</label>
                <select id="type" name="type">
                  <option value="">Select type</option>
                  <option value="Passenger Car">Passenger Car</option>
                  <option value="SUV">SUV</option>
                  <option value="Truck">Truck</option>
                  <option value="Van">Van</option>
                </select>
              </div>
              <div class="field">
                <label for="year">Year</label>
                <input id="year" name="year" inputmode="numeric" placeholder="2023" type="text"/>
              </div>
              <div class="field">
                <label for="make">Make</label>
                <input id="make" name="make" placeholder="Toyota" type="text"/>
              </div>
              <div class="field">
                <label for="model">Model</label>
                <input id="model" name="model" placeholder="Camry" type="text"/>
              </div>
              <div class="field full">
                <label for="size">Tire Size (if known)</label>
                <input id="size" name="size" placeholder="205/55R16" type="text"/>
              </div>
            </div>
          </div>

          <!-- 4. Preferred Appointment Date & Time -->
          <div class="form-section">
            <h3>Preferred Appointment</h3>
            <div class="form-grid">
              <div class="field">
                <label for="date">Preferred Date *</label>
                <input id="date" name="date" required type="date" min="{{ date('Y-m-d') }}"/>
              </div>
              <div class="field">
                <label for="time">Preferred Time *</label>
                <select id="time" name="time" required>
                  <option value="">Select time</option>
                  <option value="Morning">Morning (8:00 AM - 12:00 PM)</option>
                  <option value="Afternoon">Afternoon (12:00 PM - 4:00 PM)</option>
                  <option value="Evening">Evening (4:00 PM - 7:30 PM)</option>
                </select>
              </div>
            </div>
          </div>

          <!-- 5. Additional Information -->
          <div class="form-section">
            <h3>Additional Information</h3>
            <div class="form-grid">
              <div class="field full">
                <label for="message">Message (Optional)</label>
                <textarea id="message" name="message" placeholder="Tell us anything else we should know..."></textarea>
              </div>
            </div>
          </div>

          <button class="submit-btn" type="submit">Request Appointment ↗</button>
          <div class="form-note">
            By submitting this form, you agree to be contacted regarding your appointment request.
          </div>
        </form>

        <!-- Aside Contact Info Stack -->
        <aside class="contact-stack">
          <div class="contact-card">
            <div class="contact-card-head">
              <span class="contact-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.9a2 2 0 0 1-.5 2.1L8 10a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.9.6 2.9.7a2 2 0 0 1 1.7 2z"></path></svg>
              </span>
              <div>
                <small>Phone</small>
                <strong>{{ $settings['phone_display'] ?? '(240) 854-0273' }}</strong>
                <a href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">Call Now ↗</a>
              </div>
            </div>
          </div>

          <div class="contact-card">
            <div class="contact-card-head">
              <span class="contact-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect height="14" rx="1" width="18" x="3" y="5"></rect><path d="m3 7 9 6 9-6"></path></svg>
              </span>
              <div>
                <small>Email</small>
                <strong>{{ $settings['email'] ?? 'mukohtires@gmail.com' }}</strong>
                <a href="mailto:{{ $settings['email'] ?? 'mukohtires@gmail.com' }}?subject=Mukoh%20Tires%20Website%20Inquiry">Send Email ↗</a>
              </div>
            </div>
          </div>

          <div class="contact-card">
            <div class="contact-card-head">
              <span class="contact-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0z"></path><circle cx="12" cy="10" r="2.5"></circle></svg>
              </span>
              <div>
                <small>Location</small>
                <strong>{!! nl2br(e($settings['address'] ?? "3415 Berwyn Ave,\nBaltimore, MD 21207")) !!}</strong>
                <a href="{{ $settings['maps_directions_url'] ?? 'https://www.google.com/maps/dir/?api=1&destination=3415+Berwyn+Ave%2C+Baltimore%2C+MD+21207' }}" rel="noopener" target="_blank">Get Directions ↗</a>
              </div>
            </div>
          </div>

          <div class="contact-card">
            <div class="contact-card-head">
              <span class="contact-icon">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg>
              </span>
              <div>
                <small>Hours</small>
                <strong>Monday – Sunday<br/>{{ $settings['business_hours'] ?? '8:00 AM – 7:30 PM' }}</strong>
              </div>
            </div>
          </div>

          <div class="tips">
            <h3>Helpful Tips</h3>
            <ul>
              <li>Bring your tire size if you know it</li>
              <li>Arrive a few minutes before your time</li>
              <li>Ask about available warranty options</li>
              <li>Call ahead for same-day availability</li>
            </ul>
          </div>
        </aside>

      </div>
    </div>
  </section>

  <!-- Interactive Map Section -->
  <section class="section-pad section-soft">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="section-label">Find us</div>
      <h2 class="inner-title">EASY TO <span>REACH.</span></h2>

      <div class="map-card mt-4">
        <iframe allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="{{ $settings['maps_embed_url'] ?? 'https://www.google.com/maps?q=3415%20Berwyn%20Ave%2C%20Baltimore%2C%20MD%2021207&output=embed' }}" title="Mukoh Tires location map"></iframe>
        <div class="map-overlay">
          <div>
            <small>FIND US</small>
            <h3>Mukoh Tires LLC</h3>
            <p>{{ $settings['address'] ?? '3415 Berwyn Ave, Baltimore, MD 21207' }}</p>
          </div>
          <a class="map-action" href="{{ $settings['maps_directions_url'] ?? 'https://www.google.com/maps/dir/?api=1&destination=3415+Berwyn+Ave%2C+Baltimore%2C+MD+21207' }}" rel="noopener" target="_blank">
            Open in Google Maps ↗
          </a>
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
              <b>↗</b>
            </div>
            <div class="difference-row reveal">
              <span>02</span>
              <div>
                <h3>Fast Professional Service</h3>
                <p>Mounting, balancing, repair and inspection handled carefully so you get back on the road quickly.</p>
              </div>
              <b>↗</b>
            </div>
            <div class="difference-row reveal">
              <span>03</span>
              <div>
                <h3>Honest Local Support</h3>
                <p>Straightforward help, competitive pricing and a team focused on practical solutions.</p>
              </div>
              <b>↗</b>
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
