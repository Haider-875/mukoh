@extends('layouts.app')

@section('title', $settings['meta_title'] ?? 'Mukoh Tires LLC | Quality Tires You Can Trust')
@section('meta_description', $settings['meta_description'] ?? 'Mukoh Tires LLC quality new and used tires, installation, balancing, repair and inspections.')
@section('is_home', true)

@section('content')

  <!-- Page Startup Loader -->
  <div aria-live="polite" class="page-loader" id="loader">
    <div class="loader-mark">M</div>
    <div class="loader-copy">LOADING ROAD EXPERIENCE <span id="loadPercent">0%</span></div>
    <div class="loader-track"><span id="loaderBar"></span></div>
  </div>

  <!-- 3D Real-Time PBR Canvas Stage -->
  <div aria-hidden="true" class="frame-stage" id="frameStage">
    <canvas id="frameCanvas"></canvas>
    <div class="frame-vignette"></div>
  </div>

  <main>
    <!-- 1. Hero Section -->
    <section class="hero-section scrub-section" id="home">
      <div class="container-fluid section-shell px-3 px-md-4 px-xl-5">
        <div class="hero-top d-flex flex-column flex-sm-row justify-content-between gap-4">
          <div class="service-kicker reveal-group">
            <span class="reveal" style="--delay:120ms">/ {{ $settings['hero_kicker_1'] ?? 'NEW & USED TIRES' }}</span>
            <span class="reveal" style="--delay:220ms">/ {{ $settings['hero_kicker_2'] ?? 'INSTALLATION & BALANCING' }}</span>
            <span class="reveal" style="--delay:320ms">/ {{ $settings['hero_kicker_3'] ?? 'TIRE REPAIR & INSPECTION' }}</span>
          </div>
          <p class="hero-intro reveal" style="--delay:260ms">
            {{ $settings['hero_intro'] ?? 'Professional tire service built around safety, speed and honest value for every road you take.' }}
          </p>
        </div>

        <div class="hero-bottom row align-items-end g-4">
          <div class="col-lg-8">
            <div class="eyebrow-badge reveal" style="--delay:120ms">
              <span></span> {{ $settings['hero_eyebrow'] ?? 'PROFESSIONAL TIRE SERVICES' }}
            </div>
            <h1 class="display-title reveal" style="--delay:260ms">
              {{ $settings['hero_title_line1'] ?? 'QUALITY.' }}<br/>
              {{ $settings['hero_title_line2'] ?? 'TIRES.' }}<br/>
              <em>{{ $settings['hero_title_emphasis'] ?? 'YOU CAN TRUST.' }}</em>
            </h1>
          </div>

          <div class="col-lg-4 d-flex justify-content-lg-end">
            <div class="quick-card glass reveal" style="--delay:420ms">
              <div class="quick-card-icon">24</div>
              <div>
                <div class="micro-label">QUICK SERVICE</div>
                <h3>{{ $settings['hero_quick_title'] ?? 'Get back on the road.' }}</h3>
                <p>{{ $settings['hero_quick_copy'] ?? 'New and used tires from practical everyday options to premium road ready setups.' }}</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                  <a class="btn btn-light-pill" href="{{ route('tires') }}">View Tires</a>
                  <a class="btn btn-glass-pill" href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">Call Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="scroll-cue"><span>SCROLL TO EXPLORE</span><i></i></div>
    </section>

    <!-- Scrub Spacer for 3D experience transition -->
    <div aria-hidden="true" class="scrub-spacer"></div>

    <!-- 2. Capability / Engineering Section -->
    <section class="capability-section scrub-section" id="tires">
      <div class="container-fluid section-shell px-3 px-md-4 px-xl-5">
        <div class="cap-top d-flex flex-column flex-sm-row justify-content-between gap-4">
          <div class="eyebrow-badge reveal" style="--delay:120ms">
            <span></span> {{ $settings['cap_eyebrow'] ?? 'BUILT FROM THE INSIDE OUT' }}
          </div>
          <p class="hero-intro reveal" style="--delay:220ms">
            {{ $settings['cap_intro'] ?? 'Every layer matters. Our tire selection is chosen for dependable grip, strong construction and confident everyday performance.' }}
          </p>
        </div>

        <div class="row align-items-end mt-auto g-4 g-xl-5">
          <div class="col-lg-7">
            <h2 class="display-title reveal" style="--delay:180ms">
              {{ $settings['cap_title_line1'] ?? 'ENGINEERED FOR' }}<br/>
              <em>{{ $settings['cap_title_emphasis'] ?? 'EVERY ROAD.' }}</em>
            </h2>
            <p class="section-copy reveal" style="--delay:300ms">
              {{ $settings['cap_description'] ?? 'From budget friendly used tires to all season and all terrain options, Mukoh helps match the tire to your vehicle, driving style and budget.' }}
            </p>
            <div class="d-flex flex-wrap gap-2 mt-4 reveal" style="--delay:410ms">
              <a class="btn btn-light-pill" href="{{ route('tires') }}">Browse Tires</a>
              <button class="btn btn-glass-pill quote-main-link" type="button">Get a Quote</button>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="cap-panel glass reveal" style="--delay:260ms">
              <div class="cap-row">
                <span class="num">01</span>
                <div>
                  <h3>Road Grip</h3>
                  <p>Tread patterns selected for stable contact and dependable traction.</p>
                </div>
              </div>
              <div class="cap-row">
                <span class="num">02</span>
                <div>
                  <h3>Layered Strength</h3>
                  <p>Internal structure designed to manage load, impact and daily road stress.</p>
                </div>
              </div>
              <div class="cap-row">
                <span class="num">03</span>
                <div>
                  <h3>Right Fit</h3>
                  <p>Options across common sizes and vehicle types, with practical guidance.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. Services Section -->
    <section class="content-section services-section" id="services">
      <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="section-head row g-4 align-items-end">
          <div class="col-lg-8">
            <div class="micro-label reveal">WHAT WE OFFER</div>
            <h2 class="section-title reveal">OUR <span>SERVICES</span></h2>
          </div>
          <div class="col-lg-4">
            <p class="muted-copy reveal">Everything your tires need, handled in one place with a focus on safety, efficiency and value.</p>
          </div>
        </div>

        <div class="row g-3 g-xl-4 mt-4">
          @foreach($services as $index => $srv)
            <div class="col-md-6 col-xl-3">
              <article class="service-card tilt-card reveal">
                <span class="num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="service-image transparent-service-visual">
                  <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 64 64">
                    <circle cx="32" cy="32" r="21"></circle>
                    <circle cx="32" cy="32" r="8"></circle>
                    <path d="M32 11v8M32 45v8M11 32h8M45 32h8M17 17l6 6M41 41l6 6M47 17l-6 6M23 41l-6 6"></path>
                  </svg>
                </div>
                <h3>{{ $srv->title }}</h3>
                <p>{{ $srv->short_description }}</p>
                <a href="{{ $srv->action_link }}" class="service-card-btn">
                  {{ trim(str_replace(['↗', '→'], '', $srv->action_text ?? 'EXPLORE SERVICE')) }}
                </a>
              </article>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- 4. Featured Tires Section -->
    <section class="content-section featured-section" id="featured">
      <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="section-head d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
          <div>
            <div class="micro-label reveal">TOP PICKS</div>
            <h2 class="section-title reveal">FEATURED <span>TIRES</span></h2>
          </div>
          <button class="text-link quote-main-link reveal border-0 bg-transparent text-dark p-0" type="button">GET A QUOTE</button>
        </div>

        <div class="product-grid mt-5">
          @foreach($featuredProducts as $product)
            <article class="product-card reveal">
              <div class="product-visual photo-visual">
                @if($product->image)
                  <img alt="{{ $product->name }}" decoding="async" loading="lazy" src="{{ $product->image }}"/>
                @else
                  <div class="tire-orbit">
                    <div class="ring ring-a"></div>
                    <div class="ring ring-b"></div>
                    <div class="tire-css {{ $product->category_slug }}"></div>
                  </div>
                @endif
              </div>

              @if($product->badge)
                <div class="product-tag">{{ $product->badge }}</div>
              @endif

              <div class="product-brand">{{ $product->brand }}</div>
              <h3>{{ $product->name }}</h3>

              @if(!empty($product->features))
                <ul>
                  @foreach($product->features as $feat)
                    <li>{{ $feat }}</li>
                  @endforeach
                </ul>
              @endif

              <div class="price-row">
                <span>FROM</span>
                <strong>${{ number_format($product->price, 0) }}</strong>
                <button class="quote-button border-0 bg-transparent" type="button">GET QUOTE</button>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <!-- 5. Difference Section / About -->
    <section class="difference-section content-section" id="about">
      <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="row g-5 align-items-end">
          <div class="col-lg-6">
            <div class="micro-label reveal">WHY MUKOH TIRES</div>
            <h2 class="section-title xl reveal">EXPERIENCE<br/><span>THE DIFFERENCE</span></h2>
          </div>
          <div class="col-lg-6">
            <div class="difference-list">
              <div class="difference-row reveal">
                <span>01</span>
                <div>
                  <h3>Expert Technicians</h3>
                  <p>Experienced hands focused on doing the job correctly and efficiently.</p>
                </div>
              </div>
              <div class="difference-row reveal">
                <span>02</span>
                <div>
                  <h3>Competitive Pricing</h3>
                  <p>Useful choices across price points without losing sight of safety.</p>
                </div>
              </div>
              <div class="difference-row reveal">
                <span>03</span>
                <div>
                  <h3>Fast Turnaround</h3>
                  <p>Service designed to get you moving again with less waiting.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Animated Stats Counter Grid -->
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

    <!-- 6. Testimonials Section -->
    <section class="content-section testimonials-section">
      <div class="container-fluid px-3 px-md-4 px-xl-5">
        <div class="micro-label reveal testimonial-label">TESTIMONIALS</div>
        <h2 class="section-title reveal">WHAT <span>CUSTOMERS SAY</span></h2>

        <div class="row g-3 mt-4">
          @foreach($testimonials as $test)
            <div class="col-md-6 col-xl-4">
              <blockquote class="quote-card reveal">
                <div class="stars">★★★★★</div>
                <p>“{{ $test->content }}”</p>
                <footer>{{ $test->author_name }}</footer>
              </blockquote>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- 7. CTA Section -->
    <section class="cta-section" id="contact">
      <div aria-hidden="true" class="cta-marquee">
        <div>READY FOR THE ROAD • READY FOR THE ROAD • READY FOR THE ROAD •&nbsp;</div>
        <div>READY FOR THE ROAD • READY FOR THE ROAD • READY FOR THE ROAD •&nbsp;</div>
      </div>
      <div class="container-fluid px-3 px-md-4 px-xl-5 cta-inner">
        <div class="row g-4 align-items-end">
          <div class="col-lg-8">
            <div class="micro-label reveal">READY TO GET STARTED?</div>
            <h2 class="cta-title reveal">LET'S GET YOU<br/>BACK <em>ON THE ROAD.</em></h2>
          </div>
          <div class="col-lg-4">
            <p class="reveal">Call Mukoh Tires to check availability, ask about sizes or schedule tire service.</p>
            <div class="d-flex flex-wrap gap-2 mt-4 reveal">
              <a class="btn btn-dark-pill" href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}">{{ $settings['phone_display'] ?? '(240) 854-0273' }}</a>
              <a class="btn btn-outline-dark-pill" href="mailto:{{ $settings['email'] ?? 'mukohtires@gmail.com' }}?subject=Mukoh%20Tires%20Website%20Inquiry">Email Us</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection

@push('scripts')
  <!-- Startup Loader Simulation -->
  <script>
    (() => {
      const loader = document.getElementById('loader');
      const loaderBar = document.getElementById('loaderBar');
      const loadPercent = document.getElementById('loadPercent');
      let progress = 0;

      const timer = setInterval(() => {
        progress += Math.floor(Math.random() * 25) + 15;
        if (progress > 100) progress = 100;
        if (loaderBar) loaderBar.style.width = progress + '%';
        if (loadPercent) loadPercent.textContent = progress + '%';

        if (progress >= 100) {
          clearInterval(timer);
          setTimeout(() => {
            if (loader) loader.classList.add('done');
            document.body.classList.add('ready');
          }, 250);
        }
      }, 70);
    })();
  </script>
@endpush
