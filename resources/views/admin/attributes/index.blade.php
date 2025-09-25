@extends('admin.dashboard')

@section('content')

<script>
// CRITICAL FIX: Define search functions immediately in global scope
window.handleAttributeSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    console.log('Enhanced Attribute Search - onkeyup triggered:', searchTerm);
    
    // Force clean professional styling
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';
    
    // Advanced visual feedback
    if (searchTerm.length >= minSearchLength) {
        // Active search state - Clean Professional
        input.style.borderColor = '#3182ce';
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(-1px)';
        
    } else if (searchTerm.length > 0 && searchTerm.length < minSearchLength) {
        // Typing but not enough characters - Clean Warning
        input.style.borderColor = '#d69e2e';
        input.style.boxShadow = '0 0 0 3px rgba(214, 158, 46, 0.15)';
        input.style.background = '#fffbeb';
        input.style.transform = 'translateY(0)';
        
    } else {
        // Empty or cleared - Clean Default
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(0)';
    }
    
    // Smart auto-submit with minimum length requirement
    clearTimeout(window.attributeSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.attributeSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                console.log('Auto-submitting attribute search for:', searchTerm);
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleAttributeSearchKeydown = function(event, input) {
    if (event.key === 'Enter') {
        event.preventDefault();
        console.log('Enter pressed - immediate attribute search');
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
    console.log('Attribute search input focused');
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleAttributeSearchBlur = function(input) {
    console.log('Attribute search input blurred');
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#e2e8f0';
            input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        }
    }, 150);
};

