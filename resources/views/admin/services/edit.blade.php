@extends('admin.layouts.app')

@section('title', 'Edit Service: ' . $service->title)
@section('header-title', 'Edit Service')
@section('header-subtitle', 'Update service specifications, descriptions, and pricing')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-pencil-square me-2 text-primary"></i> Edit Service: {{ $service->title }}</span>
        <span class="badge bg-secondary">ID #{{ $service->id }}</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Service Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $service->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Starting Price Tag</label>
                    <input type="text" name="price_starting_at" class="form-control @error('price_starting_at') is-invalid @enderror" value="{{ old('price_starting_at', $service->price_starting_at) }}" placeholder="e.g. $49.99">
                    @error('price_starting_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price Subtext</label>
                    <input type="text" name="price_subtext" class="form-control" value="{{ old('price_subtext', $service->price_subtext) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                </div>

                <div class="col-12">
                    <label class="form-label">Short Summary (Visible on Home & Services Cards)</label>
                    <textarea name="short_description" rows="2" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $service->short_description) }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Full Technical Description</label>
                    <textarea name="full_description" rows="4" class="form-control">{{ old('full_description', $service->full_description) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Included Service Checklist / Features (One per line)</label>
                    @php
                        $featuresText = is_array($service->features) ? implode("\n", $service->features) : $service->features;
                    @endphp
                    <textarea name="features" rows="4" class="form-control">{{ old('features', $featuresText) }}</textarea>
                    <small class="text-secondary">Enter each key service item on a new line</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Action Text</label>
                    <input type="text" name="action_text" class="form-control" value="{{ old('action_text', $service->action_text) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Action Link</label>
                    <input type="text" name="action_link" class="form-control" value="{{ old('action_link', $service->action_link) }}">
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible to Public</label>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> Update Service</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
