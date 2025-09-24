@extends('admin.layouts.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0 text-dark">
        Role Edit
    </h2>
    <a href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">
        Back
    </a>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                     

                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $role->name) }}"
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
<input {{($haspermissions->contains($permission->name ))? 'checked' :''}} type="checkbox" id="permission-{{$permission->id}}" class="rounded" name="permissions[]"
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
