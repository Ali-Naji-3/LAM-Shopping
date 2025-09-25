@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">📦 Add New Inventory Record</h1>
                    <p class="text-muted">Create a new inventory record for a product in a warehouse</p>
                </div>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
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
                    <form action="{{ route('admin.inventory.store') }}" method="POST">
                        @csrf
                        
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
                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}
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
                                                    {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
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
                                           value="{{ old('quantity', 0) }}" 
                                           min="0" 
                                           required
                                           onchange="calculateStockValue()">
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('minimum_stock', 0) }}" 
                                           min="0" 
                                           required>
                                    @error('minimum_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('reorder_level', 5) }}" 
                                           min="0" 
                                           required>
                                    @error('reorder_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Inventory Record
                            </button>
                            <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Guidelines and Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">📋 Inventory Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold text-primary">📝 Stock Management</h6>
                        <ul class="text-muted small">
                            <li>Set realistic minimum stock levels</li>
                            <li>Reorder level should be above minimum stock</li>
                            <li>Consider lead times for reordering</li>
                            <li>Monitor seasonal demand patterns</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-info">🏗️ Best Practices</h6>
                        <ul class="text-muted small">
                            <li>One record per product-warehouse combination</li>
                            <li>Regular stock audits recommended</li>
                            <li>Update quantities after stock movements</li>
                            <li>Set alerts for low stock items</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold text-warning">⚠️ Important Notes</h6>
                        <ul class="text-muted small">
                            <li>Cannot duplicate product-warehouse pairs</li>
                            <li>Quantities cannot be negative</li>
                            <li>Changes affect stock reports immediately</li>
                            <li>Consider impact on order fulfillment</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Stock Value Preview -->
            <div class="card shadow mb-4" id="stockValueCard" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">💰 Stock Value Preview</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Estimated Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="stockValueAmount">$0.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            Based on product regular price
                        </small>
                    </div>
                </div>
            </div>

            <!-- Selected Product Info -->
            <div class="card shadow mb-4" id="productInfoCard" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">📦 Product Information</h6>
                </div>
                <div class="card-body">
                    <div id="productDetails">
                        <!-- Product details will be populated via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const productInfoCard = document.getElementById('productInfoCard');
    
    if (this.value) {
        const productName = selectedOption.text.split(' (')[0];
        const productSku = selectedOption.getAttribute('data-sku');
        const productPrice = selectedOption.getAttribute('data-price');
        
        document.getElementById('productDetails').innerHTML = `
            <div class="mb-2">
                <strong>Name:</strong><br>
                <span class="text-muted">${productName}</span>
            </div>
            <div class="mb-2">
                <strong>SKU:</strong><br>
                <span class="text-muted">${productSku}</span>
            </div>
            <div class="mb-2">
                <strong>Regular Price:</strong><br>
                <span class="text-success font-weight-bold">$${parseFloat(productPrice).toFixed(2)}</span>
            </div>
        `;
        productInfoCard.style.display = 'block';
        calculateStockValue();
    } else {
        productInfoCard.style.display = 'none';
        document.getElementById('stockValueCard').style.display = 'none';
    }
});

function calculateStockValue() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const stockValueCard = document.getElementById('stockValueCard');
    const stockValueAmount = document.getElementById('stockValueAmount');
    
    if (productSelect.value && quantityInput.value) {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const totalValue = price * quantity;
        
        stockValueAmount.textContent = '$' + totalValue.toFixed(2);
        stockValueCard.style.display = 'block';
    } else {
        stockValueCard.style.display = 'none';
    }
}

// Check for existing inventory when both product and warehouse are selected
document.getElementById('product_id').addEventListener('change', checkExistingInventory);
document.getElementById('warehouse_id').addEventListener('change', checkExistingInventory);

function checkExistingInventory() {
    const productId = document.getElementById('product_id').value;
    const warehouseId = document.getElementById('warehouse_id').value;
    
    if (productId && warehouseId) {
        fetch(`{{ route('admin.inventory.getData') }}?product_id=${productId}&warehouse_id=${warehouseId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.id) {
                    alert('An inventory record already exists for this product in the selected warehouse. Please edit the existing record instead.');
                    // Optionally redirect to edit page
                    // window.location.href = `/admin/inventory/${data.id}/edit`;
                }
            })
            .catch(error => {
                // Handle error silently or show appropriate message
                console.log('Checking existing inventory...');
            });
    }
}
</script>
@endpush
@endsection
