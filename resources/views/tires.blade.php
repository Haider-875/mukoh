@extends('layouts.app')

@section('title', 'Tires | Mukoh Tires LLC')
@section('meta_description', 'Browse Mukoh Tires new and used tire inventory by vehicle category and condition.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <!-- Page Hero -->
  <section class="page-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>Tires
      </div>
      <div class="page-hero-grid">
        <div class="page-hero-main">
          <div class="page-kicker">Our Inventory</div>
          <h1 class="page-title">NEW &amp; USED<br/><span>TIRES.</span></h1>
        </div>
        <div class="page-hero-aside">
          <p class="page-lead">
            Explore a broad mix of dependable new and pre-owned tires for passenger cars, SUVs, trucks and performance vehicles, with practical options across common sizes and budgets.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories Section -->
  <section class="section-pad section-dark">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="section-label">Shop by category</div>
      <h2 class="inner-title">FIND YOUR <span>FIT.</span></h2>

      <div class="category-grid">
        @foreach($categories as $cat)
          <article class="category-card" style="cursor: pointer;" onclick="filterByCategory('{{ $cat->slug }}')">
            <div class="category-icon proper-icon">
              @if($cat->slug === 'passenger')
                <svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="7" cy="17" r="2.5"></circle><circle cx="17" cy="17" r="2.5"></circle><path d="M3 15l2-6h12l4 6v2h-2M9.5 17h5M6 9l2-3h7l2 3"></path></svg>
              @elseif($cat->slug === 'suv')
                <svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="6.5" cy="17" r="2.5"></circle><circle cx="17.5" cy="17" r="2.5"></circle><path d="M2.5 15V9h4l2-3h7l3 4H22v5.5M9 17h6"></path></svg>
              @elseif($cat->slug === 'performance')
                <svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path d="M4 15c2-5 5-7 9-7h5l3 4-2 4H5z"></path><circle cx="8" cy="17" r="2"></circle><circle cx="17" cy="17" r="2"></circle><path d="M13 8l2-3"></path></svg>
              @else
                <svg fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle><circle cx="12" cy="12" r="3"></circle><path d="M12 4v3M12 17v3M4 12h3M17 12h3M6.3 6.3l2.1 2.1M15.6 15.6l2.1 2.1M17.7 6.3l-2.1 2.1M8.4 15.6l-2.1 2.1"></path></svg>
              @endif
            </div>
            <div class="category-icon">
              <img alt="{{ $cat->name }}" aria-hidden="true" src="{{ asset($cat->icon) }}"/>
            </div>
            <h3>{{ $cat->name }}</h3>
            <p>{{ $cat->description }}</p>
            <small>{{ $cat->count_label }}</small>
          </article>
        @endforeach
      </div>

      <!-- Top Brands Strip -->
      <div class="brand-strip">
        <strong>TOP BRANDS:</strong>
        <span>Michelin</span>
        <span>Goodyear</span>
        <span>Bridgestone</span>
        <span>Continental</span>
        <span>Pirelli</span>
        <span>BFGoodrich</span>
      </div>
    </div>
  </section>

  <!-- Interactive Filter & Inventory Section -->
  <section class="section-pad">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="section-label">Inventory</div>

      <div class="filter-bar">
        <div class="filter-groups-inline">
          <div class="filter-group" data-kind="category">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="passenger">Passenger</button>
            <button class="filter-btn" data-filter="suv">SUV &amp; Truck</button>
            <button class="filter-btn" data-filter="performance">Performance</button>
            <button class="filter-btn" data-filter="terrain">All-Terrain</button>
          </div>
          <div class="filter-group" data-kind="condition">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="new">New</button>
            <button class="filter-btn" data-filter="used">Used</button>
          </div>
        </div>

        <select aria-label="Sort tires" class="sort-select" data-sort="">
          <option value="low">Price: Low to High</option>
          <option value="high">Price: High to Low</option>
        </select>
      </div>

      <div class="results-count" data-results-count="">Showing {{ $tires->count() }} tires</div>

      <div class="tire-grid">
        @foreach($tires as $tire)
          <article class="tire-card no-image-card" data-category="{{ $tire->category_slug }}" data-condition="{{ $tire->condition }}" data-price="{{ (int) $tire->price }}">
            <div class="tire-body">
              <div class="tire-meta">
                <span class="condition">{{ $tire->condition }}</span>
                <span class="brand-name">{{ $tire->brand }}</span>
              </div>
              <h3>{{ $tire->name }}</h3>
              <div class="tire-size">{{ $tire->size }}</div>

              @if(!empty($tire->features))
                <div class="tire-features">
                  @foreach($tire->features as $feat)
                    <span>{{ $feat }}</span>
                  @endforeach
                </div>
              @endif

              <div class="tire-bottom">
                <div class="tire-price">
                  <small>From</small>
                  <strong>${{ number_format($tire->price, 0) }}</strong>{{ $tire->price_unit ?? '/ea' }}
                </div>
                <button class="link-arrow quote-button border-0 bg-transparent p-0" type="button">Quote ↗</button>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Inner CTA Section -->
  <section class="inner-cta">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="row align-items-end g-4">
        <div class="col-lg-8">
          <div class="section-label text-dark">Need another size?</div>
          <h2>CAN'T FIND WHAT<br/>YOU'RE LOOKING FOR?</h2>
        </div>
        <div class="col-lg-4">
          <p>Tell us your vehicle or tire size and our team can help you narrow down a suitable option.</p>
          <div class="d-flex gap-2">
            <a class="dark-btn" href="{{ route('contact') }}">Contact Us ↗</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About & Difference Section -->
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

@push('scripts')
<script>
  function filterByCategory(slug) {
    const btn = document.querySelector(`.filter-group[data-kind="category"] [data-filter="${slug}"]`);
    if (btn) btn.click();
    document.querySelector('.filter-bar')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
</script>
@endpush
