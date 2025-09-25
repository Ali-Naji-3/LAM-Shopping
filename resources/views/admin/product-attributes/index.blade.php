@extends('admin.dashboard')

@section('content')

<script>
// Global search functions for product attributes
window.handleAttributeSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';
    
    if (searchTerm.length >= minSearchLength) {
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.transform = 'translateY(-1px)';
    } else {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.transform = 'translateY(0)';
    }
    
    clearTimeout(window.attributeSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.attributeSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleAttributeSearchKeydown = function(event, input) {
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

window.handleAttributeSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleAttributeSearchBlur = function(input) {
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                🔗 Product Attributes Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage product-attribute assignments and pricing • {{ $productAttributes->total() }} total assignments
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.productAttributes.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-circle me-2"></i>Assign Attribute
            </a>
            <a href="{{ route('admin.productAttributes.analytics') }}" class="btn btn-outline-info" 
               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                <i class="bi bi-bar-chart me-2"></i>Analytics
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Total Assignments</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['total_assignments']) }}</h3>
                        </div>
                        <i class="bi bi-link-45deg" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Products with Attributes</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">{{ number_format($statistics['products_with_attributes']) }}</h3>
                        </div>
                        <i class="bi bi-box" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Additional Revenue</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($statistics['total_additional_revenue'], 2) }}</h3>
                        </div>
                        <i class="bi bi-currency-dollar" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; border-radius: 12px !important; color: #ffffff !important;">
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="color: rgba(255, 255, 255, 0.8) !important; font-size: 12px !important; text-transform: uppercase !important; font-weight: 600 !important; margin-bottom: 8px !important;">Avg. Additional Price</h6>
                            <h3 style="color: #ffffff !important; font-weight: 700 !important; margin: 0 !important;">${{ number_format($statistics['average_additional_price'], 2) }}</h3>
                        </div>
                        <i class="bi bi-graph-up" style="font-size: 2.5rem !important; opacity: 0.3 !important;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form method="GET" action="{{ route('admin.productAttributes.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search</label>
                        <div class="search-input-container" style="position: relative;">
                            <input type="text" 
                                   name="search" 
                                   id="search-attributes"
                                   class="form-control" 
                                   placeholder="🔍 Search products, attributes, values..." 
                                   value="{{ request('search') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   onkeyup="handleAttributeSearchKeyup(this)"
                                   onkeydown="handleAttributeSearchKeydown(event, this)"
                                   onfocus="handleAttributeSearchFocus(this)"
                                   onblur="handleAttributeSearchBlur(this)"
                                   autocomplete="off">
                            <i class="bi bi-search search-icon" 
                               style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Filter by Product</label>
                        <select name="product_id" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Filter by Attribute</label>
                        <select name="attribute_id" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Attributes</option>
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ request('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                    {{ $attribute->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Price Filter</label>
                        <select name="price_filter" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Prices</option>
                            <option value="free" {{ request('price_filter') == 'free' ? 'selected' : '' }}>Free (No Additional Cost)</option>
                            <option value="paid" {{ request('price_filter') == 'paid' ? 'selected' : '' }}>Paid (Has Additional Cost)</option>
                            <option value="expensive" {{ request('price_filter') == 'expensive' ? 'selected' : '' }}>Expensive (>$10)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-outline-primary flex-fill" 
                                    style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            @if(request()->hasAny(['search', 'product_id', 'attribute_id', 'price_filter']))
                                <a href="{{ route('admin.productAttributes.index') }}" class="btn btn-outline-secondary"
                                   style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 16px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                   onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                                   onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($productAttributes->count() > 0)
        <!-- Bulk Actions Card -->
        <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 1rem 2rem !important;">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.productAttributes.bulk') }}">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select-all">
                                <label class="form-check-label" for="select-all" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="action" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                                <option value="">Bulk Actions</option>
                                <option value="delete">Delete Selected</option>
                                <option value="update_price">Update Additional Price</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="bulk_additional_price" class="form-control" placeholder="Additional Price ($)" step="0.01" min="0" max="9999.99" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-warning" 
                                    style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onclick="return confirm('Are you sure you want to perform this bulk action?')">
                                <i class="bi bi-lightning me-1"></i> Apply Action
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Assignments Display -->
        <div class="row">
            @foreach($productAttributes as $assignment)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="assignment-card" 
                         style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; padding: 1.5rem !important; transition: all 0.2s ease !important; height: 100% !important;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <!-- Product Info -->
                            <div class="flex-grow-1">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                    {{ $assignment->product->name }}
                                </h6>
                                <small style="color: #4a5568 !important; font-size: 12px !important;">
                                    SKU: {{ $assignment->product->sku }} • 
                                    @if($assignment->product->category)
                                        {{ $assignment->product->category->name }}
                                    @endif
                                </small>
                            </div>
                            <!-- Checkbox for bulk actions -->
                            <div class="form-check">
                                <input class="form-check-input assignment-checkbox" type="checkbox" value="{{ $assignment->id }}" name="selected_assignments[]">
                            </div>
                        </div>
                        
                        <!-- Attribute Info -->
                        <div class="mb-3" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="type-icon" style="background: {{ $assignment->attributeValue->attribute->type === 'text' ? '#3182ce' : ($assignment->attributeValue->attribute->type === 'select' ? '#10b981' : ($assignment->attributeValue->attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; width: 24px !important; height: 24px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                    <i class="bi bi-{{ $assignment->attributeValue->attribute->type === 'text' ? 'input-cursor-text' : ($assignment->attributeValue->attribute->type === 'select' ? 'list-ul' : ($assignment->attributeValue->attribute->type === 'checkbox' ? 'check-square' : 'circle')) }}" style="color: #ffffff !important; font-size: 10px !important;"></i>
                                </div>
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">{{ $assignment->attributeValue->attribute->name }}</span>
                            </div>
                            
                            <!-- Value Display -->
                            <div class="d-flex align-items-center justify-content-between">
                                @if($assignment->attributeValue->attribute->name === 'Color' && in_array(strtolower($assignment->attributeValue->value), ['red', 'blue', 'green', 'black', 'white', 'yellow', 'pink', 'purple', 'orange', 'brown', 'gray']))
                                    <!-- Color Swatch -->
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="color-swatch" style="width: 20px !important; height: 20px !important; border-radius: 50% !important; background-color: {{ strtolower($assignment->attributeValue->value) === 'black' ? '#000000' : (strtolower($assignment->attributeValue->value) === 'white' ? '#ffffff' : strtolower($assignment->attributeValue->value)) }} !important; border: 2px solid #e2e8f0 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"></div>
                                        <span style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">{{ $assignment->attributeValue->value }}</span>
                                    </div>
                                @else
                                    <!-- Regular Value -->
                                    <span style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">{{ $assignment->attributeValue->value }}</span>
                                @endif
                                
                                <!-- Additional Price -->
                                @if($assignment->additional_price > 0)
                                    <span class="badge" style="background: #10b981 !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        +${{ number_format($assignment->additional_price, 2) }}
                                    </span>
                                @else
                                    <span class="badge" style="background: #6b7280 !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important;">
                                        Free
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Assignment Details -->
                        <div class="mb-3" style="padding: 8px 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 6px !important;">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div style="color: #92400e !important; font-weight: 600 !important; font-size: 12px !important;">ID: {{ $assignment->id }}</div>
                                </div>
                                <div class="col-6">
                                    <div style="color: #92400e !important; font-weight: 600 !important; font-size: 12px !important;">{{ $assignment->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.productAttributes.edit', $assignment) }}" class="btn btn-sm btn-outline-primary flex-fill"
                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('admin.productAttributes.show', $assignment) }}" class="btn btn-sm btn-outline-info flex-fill"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.productAttributes.destroy', $assignment) }}" class="d-inline flex-fill" 
                                  onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                        style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                        onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Professional Pagination -->
        <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                Showing {{ $productAttributes->firstItem() ?? 0 }} to {{ $productAttributes->lastItem() ?? 0 }} of {{ $productAttributes->total() }} entries
            </div>
            <div class="pagination-links">
                {{ $productAttributes->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 3rem !important;">
                <div class="text-center">
                    <i class="bi bi-link-45deg" style="color: #718096 !important; font-size: 4rem !important; margin-bottom: 1.5rem !important;"></i>
                    <h4 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">No Product Attributes Found</h4>
                    <p style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important; max-width: 500px !important; margin: 0 auto 2rem auto !important;">
                        @if(request()->hasAny(['search', 'product_id', 'attribute_id', 'price_filter']))
                            No assignments match your current search criteria. Try adjusting your filters.
                        @else
                            Start by assigning attributes to products to define product variations and additional pricing.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.productAttributes.create') }}" class="btn btn-primary"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                            <i class="bi bi-plus-circle me-2"></i>Create First Assignment
                        </a>
                        @if(request()->hasAny(['search', 'product_id', 'attribute_id', 'price_filter']))
                            <a href="{{ route('admin.productAttributes.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-arrow-left me-2"></i>Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk selection functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const assignmentCheckboxes = document.querySelectorAll('.assignment-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            assignmentCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsState();
        });
    }
    
    assignmentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsState();
        });
    });
    
    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.assignment-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === assignmentCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < assignmentCheckboxes.length;
        }
    }
    
    function updateBulkActionsState() {
        const selectedCount = document.querySelectorAll('.assignment-checkbox:checked').length;
        const bulkForm = document.getElementById('bulk-actions-form');
        
        if (bulkForm) {
            const actionSelect = bulkForm.querySelector('select[name="action"]');
            const priceInput = bulkForm.querySelector('input[name="bulk_additional_price"]');
            
            if (selectedCount > 0) {
                actionSelect.style.borderColor = '#3182ce';
                actionSelect.style.background = '#f0f9ff';
                if (priceInput) {
                    priceInput.style.borderColor = '#3182ce';
                    priceInput.style.background = '#f0f9ff';
                }
            } else {
                actionSelect.style.borderColor = '#e2e8f0';
                actionSelect.style.background = '#ffffff';
                if (priceInput) {
                    priceInput.style.borderColor = '#e2e8f0';
                    priceInput.style.background = '#ffffff';
                }
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN PRODUCT ATTRIBUTES INDEX - Professional Styling */
    .assignment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .color-swatch {
        transition: all 0.2s ease !important;
    }
    
    .assignment-card:hover .color-swatch {
        transform: scale(1.2) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Clean Search Input Styling */
    #search-attributes::placeholder {
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
    
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    .type-icon {
        transition: all 0.2s ease !important;
    }
    
    .assignment-card:hover .type-icon {
        transform: scale(1.1) !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .assignment-card {
            margin-bottom: 1rem !important;
        }
        
        .d-flex.gap-1 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        
        .d-flex.gap-1 .btn {
            width: 100% !important;
        }
    }
</style>
@endpush
@endsection
