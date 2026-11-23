@extends('admin.layouts.app')

@section('title', 'Add New Tire Product')
@section('header-title', 'Add Tire Product')
@section('header-subtitle', 'Create a new tire product entry for the catalog')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2 text-primary"></i> Tire Product Details
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Mukoh UltraGrip Sport X" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', 'MUKOH') }}" required>
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Size <span class="text-danger">*</span></label>
                    <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" placeholder="e.g. 245/45 R19" required>
                    @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Condition <span class="text-danger">*</span></label>
                    <select name="condition" class="form-select @error('condition') is-invalid @enderror" required>
                        <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>Brand New</option>
                        <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Certified Used</option>
                    </select>
                    @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Badge Label</label>
                    <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge') }}" placeholder="e.g. Best Seller, Top Rated, High Grip">
                    @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="199.99" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Original Price ($)</label>
                    <input type="number" step="0.01" name="original_price" class="form-control @error('original_price') is-invalid @enderror" value="{{ old('original_price') }}" placeholder="239.99">
                    @error('original_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Price Unit</label>
                    <input type="text" name="price_unit" class="form-control" value="{{ old('price_unit', '/ea') }}" placeholder="/ea or /set">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Warranty Info</label>
                    <input type="text" name="warranty" class="form-control" value="{{ old('warranty', '60,000 Miles Warranty') }}" placeholder="e.g. 50,000 Miles Limited">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Upload Product Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-secondary">Upload PNG/JPG/WebP file</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Or Image URL</label>
                    <input type="url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url') }}" placeholder="https://...">
                    @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Describe tire capabilities, tread pattern design, wet/dry grip...">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Features / Specifications (One per line)</label>
                    <textarea name="features" rows="4" class="form-control" placeholder="Adaptive Asymmetric Tread Pattern
Silica-Infused Polymer Compound
4 Longitudinal Evacuation Grooves
Reinforced Twin Steel Belts">{{ old('features') }}</textarea>
                    <small class="text-secondary">Enter each key highlight or spec on a new line</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>

                <div class="col-md-8 d-flex align-items-end gap-4 pb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured on Homepage</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible</label>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> Save Tire Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
