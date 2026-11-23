@extends('admin.layouts.app')

@section('title', 'Edit Tire Product: ' . $product->name)
@section('header-title', 'Edit Tire Product')
@section('header-subtitle', 'Update specifications, pricing, or media for this tire')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-pencil-square me-2 text-primary"></i> Edit Product: {{ $product->name }}</span>
        <span class="badge bg-secondary">ID #{{ $product->id }}</span>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Brand <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', $product->brand) }}" required>
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Size <span class="text-danger">*</span></label>
                    <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size', $product->size) }}" required>
                    @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Condition <span class="text-danger">*</span></label>
                    <select name="condition" class="form-select @error('condition') is-invalid @enderror" required>
                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>Brand New</option>
                        <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Certified Used</option>
                    </select>
                    @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Badge Label</label>
                    <input type="text" name="badge" class="form-control @error('badge') is-invalid @enderror" value="{{ old('badge', $product->badge) }}" placeholder="e.g. Best Seller, Top Rated, High Grip">
                    @error('badge')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Original Price ($)</label>
                    <input type="number" step="0.01" name="original_price" class="form-control @error('original_price') is-invalid @enderror" value="{{ old('original_price', $product->original_price) }}">
                    @error('original_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Price Unit</label>
                    <input type="text" name="price_unit" class="form-control" value="{{ old('price_unit', $product->price_unit) }}" placeholder="/ea">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Warranty Info</label>
                    <input type="text" name="warranty" class="form-control" value="{{ old('warranty', $product->warranty) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Upload New Image File</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-secondary">Upload PNG/JPG/WebP to replace current image</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Or Image URL</label>
                    <input type="url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url', $product->image) }}" placeholder="https://...">
                    @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($product->image_url)
                <div class="col-12">
                    <label class="form-label text-secondary">Current Image Preview:</label>
                    <div class="p-2 bg-black rounded d-inline-block border border-secondary">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-height: 100px; max-width: 150px; object-fit: contain;">
                    </div>
                </div>
                @endif

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Features / Specifications (One per line)</label>
                    @php
                        $featuresText = is_array($product->features) ? implode("\n", $product->features) : $product->features;
                    @endphp
                    <textarea name="features" rows="4" class="form-control">{{ old('features', $featuresText) }}</textarea>
                    <small class="text-secondary">Enter each key highlight or spec on a new line</small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product->sort_order) }}" min="0">
                </div>

                <div class="col-md-8 d-flex align-items-end gap-4 pb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured on Homepage</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active & Visible</label>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i> Update Tire Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
