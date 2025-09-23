    @extends('admin.dashboard')

@section('content')

<script>
// CRITICAL FIX: Define search functions immediately in global scope
window.handleSearchKeyup = function(input) {
    const searchTerm = input.value.trim();
    const minSearchLength = 2;
    
    console.log('Enhanced Search - onkeyup triggered:', searchTerm);
    
    // Force clean professional styling (CLEAN COLORS)
    input.style.background = '#ffffff';
    input.style.color = '#1a202c';
    input.style.border = '2px solid #e2e8f0';   
    
    // Force white placeholder through JavaScript
    if (input.placeholder) {
        input.setAttribute('data-placeholder', input.placeholder);
        // Force re-render placeholder
        const placeholder = input.placeholder;
        input.placeholder = '';
        setTimeout(() => {
            input.placeholder = placeholder;
        }, 1);
    }
    
    // Advanced visual feedback
    if (searchTerm.length >= minSearchLength) {
        // Active search state - Clean Professional
        input.style.borderColor = '#3182ce'; // Blue for active search
        input.style.boxShadow = '0 0 0 4px rgba(49, 130, 206, 0.15)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(-1px)';
        
        // Show search count preview
        if (typeof showSearchPreview === 'function') showSearchPreview(searchTerm);
        
    } else if (searchTerm.length > 0 && searchTerm.length < minSearchLength) {
        // Typing but not enough characters - Clean Warning
        input.style.borderColor = '#d69e2e'; // Professional orange
        input.style.boxShadow = '0 0 0 3px rgba(214, 158, 46, 0.15)';
        input.style.background = '#fffbeb';
        input.style.transform = 'translateY(0)';
        
        if (typeof hideSearchPreview === 'function') hideSearchPreview();
        
    } else {
        // Empty or cleared - Clean Default
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
        input.style.background = '#ffffff';
        input.style.transform = 'translateY(0)';
        
        if (typeof hideSearchPreview === 'function') hideSearchPreview();
    }
    
    // Enhanced loading indicator
    if (typeof showSearchLoading === 'function') showSearchLoading(searchTerm.length >= minSearchLength);
    
    // Smart auto-submit with minimum length requirement
    clearTimeout(window.searchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.searchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                console.log('Auto-submitting enhanced search for:', searchTerm);
                if (typeof showSearchLoading === 'function') showSearchLoading(false);
                if (typeof hideSearchPreview === 'function') hideSearchPreview();
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleSearchKeydown = function(event, input) {
    // Handle Enter key
    if (event.key === 'Enter') {
        event.preventDefault();
        console.log('Enter pressed - immediate search');
        if (typeof hideSearchPreview === 'function') hideSearchPreview();
        if (typeof showSearchLoading === 'function') showSearchLoading(false);
        input.closest('form').submit();
    }
    
    // Handle Escape key
    if (event.key === 'Escape') {
        input.value = '';
        input.style.borderColor = '#64748b';
        input.style.boxShadow = 'none';
        if (typeof hideSearchPreview === 'function') hideSearchPreview();
        if (typeof showSearchLoading === 'function') showSearchLoading(false);
        input.blur();
    }
};

window.handleSearchFocus = function(input) {
    console.log('Search input focused');
    input.style.borderColor = '#3b82f6';
    input.style.boxShadow = '0 0 0 2px rgba(59, 130, 246, 0.2)';
    
    // Show search tips if empty
    if (input.value.trim().length === 0) {
        if (typeof showSearchTips === 'function') showSearchTips();
    }
};

window.handleSearchBlur = function(input) {
    console.log('Search input blurred');
    setTimeout(function() {
        if (input.value.trim().length === 0) {
            input.style.borderColor = '#64748b';
            input.style.boxShadow = 'none';
            if (typeof hideSearchTips === 'function') hideSearchTips();
        }
        if (typeof hideSearchPreview === 'function') hideSearchPreview();
    }, 150);
};

console.log('CRITICAL FIX: Global search functions defined at top of content');
</script>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: var(--text-primary); font-weight: var(--font-semibold);">
                📂 Categories Management
            </h2>
            <p class="text-muted mb-0">Manage your product categories and hierarchy</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Category
        </a>
    </div>

    <!-- Filters and Search - Clean Professional Design -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 2rem !important;">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Categories</label>
                    <div class="search-input-container" style="position: relative;">
                        <input type="text" 
                               name="search" 
                               id="search-categories"
                               class="form-control" 
                               placeholder="🔍 Search by name, description, or slug..." 
                               value="{{ request('search') }}"
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                               onkeyup="handleSearchKeyup(this)"
                               onkeydown="handleSearchKeydown(event, this)"
                               onfocus="handleSearchFocus(this)"
                               onblur="handleSearchBlur(this)"
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
                    <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Parent Category</label>
                    <select name="parent_id" class="form-control" 
                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                        <option value="">All Categories</option>
                        <option value="root" {{ request('parent_id') === 'root' ? 'selected' : '' }}>Root Categories</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2" 
                            style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"
                            onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.25) !important';"
                            onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1) !important';">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary" 
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
    <div class="card mb-4" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="card-body">
            <form id="bulk-actions-form" method="POST" action="{{ route('admin.categories.bulk') }}">
                @csrf
                <div class="d-flex align-items-center gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select-all">
                        <label class="form-check-label" for="select-all" style="color: var(--text-secondary);">
                            Select All
                        </label>
                    </div>
                    <select name="action" class="form-control" style="width: auto; background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to perform this action?')">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card" style="background: var(--bg-card); border: 1px solid var(--border-color);">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" style="color: var(--text-primary);">
                        <thead style="border-bottom: 2px solid var(--border-color);">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all-table">
                                </th>
                                <th width="10%">Image</th>
                                <th width="25%">Category</th>
                                <th width="15%">Parent</th>
                                <th width="10%">Products</th>
                                <th width="10%">Contacts</th>
                                <th width="10%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr style="border-bottom: 1px solid var(--border-light);">
                                    <td>
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-checkbox">
                                    </td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; border-radius: 4px;">
                                                <i class="bi bi-image" style="color: var(--text-muted);"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1" style="color: #000000 !important;">{{ $category->name }}</h6>
                                            <small class="text-muted">{{ $category->slug }}</small>
                                            @if($category->description)
                                                <p class="mb-0 text-muted small">{{ Str::limit($category->description, 50) }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-info">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="badge bg-primary">Root Category</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->products_count }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $contactCount = $category->contacts_count ?? $category->contacts()->count();
                                        @endphp
                                        <a href="{{ route('admin.categories.contacts', $category) }}" 
                                           class="btn btn-sm btn-outline-info d-flex align-items-center gap-1"
                                           title="Manage contact messages for this category"
                                           style="min-width: 100px; justify-content: center;">
                                            <i class="bi bi-envelope-fill"></i>
                                            <span class="badge bg-white text-info ms-1">{{ $contactCount }}</span>
                                            @if($contactCount > 0)
                                                <span class="text-success ms-1">●</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" 
                                                   type="checkbox" 
                                                   data-id="{{ $category->id }}"
                                                   {{ $category->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" style="color: var(--text-secondary);">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category) }}" 
                                               class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Professional Pagination -->
                <div class="pagination-container mt-4" style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
                    <div class="pagination-info" style="color: #6c757d; font-weight: 400; font-size: 14px; white-space: nowrap;">
                        Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} entries
                    </div>
                    <div class="pagination-links">
                        {{ $categories->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-folder2-open display-1" style="color: var(--text-muted);"></i>
                    <h4 class="mt-3" style="color: var(--text-secondary);">No Categories Found</h4>
                    <p class="text-muted">Start by creating your first category to organize your products.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create First Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Helper functions for search functionality - defined after main functions above

// Force White Placeholder on Page Load - CRITICAL FIX
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-categories');
    if (searchInput) {
        console.log('Forcing white placeholder on page load');
        
        // Apply comprehensive styling
        searchInput.style.background = 'linear-gradient(135deg, #334155 0%, #475569 100%)';
        searchInput.style.color = '#ffffff';
        searchInput.style.border = '1px solid #64748b';
        
        // Force placeholder refresh
        const originalPlaceholder = searchInput.placeholder;
        searchInput.placeholder = '';
        setTimeout(() => {
            searchInput.placeholder = originalPlaceholder;
            console.log('White placeholder restored:', originalPlaceholder);
        }, 10);
    }
});

// Helper functions for search functionality

// Show search results preview
function showSearchPreview(searchTerm) {
    let preview = document.getElementById('search-preview');
    if (!preview) {
        preview = document.createElement('div');
        preview.id = 'search-preview';
        preview.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg,rgb(23, 32, 46) 0%,rgb(55, 79, 113) 100%);
            border: 1px solid #3b82f6;
            border-radius: 0 0 8px 8px;
            padding: 8px 12px;
            color: #ffffff;
            font-size: 12px;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        document.getElementById('search-categories').parentElement.style.position = 'relative';
        document.getElementById('search-categories').parentElement.appendChild(preview);
    }
    
    preview.innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-search text-info"></i>
            <span>Searching for: "<strong>${searchTerm}</strong>"</span>
            <div class="ms-auto">
                <i class="bi bi-arrow-return-left text-muted"></i>
                <small class="text-muted">Press Enter</small>
            </div>
        </div>
    `;
    preview.style.display = 'block';
}

// Hide search preview
function hideSearchPreview() {
    const preview = document.getElementById('search-preview');
    if (preview) {
        preview.style.display = 'none';
    }
}

// All search handlers are now defined as global window functions above

// Show search tips
function showSearchTips() {
    let tips = document.getElementById('search-tips');
    if (!tips) {
        tips = document.createElement('div');
        tips.id = 'search-tips';
        tips.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border: 1px solid #475569;
            border-radius: 0 0 8px 8px;
            padding: 12px;
            color: #cbd5e1;
            font-size: 11px;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        document.getElementById('search-categories').parentElement.appendChild(tips);
    }
    
    tips.innerHTML = `
        <div class="search-tips-content">
            <div class="mb-2"><strong style="color: #ffffff;">💡 Search Tips:</strong></div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-secondary">Name</span>
                <span class="badge bg-secondary">Description</span>
                <span class="badge bg-secondary">Slug</span>
            </div>
            <div class="mt-2 text-muted" style="font-size: 10px;">
                <i class="bi bi-info-circle me-1"></i>Minimum 2 characters • Press Enter to search immediately
            </div>
        </div>
    `;
    tips.style.display = 'block';
}

// Hide search tips
function hideSearchTips() {
    const tips = document.getElementById('search-tips');
    if (tips) {
        tips.style.display = 'none';
    }
}

// Show/hide search loading indicator
function showSearchLoading(show) {
    let loader = document.getElementById('search-loader');
    if (show) {
        if (!loader) {
            loader = document.createElement('div');
            loader.id = 'search-loader';
            loader.innerHTML = '<i class="bi bi-search text-info"></i>';
            loader.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #3b82f6;';
            document.getElementById('search-categories').parentElement.style.position = 'relative';
            document.getElementById('search-categories').parentElement.appendChild(loader);
        }
        loader.style.display = 'block';
    } else {
        if (loader) {
            loader.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const selectAllTableCheckbox = document.getElementById('select-all-table');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    
    [selectAllCheckbox, selectAllTableCheckbox].forEach(checkbox => {
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                categoryCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                // Sync both select-all checkboxes
                if (selectAllCheckbox && selectAllTableCheckbox) {
                    selectAllCheckbox.checked = this.checked;
                    selectAllTableCheckbox.checked = this.checked;
                }
            });
        }
    });
    
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const categoryId = this.dataset.id;
            const isActive = this.checked;
            
            fetch(`/admin/categories/${categoryId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the label
                    const label = this.nextElementSibling;
                    label.textContent = data.is_active ? 'Active' : 'Inactive';
                    
                    // Show success message
                    showToast(data.message, 'success');
                } else {
                    // Revert the toggle if failed
                    this.checked = !isActive;
                    showToast('Failed to update category status', 'error');
                }
            })
            .catch(error => {
                // Revert the toggle if failed
                this.checked = !isActive;
                showToast('An error occurred while updating status', 'error');
            });
        });
    });
    
    // Bulk actions form submission
    document.getElementById('bulk-actions-form').addEventListener('submit', function(e) {
        const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
        const action = this.querySelector('select[name="action"]').value;
        
        if (selectedCategories.length === 0) {
            e.preventDefault();
            showToast('Please select at least one category', 'warning');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            showToast('Please select an action', 'warning');
            return;
        }
        
        // Add selected category IDs to form
        selectedCategories.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'categories[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
});

