@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">📦 Edit Inventory Record</h1>
                    <p class="text-muted">Update inventory information for {{ $inventory->product->name ?? 'Unknown Product' }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.inventory.show', $inventory) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Details
                    </a>
                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Inventory Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.inventory.update', $inventory) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_id" class="form-label">
                                        <i class="fas fa-box text-primary"></i> Product *
                                    </label>
                                    <select class="form-control @error('product_id') is-invalid @enderror" 
                                            id="product_id" name="product_id" required>
                                        <option value="">Select a product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    {{ old('product_id', $inventory->product_id) == $product->id ? 'selected' : '' }}
                                                    data-price="{{ $product->regular_price }}"
                                                    data-sku="{{ $product->sku }}">
                                                {{ $product->name }} ({{ $product->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="warehouse_id" class="form-label">
                                        <i class="fas fa-warehouse text-info"></i> Warehouse *
                                    </label>
                                    <select class="form-control @error('warehouse_id') is-invalid @enderror" 
                                            id="warehouse_id" name="warehouse_id" required>
                                        <option value="">Select a warehouse</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" 
                                                    {{ old('warehouse_id', $inventory->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }} ({{ $warehouse->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">
                                        <i class="fas fa-cubes text-success"></i> Current Quantity *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('quantity') is-invalid @enderror" 
                                           id="quantity" 
                                           name="quantity" 
                                           value="{{ old('quantity', $inventory->quantity) }}" 
                                           min="0" 
                                           required
                                           onchange="calculateStockValue()">
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Previous: {{ number_format($inventory->quantity) }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="minimum_stock" class="form-label">
                                        <i class="fas fa-exclamation-triangle text-warning"></i> Minimum Stock *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('minimum_stock') is-invalid @enderror" 
                                           id="minimum_stock" 
                                           name="minimum_stock" 
                                           value="{{ old('minimum_stock', $inventory->minimum_stock) }}" 
                                           min="0" 
                                           required>
                                    @error('minimum_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Previous: {{ number_format($inventory->minimum_stock) }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reorder_level" class="form-label">
                                        <i class="fas fa-redo text-info"></i> Reorder Level *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('reorder_level') is-invalid @enderror" 
                                           id="reorder_level" 
                                           name="reorder_level" 
                                           value="{{ old('reorder_level', $inventory->reorder_level) }}" 
                                           min="0" 
                                           required>
                                    @error('reorder_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Previous: {{ number_format($inventory->reorder_level) }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Inventory Record
                            </button>
                            <a href="{{ route('admin.inventory.show', $inventory) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="button" class="btn btn-danger float-right" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Delete Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">📊 Current Status</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="h2 mb-1 text-{{ $inventory->getStockStatusColor() }}">
                            {{ number_format($inventory->quantity) }}
                        </div>
                        <div class="text-muted">Current Quantity</div>
                        <span class="badge badge-{{ $inventory->getStockStatusColor() }} mt-2">
                            {{ $inventory->getStockStatus() }}
                        </span>
                    </div>

                    <hr>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="text-warning font-weight-bold">{{ number_format($inventory->minimum_stock) }}</div>
                            <div class="text-xs text-muted">Min Stock</div>
                        </div>
                        <div class="col-6">
                            <div class="text-info font-weight-bold">{{ number_format($inventory->reorder_level) }}</div>
                            <div class="text-xs text-muted">Reorder Level</div>
                        </div>
                    </div>

                    @if($inventory->product && $inventory->product->regular_price)
                    <hr>
                    <div class="text-center">
                        <div class="text-success font-weight-bold h5" id="currentStockValue">
                            ${{ number_format($inventory->getStockValue(), 2) }}
                        </div>
                        <div class="text-xs text-muted">Current Stock Value</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">📦 Product Information</h6>
                </div>
                <div class="card-body">
                    @if($inventory->product)
                    <div class="d-flex align-items-center mb-3">
                        @if($inventory->product->image)
                            <img src="{{ Storage::url($inventory->product->image) }}" 
                                 alt="{{ $inventory->product->name }}" 
                                 class="rounded me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-box text-white"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $inventory->product->name }}</h6>
                            <small class="text-muted">{{ $inventory->product->sku }}</small>
                        </div>
                    </div>

                    <div class="mb-2">
                        <strong>Regular Price:</strong>
                        <span class="text-success">${{ number_format($inventory->product->regular_price, 2) }}</span>
                    </div>

                    @if($inventory->product->category)
                    <div class="mb-2">
                        <strong>Category:</strong>
                        <span class="badge badge-info">{{ $inventory->product->category->name }}</span>
                    </div>
                    @endif

                    @if($inventory->product->brand)
                    <div class="mb-2">
                        <strong>Brand:</strong>
                        <span class="badge badge-secondary">{{ $inventory->product->brand->name }}</span>
                    </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('admin.products.show', $inventory->product) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> View Product
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Warehouse Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">🏪 Warehouse Information</h6>
                </div>
                <div class="card-body">
                    @if($inventory->warehouse)
                    <div class="mb-2">
                        <strong>Name:</strong>
                        <div class="text-muted">{{ $inventory->warehouse->name }}</div>
                    </div>

                    <div class="mb-2">
                        <strong>Code:</strong>
                        <div class="text-muted">{{ $inventory->warehouse->code }}</div>
                    </div>

                    <div class="mb-2">
                        <strong>Location:</strong>
                        <div class="text-muted">{{ $inventory->warehouse->location }}</div>
                    </div>

                    @if($inventory->warehouse->manager)
                    <div class="mb-2">
                        <strong>Manager:</strong>
                        <div class="text-muted">{{ $inventory->warehouse->manager }}</div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('admin.warehouses.show', $inventory->warehouse) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-external-link-alt"></i> View Warehouse
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stock Alerts -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">⚠️ Stock Alerts</h6>
                </div>
                <div class="card-body">
                    @if($inventory->isOutOfStock())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Out of Stock!</strong><br>
                            Immediate restocking required.
                        </div>
                    @elseif($inventory->isLowStock())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Low Stock Alert!</strong><br>
                            Below minimum stock level.
                        </div>
                    @elseif($inventory->needsReorder())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Reorder Recommended!</strong><br>
                            Consider reordering soon.
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Stock Levels Good!</strong><br>
                            No immediate action needed.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this inventory record?</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action cannot be undone. The inventory record for 
                    <strong>{{ $inventory->product->name ?? 'Unknown Product' }}</strong> at 
                    <strong>{{ $inventory->warehouse->name ?? 'Unknown Warehouse' }}</strong> will be permanently removed.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.inventory.destroy', $inventory) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Record
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateStockValue() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const stockValueElement = document.getElementById('currentStockValue');
    
    if (productSelect.value && quantityInput.value && stockValueElement) {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const totalValue = price * quantity;
        
        stockValueElement.textContent = '$' + totalValue.toFixed(2);
    }
}

function confirmDelete() {
    $('#deleteModal').modal('show');
}

// Initialize stock value calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateStockValue();
});

// Check for existing inventory when product or warehouse changes
document.getElementById('product_id').addEventListener('change', checkExistingInventory);
document.getElementById('warehouse_id').addEventListener('change', checkExistingInventory);

function checkExistingInventory() {
    const productId = document.getElementById('product_id').value;
    const warehouseId = document.getElementById('warehouse_id').value;
    const currentInventoryId = {{ $inventory->id }};
    
    if (productId && warehouseId) {
        fetch(`{{ route('admin.inventory.getData') }}?product_id=${productId}&warehouse_id=${warehouseId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.id && data.id != currentInventoryId) {
                    alert('An inventory record already exists for this product in the selected warehouse. Please choose a different combination.');
                    // Reset to original values
                    document.getElementById('product_id').value = {{ $inventory->product_id }};
                    document.getElementById('warehouse_id').value = {{ $inventory->warehouse_id }};
                }
            })
            .catch(error => {
                console.log('Checking existing inventory...');
            });
    }
}
</script>
@endpush
@endsection
