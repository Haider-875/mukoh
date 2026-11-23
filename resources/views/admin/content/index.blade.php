@extends('admin.layouts.app')

@section('title', 'Website Content Management')
@section('header-title', 'Website Content & Settings')
@section('header-subtitle', 'Manage hero text, contact info, business hours, and site metadata')

@section('content')
<div class="card">
    <div class="card-header p-0 border-bottom border-secondary">
        <ul class="nav nav-tabs border-0" id="contentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-0 text-white border-0 py-3 px-4" id="general-tab" data-bs-toggle="tab" data-bs-target="#tab-general" type="button" role="tab"><i class="bi bi-gear me-2"></i>General & Branding</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 text-white border-0 py-3 px-4" id="hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button" role="tab"><i class="bi bi-display me-2"></i>Hero & 3D Settings</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 text-white border-0 py-3 px-4" id="contact-tab" data-bs-toggle="tab" data-bs-target="#tab-contact" type="button" role="tab"><i class="bi bi-telephone me-2"></i>Contact & Hours</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 text-white border-0 py-3 px-4" id="about-tab" data-bs-toggle="tab" data-bs-target="#tab-about" type="button" role="tab"><i class="bi bi-info-circle me-2"></i>About & Statistics</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 text-white border-0 py-3 px-4" id="sound-tab" data-bs-toggle="tab" data-bs-target="#tab-sound" type="button" role="tab"><i class="bi bi-volume-up me-2"></i>Sound & Audio</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-0 text-white border-0 py-3 px-4" id="seo-tab" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab"><i class="bi bi-search me-2"></i>SEO & Social</button>
            </li>
        </ul>
    </div>

    <form action="{{ route('admin.content.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body p-4">
            <div class="tab-content" id="contentTabsContent">
                <!-- General Tab -->
                <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-building me-2 text-primary"></i>Company Branding & Info</h5>
                    <div class="row g-3">
                        @foreach($settings->get('general', collect()) as $setting)
                            <div class="col-md-6">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $setting->key }}" rows="3" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                                @elseif($setting->type === 'boolean')
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value ? 'checked' : '' }}>
                                        <label class="form-check-label">Enabled</label>
                                    </div>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Hero Tab -->
                <div class="tab-pane fade" id="tab-hero" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-camera-reels me-2 text-primary"></i>Homepage Hero & Three.js 3D Controls</h5>
                    <div class="row g-3">
                        @foreach($settings->get('hero', collect()) as $setting)
                            <div class="{{ in_array($setting->type, ['textarea']) ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $setting->key }}" rows="3" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                                @elseif($setting->type === 'boolean')
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value ? 'checked' : '' }}>
                                        <label class="form-check-label">Enabled</label>
                                    </div>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Tab -->
                <div class="tab-pane fade" id="tab-contact" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Business Address, Phone & Working Hours</h5>
                    <div class="row g-3">
                        @foreach($settings->get('contact', collect()) as $setting)
                            <div class="{{ in_array($setting->type, ['textarea']) ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $setting->key }}" rows="3" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                                @elseif($setting->type === 'boolean')
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value ? 'checked' : '' }}>
                                        <label class="form-check-label">Enabled</label>
                                    </div>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- About Tab -->
                <div class="tab-pane fade" id="tab-about" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>About Section & Homepage Counter Metrics</h5>
                    <div class="row g-3">
                        @foreach($settings->get('about', collect()) as $setting)
                            <div class="{{ in_array($setting->type, ['textarea']) ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $setting->key }}" rows="3" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sound Tab -->
                <div class="tab-pane fade" id="tab-sound" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-soundwave me-2 text-primary"></i>Interactive Sound Effects (Web Audio API)</h5>
                    <div class="row g-3">
                        @foreach($settings->get('sound', collect()) as $setting)
                            <div class="col-md-6">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'boolean')
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value ? 'checked' : '' }}>
                                        <label class="form-check-label">Enabled by default</label>
                                    </div>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- SEO Tab -->
                <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                    <h5 class="text-white mb-3"><i class="bi bi-google me-2 text-primary"></i>Search Engine Optimization & Social Media</h5>
                    <div class="row g-3">
                        @foreach($settings->get('seo', collect()) as $setting)
                            <div class="{{ in_array($setting->type, ['textarea']) ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label">{{ $setting->label }}</label>
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $setting->key }}" rows="3" class="form-control">{{ old($setting->key, $setting->value) }}</textarea>
                                @else
                                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ old($setting->key, $setting->value) }}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end p-3">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Save Content Changes</button>
        </div>
    </form>
</div>
@endsection
