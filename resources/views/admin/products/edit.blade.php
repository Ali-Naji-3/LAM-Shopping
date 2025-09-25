@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">🛍️ Edit Product</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $product->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info" style="font-weight: 600;">
                        <i class="fas fa-eye me-1"></i> View Details
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="font-weight: 600;">
                        <i class="fas fa-arrow-left me-1"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">Edit Product Information</h6>
                        <!-- Eye-catching Product Statistics -->
                        <div class="product-stats" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 12px; border-radius: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; margin-bottom: 2px; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                ✨ Product Statistics
                            </div>
                            <div class="d-flex gap-3" style="font-size: 10px;">
                                <span style="color: #ffffff; font-weight: 700;">{{ $connectionCounts['reviews_count'] ?? 0 }} Reviews</span>
                                <span style="color: #ffffff; font-weight: 700;">{{ $connectionCounts['orders_count'] ?? 0 }} Orders</span>
                                <span style="color: #ffffff; font-weight: 700;">{{ $connectionCounts['inventory_count'] ?? 0 }} Inventory</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-box text-primary me-1"></i> Product Name *
                                    </label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-barcode text-info me-1"></i> SKU *
                                    </label>
                                    <input type="text"
                                           class="form-control @error('sku') is-invalid @enderror"
                                           name="sku" value="{{ old('sku', $product->sku) }}" required>
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-dollar-sign text-success me-1"></i> Regular Price *
                                    </label>
                                    <input type="number" step="0.01"
                                           class="form-control @error('regular_price') is-invalid @enderror"
                                           name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" required>
                                    @error('regular_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-tag text-warning me-1"></i> Sale Price
                                    </label>
                                    <input type="number" step="0.01"
                                           class="form-control @error('sale_price') is-invalid @enderror"
                                           name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-cubes text-info me-1"></i> Quantity
                                    </label>
                                    <input type="number"
                                           class="form-control @error('quantity') is-invalid @enderror"
                                           name="quantity" value="{{ old('quantity', $product->quantity) }}">
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-folder text-primary me-1"></i> Category
                                    </label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" style="color: #2d3748; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-tag text-secondary me-1"></i> Brand
                                    </label>
                                    <select class="form-control @error('brand_id') is-invalid @enderror" name="brand_id">
                                        <option value="">Select Brand</option>
                                        @foreach(\App\Models\Brand::where('is_active', true)->get() as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-save me-1"></i> Update Product
                            </button>
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary" style="font-weight: 600; border-radius: 8px; padding: 10px 20px;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-control {
    border-radius: 6px !important;
    border: 2px solid #e2e8f0 !important;
    font-size: 13px !important;
    transition: all 0.3s ease !important;
}

.form-control:focus {
    border-color: #4299e1 !important;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1) !important;
}

.btn {
    transition: all 0.3s ease !important;
}

.btn:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
}

.product-stats {
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
    50% { box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5); }
    100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
}
</style>
@endpush

@push('scripts')
<script>
function viewProductAnalytics() {
    showNotification('Product analytics feature coming soon!', 'info');
}
</script>
@endpush
@endsection
