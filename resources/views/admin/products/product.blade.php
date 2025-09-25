@extends('admin.layouts.dashboard')

@section('content')
<div class="container my-4">
    <h2 class="mb-3 text-white">Products</h2>

    <!-- Search + Add button row -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Search box -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search here..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!-- Add new button -->
        <a class="btn btn-primary d-flex align-items-center" href="{{route('admin.create')}}">
            <i class="bi bi-plus me-1"></i> Add new
        </a>
    </div>

    <!-- Table -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0" role="table" aria-label="Product Table">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Regular Price</th>
                <th scope="col">Sale Price</th>
                <th scope="col">Featured</th>
                <th scope="col">Status</th>
                <th scope="col">Quantity</th>
                <th scope="col">Image</th>
                <th scope="col">Category ID</th>
                <th scope="col">Brand ID</th>
               <th scope="col" class="text-center" style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Sample Product</td>
                <td>sample-product</td>
                <td>Full description text here</td>
                <td>$100.00</td>
                <td>$80.00</td>
                <td><span class="badge bg-success">Yes</span></td>
                <td><span class="badge bg-primary">Active</span></td>
                <td>50</td>
                <td>
                    <img src="https://via.placeholder.com/48" class="rounded" width="48" height="48" alt="image">
                </td>
                <td>10</td>
                <td>5</td>
            <td class="actions-col">
    <div class="d-flex gap-3 justify-content-center">
        <!-- View -->
        <a href="#"
           class="btn btn-sm btn-outline-primary rounded-circle"
           title="View">
            <i class="bi bi-eye"></i>
        </a>

        <!-- Edit -->
        <a href="{{ route('admin.edit') }}"
           class="btn btn-sm btn-outline-warning rounded-circle"
           title="Edit">
            <i class="bi bi-pencil"></i>
        </a>

        <!-- Delete (needs form for POST/DELETE method) -->
        {{-- <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE') --}}
            <button type="submit"
                    class="btn btn-sm btn-outline-danger rounded-circle"
                    title="Delete"
                    onclick="return confirm('Are you sure you want to delete this product?');">
                <i class="bi bi-trash"></i>
            </button>
        {{-- </form> --}}
    </div>
</td>

            </tr>
            <!-- Repeat rows dynamically -->
        </tbody>
    </table>
</div>


</div>

@endsection
