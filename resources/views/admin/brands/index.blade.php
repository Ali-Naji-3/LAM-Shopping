@extends('admin.dashboard')

@section('content')

<script>
// CRITICAL FIX: Define search functions immediately in global scope
window.handleBrandSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    console.log('Enhanced Brand Search - onkeyup triggered:', searchTerm);
    
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
    clearTimeout(window.brandSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.brandSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                console.log('Auto-submitting brand search for:', searchTerm);
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleBrandSearchKeydown = function(event, input) {
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

window.handleBrandSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleBrandSearchBlur = function(input) {
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
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important;">
                🏷️ Brands Management
            </h2>
            <p class="text-muted mb-0" style="color: #4a5568 !important;">Manage your product brands and their connections</p>
        </div>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"
           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <i class="bi bi-plus-circle me-2"></i>Add New Brand
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            <form method="GET" action="{{ route('admin.brands.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Brands</label>
                    <div class="search-input-container" style="position: relative;">
                        <input type="text" 
                               name="search" 
                               id="search-brands"
                               class="form-control" 
                               placeholder="🔍 Search by name, description, or slug..." 
                               value="{{ request('search') }}"
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                               onkeyup="handleBrandSearchKeyup(this)"
                               onkeydown="handleBrandSearchKeydown(event, this)"
                               onfocus="handleBrandSearchFocus(this)"
                               onblur="handleBrandSearchBlur(this)"
                               autocomplete="off">
                        <i class="bi bi-search search-icon" 
                           style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Status</label>
                    <select name="status" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary" 
                            style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"
                            onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary" 
                       style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; text-decoration: none !important;"
                       onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(74, 85, 104, 0.25) !important';"
                       onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-x-circle me-1"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Brands Grid -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            @if($brands->count() > 0)
                <div class="row">
                    @foreach($brands as $brand)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="brand-card h-100" 
                                 style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; overflow: hidden !important;"
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#e2e8f0 !important';">
                                
                                <!-- Brand Image -->
                                <div class="brand-image text-center p-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;">
                                    @if($brand->image)
                                        <img src="{{ asset('storage/' . $brand->image) }}" 
                                             alt="{{ $brand->name }}" 
                                             class="img-fluid"
                                             style="max-height: 80px; max-width: 120px; object-fit: contain; border-radius: 8px;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center" 
                                             style="height: 80px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); border-radius: 8px;">
                                            <i class="bi bi-award" style="color: #718096 !important; font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Brand Info -->
                                <div class="card-body" style="padding: 1.5rem !important;">
                                    <h5 class="brand-name mb-1" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                                        {{ $brand->name }}
                                    </h5>
                                    
                                    @if($brand->description)
                                        <p class="brand-description small mb-3" style="color: #4a5568 !important; line-height: 1.5;">
                                            {{ Str::limit($brand->description, 80) }}
                                        </p>
                                    @endif
                                    
                                    <!-- Brand Stats -->
                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="stat-number" style="color: #3182ce !important; font-weight: 700 !important; font-size: 18px !important;">
                                                {{ $brand->products_count ?? 0 }}
                                            </div>
                                            <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important;">Products</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="stat-number" style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important;">
                                                {{ $brand->contacts_count ?? 0 }}
                                            </div>
                                            <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important;">Contacts</small>
                                        </div>
                                        <div class="col-4">
                                            <span class="badge" style="background-color: {{ $brand->is_active ? '#10b981' : '#e53e3e' }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important;">
                                                {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-sm btn-outline-primary flex-fill"
                                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-secondary flex-fill"
                                           style="color: #6b7280 !important; border-color: #6b7280 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#6b7280 !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#6b7280 !important';">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Professional Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                    <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                        Showing {{ $brands->firstItem() ?? 0 }} to {{ $brands->lastItem() ?? 0 }} of {{ $brands->total() }} entries
                    </div>
                    <div class="pagination-links">
                        {{ $brands->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-award display-1" style="color: #718096 !important;"></i>
                    <h4 class="mt-3" style="color: #2d3748 !important;">No Brands Found</h4>
                    <p style="color: #4a5568 !important;">Start by creating your first brand to organize your products.</p>
                    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary"
                       style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                        <i class="bi bi-plus-circle me-2"></i>Create First Brand
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN BRANDS PAGE - Professional Styling */
    .brand-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .brand-card:hover .brand-name {
        color: #3182ce !important;
    }
    
    /* Clean Search Input Styling */
    #search-brands::placeholder {
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
