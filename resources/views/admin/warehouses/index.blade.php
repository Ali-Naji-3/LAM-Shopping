@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                🏪 Warehouses Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage warehouse locations and inventory centers • {{ $statistics['total_warehouses'] }} total warehouses
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-lg me-2"></i>Add Warehouse
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #3182ce !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">🏪</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['total_warehouses']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Warehouses</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 1px solid #dcfce7 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #10b981 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">✅</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['active_warehouses']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Active Warehouses</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #fed7aa !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #f59e0b !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📍</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['unique_locations']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Unique Locations</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #8b5cf6 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">👨‍💼</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['managed_warehouses']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Managed Warehouses</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem !important;">
            <form method="GET" action="{{ route('admin.warehouses.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Search Warehouses</label>
                        <input type="text" name="search" class="form-control" placeholder="🔍 Search name, code, location, manager..."
                               value="{{ request('search') }}"
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Status</label>
                        <select name="status" class="form-control"
                                style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Location</label>
                        <select name="location" class="form-control"
                                style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') === $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" style="color: transparent !important;">Actions</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"
                                    style="background: #3182ce !important; border: 1px solid #3182ce !important; color: #ffffff !important; padding: 14px 16px !important; border-radius: 8px !important; font-weight: 600 !important;">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 14px 16px !important; border-radius: 8px !important; text-decoration: none !important;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Warehouses Table -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                    Warehouses ({{ $warehouses->total() }})
                </h5>
                <div class="d-flex gap-2">
                    <!-- Bulk Actions -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 8px 12px !important; border-radius: 8px !important; font-size: 14px !important;">
                            <i class="bi bi-three-dots me-1"></i>Bulk Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                                <i class="bi bi-check-circle me-2"></i>Activate Selected
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                                <i class="bi bi-x-circle me-2"></i>Deactivate Selected
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                                <i class="bi bi-trash me-2"></i>Delete Selected
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 0 !important;">
            @if($warehouses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc !important; border-bottom: 2px solid #e2e8f0 !important;">
                            <tr>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Warehouse</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Code</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Location</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Manager</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Contact</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Status</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($warehouses as $warehouse)
                                <tr style="transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#f8fafc !important';"
                                    onmouseout="this.style.backgroundColor='transparent';">
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <input type="checkbox" name="selected_warehouses[]" value="{{ $warehouse->id }}" class="form-check-input warehouse-checkbox">
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex align-items-center">
                                            <div class="warehouse-info">
                                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    <a href="{{ route('admin.warehouses.show', $warehouse) }}"
                                                       style="color: #3182ce !important; text-decoration: none !important;"
                                                       onmouseover="this.style.textDecoration='underline !important';"
                                                       onmouseout="this.style.textDecoration='none !important';">
                                                        {{ $warehouse->name }}
                                                    </a>
                                                </div>
                                                <div style="color: #4a5568 !important; font-size: 12px !important;">
                                                    {{ $warehouse->total_inventory }} inventory items
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <span class="badge" style="background: #3182ce !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 10px !important; border-radius: 15px !important; font-family: monospace !important;">
                                            {{ $warehouse->code }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">
                                            <i class="bi bi-geo-alt me-1" style="color: #f59e0b !important;"></i>{{ $warehouse->location }}
                                        </div>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        @if($warehouse->manager)
                                            <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important;">
                                                <i class="bi bi-person me-1" style="color: #8b5cf6 !important;"></i>{{ $warehouse->manager }}
                                            </div>
                                        @else
                                            <span style="color: #9ca3af !important; font-size: 12px !important; font-style: italic;">No manager assigned</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        @if($warehouse->contact_number)
                                            <div style="color: #1a202c !important; font-weight: 500 !important; font-size: 13px !important; font-family: monospace !important;">
                                                <i class="bi bi-telephone me-1" style="color: #10b981 !important;"></i>{{ $warehouse->formatted_contact_number }}
                                            </div>
                                        @else
                                            <span style="color: #9ca3af !important; font-size: 12px !important; font-style: italic;">No contact</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <span class="badge" style="background: {{ $warehouse->status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                            {{ $warehouse->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-sm btn-outline-info"
                                               style="color: #06b6d4 !important; border-color: #06b6d4 !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-sm btn-outline-warning"
                                               style="color: #f59e0b !important; border-color: #f59e0b !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.warehouses.toggleStatus', $warehouse) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $warehouse->is_active ? 'danger' : 'success' }}"
                                                        style="color: {{ $warehouse->is_active ? '#ef4444' : '#10b981' }} !important; border-color: {{ $warehouse->is_active ? '#ef4444' : '#10b981' }} !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important;">
                                                    <i class="bi bi-{{ $warehouse->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.warehouses.destroy', $warehouse) }}" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this warehouse?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        style="color: #ef4444 !important; border-color: #ef4444 !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important;">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center" style="padding: 1.5rem 2rem !important; border-top: 1px solid #f1f5f9 !important;">
                    <div style="color: #4a5568 !important; font-size: 14px !important;">
                        Showing {{ $warehouses->firstItem() }}-{{ $warehouses->lastItem() }} of {{ $warehouses->total() }}
                    </div>
                    <div>
                        {{ $warehouses->appends(request()->query())->links('pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center" style="padding: 3rem !important;">
                    <i class="bi bi-building" style="color: #9ca3af !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                    <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No warehouses found</h6>
                    <p style="color: #9ca3af !important; font-size: 14px !important;">Try adjusting your search criteria or add some warehouses.</p>
                    <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary"
                       style="background: #3182ce !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;">
                        <i class="bi bi-plus-lg me-2"></i>Add First Warehouse
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Select all functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.warehouse-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk actions
    function bulkAction(action) {
        const selectedWarehouses = document.querySelectorAll('.warehouse-checkbox:checked');
        if (selectedWarehouses.length === 0) {
            alert('Please select at least one warehouse.');
            return;
        }

        let message = '';
        switch(action) {
            case 'activate':
                message = `Activate ${selectedWarehouses.length} warehouses?`;
                break;
            case 'deactivate':
                message = `Deactivate ${selectedWarehouses.length} warehouses?`;
                break;
            case 'delete':
                message = `Are you sure you want to delete ${selectedWarehouses.length} warehouses?`;
                break;
            default:
                message = `Perform this action on ${selectedWarehouses.length} warehouses?`;
        }

        if (!confirm(message)) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.warehouses.bulk") }}';
        form.innerHTML = `
            @csrf
            <input type="hidden" name="action" value="${action}">
        `;

        selectedWarehouses.forEach(warehouse => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_warehouses[]';
            input.value = warehouse.value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }

    // Clear modal backdrops on page load
    document.addEventListener('DOMContentLoaded', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        if (backdrops.length > 0) {
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            console.log('Modal backdrops cleared');
        }
    });
</script>
@endpush
@endsection
