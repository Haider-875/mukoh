@php
  // Extract initials
  $parts = explode(' ', trim($item->author_name ?? 'Driver'));
  $initials = '';
  foreach($parts as $p) {
      if (!empty($p)) $initials .= strtoupper($p[0]);
  }
  $initials = substr($initials, 0, 2);
@endphp
<article class="mukoh-review-card">
  <!-- Card Header -->
  <div class="review-card-top d-flex justify-content-between align-items-start gap-2">
    <div class="d-flex align-items-center gap-3">
      <div class="review-avatar">
        <span>{{ $initials }}</span>
      </div>
      <div>
        <div class="review-author d-flex align-items-center gap-1">
          <strong>{{ $item->author_name }}</strong>
          <i class="bi bi-patch-check-fill text-danger review-check" title="Verified Customer"></i>
        </div>
        <div class="review-location text-secondary">
          <i class="bi bi-geo-alt me-1"></i>Baltimore, MD
        </div>
      </div>
    </div>

    <!-- Rating Stars -->
    <div class="review-rating-block text-end">
      <div class="stars-gold">
        @for($s = 0; $s < ($item->rating ?? 5); $s++)
          <i class="bi bi-star-fill"></i>
        @endfor
      </div>
      <div class="rating-badge">
        <span class="rating-num">5.0</span>
        <span class="rating-sub">Google Review</span>
      </div>
    </div>
  </div>

  <!-- Vehicle & Tire Service Pill -->
  @if(!empty($item->vehicle_or_service))
    <div class="review-vehicle-pill">
      <i class="bi bi-car-front-fill me-1 text-danger"></i>
      <span>{{ $item->vehicle_or_service }}</span>
    </div>
  @endif

  <!-- Review Quote Body -->
  <p class="review-body">
    “{{ $item->content }}”
  </p>

  <!-- Card Footer -->
  <div class="review-card-foot d-flex justify-content-between align-items-center">
    <span class="review-verified-badge">
      <i class="bi bi-shield-fill-check text-success me-1"></i>Verified Local Buyer
    </span>
    <span class="review-quote-mark">
      <i class="bi bi-quote"></i>
    </span>
  </div>
</article>
