@extends('admin.layouts.app')

@section('title', 'Manage Services')
@section('header-title', 'Services Management')
@section('header-subtitle', 'Add, modify, or reorder tire installation and maintenance services')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-tools me-2 text-primary"></i> Service Offerings ({{ $services->count() }})</span>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add New Service</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Service Title</th>
                        <th>Starting Price</th>
                        <th>Key Inclusions</th>
                        <th>CTA Link</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td><span class="badge bg-dark border border-secondary">{{ $service->sort_order }}</span></td>
                        <td>
                            <div class="fw-bold text-white">{{ $service->title }}</div>
                            <small class="text-secondary">{{ Str::limit($service->short_description, 70) }}</small>
                        </td>
                        <td>
                            @if($service->price_starting_at)
                                <span class="fw-bold text-primary">{{ $service->price_starting_at }}</span>
                                <small class="text-secondary d-block">{{ $service->price_subtext }}</small>
                            @else
                                <span class="text-secondary">Custom Quote</span>
                            @endif
                        </td>
                        <td>
                            @if(is_array($service->features) && count($service->features) > 0)
                                <small class="text-secondary">{{ count($service->features) }} features listed</small>
                            @else
                                <span class="text-secondary">—</span>
                            @endif
                        </td>
                        <td>
                            <code>{{ $service->action_link ?? '/contact' }}</code>
                        </td>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="bi bi-tools fs-1 d-block mb-2"></i>
                            No services found. Click "Add New Service" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
