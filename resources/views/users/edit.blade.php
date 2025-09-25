@extends('admin.dashboard')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 text-white">Users Edit</h2>

        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf


                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Name"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email with underline -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $user->email) }}"
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
                            <input type="text" id="mobile" name="mobile"
                                   value="{{ old('mobile', $user->mobile ?? '') }}"
                                   placeholder="Mobile Number"
                                   class="form-control @error('mobile') is-invalid @enderror">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Roles Checkboxes -->
                       @if($roles->isNotEmpty())
        @foreach($roles as $role)
    <div class="my-3">

<input {{($hasRoles->contains($role->id ))? 'checked' :''}} type="checkbox" id="role-{{$role->id}}" class="rounded" name="role[]"
value="{{ $role->name }}">
<label for="role-{{$role->id}}">{{ $role->name }}</label>
    </div>
        @endforeach
    @endif

                        <!-- Submit Button -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-dark">
                                Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
