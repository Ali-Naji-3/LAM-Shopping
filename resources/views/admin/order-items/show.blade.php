@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👁️ Order Item Details
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                Item #{{ $orderItem->id }} • {{ $orderItem->product->name }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orderItems.edit', $orderItem) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Item
            </a>
            <a href="{{ route('admin.orderItems.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Order Items
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Item Overview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-info-circle me-2" style="color: #3182ce !important;"></i>Item Overview
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="item-info">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Order Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important; width: 40%;">Order Number:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">
                                                <a href="{{ route('admin.orders.show', $orderItem->order) }}" 
                                                   style="color: #3182ce !important; text-decoration: none !important;"
                                                   onmouseover="this.style.textDecoration='underline !important';"
                                                   onmouseout="this.style.textDecoration='none !important';">
                                                    {{ $orderItem->order->order_number }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Customer:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->order->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Order Date:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->order->created_at->format('M d, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Order Status:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">
                                                <span class="badge" style="background: {{ $orderItem->order->status_color }} !important; color: #ffffff !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 12px !important; text-transform: uppercase !important;">
                                                    {{ $orderItem->order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-info">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Product Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important; width: 40%;">Product Name:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->product->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">SKU:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->product->sku }}</td>
                                        </tr>
                                        @if($orderItem->product->category)
                                            <tr>
                                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Category:</td>
                                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->product->category->name }}</td>
                                            </tr>
                                        @endif
                                        @if($orderItem->product->brand)
                                            <tr>
                                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Brand:</td>
                                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $orderItem->product->brand->name }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Details -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-receipt me-2" style="color: #10b981 !important;"></i>Item Details & Pricing
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Quantity & Pricing</h6>
                                <div class="pricing-details">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Quantity:</span>
                                        <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 16px !important;">{{ $orderItem->quantity }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Unit Price:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">{{ $orderItem->formatted_unit_price }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Subtotal:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">${{ number_format($itemAnalytics['subtotal'], 2) }}</span>
                                    </div>
                                    @if($itemAnalytics['has_discount'])
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="color: #4a5568 !important; font-size: 14px !important;">Discount:</span>
                                            <span style="color: #ef4444 !important; font-weight: 600 !important; font-size: 14px !important;">-${{ number_format($itemAnalytics['discount_amount'], 2) }} ({{ $itemAnalytics['discount_percentage'] }}%)</span>
                                        </div>
                                    @endif
                                    <hr style="margin: 12px 0 !important; border-color: #dcfce7 !important;">
                                    <div class="d-flex justify-content-between">
                                        <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 16px !important;">Total Price:</span>
                                        <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important;">{{ $orderItem->formatted_total_price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 10px !important; border-left: 4px solid #8b5cf6 !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Item Attributes</h6>
                                @if($orderItem->attributes && count($orderItem->attributes) > 0)
                                    <div class="attributes-list">
                                        @foreach($orderItem->attributes as $key => $value)
                                            <div class="d-flex justify-content-between mb-2">
                                                <span style="color: #4a5568 !important; font-size: 14px !important; text-transform: capitalize;">{{ str_replace('_', ' ', $key) }}:</span>
                                                <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p style="color: #9ca3af !important; font-size: 14px !important; font-style: italic; margin: 0 !important;">No specific attributes for this item.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Order Items -->
            @if($relatedItems->count() > 0)
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-collection me-2" style="color: #06b6d4 !important;"></i>Other Items in This Order
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            @foreach($relatedItems as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="related-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; border: 1px solid #e0f2fe !important; transition: all 0.2s ease !important;"
                                         onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.1) !important';"
                                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 4px !important;">
                                                    <a href="{{ route('admin.orderItems.show', $item) }}" 
                                                       style="color: #3182ce !important; text-decoration: none !important;"
                                                       onmouseover="this.style.textDecoration='underline !important';"
                                                       onmouseout="this.style.textDecoration='none !important';">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h6>
                                                <div style="color: #4a5568 !important; font-size: 12px !important;">
                                                    <div>SKU: {{ $item->product->sku }}</div>
                                                    <div>Qty: {{ $item->quantity }} × {{ $item->formatted_unit_price }}</div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">
                                                    {{ $item->formatted_total_price }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-lightning me-2" style="color: #3182ce !important;"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orderItems.edit', $orderItem) }}" class="btn btn-primary w-100"
                           style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="bi bi-pencil me-2"></i>Edit Item Details
                        </a>
                        
                        <a href="{{ route('admin.orders.show', $orderItem->order) }}" class="btn btn-outline-info w-100"
                           style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                            <i class="bi bi-receipt me-2"></i>View Full Order
                        </a>
                        
                        <a href="{{ route('admin.orderItems.create', ['order_id' => $orderItem->order_id]) }}" class="btn btn-outline-success w-100"
                           style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                            <i class="bi bi-plus-circle me-2"></i>Add Another Item
                        </a>
                        
                        <form method="POST" action="{{ route('admin.orderItems.destroy', $orderItem) }}" onsubmit="return confirm('Are you sure you want to delete this order item? This will update the order total.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Item
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Item Statistics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Item Statistics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="item-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Item ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $orderItem->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Quantity</span>
                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $orderItem->quantity }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Attributes</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">{{ $itemAnalytics['attributes_count'] }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Created</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $orderItem->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* CLEAN ORDER ITEM SHOW PAGE - Professional Styling */
    .related-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item {
        transition: all 0.2s ease !important;
    }
    
    .stat-item:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    .table td {
        border-bottom: 1px solid #f1f5f9 !important;
    }
    
    .table tr:last-child td {
        border-bottom: none !important;
    }
    
    .pricing-details, .attributes-list {
        transition: all 0.2s ease !important;
    }
</style>
@endpush
@endsection
