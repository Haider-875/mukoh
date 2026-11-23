@extends('admin.layouts.app')

@section('title', 'Admin Profile & Security Settings')
@section('header-title', 'Security & Profile')
@section('header-subtitle', 'Manage your administrator account credentials')

@section('content')
<div class="row g-4">
    <!-- Profile Info Form -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-circle me-2 text-primary"></i> Profile Information
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.profile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Administrator Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role ?? 'Administrator') }}" disabled readonly>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Form -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-key me-2 text-primary"></i> Change Admin Password
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required placeholder="Enter current password">
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimum 8 characters">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat new password">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-shield-lock me-1"></i> Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
