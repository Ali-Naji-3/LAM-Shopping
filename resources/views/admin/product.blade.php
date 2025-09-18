@extends('admin.dashboard')

@section('content')
<div class="container my-4">
    <h2 class="mb-3">Create Table</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" role="table" aria-label="Product Table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    {{-- <th scope="col">SKU</th> --}}
                    {{-- <th scope="col">Short Description</th> --}}
                    <th scope="col">Description</th>
                    <th scope="col">Regular Price</th>
                    <th scope="col">Sale Price</th>
                    <th scope="col">Featured</th>
                    <th scope="col">Status</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Image</th>
                    {{-- <th scope="col">Images</th> --}}
                    <th scope="col">Category ID</th>
                    <th scope="col">Brand ID</th>
                    {{-- <th scope="col">Weight</th> --}}
                    {{-- <th scope="col">Created At</th> --}}
                    {{-- <th scope="col">Updated At</th> --}}
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sample Product</td>
                    <td>sample-product</td>
                    {{-- <td>SKU123</td> --}}
                    {{-- <td>Short preview...</td> --}}
                    <td>Full description text here</td>
                    <td>$100.00</td>
                    <td>$80.00</td>
                    <td><span class="badge bg-success">Yes</span></td>
                    <td><span class="badge bg-primary">Active</span></td>
                    <td>50</td>
                    <td>
                        <img src="https://via.placeholder.com/48" class="rounded" width="48" height="48" alt="image">
                    </td>
                    {{-- <td>
                        <img src="https://via.placeholder.com/32" class="rounded me-1" width="32" height="32" alt="img">
                        <img src="https://via.placeholder.com/32" class="rounded me-1" width="32" height="32" alt="img">
                        <span class="badge bg-secondary">+2</span>
                    </td> --}}
                    <td>10</td>
                    <td>5</td>
                    {{-- <td>1.2kg</td> --}}
                    {{-- <td>2025-09-18</td> --}}
                    {{-- <td>2025-09-18</td> --}}
                   <td class="text-nowrap">
                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="View">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                </tr>
                <!-- Repeat rows dynamically -->
            </tbody>
        </table>
    </div>
</div>
@endsection
