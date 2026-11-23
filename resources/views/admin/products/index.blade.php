@extends('admin.layouts.app')

@section('title', 'Manage Tire Products')
@section('header-title', 'Tire Products')
@section('header-subtitle', 'Add, update, or remove tires from the catalog')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name, brand, or model...">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="condition" class="form-select">
                    <option value="">All Conditions</option>
                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>Brand New</option>
                    <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Certified Used</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-1"></i> Filter</button>
                @if(request()->hasAny(['search', 'category', 'condition']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-disc me-2 text-primary"></i> Product Catalog ({{ $products->total() }})</span>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add New Tire</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Product Details</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Badge</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: contain; background: #000; border-radius: 6px; padding: 4px;">
                            @else
                                <div style="width: 50px; height: 50px; background: #222; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #555;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $product->name }}</div>
                            <small class="text-secondary">{{ $product->brand }} &bull; {{ $product->condition == 'new' ? 'Brand New' : 'Certified Used' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-secondary">{{ $product->category->name ?? ucfirst($product->category_slug ?? 'General') }}</span>
                        </td>
                        <td><code>{{ $product->size ?? 'N/A' }}</code></td>
                        <td>
                            <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                            @if($product->original_price)
                                <small class="text-secondary text-decoration-line-through d-block">${{ number_format($product->original_price, 2) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($product->badge)
                                <span class="badge bg-danger">{{ $product->badge }}</span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_featured)
                                <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to toggle status">
                                    @if($product->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tire product?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-secondary">
                            <i class="bi bi-disc fs-1 d-block mb-2"></i>
                            No products found matching your criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer d-flex justify-content-end">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
