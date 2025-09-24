@extends('admin.layouts.dashboard')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 text-white">Roles Create</h2>

        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Enter Name"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Permissions Checkboxes -->
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                               @if($permissions->isNotEmpty())
        @foreach($permissions as $permission)
    <div class="mt-3">
<input type="checkbox" id="permission-{{$permission->id}}" class="rounded" name="permissions[]"
value="{{ $permission->name }}">
<label for="permission-{{$permission->id}}">{{ $permission->name }}</label>
    </div>
        @endforeach
    @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-dark">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
