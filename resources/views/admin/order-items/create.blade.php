@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Add Order Item
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Add a new item to an existing order
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Order Items
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.orderItems.store') }}">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Item Information -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Order Item Details
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Select Order -->
                                <div class="mb-3">
                                    <label for="order_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Select Order <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select name="order_id" id="order_id" class="form-control @error('order_id') is-invalid @enderror" required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                            onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                            onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';">
                                        <option value="">Choose an order...</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->id }}" {{ old('order_id', $selectedOrder?->id) == $order->id ? 'selected' : '' }}>
                                                {{ $order->order_number }} - {{ $order->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Select Product -->
                                <div class="mb-3">
                                    <label for="product_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Select Product <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                            onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                            onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                            onchange="updateProductInfo()">
                                        <option value="">Choose a product...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    data-price="{{ $product->regular_price ?? 0 }}"
                                                    data-sku="{{ $product->sku }}"
                                                    data-category="{{ $product->category?->name ?? 'N/A' }}"
                                                    data-brand="{{ $product->brand?->name ?? 'N/A' }}"
                                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->sku }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="mb-3">
                                    <label for="quantity" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Quantity <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                           value="{{ old('quantity', 1) }}" min="1" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="Enter quantity">
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Unit Price -->
                                <div class="mb-3">
                                    <label for="unit_price" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Unit Price <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" name="unit_price" id="unit_price" class="form-control @error('unit_price') is-invalid @enderror" 
                                           value="{{ old('unit_price') }}" step="0.01" min="0" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="0.00">
                                    @error('unit_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Total Price -->
                                <div class="mb-3">
                                    <label for="total_price" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Total Price <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror" 
                                           value="{{ old('total_price') }}" step="0.01" min="0" required
                                           style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 2px solid #10b981 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 16px !important; font-weight: 700 !important;"
                                           placeholder="0.00">
                                    @error('total_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Info Display -->
                                <div id="product-info" style="display: none; padding: 1rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important;">
                                    <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 0.5rem !important;">Product Information</h6>
                                    <div style="color: #4a5568 !important; font-size: 13px !important;">
                                        <div><strong>SKU:</strong> <span id="product-sku">-</span></div>
                                        <div><strong>Category:</strong> <span id="product-category">-</span></div>
                                        <div><strong>Brand:</strong> <span id="product-brand">-</span></div>
                                        <div><strong>Regular Price:</strong> $<span id="product-price">0.00</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Attributes -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-tags me-2" style="color: #8b5cf6 !important;"></i>Product Attributes
                            <small style="color: #4a5568 !important; font-weight: 400 !important; font-size: 14px !important;">(Optional)</small>
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div id="attributes-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Color</label>
                                        <input type="text" name="attributes[color]" class="form-control" 
                                               value="{{ old('attributes.color') }}"
                                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                                               placeholder="e.g., Red, Blue, Black">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Size</label>
                                        <input type="text" name="attributes[size]" class="form-control" 
                                               value="{{ old('attributes.size') }}"
                                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                                               placeholder="e.g., XS, S, M, L, XL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Material</label>
                                        <input type="text" name="attributes[material]" class="form-control" 
                                               value="{{ old('attributes.material') }}"
                                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                                               placeholder="e.g., Cotton, Polyester, Wool">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Style</label>
                                        <input type="text" name="attributes[style]" class="form-control" 
                                               value="{{ old('attributes.style') }}"
                                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                                               placeholder="e.g., Casual, Formal, Sport">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Add More Attributes Button -->
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-secondary" onclick="addAttributeField()"
                                        style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 10px 20px !important; border-radius: 8px !important; font-size: 14px !important;">
                                    <i class="bi bi-plus-lg me-2"></i>Add Custom Attribute
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-calculator me-2" style="color: #10b981 !important;"></i>Order Item Summary
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="summary-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Quantity:</span>
                                <span id="summary-quantity" style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">1</span>
                            </div>
                        </div>
                        <div class="summary-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Unit Price:</span>
                                <span id="summary-unit-price" style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">$0.00</span>
                            </div>
                        </div>
                        <div class="summary-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Subtotal:</span>
                                <span id="summary-subtotal" style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">$0.00</span>
                            </div>
                        </div>
                        <hr style="margin: 12px 0 !important; border-color: #e2e8f0 !important;">
                        <div class="summary-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 700 !important; font-size: 16px !important;">Total:</span>
                                <span id="summary-total" style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 18px !important;">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Actions
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div class="d-grid gap-2">
                            <!-- Create Order Item Button -->
                            <button type="submit" class="btn btn-primary w-100"
                                    style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.4) !important';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-plus-circle me-2"></i>Add Order Item
                            </button>

                            <!-- Cancel Button -->
                            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary w-100"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Update product information when product is selected
    function updateProductInfo() {
        const productSelect = document.getElementById('product_id');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        
        if (selectedOption.value) {
            const price = selectedOption.getAttribute('data-price');
            const sku = selectedOption.getAttribute('data-sku');
            const category = selectedOption.getAttribute('data-category');
            const brand = selectedOption.getAttribute('data-brand');
            
            // Update product info display
            document.getElementById('product-sku').textContent = sku;
            document.getElementById('product-category').textContent = category;
            document.getElementById('product-brand').textContent = brand;
            document.getElementById('product-price').textContent = parseFloat(price).toFixed(2);
            
            // Update unit price field
            document.getElementById('unit_price').value = parseFloat(price).toFixed(2);
            
            // Show product info
            document.getElementById('product-info').style.display = 'block';
            
            // Calculate total
            calculateTotal();
        } else {
            // Hide product info
            document.getElementById('product-info').style.display = 'none';
            document.getElementById('unit_price').value = '';
            calculateTotal();
        }
    }

    // Calculate total price and update summary
    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
        
        const subtotal = quantity * unitPrice;
        const total = subtotal; // For now, total equals subtotal
        
        // Update form fields
        document.getElementById('total_price').value = total.toFixed(2);
        
        // Update summary
        document.getElementById('summary-quantity').textContent = quantity;
        document.getElementById('summary-unit-price').textContent = '$' + unitPrice.toFixed(2);
        document.getElementById('summary-subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('summary-total').textContent = '$' + total.toFixed(2);
    }

    // Add custom attribute field
    function addAttributeField() {
        const container = document.getElementById('attributes-container');
        const attributeName = prompt('Enter attribute name:');
        
        if (attributeName && attributeName.trim()) {
            const fieldName = attributeName.toLowerCase().replace(/[^a-z0-9]/g, '_');
            const fieldId = 'attr_' + Date.now();
            
            const newField = document.createElement('div');
            newField.className = 'mb-3';
            newField.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <div class="flex-grow-1">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">${attributeName}</label>
                        <input type="text" name="attributes[${fieldName}]" class="form-control" 
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important;"
                               placeholder="Enter ${attributeName.toLowerCase()}">
                    </div>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.parentElement.remove()"
                            style="color: #ef4444 !important; border-color: #ef4444 !important; padding: 8px 12px !important; border-radius: 6px !important; margin-top: 24px !important;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            // Insert before the "Add Custom Attribute" button
            const addButton = container.querySelector('.text-center');
            container.insertBefore(newField, addButton);
        }
    }

    // Initialize calculations on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        
        // If a product is pre-selected, update info
        const productSelect = document.getElementById('product_id');
        if (productSelect.value) {
            updateProductInfo();
        }
    });
</script>
@endpush
@endsection
