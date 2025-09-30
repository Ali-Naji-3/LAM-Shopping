@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Compact Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0" style="color: #1a202c; font-weight: 700;">🛍️ Product Details</h1>
                    <p style="color: #4a5568; font-size: 14px; margin-bottom: 0;">{{ $product->name }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning" style="font-weight: 600;">
                        <i class="fas fa-edit me-1"></i> Edit Product
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
            <!-- Product Information -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">📋 Product Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Product Name</label>
                                <div style="color: #1a202c; font-weight: 700; font-size: 20px;">{{ $product->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">SKU</label>
                                        <div style="color: #4299e1; font-weight: 600; font-size: 14px;">{{ $product->sku }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Slug</label>
                                        <div style="color: #718096; font-size: 14px;">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </div>

                            @if($product->short_description)
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Short Description</label>
                                <div style="color: #2d3748; font-size: 14px;">{{ $product->short_description }}</div>
                            </div>
                            @endif

                            @if($product->description)
                            <div class="mb-3">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Description</label>
                                <div style="color: #2d3748; font-size: 14px; line-height: 1.6;">{{ $product->description }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            @if($product->image)
                            <div class="text-center">
                                <label style="color: #718096; font-size: 12px; font-weight: 600; text-transform: uppercase;">Product Image</label>
                                <div class="mt-2">
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                         class="img-fluid rounded" style="max-width: 150px; border: 2px solid #e2e8f0;">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 15px;">
                    <h6 class="m-0" style="color: #2d3748; font-weight: 700; font-size: 15px;">💰 Pricing & Stock</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: #f0fff4; border-radius: 8px; border: 1px solid #68d391;">
                                <div style="color: #22543d; font-size: 18px; font-weight: 800;">${{ number_format($product->regular_price, 2) }}</div>
                                <div style="color: #68d391; font-size: 11px; font-weight: 600; text-transform: uppercase;">Regular Price</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: #eff6ff; border-radius: 8px; border: 1px solid #60a5fa;">
                                <div style="color: #1e40af; font-size: 18px; font-weight: 800;">
                                    @if($product->sale_price)
                                        ${{ number_format($product->sale_price, 2) }}
                                    @else
                                        <span style="color: #a0aec0;">N/A</span>
                                    @endif
                                </div>
                                <div style="color: #60a5fa; font-size: 11px; font-weight: 600; text-transform: uppercase;">Sale Price</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: #fef3c7; border-radius: 8px; border: 1px solid #f59e0b;">
                                <div style="color: #92400e; font-size: 18px; font-weight: 800;">{{ number_format($product->quantity) }}</div>
                                <div style="color: #f59e0b; font-size: 11px; font-weight: 600; text-transform: uppercase;">Stock Quantity</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3" style="background: #f3e8ff; border-radius: 8px; border: 1px solid #a855f7;">
                                <div style="color: #7c3aed; font-size: 14px; font-weight: 800;">
                                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : ($product->status == 'draft' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </div>
                                <div style="color: #a855f7; font-size: 11px; font-weight: 600; text-transform: uppercase;">Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow border-0 mb-3" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">⚡ Quick Actions</h6>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-2">
                        @if($product->category)
                        <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-outline-primary" style="font-weight: 600;">
                            <i class="fas fa-folder me-1"></i> View Category
                        </a>
                        @endif

                        @if($product->brand)
                        <a href="{{ route('admin.brands.show', $product->brand) }}" class="btn btn-outline-secondary" style="font-weight: 600;">
                            <i class="fas fa-tag me-1"></i> View Brand
                        </a>
                        @endif

                        <a href="{{ route('admin.inventory.index') }}?search={{ $product->sku }}" class="btn btn-outline-success" style="font-weight: 600;">
                            <i class="fas fa-warehouse me-1"></i> View Inventory
                        </a>

                        <a href="{{ route('admin.reviews.index') }}?product_id={{ $product->id }}" class="btn btn-outline-warning" style="font-weight: 600;">
                            <i class="fas fa-star me-1"></i> View Reviews
                        </a>

                        <button class="btn btn-outline-info" onclick="viewProductAnalytics()" style="font-weight: 600;">
                            <i class="fas fa-chart-bar me-1"></i> Product Analytics
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-header" style="background: linear-gradient(135deg, #9f7aea 0%, #805ad5 100%); color: white; padding: 15px;">
                    <h6 class="m-0" style="font-weight: 700; font-size: 14px;">📊 Product Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Category:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Brand:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $product->brand->name ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Featured:</span>
                            <span class="badge badge-{{ $product->featured ? 'success' : 'secondary' }}" style="font-size: 10px;">
                                {{ $product->featured ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>

                    @if($product->weight)
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Weight:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $product->weight }} kg</span>
                        </div>
                    </div>
                    @endif

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span style="color: #718096; font-size: 12px;">Created:</span>
                            <span style="color: #2d3748; font-weight: 600; font-size: 12px;">{{ $product->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
