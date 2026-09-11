@extends('layout.master')

@section('title', 'Profile')

@section('content')

<style>
.card-custom {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.profile-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #eaeaea;
}

.form-control {
    height: 46px;
    border-radius: 10px;
}

.btn-save {
    height: 46px;
    padding: 0px 40px;
    border-radius: 10px;
    font-weight: 600;
}
</style>


<div class="page-title-box d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">My Profile</h4>
</div>


<div class="row">

    <!-- LEFT PROFILE PANEL -->
    <div class="col-md-4">
        <div class="card-custom text-center">

            <img src="{{ asset('backends/assets/images/users/first.png') }}" class="profile-photo mb-3">

            <h5 class="fw-bold">{{ Auth::user()->name }}</h5>
            <p class="text-muted">{{ Auth::user()->email }}</p>

        </div>
    </div>

    <!-- RIGHT PROFILE FORM -->
    <div class="col-md-8">

        <div class="card-custom mb-4">

            <h5 class="fw-bold mb-3">Update Profile Information</h5>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', Auth::user()->email) }}" required>
                </div>

                <button type="submit" class="btn btn-primary btn-save">Save</button>
            </form>

        </div>


        <div class="card-custom mb-4">

            <h5 class="fw-bold mb-3">Change Password</h5>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-success btn-save">Update Password</button>
            </form>

        </div>

        <div class="card-custom mb-4">

            <h5 class="fw-bold mb-3 text-danger">Delete Account</h5>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <p class="text-muted">Once you delete your account, all your data will be permanently removed.</p>

                <button type="submit" class="btn btn-danger btn-save"
                        onclick="return confirm('Are you sure you want to delete your account permanently?')">
                    Delete Account
                </button>

            </form>

        </div>

    </div>
</div>

@endsection
