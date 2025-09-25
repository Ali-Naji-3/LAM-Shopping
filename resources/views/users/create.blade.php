@extends('admin.dashboard')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 text-white">Users Create</h2>

        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   placeholder="Name"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email with underline -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   placeholder="Email"
                                   class="form-control border-bottom border-2 @error('email') is-invalid @enderror"
                                   style="border-radius: 0;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                                   placeholder="Mobile Number"
                                   class="form-control @error('mobile') is-invalid @enderror">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                   placeholder="Password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password"
                                   value="{{ old('confirm_password') }}"
                                   placeholder="Confirm Your Password"
                                   class="form-control @error('confirm_password') is-invalid @enderror">
                            @error('confirm_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Roles Checkboxes -->
       @if ($roles->isNotEmpty())
                            @foreach ($roles as $role)
                                <div class="my-3">
{{-- {{ $hasRoles->contains($role->id) ? 'checked' : '' }} --}}
                                    <input  type="checkbox"
                                        id="role-{{ $role->id }}" class="rounded" name="role[]"
                                        value="{{ $role->name }}">
                                    <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                            @endforeach
                        @endif


                        <!-- Submit -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-dark">
                                Create
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
