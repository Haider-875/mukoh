@extends('admin.layouts.app')

@section('title', 'Manage Customer Testimonials')
@section('header-title', 'Customer Testimonials')
@section('header-subtitle', 'Manage reviews and star ratings shown on the homepage')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-chat-square-quote me-2 text-primary"></i> Testimonials ({{ $testimonials->count() }})</span>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add Testimonial</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Customer / Driver</th>
                        <th>Rating</th>
                        <th>Review Comment</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                    <tr>
                        <td><span class="badge bg-dark border border-secondary">{{ $t->sort_order }}</span></td>
                        <td>
                            <strong class="text-white">{{ $t->author_name }}</strong>
                        </td>
                        <td>
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $t->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <span class="text-light">"{{ Str::limit($t->content, 120) }}"</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.testimonials.toggle', $t) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Click to toggle">
                                    @if($t->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Hidden</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-2">
                                <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-action btn-action-edit" title="Edit Testimonial"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete this testimonial?');" class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-action-delete" title="Delete Testimonial"><i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-secondary">
                            <i class="bi bi-chat-square-quote fs-1 d-block mb-2"></i>
                            No testimonials found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
