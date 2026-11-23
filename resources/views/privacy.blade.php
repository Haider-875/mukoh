@extends('layouts.app')

@section('title', 'Privacy Policy | Mukoh Tires LLC')
@section('meta_description', 'Privacy Policy for Mukoh Tires LLC.')
@section('body_class', 'inner-page')

@section('content')
<main>
  <section class="page-hero legal-hero">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="breadcrumb-line">
        <a href="{{ route('home') }}">Home</a><b>/</b>Privacy Policy
      </div>
      <div class="page-kicker">Your Privacy</div>
      <h1 class="page-title">PRIVACY POLICY.</h1>
      <p class="page-lead">This page explains how basic website inquiries and contact information are handled.</p>
    </div>
  </section>

  <section class="section-pad legal-page">
    <div class="container-fluid px-3 px-md-4 px-xl-5">
      <div class="legal-shell">
        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">Information We Receive</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">When you contact Mukoh Tires by form, phone or email, you may provide your name, contact details, vehicle information and details about the service you are requesting.</p>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">We may also receive standard technical information from your browser or hosting provider, such as device type and basic usage data.</p>
        </section>

        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">How We Use Information</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">Information is used to respond to inquiries, schedule requested services, provide quotes, improve the website and support normal business operations.</p>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">We do not sell personal information to advertisers.</p>
        </section>

        <section class="legal-block mb-5">
          <h2 class="inner-title mb-3" style="font-size:26px;">Third-Party Services</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">This site may link to services such as Google Maps, email applications and telephone services. Those services operate under their own privacy policies.</p>
        </section>

        <section class="legal-block">
          <h2 class="inner-title mb-3" style="font-size:26px;">Contact</h2>
          <p class="text-secondary" style="font-size:15px;line-height:1.75;">
            Questions about this policy can be sent to <a href="mailto:{{ $settings['email'] ?? 'mukohtires@gmail.com' }}" class="text-danger">{{ $settings['email'] ?? 'mukohtires@gmail.com' }}</a> or discussed by calling <a href="tel:{{ $settings['phone_raw'] ?? '+12408540273' }}" class="text-danger">{{ $settings['phone_display'] ?? '(240) 854-0273' }}</a>.
          </p>
        </section>
      </div>
    </div>
  </section>
</main>
@endsection
