@extends('layouts.app')

@section('title', 'Terms of Service | Mukoh Tires LLC')
@section('meta_description', 'Terms of Service for Mukoh Tires LLC.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <section class="page-hero legal-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>Terms of Service
      </div>
      <div class="page-kicker">Terms & Conditions</div>
      <h1 class="page-title">TERMS OF SERVICE.</h1>
      <p class="page-lead">Standard terms of service for Mukoh Tires LLC website use and appointments.</p>
    </div>
  </section>

  <section class="section-pad legal-page">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="legal-shell">
        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">General Website Terms</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">The information provided on this website is for general informational and scheduling purposes. Tire availability, pricing, and service turnaround times are subject to change based on in-shop inventory and vehicle condition.</p>
        </section>

        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">Appointments & Estimates</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">Online appointment requests and quotes submitted through this website do not constitute a binding contract until confirmed by our shop technicians. We reserve the right to verify vehicle specifications and tire fitment prior to performing installation or balancing.</p>
        </section>

        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">Used Tire Conditions</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">All used tires are inspected for roadworthiness and tread depth prior to sale. Used tires are sold with standard inspection guarantees as outlined at time of service.</p>
        </section>

        <section class="legal-block">
          <h2 class="inner-title mb-3" style="font-size:26px;">Questions & Inquiries</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">
            If you have questions regarding our terms, please contact us at <a href="mailto:{{ $settings['email'] ?? 'mukohtires@gmail.com' }}" class="text-danger">{{ $settings['email'] ?? 'mukohtires@gmail.com' }}</a> or call <a href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}" class="text-danger">{{ $settings['phone_display'] ?? '(240) 854-0273' }}</a>.
          </p>
        </section>
      </div>
    </div>
  </section>
</main>
@endsection
