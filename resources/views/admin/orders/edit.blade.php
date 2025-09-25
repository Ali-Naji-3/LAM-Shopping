@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ✏️ Edit Order
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">
                {{ $order->order_number }} • Update order details and status
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info"
               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                <i class="bi bi-eye me-2"></i>View Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" 
               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                <i class="bi bi-arrow-left me-2"></i>Back to Orders
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Information -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-receipt me-2" style="color: #3182ce !important;"></i>Order Information
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Order Number (Read Only) -->
                                <div class="mb-3">
                                    <label for="order_number" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Order Number
                                    </label>
                                    <input type="text" id="order_number" class="form-control" value="{{ $order->order_number }}" readonly
                                           style="background: #f7fafc !important; border: 2px solid #e2e8f0 !important; color: #4a5568 !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important;">
                                </div>

                                <!-- Customer Name -->
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Customer Name <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                                           value="{{ old('customer_name', $order->customer_name) }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter customer full name">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Customer Phone -->
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Customer Phone <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" 
                                           value="{{ old('customer_phone', $order->customer_phone) }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter phone number">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Customer Email -->
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Customer Email <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control @error('customer_email') is-invalid @enderror" 
                                           value="{{ old('customer_email', $order->customer_email) }}" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter email address">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Locality -->
                                <div class="mb-3">
                                    <label for="locality" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Locality
                                    </label>
                                    <input type="text" name="locality" id="locality" class="form-control @error('locality') is-invalid @enderror" 
                                           value="{{ old('locality', $order->locality) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="Enter locality/area">
                                    @error('locality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Order Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Order Status <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                            onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                            onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';">
                                        <option value="pending" {{ old('status', $order->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ old('status', $order->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="processing" {{ old('status', $order->status) === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ old('status', $order->status) === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ old('status', $order->status) === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ old('status', $order->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="refunded" {{ old('status', $order->status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Status -->
                                <div class="mb-3">
                                    <label for="payment_status" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Payment Status <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                            onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                            onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';">
                                        <option value="pending" {{ old('payment_status', $order->payment_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status', $order->payment_status) === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ old('payment_status', $order->payment_status) === 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('payment_status', $order->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Payment Method
                                    </label>
                                    <input type="text" name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" 
                                           value="{{ old('payment_method', $order->payment_method) }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                           placeholder="e.g., Credit Card, PayPal, Cash on Delivery">
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- User Assignment (Optional) -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Registered User (Optional)
                                    </label>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror"
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                            onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                            onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';">
                                        <option value="">Select User (Leave empty for guest order)</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Amounts -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-currency-dollar me-2" style="color: #10b981 !important;"></i>Order Amounts
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Subtotal -->
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Subtotal <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" name="subtotal" id="subtotal" class="form-control @error('subtotal') is-invalid @enderror" 
                                           value="{{ old('subtotal', $order->subtotal) }}" step="0.01" min="0" required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="0.00">
                                    @error('subtotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tax Amount -->
                                <div class="mb-3">
                                    <label for="tax_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Tax Amount
                                    </label>
                                    <input type="number" name="tax_amount" id="tax_amount" class="form-control @error('tax_amount') is-invalid @enderror" 
                                           value="{{ old('tax_amount', $order->tax_amount) }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="0.00">
                                    @error('tax_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Shipping Amount -->
                                <div class="mb-3">
                                    <label for="shipping_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Shipping Amount
                                    </label>
                                    <input type="number" name="shipping_amount" id="shipping_amount" class="form-control @error('shipping_amount') is-invalid @enderror" 
                                           value="{{ old('shipping_amount', $order->shipping_amount) }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#10b981 !important'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="0.00">
                                    @error('shipping_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Discount Amount -->
                                <div class="mb-3">
                                    <label for="discount_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Discount Amount
                                    </label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" 
                                           value="{{ old('discount_amount', $order->discount_amount) }}" step="0.01" min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; transition: all 0.2s ease !important;"
                                           onfocus="this.style.borderColor='#ef4444 !important'; this.style.boxShadow='0 0 0 3px rgba(239, 68, 68, 0.1) !important';"
                                           onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none'; calculateTotal();"
                                           onkeyup="calculateTotal()"
                                           placeholder="0.00">
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Total Amount (Auto-calculated) -->
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Total Amount <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" name="total_amount" id="total_amount" class="form-control @error('total_amount') is-invalid @enderror" 
                                           value="{{ old('total_amount', $order->total_amount) }}" step="0.01" min="0" required readonly
                                           style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border: 2px solid #10b981 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 16px !important; font-weight: 700 !important;">
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Total Display -->
                                <div style="padding: 1rem !important; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important; margin-top: 1rem !important;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">Final Total:</span>
                                        <span id="display_total" style="color: #10b981 !important; font-weight: 700 !important; font-size: 20px !important;">${{ number_format($order->total_amount, 2) }}</span>
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
                            <i class="bi bi-geo-alt me-2" style="color: #3182ce !important;"></i>Delivery Addresses
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Shipping Address -->
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Shipping Address <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" 
                                              rows="4" required
                                              style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.5 !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                              onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                              onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                              placeholder="Enter complete shipping address with street, city, state, and postal code">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Billing Address -->
                                <div class="mb-3">
                                    <label for="billing_address" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                        Billing Address
                                        <small style="color: #4a5568 !important; font-weight: 400 !important;">(Leave empty if same as shipping)</small>
                                    </label>
                                    <textarea name="billing_address" id="billing_address" class="form-control @error('billing_address') is-invalid @enderror" 
                                              rows="4"
                                              style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.5 !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                              onfocus="this.style.borderColor='#3182ce !important'; this.style.boxShadow='0 0 0 3px rgba(49, 130, 206, 0.1) !important';"
                                              onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                              placeholder="Enter billing address if different from shipping address">{{ old('billing_address', $order->billing_address) }}</textarea>
                                    @error('billing_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-sticky me-2" style="color: #f59e0b !important;"></i>Order Notes
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="mb-3">
                            <label for="notes" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">
                                Special Instructions or Notes
                            </label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; border-radius: 10px !important; padding: 14px 18px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.5 !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      onfocus="this.style.borderColor='#f59e0b !important'; this.style.boxShadow='0 0 0 3px rgba(245, 158, 11, 0.1) !important';"
                                      onblur="this.style.borderColor='#e2e8f0 !important'; this.style.boxShadow='none';"
                                      placeholder="Add any special instructions, delivery notes, or comments about this order">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Statistics -->
                <div class="card mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; border: 1px solid #475569 !important; border-radius: 12px !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: transparent !important; border-bottom: 1px solid #475569 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0 eye-catching-title" style="
                            background: linear-gradient(135deg, #60a5fa 0%, #34d399 50%, #fbbf24 100%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                            font-weight: 700;
                            font-size: 1.25rem;
                            text-shadow: 0 0 20px rgba(96, 165, 250, 0.5);
                            position: relative;
                            z-index: 2;
                            animation: shimmer 4s ease-in-out infinite alternate;
                            background-size: 200% 100%;
                        ">
                            <i class="bi bi-bar-chart me-2" style="color: #60a5fa; filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); animation: iconGlow 3s ease-in-out infinite;"></i>Order Statistics
                        </h5>
                    </div>
                    <div class="card-body" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%) !important; padding: 2rem !important; border-radius: 0 0 12px 12px !important;">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $orderAnalytics['items_count'] ?? 0 }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Items</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $orderAnalytics['total_quantity'] ?? 0 }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Quantity</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    #{{ $order->id }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Order ID</div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-number h4 mb-1" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);">
                                    {{ $order->created_at->format('M d') }}
                                </div>
                                <div class="stat-label small" style="color: #ffffff !important; opacity: 0.9; font-weight: 500;">Created</div>
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
                            <!-- Update Order Button -->
                            <button type="submit" class="btn btn-primary w-100"
                                    style="background: linear-gradient(135deg, #3182ce 0%, #1e40af 100%) !important; border: none !important; color: #ffffff !important; padding: 14px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 16px !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(49, 130, 206, 0.4) !important';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                <i class="bi bi-check-circle me-2"></i>Update Order
                            </button>

                            <!-- View Order Button -->
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info w-100"
                               style="color: #06b6d4 !important; border-color: #06b6d4 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#06b6d4 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#06b6d4 !important';">
                                <i class="bi bi-eye me-2"></i>View Order Details
                            </a>

                            <!-- Cancel Button -->
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100"
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 16px !important; border-radius: 8px !important; font-weight: 600 !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel Changes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    /* CLEAN ORDERS EDIT PAGE - Professional Styling */
    .form-control::placeholder {
        color: #9ca3af !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .form-control::-webkit-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control::-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-ms-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    .form-control:-moz-placeholder { color: #9ca3af !important; opacity: 1 !important; }
    
    /* Eye-catching animations */
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    @keyframes iconGlow {
        0%, 100% { filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.6)); }
        50% { filter: drop-shadow(0 0 15px rgba(96, 165, 250, 0.9)) drop-shadow(0 0 25px rgba(96, 165, 250, 0.6)); }
    }
    
    .eye-catching-title {
        animation: shimmer 4s ease-in-out infinite alternate;
    }
    
    .card-header:has(.eye-catching-title) {
        position: relative;
        overflow: hidden;
    }
    
    .card-header:has(.eye-catching-title):hover {
        box-shadow: 0 0 25px rgba(96, 165, 250, 0.3) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-calculate total amount
    function calculateTotal() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const taxAmount = parseFloat(document.getElementById('tax_amount').value) || 0;
        const shippingAmount = parseFloat(document.getElementById('shipping_amount').value) || 0;
        const discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
        
        const total = subtotal + taxAmount + shippingAmount - discountAmount;
        
        document.getElementById('total_amount').value = total.toFixed(2);
        document.getElementById('display_total').textContent = '$' + total.toFixed(2);
    }
    
    // Initialize calculation on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
    });
</script>
@endpush
@endsection
