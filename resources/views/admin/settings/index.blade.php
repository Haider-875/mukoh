@extends('admin.layouts.app')

@section('title', 'Admin Profile & Security Settings')
@section('header-title', 'Security & Profile')
@section('header-subtitle', 'Manage administrator credentials and account security')

@section('content')
<div class="row g-4">
    <!-- Profile Info Form -->
    <div class="col-lg-6">
        <div class="card h-100 mb-0">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa-regular fa-user text-danger"></i>
                <span>Profile Information</span>
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
                        <input type="text" class="form-control" value="{{ ucfirst($user->role ?? 'Administrator') }}" disabled readonly style="background:#111 !important; color:#888 !important;">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Password Change Form -->
    <div class="col-lg-6">
        <div class="card h-100 mb-0" id="passwordCard" style="transition: border-color 0.3s ease, box-shadow 0.3s ease;">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-key text-warning"></i>
                    <span>Change Admin Password</span>
                </div>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25" style="font-size:10px;">Security</span>
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

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat new password">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-shield-halved"></i> Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === '#passwordCard') {
      const card = document.getElementById('passwordCard');
      if (card) {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        card.style.borderColor = 'var(--admin-accent)';
        card.style.boxShadow = '0 0 20px rgba(239, 59, 45, 0.35)';
        const input = card.querySelector('input[name="current_password"]');
        if (input) input.focus();
      }
    }
  });
</script>
@endpush
