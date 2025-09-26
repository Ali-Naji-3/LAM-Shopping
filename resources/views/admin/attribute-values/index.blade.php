@extends('admin.dashboard')

@section('content')

<script>
// Global search functions for attribute values
window.handleValueSearchKeyup = function(input) {
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

    clearTimeout(window.valueSearchTimeout);
    if (searchTerm.length >= minSearchLength || searchTerm.length === 0) {
        window.valueSearchTimeout = setTimeout(function() {
            if (searchTerm !== '{{ request('search') }}') {
                input.closest('form').submit();
            }
        }, 600);
    }
};

window.handleValueSearchKeydown = function(event, input) {
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

window.handleValueSearchFocus = function(input) {
    input.style.borderColor = '#3182ce';
    input.style.boxShadow = '0 0 0 2px rgba(49, 130, 206, 0.2)';
};

window.handleValueSearchBlur = function(input) {
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
                📝 Attribute Values Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage all values for your product attributes • {{ $attributeValues->total() }} total values
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attributeValues.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-circle me-2"></i>Add New Value
            </a>
            <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary"
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-gear me-2"></i>Manage Attributes
            </a>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem 2rem !important;">
            <form method="GET" action="{{ route('admin.attributeValues.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Search Values</label>
                        <div class="search-input-container" style="position: relative;">
                            <input type="text"
                                   name="search"
                                   id="search-values"
                                   class="form-control"
                                   placeholder="🔍 Search by value or attribute name..."
                                   value="{{ request('search') }}"
                                   style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px 14px 45px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   onkeyup="handleValueSearchKeyup(this)"
                                   onkeydown="handleValueSearchKeydown(event, this)"
                                   onfocus="handleValueSearchFocus(this)"
                                   onblur="handleValueSearchBlur(this)"
                                   autocomplete="off">
                            <i class="bi bi-search search-icon"
                               style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #718096 !important; opacity: 0.8; pointer-events: none; z-index: 10; font-size: 16px;"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">Filter by Attribute</label>
                        <select name="attribute_id" class="form-control" style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important;">
                            <option value="">All Attributes</option>
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ request('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                    {{ $attribute->name }} ({{ ucfirst($attribute->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-outline-primary flex-fill"
                                    style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            @if(request('search') || request('attribute_id'))
                                <a href="{{ route('admin.attributeValues.index') }}" class="btn btn-outline-secondary"
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

    @if($attributeValues->count() > 0)
        <!-- Bulk Actions Card -->
        <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 1rem 2rem !important;">
                <form id="bulk-actions-form" method="POST" action="{{ route('admin.attributeValues.bulk') }}">
                    @csrf
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            <label class="form-check-label" for="select-all" style="color: #2d3748 !important; font-weight: 500 !important; font-size: 14px !important;">
                                Select All
                            </label>
                        </div>
                        <select name="action" class="form-control" style="width: auto; background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 10px 16px !important; border-radius: 8px !important; font-size: 14px !important; font-weight: 500 !important;">
                            <option value="">Bulk Actions</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="submit" class="btn btn-outline-warning"
                                style="color: #d69e2e !important; border-color: #d69e2e !important; background: #ffffff !important; padding: 10px 16px !important; border-radius: 8px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important;"
                                onclick="return confirm('Are you sure you want to perform this bulk action?')">
                            <i class="bi bi-lightning me-1"></i> Apply
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Values Display Grid -->
        <div class="row">
            @foreach($attributeValues as $value)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="value-card"
                         style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; padding: 1.5rem !important; transition: all 0.2s ease !important; height: 100% !important;"
                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1) !important'; this.style.borderColor='#3182ce !important';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.borderColor='#e2e8f0 !important';">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <!-- Attribute Type Icon -->
                            <div class="type-icon" style="background: {{ $value->attribute->type === 'text' ? '#3182ce' : ($value->attribute->type === 'select' ? '#10b981' : ($value->attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; width: 40px !important; height: 40px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                                <i class="bi bi-{{ $value->attribute->type === 'text' ? 'input-cursor-text' : ($value->attribute->type === 'select' ? 'list-ul' : ($value->attribute->type === 'checkbox' ? 'check-square' : 'circle')) }}" style="color: #ffffff !important; font-size: 16px !important;"></i>
                            </div>
                            <!-- Checkbox for bulk actions -->
                            <div class="form-check">
                                <input class="form-check-input value-checkbox" type="checkbox" value="{{ $value->id }}" name="selected_values[]">
                            </div>
                        </div>

                        <!-- Attribute Name -->
                        <div class="mb-2">
                            <span class="badge" style="background-color: {{ $value->attribute->type === 'text' ? '#3182ce' : ($value->attribute->type === 'select' ? '#10b981' : ($value->attribute->type === 'checkbox' ? '#f59e0b' : '#8b5cf6')) }} !important; color: #ffffff !important; font-size: 10px !important; padding: 4px 8px !important; border-radius: 12px !important; text-transform: uppercase !important;">
                                {{ $value->attribute->name }}
                            </span>
                        </div>

                        <!-- Value Display -->
                        <div class="mb-3">
                            @if($value->attribute->name === 'Color' && in_array(strtolower($value->value), ['red', 'blue', 'green', 'black', 'white', 'yellow', 'pink', 'purple', 'orange', 'brown', 'gray']))
                                <!-- Color Swatch -->
                                <div class="d-flex align-items-center gap-2">
                                    <div class="color-swatch" style="width: 30px !important; height: 30px !important; border-radius: 50% !important; background-color: {{ strtolower($value->value) === 'black' ? '#000000' : (strtolower($value->value) === 'white' ? '#ffffff' : strtolower($value->value)) }} !important; border: 2px solid #e2e8f0 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;"></div>
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin: 0 !important;">{{ $value->value }}</h6>
                                </div>
                            @else
                                <!-- Regular Value -->
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin: 0 !important;">{{ $value->value }}</h6>
                            @endif
                        </div>

                        <!-- Statistics -->
                        <div class="mb-3" style="padding: 10px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div style="color: #3182ce !important; font-weight: 700 !important; font-size: 18px !important;">{{ $value->products_count ?? 0 }}</div>
                                    <div style="color: #4a5568 !important; font-size: 11px !important; font-weight: 500 !important;">Products</div>
                                </div>
                                <div class="col-6">
                                    <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important;">{{ $value->id }}</div>
                                    <div style="color: #4a5568 !important; font-size: 11px !important; font-weight: 500 !important;">Value ID</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.attributeValues.edit', $value) }}" class="btn btn-sm btn-outline-primary flex-fill"
                               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('admin.attributeValues.show', $value) }}" class="btn btn-sm btn-outline-info flex-fill"
                               style="color: #0891b2 !important; border-color: #0891b2 !important; background: #ffffff !important; padding: 8px 12px !important; border-radius: 6px !important; font-size: 12px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#0891b2 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#0891b2 !important';">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.attributeValues.destroy', $value) }}" class="d-inline flex-fill"
                                  onsubmit="return confirm('Are you sure you want to delete this value?')">
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
                Showing {{ $attributeValues->firstItem() ?? 0 }} to {{ $attributeValues->lastItem() ?? 0 }} of {{ $attributeValues->total() }} entries
            </div>
            <div class="pagination-links">
                {{ $attributeValues->appends(request()->query())->links('pagination.custom') }}
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
            <div class="card-body" style="padding: 3rem !important;">
                <div class="text-center">
                    <i class="bi bi-plus-circle" style="color: #718096 !important; font-size: 4rem !important; margin-bottom: 1.5rem !important;"></i>
                    <h4 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">No Attribute Values Found</h4>
                    <p style="color: #4a5568 !important; font-size: 16px !important; line-height: 1.6 !important; max-width: 500px !important; margin: 0 auto 2rem auto !important;">
                        @if(request('search') || request('attribute_id'))
                            No values match your current search criteria. Try adjusting your filters.
                        @else
                            Start by creating attribute values to define the options available for your product attributes.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.attributeValues.create') }}" class="btn btn-primary"
                           style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 10px !important; font-weight: 600 !important;">
                            <i class="bi bi-plus-circle me-2"></i>Create First Value
                        </a>
                        @if(request('search') || request('attribute_id'))
                            <a href="{{ route('admin.attributeValues.index') }}" class="btn btn-outline-secondary"
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
    const valueCheckboxes = document.querySelectorAll('.value-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            valueCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsState();
        });
    }

    valueCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsState();
        });
    });

    function updateSelectAllState() {
        if (selectAllCheckbox) {
            const checkedCount = document.querySelectorAll('.value-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === valueCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < valueCheckboxes.length;
        }
    }

    function updateBulkActionsState() {
        const selectedCount = document.querySelectorAll('.value-checkbox:checked').length;
        const bulkForm = document.getElementById('bulk-actions-form');

        if (bulkForm) {
            const actionSelect = bulkForm.querySelector('select[name="action"]');
            if (selectedCount > 0) {
                actionSelect.style.borderColor = '#3182ce';
                actionSelect.style.background = '#f0f9ff';
            } else {
                actionSelect.style.borderColor = '#e2e8f0';
                actionSelect.style.background = '#ffffff';
            }
        }
    }
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ATTRIBUTE VALUES INDEX - Professional Styling */
    .value-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .color-swatch {
        transition: all 0.2s ease !important;
    }

    .value-card:hover .color-swatch {
        transform: scale(1.1) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
    }

    /* Clean Search Input Styling */
    #search-values::placeholder {
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .value-card {
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
