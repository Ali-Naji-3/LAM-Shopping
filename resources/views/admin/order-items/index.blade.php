@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                📋 Order Items Management
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Manage individual items within orders • {{ $statistics['total_items'] }} total items
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orderItems.analytics') }}" class="btn btn-outline-info"
               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                <i class="bi bi-graph-up me-2"></i>Analytics
            </a>
            <a href="{{ route('admin.orderItems.create') }}" class="btn btn-primary"
               style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="bi bi-plus-lg me-2"></i>Add Order Item
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 1px solid #e0f2fe !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #3182ce !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📋</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['total_items']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Items</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 1px solid #dcfce7 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #10b981 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📊</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['total_quantity']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Quantity</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border: 1px solid #fed7aa !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #f59e0b !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">💰</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">${{ number_format($statistics['total_value'], 2) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Total Value</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border: 1px solid #e9d5ff !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body text-center" style="padding: 1.5rem !important;">
                    <div class="stat-icon" style="color: #8b5cf6 !important; font-size: 2rem !important; margin-bottom: 0.5rem !important;">📦</div>
                    <div class="stat-number h3 mb-1" style="color: #1a202c !important; font-weight: 700 !important;">{{ number_format($statistics['unique_orders']) }}</div>
                    <div class="stat-label" style="color: #4a5568 !important; font-size: 14px !important;">Unique Orders</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-body" style="padding: 1.5rem !important;">
            <form method="GET" action="{{ route('admin.orderItems.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Search Order Items</label>
                        <input type="text" name="search" class="form-control" placeholder="🔍 Search orders, products, SKU..."
                               value="{{ request('search') }}"
                               style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Filter by Order</label>
                        <select name="order_id" class="form-control"
                                style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                            <option value="">All Orders</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }} - {{ $order->customer_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Filter by Product</label>
                        <select name="product_id" class="form-control"
                                style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important;">
                            <option value="">All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }})
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
                            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 14px 16px !important; border-radius: 8px !important; text-decoration: none !important;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
        <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                    Order Items ({{ $orderItems->total() }})
                </h5>
                <div class="d-flex gap-2">
                    <!-- Bulk Actions -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                style="color: #4a5568 !important; border-color: #4a5568 !important; padding: 8px 12px !important; border-radius: 8px !important; font-size: 14px !important;">
                            <i class="bi bi-three-dots me-1"></i>Bulk Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="bulkAction('recalculate_totals')">
                                <i class="bi bi-calculator me-2"></i>Recalculate Totals
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
            @if($orderItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc !important; border-bottom: 2px solid #e2e8f0 !important;">
                            <tr>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Order</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Product</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Quantity</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Unit Price</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Total Price</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Attributes</th>
                                <th style="padding: 1rem !important; color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; border: none !important;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderItems as $item)
                                <tr style="transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#f8fafc !important';"
                                    onmouseout="this.style.backgroundColor='transparent';">
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="form-check-input item-checkbox">
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex align-items-center">
                                            <div class="order-info">
                                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    <a href="{{ route('admin.orders.show', $item->order) }}"
                                                       style="color: #3182ce !important; text-decoration: none !important;"
                                                       onmouseover="this.style.textDecoration='underline !important';"
                                                       onmouseout="this.style.textDecoration='none !important';">
                                                        {{ $item->order->order_number }}
                                                    </a>
                                                </div>
                                                <div style="color: #4a5568 !important; font-size: 12px !important;">{{ $item->order->customer_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex align-items-center">
                                            <div class="product-info">
                                                <div style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    {{ $item->product->name }}
                                                </div>
                                                <div style="color: #4a5568 !important; font-size: 12px !important;">
                                                    SKU: {{ $item->product->sku }}
                                                    @if($item->product->category)
                                                        • {{ $item->product->category->name }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <span class="badge" style="background: #10b981 !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important;">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                            {{ $item->formatted_unit_price }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">
                                            {{ $item->formatted_total_price }}
                                        </span>
                                        @if($item->has_discount)
                                            <div style="color: #ef4444 !important; font-size: 11px !important;">
                                                {{ $item->discount_percentage }}% off
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        @if($item->attributes && count($item->attributes) > 0)
                                            <span class="badge bg-info text-white" style="font-size: 11px !important; padding: 4px 8px !important;">
                                                {{ count($item->attributes) }} attributes
                                            </span>
                                        @else
                                            <span style="color: #9ca3af !important; font-size: 12px !important; font-style: italic;">No attributes</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem !important; border-bottom: 1px solid #f1f5f9 !important;">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.orderItems.show', $item) }}" class="btn btn-sm btn-outline-info"
                                               style="color: #06b6d4 !important; border-color: #06b6d4 !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orderItems.edit', $item) }}" class="btn btn-sm btn-outline-warning"
                                               style="color: #f59e0b !important; border-color: #f59e0b !important; padding: 6px 8px !important; border-radius: 6px !important; font-size: 12px !important; text-decoration: none !important;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.orderItems.destroy', $item) }}" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this order item?')">
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
                        Showing {{ $orderItems->firstItem() }}-{{ $orderItems->lastItem() }} of {{ $orderItems->total() }}
                    </div>
                    <div>
                        {{ $orderItems->appends(request()->query())->links('pagination.custom') }}
                    </div>
                </div>
            @else
                <div class="text-center" style="padding: 3rem !important;">
                    <i class="bi bi-inbox" style="color: #9ca3af !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                    <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No order items found</h6>
                    <p style="color: #9ca3af !important; font-size: 14px !important;">Try adjusting your search criteria or add some order items.</p>
                    <a href="{{ route('admin.orderItems.create') }}" class="btn btn-primary"
                       style="background: #3182ce !important; border: none !important; color: #ffffff !important; padding: 12px 24px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;">
                        <i class="bi bi-plus-lg me-2"></i>Add First Order Item
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
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk actions
    function bulkAction(action) {
        const selectedItems = document.querySelectorAll('.item-checkbox:checked');
        if (selectedItems.length === 0) {
            alert('Please select at least one item.');
            return;
        }

        let message = '';
        switch(action) {
            case 'delete':
                message = `Are you sure you want to delete ${selectedItems.length} order items?`;
                break;
            case 'recalculate_totals':
                message = `Recalculate totals for ${selectedItems.length} order items?`;
                break;
            default:
                message = `Perform this action on ${selectedItems.length} order items?`;
        }

        if (!confirm(message)) {
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.orderItems.bulk") }}';
        form.innerHTML = `
            @csrf
            <input type="hidden" name="action" value="${action}">
        `;

        selectedItems.forEach(item => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = item.value;
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
