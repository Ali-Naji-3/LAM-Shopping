@extends('admin.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center m-3">
    <h2 class="h4 text-white mb-0">
        Permissions Edit
    </h2>
    <a href="{{ route('permissions.index') }}" class="btn btn-dark btn-sm">
        Back
    </a>
</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf


                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $permission->name) }}"
                                   placeholder="Enter Name"
                                   class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