console.log('CRITICAL FIX: Global attribute search functions defined at top of content');
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important;">
                🔧 Attributes Management
            </h2>
            <p class="text-muted mb-0" style="color: #4a5568 !important;">Manage product attributes and their types</p>
        </div>
        <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary"
           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <i class="bi bi-plus-circle me-2"></i>Add New Attribute
        </a>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            <form method="GET" action="{{ route('admin.attributes.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Attributes</label>
                    <div class="search-input-container" style="position: relative;">
                        <input type="text" 
                               name="search" 
                               id="search-attributes"
                               class="form-control" 
                               placeholder="🔍 Search by name or slug..." 
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
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Type</label>
                    <select name="type" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Types</option>
                        <option value="text" {{ request('type') === 'text' ? 'selected' : '' }}>Text</option>
                        <option value="select" {{ request('type') === 'select' ? 'selected' : '' }}>Select</option>
                        <option value="checkbox" {{ request('type') === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        <option value="radio" {{ request('type') === 'radio' ? 'selected' : '' }}>Radio</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Required</label>
                    <select name="required" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Attributes</option>
                        <option value="yes" {{ request('required') === 'yes' ? 'selected' : '' }}>Required Only</option>
                        <option value="no" {{ request('required') === 'no' ? 'selected' : '' }}>Optional Only</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-outline-primary" 
                            style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"
                            onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary" 
                       style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; text-decoration: none !important;"
                       onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(74, 85, 104, 0.25) !important';"
                       onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-x-circle me-1"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form id="bulk-actions-form" method="POST" action="{{ route('admin.attributes.bulk') }}">
                @csrf
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select-all-attributes" 
                               style="width: 18px !important; height: 18px !important; border: 2px solid #e2e8f0 !important; border-radius: 4px !important; background-color: #ffffff !important; transition: all 0.2s ease !important;">
                        <label class="form-check-label" for="select-all-attributes" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-left: 8px !important;">
                            Select All
                        </label>
                    </div>
                    <select name="action" class="form-control" style="width: auto; background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 12px 16px !important; border-radius: 10px !important; font-size: 14px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                        <option value="">Bulk Actions</option>
                        <option value="require">Mark as Required</option>
                        <option value="unrequire">Mark as Optional</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="submit" class="btn btn-outline-warning" 
                            style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"
                            onmouseover="this.style.backgroundColor='#d69e2e !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(214, 158, 46, 0.25) !important';"
                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#d69e2e !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';"
                            onclick="return confirm('Are you sure you want to perform this bulk action?')">
                        <i class="bi bi-lightning me-1"></i> Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Attributes Grid -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            @if($attributes->count() > 0)
                <div class="row">
                    @foreach($attributes as $attribute)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="attribute-card h-100" 
                                 style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; overflow: hidden !important;"
                                 onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#e2e8f0 !important';">
                                
                                <!-- Attribute Type Header -->
                                <div class="attribute-type-header text-center py-3" style="background: linear-gradient(135deg, {{ $attribute->type === 'text' ? '#f0f9ff, #e0f2fe' : ($attribute->type === 'select' ? '#ecfdf5, #d1fae5' : ($attribute->type === 'checkbox' ? '#fef3c7, #fed7aa' : '#f3e8ff, #e9d5ff')) }}) !important;">
                                    <div class="type-icon" style="background: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; width: 50px !important; height: 50px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; margin: 0 auto 10px auto !important;">
                                        <i class="bi bi-{{ $attribute->type === 'text' ? 'input-cursor-text' : ($attribute->type === 'select' ? 'list-ul' : ($attribute->type === 'checkbox' ? 'check-square' : 'circle')) }}" style="color: #ffffff !important; font-size: 20px !important;"></i>
                                    </div>
                                    <span class="badge" style="background-color: {{ $attribute->type === 'text' ? '#3182ce' : ($attribute->type === 'select' ? '#10b981' : ($attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important; font-weight: 600 !important;">
                                        {{ $attribute->type }}
                                    </span>
                                </div>
                                
                                <!-- Attribute Info -->
                                <div class="card-body" style="padding: 1.5rem !important;">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="attribute-name mb-1" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                                            {{ $attribute->name }}
                                        </h5>
                                        <div class="form-check">
                                            <input class="form-check-input attribute-checkbox" type="checkbox" value="{{ $attribute->id }}" name="selected_attributes[]">
                                        </div>
                                    </div>
                                    
                                    <div class="attribute-meta mb-3">
                                        <small style="color: #4a5568 !important; font-size: 12px !important;">
                                            <strong>Slug:</strong> <code style="background: #f7fafc !important; color: #3182ce !important; padding: 2px 6px !important; border-radius: 4px !important; font-size: 11px !important;">{{ $attribute->slug }}</code>
                                        </small>
                                    </div>
                                    
                                    <!-- Attribute Stats -->
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <div class="stat-number" style="color: #3182ce !important; font-weight: 700 !important; font-size: 18px !important;">
                                                    {{ $attribute->attribute_values_count }}
                                                </div>
                                                <small style="color: #718096 !important; font-size: 11px !important; text-transform: uppercase !important;">Values</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-item">
                                                <span class="badge" style="background-color: {{ $attribute->is_required ? '#e53e3e' : '#10b981' }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important;">
                                                    {{ $attribute->is_required ? 'Required' : 'Optional' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-sm btn-outline-primary flex-fill"
                                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-sm btn-outline-secondary flex-fill"
                                           style="color: #6b7280 !important; border-color: #6b7280 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#6b7280 !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#6b7280 !important';">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.attributes.values', $attribute) }}" class="btn btn-sm btn-outline-success flex-fill"
                                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                            <i class="bi bi-list"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.attributes.destroy', $attribute) }}" class="d-inline flex-fill" 
                                              onsubmit="return confirm('Are you sure you want to delete this attribute?')">
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
                        </div>
                    @endforeach
                </div>

                <!-- Professional Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                    <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                        Showing {{ $attributes->firstItem() ?? 0 }} to {{ $attributes->lastItem() ?? 0 }} of {{ $attributes->total() }} entries
                    </div>
                    <div class="pagination-links">
                        {{ $attributes->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-gear display-1" style="color: #718096 !important;"></i>
                    <h4 class="mt-3" style="color: #2d3748 !important;">No Attributes Found</h4>
                    <p style="color: #4a5568 !important;">Start by creating your first attribute to organize product properties.</p>
                    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary"
                       style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                        <i class="bi bi-plus-circle me-2"></i>Create First Attribute
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality for attributes
    const selectAllCheckbox = document.getElementById('select-all-attributes');
    const attributeCheckboxes = document.querySelectorAll('.attribute-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            attributeCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }
    
    // Individual checkbox change
    attributeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(attributeCheckboxes).every(cb => cb.checked);
            const noneChecked = Array.from(attributeCheckboxes).every(cb => !cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = !allChecked && !noneChecked;
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ATTRIBUTES PAGE - Professional Styling */
    .attribute-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .attribute-card:hover .attribute-name {
        color: #3182ce !important;
    }
    
    .type-icon {
        transition: all 0.2s ease !important;
    }
    
    .attribute-card:hover .type-icon {
        transform: scale(1.1) !important;
    }
    
    /* Clean Search Input Styling */
    #search-attributes::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    #search-attributes::-webkit-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    #search-attributes::-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    #search-attributes:-ms-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    #search-attributes:-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    /* Professional Form Controls */
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
    
    /* Professional Checkbox */
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
        box-shadow: 0 0 0 2px rgba(49, 130, 206, 0.2) !important;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15) !important;
        border-color: #3182ce !important;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .attribute-card {
            margin-bottom: 1.5rem !important;
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
