@extends('admin.layouts.app')

@section('title', 'Add Customer Testimonial')
@section('header-title', 'Add Testimonial')
@section('header-subtitle', 'Add a verified driver review to display on the website')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2 text-primary"></i> Testimonial Details
    </div>
    <div class="card-body">
        <form action="{{ route('admin.testimonials.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Customer / Author Name <span class="text-danger">*</span></label>
                    <input type="text" name="author_name" class="form-control @error('author_name') is-invalid @enderror" value="{{ old('author_name') }}" placeholder="e.g. MARCUS STERLING" required>
                    @error('author_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Star Rating (1 - 5) <span class="text-danger">*</span></label>
                    <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                        <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Stars ★★★★★</option>
                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars ★★★★☆</option>
                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars ★★★☆☆</option>
                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars ★★☆☆☆</option>
                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star ★☆☆☆☆</option>
                    </select>
                    @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="col-12">
                    <label class="form-label">Review Testimonial Text <span class="text-danger">*</span></label>
                    <textarea name="content" rows="4" class="form-control @error('content') is-invalid @enderror" required placeholder="Write the customer's exact review feedback...">{{ old('content') }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible on Website</label>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> Save Testimonial</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
