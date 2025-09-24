@extends('admin.layouts.dashboard')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0 text-white">Permissions Create</h2>

        <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('permissions.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Name</label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter Name"
                                class="form-control @error('name') is-invalid @enderror"
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-sm px-4">
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
