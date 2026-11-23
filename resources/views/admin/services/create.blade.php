@extends('admin.layouts.app')

@section('title', 'Add New Service')
@section('header-title', 'Add Service')
@section('header-subtitle', 'Create a new automotive service offering')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2 text-primary"></i> Service Details
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Service Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g. Precision Wheel Balancing" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Starting Price Tag</label>
                    <input type="text" name="price_starting_at" class="form-control @error('price_starting_at') is-invalid @enderror" value="{{ old('price_starting_at', '$24.99') }}" placeholder="e.g. $49.99">
                    @error('price_starting_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price Subtext</label>
                    <input type="text" name="price_subtext" class="form-control" value="{{ old('price_subtext', 'Starting at') }}" placeholder="e.g. Starting at, Per Axle, Complete Set">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="col-12">
                    <label class="form-label">Short Summary (Visible on Home & Services Cards)</label>
                    <textarea name="short_description" rows="2" class="form-control @error('short_description') is-invalid @enderror" placeholder="Brief summary of what this service covers...">{{ old('short_description') }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Full Technical Description</label>
                    <textarea name="full_description" rows="4" class="form-control" placeholder="Detailed service overview, diagnostic equipment used, tolerances, and technician procedures...">{{ old('full_description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Included Service Checklist / Features (One per line)</label>
                    <textarea name="features" rows="4" class="form-control" placeholder="Laser Diagnostic Runout Check
High-Speed Dynamic Balancing
Corrosion Cleaning on Hub Face
Torqued to Factory OEM Specs">{{ old('features') }}</textarea>
                    <small class="text-secondary">Enter each key service item on a new line</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Action Text</label>
                    <input type="text" name="action_text" class="form-control" value="{{ old('action_text', 'Book ↗') }}" placeholder="e.g. Book ↗ or Request Quote">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Action Link</label>
                    <input type="text" name="action_link" class="form-control" value="{{ old('action_link', '/contact') }}" placeholder="/contact">
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible to Public</label>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> Save Service</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
