@extends('admin.dashboard')

@section('content')
<div class="container-fluid {{ $theme['theme_name'] }}">
    <!-- Gender-Themed Header -->
    <div class="gender-header mb-4">
        <div class="theme-gradient"></div>
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="header-content">
                    <h1 class="gender-title">
                        <span class="gender-icon">{{ $theme['icon'] }}</span>
                        {{ $theme['title'] }}
                    </h1>
                    <p class="gender-description">{{ $theme['description'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gender-stats-summary">
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['active_products'] }}</span>
                        <span class="stat-label">Active Products</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['featured_products'] }}</span>
                        <span class="stat-label">Featured</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($statistics['average_rating'], 1) }}</span>
                        <span class="stat-label">Avg Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Switcher -->
    <div class="gender-switcher mb-4">
        <div class="switcher-container">
            <span class="switcher-label">Switch Gender:</span>
            <div class="gender-buttons">
                <a href="{{ route('admin.products.men') }}" class="gender-btn men-theme {{ $gender === 'Men' ? 'active' : '' }}">
                    <span class="icon">👨</span>
                    <span>Men</span>
                </a>
                <a href="{{ route('admin.products.women') }}" class="gender-btn women-theme {{ $gender === 'Women' ? 'active' : '' }}">
                    <span class="icon">👩</span>
                    <span>Women</span>
                </a>
                <a href="{{ route('admin.products.boys') }}" class="gender-btn boys-theme {{ $gender === 'Boys' ? 'active' : '' }}">
                    <span class="icon">👦</span>
                    <span>Boys</span>
                </a>
                <a href="{{ route('admin.products.girls') }}" class="gender-btn girls-theme {{ $gender === 'Girls' ? 'active' : '' }}">
                    <span class="icon">👧</span>
                    <span>Girls</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Dashboard -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $statistics['active_products'] }}</div>
                    <div class="stats-label">Active Products</div>
                    <div class="stats-sublabel">of {{ $statistics['total_products'] }} total</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ $statistics['featured_products'] }}</div>
                    <div class="stats-label">Featured Products</div>
                    <div class="stats-sublabel">highlighted items</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">{{ number_format($statistics['total_stock']) }}</div>
                    <div class="stats-label">Total Stock</div>
                    <div class="stats-sublabel">units in inventory</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number">${{ number_format($statistics['average_price'], 0) }}</div>
                    <div class="stats-label">Average Price</div>
                    <div class="stats-sublabel">per product</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="filters-section mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form method="GET" class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Search {{ $gender }} Products</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search products..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($genderCategories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-control">
                            <option value="">All Brands</option>
                            @foreach($genderBrands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.products.' . strtolower($gender)) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
        <div class="row">
            @forelse($products as $product)
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                    <div class="product-card">
                        <div class="card-header">
                            <div class="product-info">
                                <h5 class="product-name">{{ $product->name }}</h5>
                                <div class="product-meta">
                                    <span class="product-sku">{{ $product->sku }}</span>
                                    <span class="product-status {{ $product->status }}">{{ ucfirst($product->status) }}</span>
                                </div>
                            </div>
                            @if($product->image)
                                <div class="product-image">
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="product-pricing">
                                <div class="price-current">${{ number_format($product->regular_price, 2) }}</div>
                                @if($product->sale_price)
                                    <div class="price-sale">${{ number_format($product->sale_price, 2) }}</div>
                                    <div class="price-discount">-{{ $product->discount_percentage }}%</div>
                                @endif
                            </div>

                            <div class="product-details">
                                <div class="detail-item">
                                    <i class="fas fa-folder"></i>
                                    <span>{{ $product->category->name ?? 'No Category' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $product->brand->name ?? 'No Brand' }}</span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-cubes"></i>
                                    <span>{{ $product->quantity }} in stock</span>
                                </div>
                                @if($product->featured)
                                    <div class="detail-item featured">
                                        <i class="fas fa-star"></i>
                                        <span>Featured</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="product-actions">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-warning" title="Edit Product">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('admin.inventory.index') }}?search={{ $product->sku }}"
                                   class="btn btn-sm btn-success" title="View Inventory">
                                    <i class="fas fa-warehouse"></i> Stock
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">{{ $theme['icon'] }}</div>
                        <h4>No {{ $gender }} Products Found</h4>
                        <p>Start by creating products in {{ strtolower($gender) }}'s categories.</p>
                        <a href="{{ route('admin.products.create') }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create First Product
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>

@push('styles')
<style>
/* Use the same gender theming variables and styles as categories */
:root {
    --theme-primary: {{ $theme['theme_color'] }};
    --theme-primary-rgb: {{ $this->hexToRgb($theme['theme_color']) ?? '66, 153, 225' }};
    --theme-light: {{ $theme['theme_color'] }}20;
    --theme-gradient: linear-gradient(135deg, {{ $theme['theme_color'] }} 0%, {{ $this->darkenColor($theme['theme_color'], 20) ?? '#2c5aa0' }} 100%);
}

/* Product-specific styling */
.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid var(--theme-primary);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.product-card .card-header {
    background: var(--theme-light);
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.product-name {
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    font-size: 1.1rem;
    line-height: 1.3;
}

.product-meta {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    margin-top: 0.5rem;
}

.product-sku {
    font-size: 0.8rem;
    color: #718096;
    font-weight: 500;
}

.product-status {
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.product-status.active {
    background: #d1fae5;
    color: #065f46;
}

.product-status.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.product-status.draft {
    background: #fef3c7;
    color: #92400e;
}

.product-image img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.product-pricing {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.price-current {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--theme-primary);
}

.price-sale {
    font-size: 1.1rem;
    font-weight: 600;
    color: #059669;
}

.price-discount {
    background: #fee2e2;
    color: #991b1b;
    padding: 0.2rem 0.5rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}

.product-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #4a5568;
}

.detail-item i {
    color: var(--theme-primary);
    width: 16px;
    font-size: 0.8rem;
}

.detail-item.featured {
    color: #f59e0b;
    font-weight: 600;
}

.detail-item.featured i {
    color: #f59e0b;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.product-actions .btn {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
}

/* Reuse the same header, switcher, and general styles from categories */
.gender-header,
.gender-title,
.gender-icon,
.gender-description,
.gender-stats-summary,
.gender-switcher,
.switcher-container,
.gender-buttons,
.gender-btn,
.stats-card,
.filters-section,
.empty-state {
    /* Inherit from categories gender styles */
}
</style>
@endpush
@endsection
