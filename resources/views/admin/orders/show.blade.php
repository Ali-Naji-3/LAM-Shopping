@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                👁️ Order Details
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $order->order_number }} • {{ $order->created_at->format('F d, Y \a\t g:i A') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-primary"
               style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                <i class="bi bi-pencil me-2"></i>Edit Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Overview -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-receipt me-2" style="color: #3182ce !important;"></i>Order Overview
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge" style="background: {{ $order->status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                {{ $order->status }}
                            </span>
                            <span class="badge" style="background: {{ $order->payment_status_color }} !important; color: #ffffff !important; font-size: 12px !important; padding: 6px 12px !important; border-radius: 20px !important; text-transform: uppercase !important;">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="order-info">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Order Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important; width: 40%;">Order Number:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Customer:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">
                                                {{ $order->customer_name }}
                                                @if($order->user)
                                                    <small style="color: #10b981 !important; font-weight: 600 !important;">(Registered User)</small>
                                                @else
                                                    <small style="color: #f59e0b !important; font-weight: 600 !important;">(Guest Order)</small>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Email:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $order->customer_email }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Phone:</td>
                                            <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $order->customer_phone }}</td>
                                        </tr>
                                        @if($order->locality)
                                            <tr>
                                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Locality:</td>
                                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $order->locality }}</td>
                                            </tr>
                                        @endif
                                        @if($order->payment_method)
                                            <tr>
                                                <td style="color: #4a5568 !important; font-weight: 600 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">Payment Method:</td>
                                                <td style="color: #1a202c !important; font-weight: 500 !important; font-size: 14px !important; padding: 0.5rem 0 !important;">{{ $order->payment_method }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="order-amounts">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">Order Amounts</h6>
                                <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Subtotal:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">${{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Tax:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">${{ number_format($order->tax_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span style="color: #4a5568 !important; font-size: 14px !important;">Shipping:</span>
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important;">${{ number_format($order->shipping_amount, 2) }}</span>
                                    </div>
                                    @if($order->discount_amount > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span style="color: #4a5568 !important; font-size: 14px !important;">Discount:</span>
                                            <span style="color: #ef4444 !important; font-weight: 600 !important; font-size: 14px !important;">-${{ number_format($order->discount_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    <hr style="margin: 12px 0 !important; border-color: #e2e8f0 !important;">
                                    <div class="d-flex justify-content-between">
                                        <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 16px !important;">Total:</span>
                                        <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important;">{{ $order->formatted_total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                        <i class="bi bi-geo-alt me-2" style="color: #3182ce !important;"></i>Delivery Information
                    </h5>
                </div>
                <div class="card-body" style="padding: 2rem !important;">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                <i class="bi bi-truck me-2" style="color: #10b981 !important;"></i>Shipping Address
                            </h6>
                            <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important;">
                                <p style="color: #1a202c !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; white-space: pre-line;">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 1rem !important;">
                                <i class="bi bi-credit-card me-2" style="color: #3182ce !important;"></i>Billing Address
                            </h6>
                            @if($order->billing_address)
                                <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 10px !important; border-left: 4px solid #3182ce !important;">
                                    <p style="color: #1a202c !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; white-space: pre-line;">{{ $order->billing_address }}</p>
                                </div>
                            @else
                                <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important; border-radius: 10px !important; border-left: 4px solid #6b7280 !important;">
                                    <p style="color: #4a5568 !important; font-size: 14px !important; font-style: italic !important; margin: 0 !important;">Same as shipping address</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            @if($order->orderItems && $order->orderItems->count() > 0)
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-box me-2" style="color: #3182ce !important;"></i>Order Items ({{ $order->orderItems->count() }})
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        @foreach($order->orderItems as $item)
                            <div class="order-item" style="padding: 1rem !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 10px !important; margin-bottom: 1rem !important; border: 1px solid #e2e8f0 !important; transition: all 0.2s ease !important;"
                                 onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1) !important';"
                                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                            {{ $item->product->name ?? 'Product Not Found' }}
                                        </h6>
                                        <div class="item-details" style="color: #4a5568 !important; font-size: 13px !important; line-height: 1.5 !important;">
                                            <div><strong>SKU:</strong> {{ $item->product->sku ?? 'N/A' }}</div>
                                            @if($item->product && $item->product->category)
                                                <div><strong>Category:</strong> {{ $item->product->category->name }}</div>
                                            @endif
                                            @if($item->product && $item->product->brand)
                                                <div><strong>Brand:</strong> {{ $item->product->brand->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="item-pricing text-end">
                                        <div style="color: #10b981 !important; font-weight: 700 !important; font-size: 16px !important; margin-bottom: 4px !important;">
                                            ${{ number_format($item->price, 2) }}
                                        </div>
                                        <div style="color: #4a5568 !important; font-size: 13px !important;">
                                            Qty: {{ $item->quantity }} • Total: ${{ number_format($item->price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-body text-center" style="padding: 3rem !important;">
                        <i class="bi bi-box" style="color: #718096 !important; font-size: 3rem !important; margin-bottom: 1rem !important;"></i>
                        <h6 style="color: #4a5568 !important; font-weight: 500 !important;">No order items found</h6>
                        <p style="color: #718096 !important; font-size: 14px !important;">This order doesn't have any items associated with it yet.</p>
                    </div>
                </div>
            @endif

            <!-- Order Notes -->
            @if($order->notes)
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-sticky me-2" style="color: #3182ce !important;"></i>Order Notes
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div style="padding: 1.5rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                            <p style="color: #1a202c !important; font-size: 14px !important; line-height: 1.6 !important; margin: 0 !important; white-space: pre-line;">{{ $order->notes }}</p>
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
                        <!-- Status Update Actions -->
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-success w-100"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(16, 185, 129, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-check-circle me-2"></i>Confirm Order
                                </button>
                            </form>
                        @elseif($order->status === 'confirmed')
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="btn btn-info w-100"
                                        style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(139, 92, 246, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-gear me-2"></i>Start Processing
                                </button>
                            </form>
                        @elseif($order->status === 'processing')
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="shipped">
                                <button type="submit" class="btn btn-primary w-100"
                                        style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(6, 182, 212, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-truck me-2"></i>Mark as Shipped
                                </button>
                            </form>
                        @elseif($order->status === 'shipped')
                            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" class="btn btn-success w-100"
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; border: none !important; color: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(16, 185, 129, 0.3) !important';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <i class="bi bi-check-circle me-2"></i>Mark as Delivered
                                </button>
                            </form>
                        @endif

                        <!-- Payment Status Actions -->
                        @if($order->payment_status === 'pending')
                            <form method="POST" action="{{ route('admin.orders.updatePaymentStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" class="btn btn-outline-success w-100"
                                        style="color: #10b981 !important; border-color: #10b981 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                        onmouseover="this.style.backgroundColor='#10b981 !important'; this.style.color='#ffffff !important';"
                                        onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#10b981 !important';">
                                    <i class="bi bi-currency-dollar me-2"></i>Mark as Paid
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-primary w-100"
                           style="color: #3182ce !important; border-color: #3182ce !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; text-decoration: none !important;"
                           onmouseover="this.style.backgroundColor='#3182ce !important'; this.style.color='#ffffff !important';"
                           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#3182ce !important';">
                            <i class="bi bi-pencil me-2"></i>Edit Order Details
                        </a>

                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Are you sure you want to delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    style="color: #e53e3e !important; border-color: #e53e3e !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.backgroundColor='#e53e3e !important'; this.style.color='#ffffff !important';"
                                    onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#e53e3e !important';">
                                <i class="bi bi-trash me-2"></i>Delete Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                    <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                        <i class="bi bi-graph-up me-2" style="color: #3182ce !important;"></i>Order Statistics
                    </h5>
                </div>
                <div class="card-body" style="padding: 1.5rem !important;">
                    <div class="order-stats">
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Order ID</span>
                                <span style="color: #3182ce !important; font-weight: 700 !important; font-size: 14px !important;">#{{ $order->id }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Items Count</span>
                                <span style="color: #10b981 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $orderAnalytics['items_count'] }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 8px !important; margin-bottom: 12px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Total Quantity</span>
                                <span style="color: #f59e0b !important; font-weight: 700 !important; font-size: 14px !important;">{{ $orderAnalytics['total_quantity'] }}</span>
                            </div>
                        </div>
                        <div class="stat-item" style="padding: 12px !important; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%) !important; border-radius: 8px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important;">Created</span>
                                <span style="color: #8b5cf6 !important; font-weight: 700 !important; font-size: 14px !important;">{{ $order->created_at->format('M d, Y') }}</span>
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
    /* CLEAN ORDERS SHOW PAGE - Professional Styling */
    .order-item {
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

    .order-info, .order-amounts {
        transition: all 0.2s ease !important;
    }

    .order-amounts > div {
        transition: all 0.2s ease !important;
    }

    .order-amounts > div:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush
@endsection
