@extends('admin.dashboard')

@section('content')

<script>
// CRITICAL FIX: Define search functions immediately in global scope
window.handleProductSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    console.log('Enhanced Product Search - onkeyup triggered:', searchTerm);
    
    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';
    
    // Advanced visual feedback
    if (searchTerm.length >= minSearchLength) {
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(-1px)';
    } else if (searchTerm.length > 0 && searchTerm.length < minSearchLength) {
        input.style.borderColor = '#d69e2e';
        input.style.boxShadow = '0 0 0 3px rgba(214, 158, 46, 0.15)';
        input.style.background = '#fffbeb';
        input.style.transform = 'translateY(0)';
    } else {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(0)';
    }
    
    // Smart auto-submit
    clearTimeout(window.productSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.productSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                console.log('Auto-submitting product search for:', searchTerm);
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleProductSearchKeydown = function(event, input) {
    if (event.key === 'Enter') {
        event.preventDefault();
        input.closest('form').submit();
    }
    if (event.key === 'Escape') {
        input.value = '';
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.blur();
    }
};

window.handleProductSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleProductSearchBlur = function(input) {
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};

// Delete product confirmation function
function confirmDeleteProduct(productId, productName) {
    console.log('Delete button clicked for product:', productId, productName);
    
    if (confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`)) {
        try {
            console.log('User confirmed deletion, creating form...');
            
            // Create and submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/products/${productId}`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('CSRF token not found. Please refresh the page and try again.');
                return;
            }
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
            
            // Add DELETE method
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            console.log('Form created, submitting...', form.action);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        } catch (error) {
            console.error('Error deleting product:', error);
            alert('An error occurred while deleting the product. Please try again.');
        }
    } else {
        console.log('User cancelled deletion');
    }
}
</script>

<div class="container-fluid">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; border-radius: 10px !important; margin-bottom: 2rem !important; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle me-2" style="font-size: 18px !important;"></i>
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; border: none !important; color: #ffffff !important; border-radius: 10px !important; margin-bottom: 2rem !important; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-2" style="font-size: 18px !important;"></i>
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important;">
                🛍️ Products Management
            </h2>
            <p class="text-muted mb-0" style="color: #4a5568 !important;">Manage your product catalog with frontend-style attributes</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"
           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <i class="bi bi-plus-circle me-2"></i>Add New Product
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Products</label>
                    <div class="search-input-container" style="position: relative;">
                        <input type="text" 
                               name="search" 
                               id="search-products"
                               class="form-control" 
                               placeholder="🔍 Search by name, SKU, or description..." 
                               value="{{ request('search') }}"
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                               onkeyup="handleProductSearchKeyup(this)"
                               onkeydown="handleProductSearchKeydown(event, this)"
                               onfocus="handleProductSearchFocus(this)"
                               onblur="handleProductSearchBlur(this)"
                               autocomplete="off">
                        <i class="bi bi-search search-icon" 
                           style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Status</label>
                    <select name="status" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Category</label>
                    <select name="category_id" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Brand</label>
                    <select name="brand_id" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Featured</label>
                    <select name="featured" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Products</option>
                        <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured Only</option>
                        <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary" 
                            style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"
                            onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="product-card h-100" 
                                 style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; overflow: hidden !important; position: relative !important;"
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#e2e8f0 !important';">
                                
                                <!-- Product Image -->
                                <div class="product-image text-center p-3" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; position: relative;">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid"
                                             style="max-height: 120px; max-width: 100%; object-fit: contain; border-radius: 8px;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center" 
                                             style="height: 120px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); border-radius: 8px;">
                                            <i class="bi bi-box" style="color: #718096 !important; font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Featured Badge -->
                                    @if($product->featured)
                                        <span class="badge position-absolute" 
                                              style="top: 10px; right: 10px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                            <i class="bi bi-star-fill me-1"></i>Featured
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="card-body" style="padding: 1.5rem !important;">
                                    <h5 class="product-name mb-1" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                                        {{ $product->name }}
                                    </h5>
                                    
                                    <!-- Product Meta -->
                                    <div class="product-meta mb-3">
                                        <small style="color: #4a5568 !important; font-size: 12px !important;">
                                            <strong>SKU:</strong> {{ $product->sku }}
                                        </small><br>
                                        <small style="color: #4a5568 !important; font-size: 12px !important;">
                                            <strong>Brand:</strong> {{ $product->brand->name ?? 'No Brand' }}
                                        </small><br>
                                        <small style="color: #4a5568 !important; font-size: 12px !important;">
                                            <strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}
                                        </small>
                                    </div>
                                    
                                    @if($product->short_description)
                                        <p class="product-description small mb-3" style="color: #4a5568 !important; line-height: 1.5;">
                                            {{ Str::limit($product->short_description, 80) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Price -->
                                    <div class="product-price mb-3">
                                        @if($product->sale_price)
                                            <span class="sale-price" style="color: #e53e3e !important; font-weight: 700 !important; font-size: 18px !important;">
                                                ${{ number_format($product->sale_price, 2) }}
                                            </span>
                                            <span class="regular-price" style="color: #718096 !important; font-size: 14px !important; text-decoration: line-through; margin-left: 8px;">
                                                ${{ number_format($product->regular_price, 2) }}
                                            </span>
                                        @else
                                            <span class="regular-price" style="color: #3182ce !important; font-weight: 700 !important; font-size: 18px !important;">
                                                ${{ number_format($product->regular_price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Stats -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="stat-number" style="color: #3182ce !important; font-weight: 700 !important; font-size: 16px !important;">
                                                {{ $product->reviews_count ?? 0 }}
                                            </div>
                                            <small style="color: #718096 !important; font-size: 10px !important; text-transform: uppercase !important;">Reviews</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-number" style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important;">
                                                {{ $product->order_items_count ?? 0 }}
                                            </div>
                                            <small style="color: #718096 !important; font-size: 10px !important; text-transform: uppercase !important;">Orders</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-number" style="color: #f59e0b !important; font-weight: 700 !important; font-size: 16px !important;">
                                                {{ $product->quantity }}
                                            </div>
                                            <small style="color: #718096 !important; font-size: 10px !important; text-transform: uppercase !important;">Stock</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div class="text-center mb-3">
                                        <span class="badge" style="background-color: {{ $product->status === 'active' ? '#10b981' : ($product->status === 'draft' ? '#f59e0b' : '#e53e3e') }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                            {{ $product->status }}
                                        </span>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-primary flex-fill"
                                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary flex-fill"
                                           style="color: #6b7280 !important; border-color: #6b7280 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#6b7280 !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#6b7280 !important';">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger flex-fill" 
                                                style="color: #ef4444 !important; border-color: #ef4444 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                                onmouseover="this.style.backgroundColor='#ef4444 !important'; this.style.color='#ffffff !important';"
                                                onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#ef4444 !important';"
                                                onclick="confirmDeleteProduct({{ $product->id }}, {{ json_encode($product->name) }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Professional Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                    <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} entries
                    </div>
                    <div class="pagination-links">
                        {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box display-1" style="color: #718096 !important;"></i>
                    <h4 class="mt-3" style="color: #2d3748 !important;">No Products Found</h4>
                    <p style="color: #4a5568 !important;">Start by creating your first product with attributes.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"
                       style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                        <i class="bi bi-plus-circle me-2"></i>Create First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN PRODUCTS PAGE - Professional Styling */
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .product-card:hover .product-name {
        color: #3182ce !important;
    }
    
    /* Clean Search Input Styling */
    #search-products::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    .form-control:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
</style>
@endpush
@endsection