function showToast(message, type = 'info') {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'error' ? 'danger' : type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}
</script>
@endpush

@push('styles')
<style>
    /* Category Table Specific Styling */
    .card:has(.table) .table-hover tbody tr:hover {
        background-color: #4a5568 !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
        transition: all 0.2s ease !important;
    }

    /* Category Table Header */
    .card:has(.table) thead {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%) !important;
        color: #ffffff !important;
    }

    .card:has(.table) thead th {
        border: none !important;
        padding: 16px 12px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        color: #ffffff !important;
    }

    .card:has(.table) thead th:first-child {
        border-top-left-radius: 12px !important;
    }

    .card:has(.table) thead th:last-child {
        border-top-right-radius: 12px !important;
    }

    /* Category Table Rows */
    .card:has(.table) tbody tr {
        transition: all 0.2s ease !important;
        border: none !important;
    }

    .card:has(.table) tbody tr:nth-child(even) {
        background-color: #2d3748 !important;
        color: #ffffff !important;
    }

    .card:has(.table) tbody tr:nth-child(odd) {
        background-color: #1a202c !important;
        color: #ffffff !important;
    }

    .card:has(.table) tbody td {
        padding: 16px 12px !important;
        border: none !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #4a5568 !important;
    }

    /* Category Image Styling */
    .card:has(.table) .img-thumbnail {
        width: 40px !important;
        height: 40px !important;
        object-fit: cover !important;
        border-radius: 8px !important;
        border: 2px solid #e2e8f0 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .card:has(.table) .img-thumbnail:hover {
        border-color: #667eea !important;
        transform: scale(1.05) !important;
        box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2) !important;
    }

    .card:has(.table) .bg-secondary {
        background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%) !important;
        border: 2px solid #4a5568 !important;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        color: #ffffff !important;
    }

    /* ALL Category Name Styling - Force Black Text */
    .card:has(.table) .mb-1,
    .card:has(.table) .mb-1[style],
    .card:has(.table) h6.mb-1,
    .card:has(.table) td .mb-1,
    .card:has(.table) div .mb-1 {
        color: #000000 !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        margin-bottom: 4px !important;
    }
    
    /* Force override any inline styles */
    .card:has(.table) * .mb-1 {
        color: #000000 !important;
    }

    .card:has(.table) .text-muted {
        color: #cbd5e0 !important;
        font-size: 12px !important;
    }

    /* Badge Styling */
    .card:has(.table) .badge.bg-info {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .card:has(.table) .badge.bg-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .card:has(.table) .badge.bg-secondary {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 6px 10px !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    /* Contact Button Styling */
    .card:has(.table) .btn-outline-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        border: none !important;
        color: #ffffff !important;
        padding: 8px 12px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
        min-width: 80px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 4px !important;
    }

    .card:has(.table) .btn-outline-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(6, 182, 212, 0.3) !important;
    }

    .card:has(.table) .btn-outline-info .badge {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
        padding: 2px 6px !important;
        border-radius: 4px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
    }

    /* Action Buttons Styling */
    .card:has(.table) .btn-outline-info:not(.btn-outline-info:has(.badge)) {
        background: transparent !important;
        border: 2px solid #3b82f6 !important;
        color: #3b82f6 !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
    }

    .card:has(.table) .btn-outline-info:not(.btn-outline-info:has(.badge)):hover {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3) !important;
    }

    .card:has(.table) .btn-outline-primary {
        background: transparent !important;
        border: 2px solid #f59e0b !important;
        color: #f59e0b !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
    }

    .card:has(.table) .btn-outline-primary:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3) !important;
    }

    .card:has(.table) .btn-outline-danger {
        background: transparent !important;
        border: 2px solid #ef4444 !important;
        color: #ef4444 !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 6px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
    }

    .card:has(.table) .btn-outline-danger:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3) !important;
    }

    /* Status Switch Styling */
    .card:has(.table) .form-check-input {
        width: 40px !important;
        height: 20px !important;
        background: #e2e8f0 !important;
        border: none !important;
        border-radius: 10px !important;
        transition: all 0.2s ease !important;
    }

    .card:has(.table) .form-check-input:checked {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border: none !important;
    }

    .card:has(.table) .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
    }

    .card:has(.table) .form-check-label {
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #cbd5e0 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    /* General table hover for other tables */
    .table-hover tbody tr:hover {
        background-color: var(--bg-card-hover) !important;
    }
    
    .btn-group .btn {
        border-color: var(--border-color);
    }
    
    .btn-outline-info:hover {
        background-color: var(--info-color);
        border-color: var(--info-color);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-outline-danger:hover {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    /* Enhanced contact badge styling */
    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
        border: none !important;
        padding: 6px 12px !important;
        border-radius: 6px !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 2px 4px rgba(23, 162, 184, 0.2) !important;
    }
    
    .badge.bg-info:hover {
        background: linear-gradient(135deg, #138496 0%, #117a8b 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3) !important;
        text-decoration: none !important;
    }
    
    .badge.bg-info i {
        font-size: 0.8em;
    }
    
    /* Enhanced contact action button */
    .btn-outline-info {
        border-color: #17a2b8 !important;
        color: #17a2b8 !important;
        background: rgba(23, 162, 184, 0.1) !important;
        transition: all 0.2s ease !important;
    }
    
    .btn-outline-info:hover {
        background: #17a2b8 !important;
        border-color: #17a2b8 !important;
        color: white !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3) !important;
    }
    
    .btn-outline-info .badge {
        font-size: 0.7em !important;
        padding: 2px 6px !important;
    }
    
    .btn-outline-info:hover .badge {
        background: rgba(255, 255, 255, 0.9) !important;
        color: #17a2b8 !important;
    }
    
    /* White placeholder text for search and filter inputs with onkeyup support */
    .form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        border: 1px solid #64748b !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
    }
    
    .form-control:focus {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        border: 2px solid #3b82f6 !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
    }
    
    /* CLEAN SEARCH CATEGORIES - Professional Placeholder Style */
    #search-categories::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    #search-categories::-webkit-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    #search-categories::-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    #search-categories:-ms-input-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    #search-categories:-moz-placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
        font-style: normal !important;
    }
    
    /* Additional fallback for search input container */
    .search-input-container input::placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    .search-input-container input::-webkit-input-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    .search-input-container input::-moz-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    /* Your Requested Style - Applied to All Form Controls */
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
    }
    
    .form-control::-webkit-input-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
    }
    
    .form-control::-moz-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
    }
    
    .form-control:-ms-input-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
    }
    
    .form-control:-moz-placeholder {
        color: rgba(255, 255, 255, 0.75) !important;
        opacity: 1 !important;
    }
    
    /* CLEAN SEARCH INPUT - Professional Styling */
    #search-categories {
        background: #ffffff !important;
        border: 2px solid #e2e8f0 !important;
        color: #1a202c !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    #search-categories:hover {
        border-color: #cbd5e0 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }
    
    #search-categories:focus {
        background: #ffffff !important;
        border: 2px solid #3182ce !important;
        color: #1a202c !important;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15), 0 2px 8px rgba(49, 130, 206, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px) !important;
    }
    
    /* Form labels to white */
    .form-label {
        color: #ffffff !important;
        font-weight: 600 !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    /* Select dropdown styling */
    select.form-control {
        background: linear-gradient(135deg, #334155 0%, #475569 100%) !important;
        color: #ffffff !important;
    }
    
    select.form-control option {
        background: #334155 !important;
        color: #ffffff !important;
    }
    
    /* Pagination styling for white background */
    .pagination .page-link {
        background: white !important;
        border: 2px solid #ddd !important;
        color: #333 !important;
        margin: 0 2px;
        border-radius: 6px !important;
    }
    
    .pagination .page-link:hover {
        background: #f8f9fa !important;
        border-color: #007bff !important;
        color: #007bff !important;
    }
    
    .pagination .page-item.active .page-link {
        background: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
    }
    
    .pagination .page-item.disabled .page-link {
        background: #f8f9fa !important;
        border-color: #ddd !important;
        color: #666 !important;
    }
    
    /* Professional pagination matching your image */
    .pagination-container {
        background: white !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 8px !important;
        padding: 12px 20px !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 20px;
        min-height: 50px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .pagination-info {
        flex-shrink: 0;
        white-space: nowrap;
        min-width: fit-content;
        font-size: 14px !important;
        color: #6c757d !important;
        font-weight: 400 !important;
    }
    
    .pagination-links {
        flex-shrink: 0;
        margin-left: auto;
    }
    
    .pagination {
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        list-style: none !important;
        gap: 2px;
    }
    
    .pagination .page-item {
        margin: 0 !important;
    }
    
    .pagination .page-link {
        background: white !important;
        border: 1px solid #dee2e6 !important;
        color: #007bff !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
        border-radius: 4px !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        min-width: 40px;
        text-align: center;
        line-height: 1.2;
    }
    
    .pagination .page-item.active .page-link {
        background: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
        font-weight: 500;
    }
    
    .pagination .page-item.disabled .page-link {
        background: #f8f9fa !important;
        border-color: #dee2e6 !important;
        color: #6c757d !important;
        cursor: not-allowed;
    }
    
    .pagination .page-link:hover:not(.disabled) {
        background: #e9ecef !important;
        border-color: #007bff !important;
        color: #0056b3 !important;
    }
    
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            gap: 10px;
        }
        
        .pagination-links {
            margin-left: 0;
        }
    }
</style>
@endpush
@endsection
