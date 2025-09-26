@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">📦 Inventory Management</h1>
                    <p class="text-muted">Manage product inventory across all warehouses</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.inventory.analytics') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Analytics
                    </a>
                    <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Inventory
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Items</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($statistics['total_items']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Quantity</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($statistics['total_quantity']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Low Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($statistics['low_stock_items']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Out of Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($statistics['out_of_stock_items']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter & Search</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.inventory.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Product name, SKU, or warehouse...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="warehouse_id">Warehouse</label>
                            <select class="form-control" id="warehouse_id" name="warehouse_id">
                                <option value="">All Warehouses</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }} ({{ $warehouse->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="stock_status">Stock Status</label>
                            <select class="form-control" id="stock_status" name="stock_status">
                                <option value="">All Status</option>
                                <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="needs_reorder" {{ request('stock_status') == 'needs_reorder' ? 'selected' : '' }}>Needs Reorder</option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Inventory Records</h6>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-danger" onclick="bulkDelete()" id="bulkDeleteBtn" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
                <button class="btn btn-sm btn-warning" onclick="bulkAdjustQuantity()" id="bulkAdjustBtn" style="display: none;">
                    <i class="fas fa-edit"></i> Adjust Quantity
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Product</th>
                            <th>Warehouse</th>
                            <th>Quantity</th>
                            <th>Min Stock</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                        <tr>
                            <td><input type="checkbox" class="item-checkbox" value="{{ $inventory->id }}"></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($inventory->product && $inventory->product->image)
                                        <img src="{{ Storage::url($inventory->product->image) }}" alt="{{ $inventory->product->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-box text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $inventory->product->name ?? 'Unknown Product' }}</strong><br>
                                        <small class="text-muted">SKU: {{ $inventory->product->sku ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $inventory->warehouse->name ?? 'Unknown Warehouse' }}</strong><br>
                                    <small class="text-muted">{{ $inventory->warehouse->code ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $inventory->quantity > 0 ? 'success' : 'danger' }} badge-pill">
                                    {{ number_format($inventory->quantity) }}
                                </span>
                            </td>
                            <td>{{ number_format($inventory->minimum_stock) }}</td>
                            <td>{{ number_format($inventory->reorder_level) }}</td>
                            <td>
                                <span class="badge badge-{{ $inventory->getStockStatusColor() }}">
                                    {{ $inventory->getStockStatus() }}
                                </span>
                            </td>
                            <td>{{ $inventory->updated_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.inventory.show', $inventory) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('admin.inventory.edit', $inventory) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.inventory.destroy', $inventory) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box fa-3x mb-3"></i>
                                    <p>No inventory records found.</p>
                                    <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">Add First Inventory Record</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($inventories->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $inventories->firstItem() }}-{{ $inventories->lastItem() }} of {{ $inventories->total() }} records
                </div>
                {{ $inventories->links('pagination.custom') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Modals -->
<div class="modal fade" id="bulkAdjustModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Quantity Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="bulkAdjustForm" method="POST" action="{{ route('admin.inventory.bulk') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="action" value="adjust_quantity">
                    <input type="hidden" name="selected_items" id="selectedItemsAdjust">
                    <div class="form-group">
                        <label for="adjustment_value">Adjustment Value</label>
                        <input type="number" class="form-control" name="adjustment_value" required>
                        <small class="form-text text-muted">Use positive numbers to add stock, negative to subtract.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Checkbox functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    toggleBulkButtons();
});

document.querySelectorAll('.item-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', toggleBulkButtons);
});

function toggleBulkButtons() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkAdjustBtn = document.getElementById('bulkAdjustBtn');

    if (checkedBoxes.length > 0) {
        bulkDeleteBtn.style.display = 'inline-block';
        bulkAdjustBtn.style.display = 'inline-block';
    } else {
        bulkDeleteBtn.style.display = 'none';
        bulkAdjustBtn.style.display = 'none';
    }
}

function bulkDelete() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkedBoxes.length === 0) return;

    if (confirm(`Are you sure you want to delete ${checkedBoxes.length} inventory records?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.inventory.bulk") }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete';
        form.appendChild(actionInput);

        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

function bulkAdjustQuantity() {
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
    if (checkedBoxes.length === 0) return;

    const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
    document.getElementById('selectedItemsAdjust').value = JSON.stringify(selectedIds);
    $('#bulkAdjustModal').modal('show');
}
</script>
@endpush
@endsection
