@extends('admin.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #1a202c !important; font-weight: 700 !important; font-size: 24px !important;">
                ➕ Create Order
            </h2>
            <p class="mb-0" style="color: #4a5568 !important; font-size: 14px !important;">Create a new customer order manually</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" 
           style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 12px 20px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
           onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
           onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
            <i class="bi bi-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <form method="POST" action="{{ route('admin.orders.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Customer Information -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-person me-2" style="color: #3182ce !important;"></i>Customer Information
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <!-- User Selection (Optional) -->
                        <div class="mb-4">
                            <label for="user_id" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Registered User <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                            </label>
                            <select class="form-control @error('user_id') is-invalid @enderror" 
                                    id="user_id" 
                                    name="user_id"
                                    style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                    onchange="fillUserData(this)">
                                <option value="">Select registered user or enter manually...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="customer_name" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Customer Name <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           value="{{ old('customer_name') }}" 
                                           required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="Enter customer full name">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="customer_email" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Customer Email <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                           id="customer_email" 
                                           name="customer_email" 
                                           value="{{ old('customer_email') }}" 
                                           required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="customer@example.com">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="customer_phone" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Customer Phone <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('customer_phone') is-invalid @enderror" 
                                           id="customer_phone" 
                                           name="customer_phone" 
                                           value="{{ old('customer_phone') }}" 
                                           required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="+1-555-0123">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="locality" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Locality <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('locality') is-invalid @enderror" 
                                           id="locality" 
                                           name="locality" 
                                           value="{{ old('locality') }}"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="City, State">
                                    @error('locality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Addresses -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="shipping_address" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Shipping Address <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                              id="shipping_address" 
                                              name="shipping_address" 
                                              rows="4"
                                              required
                                              style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                              placeholder="Enter complete shipping address...">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="billing_address" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Billing Address <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                              id="billing_address" 
                                              name="billing_address" 
                                              rows="4"
                                              style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                              placeholder="Enter billing address (leave empty if same as shipping)...">{{ old('billing_address') }}</textarea>
                                    @error('billing_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="same_as_shipping" onchange="copyShippingToBilling()">
                                        <label class="form-check-label" for="same_as_shipping" style="color: #4a5568 !important; font-size: 13px !important;">
                                            Same as shipping address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-calculator me-2" style="color: #3182ce !important;"></i>Order Amounts
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="subtotal" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Subtotal <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('subtotal') is-invalid @enderror" 
                                           id="subtotal" 
                                           name="subtotal" 
                                           value="{{ old('subtotal') }}" 
                                           step="0.01"
                                           min="0"
                                           required
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="0.00"
                                           onkeyup="calculateTotal()">
                                    @error('subtotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="tax_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Tax Amount
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('tax_amount') is-invalid @enderror" 
                                           id="tax_amount" 
                                           name="tax_amount" 
                                           value="{{ old('tax_amount', '0.00') }}" 
                                           step="0.01"
                                           min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="0.00"
                                           onkeyup="calculateTotal()">
                                    @error('tax_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="shipping_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Shipping Amount
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('shipping_amount') is-invalid @enderror" 
                                           id="shipping_amount" 
                                           name="shipping_amount" 
                                           value="{{ old('shipping_amount', '0.00') }}" 
                                           step="0.01"
                                           min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="0.00"
                                           onkeyup="calculateTotal()">
                                    @error('shipping_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="discount_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Discount Amount
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('discount_amount') is-invalid @enderror" 
                                           id="discount_amount" 
                                           name="discount_amount" 
                                           value="{{ old('discount_amount', '0.00') }}" 
                                           step="0.01"
                                           min="0"
                                           style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                           placeholder="0.00"
                                           onkeyup="calculateTotal()">
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Total Amount (Auto-calculated) -->
                        <div class="mb-4">
                            <label for="total_amount" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Total Amount <span style="color: #e53e3e !important;">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('total_amount') is-invalid @enderror" 
                                   id="total_amount" 
                                   name="total_amount" 
                                   value="{{ old('total_amount') }}" 
                                   step="0.01"
                                   min="0"
                                   required
                                   style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%) !important; border: 2px solid #3182ce !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 18px !important; font-weight: 700 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;"
                                   placeholder="0.00"
                                   readonly>
                            @error('total_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text" style="color: #718096 !important; font-size: 12px !important; margin-top: 6px !important;">Auto-calculated: Subtotal + Tax + Shipping - Discount</small>
                        </div>
                    </div>
                </div>

                <!-- Order Status and Payment -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1.5rem 2rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 18px !important;">
                            <i class="bi bi-gear me-2" style="color: #3182ce !important;"></i>Order Settings
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="status" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Order Status <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="payment_status" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Payment Status <span style="color: #e53e3e !important;">*</span>
                                    </label>
                                    <select class="form-control @error('payment_status') is-invalid @enderror" 
                                            id="payment_status" 
                                            name="payment_status" 
                                            required
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                        <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="payment_method" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                        Payment Method <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                                    </label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" 
                                            name="payment_method"
                                            style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important;">
                                        <option value="">Select payment method...</option>
                                        <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="PayPal" {{ old('payment_method') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="Cash on Delivery" {{ old('payment_method') == 'Cash on Delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                        <option value="Apple Pay" {{ old('payment_method') == 'Apple Pay' ? 'selected' : '' }}>Apple Pay</option>
                                        <option value="Google Pay" {{ old('payment_method') == 'Google Pay' ? 'selected' : '' }}>Google Pay</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label" style="color: #2d3748 !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 10px !important;">
                                Order Notes <small style="color: #718096 !important; font-weight: 400 !important;">(optional)</small>
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3"
                                      style="background: #ffffff !important; border: 2px solid #e2e8f0 !important; color: #1a202c !important; padding: 14px 18px !important; border-radius: 10px !important; font-size: 15px !important; font-weight: 500 !important; line-height: 1.6 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease !important; resize: vertical !important;"
                                      placeholder="Add internal notes for this order...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" 
                               style="color: #4a5568 !important; border-color: #4a5568 !important; background: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; border-width: 2px !important; transition: all 0.2s ease !important; text-decoration: none !important;"
                               onmouseover="this.style.backgroundColor='#4a5568 !important'; this.style.color='#ffffff !important';"
                               onmouseout="this.style.backgroundColor='#ffffff !important'; this.style.color='#4a5568 !important';">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" 
                                    style="background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important; border: 2px solid #3182ce !important; color: #ffffff !important; padding: 14px 24px !important; border-radius: 10px !important; font-weight: 600 !important; font-size: 14px !important; box-shadow: 0 2px 4px rgba(49, 130, 206, 0.2) !important; transition: all 0.2s ease !important;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2c5aa0 0%, #2a4a8a 100%) !important'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(49, 130, 206, 0.3) !important';"
                                    onmouseout="this.style.background='linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%) !important'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(49, 130, 206, 0.2) !important';">
                                <i class="bi bi-check-circle me-2"></i>Create Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Preview -->
                <div class="card mb-4" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-eye me-2" style="color: #3182ce !important;"></i>Order Preview
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 1.5rem !important;">
                        <div id="order-preview">
                            <div class="preview-section mb-3" style="padding: 12px !important; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important; border-radius: 8px !important;">
                                <h6 style="color: #1a202c !important; font-weight: 600 !important; font-size: 14px !important; margin-bottom: 8px !important;">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #4a5568 !important; font-size: 13px !important;">Subtotal:</span>
                                    <span id="preview-subtotal" style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #4a5568 !important; font-size: 13px !important;">Tax:</span>
                                    <span id="preview-tax" style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #4a5568 !important; font-size: 13px !important;">Shipping:</span>
                                    <span id="preview-shipping" style="color: #1a202c !important; font-weight: 600 !important; font-size: 13px !important;">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #4a5568 !important; font-size: 13px !important;">Discount:</span>
                                    <span id="preview-discount" style="color: #ef4444 !important; font-weight: 600 !important; font-size: 13px !important;">-$0.00</span>
                                </div>
                                <hr style="margin: 12px 0 !important; border-color: #e2e8f0 !important;">
                                <div class="d-flex justify-content-between">
                                    <span style="color: #1a202c !important; font-weight: 700 !important; font-size: 16px !important;">Total:</span>
                                    <span id="preview-total" style="color: #10b981 !important; font-weight: 700 !important; font-size: 18px !important;">$0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Guidelines -->
                <div class="card" style="background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;">
                    <div class="card-header" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%) !important; border-bottom: 1px solid #e2e8f0 !important; border-radius: 12px 12px 0 0 !important; padding: 1rem 1.5rem !important;">
                        <h5 class="mb-0" style="color: #1a202c !important; font-weight: 600 !important; font-size: 16px !important;">
                            <i class="bi bi-lightbulb me-2" style="color: #3182ce !important;"></i>Order Guidelines
                        </h5>
                    </div>
                    <div class="card-body" style="padding: 2rem !important;">
                        <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%) !important; border-radius: 10px !important; border-left: 4px solid #10b981 !important; margin-bottom: 1rem;">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">📋 Order Creation Tips:</h6>
                            <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Link to registered user when possible</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Verify customer contact information</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Double-check address details</li>
                            </ul>
                        </div>
                        
                        <div style="padding: 1.25rem !important; background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%) !important; border-radius: 10px !important; border-left: 4px solid #f59e0b !important;">
                            <h6 style="color: #1a202c !important; font-weight: 600 !important; margin-bottom: 1rem !important;">💰 Amount Calculation:</h6>
                            <ul style="margin-bottom: 0 !important; padding-left: 1.25rem !important;">
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">Total = Subtotal + Tax + Shipping - Discount</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0.5rem !important;">All amounts auto-calculate</li>
                                <li style="color: #2d3748 !important; font-size: 13px !important; font-weight: 500 !important; line-height: 1.6 !important; margin-bottom: 0 !important;">Order number auto-generated</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Calculate total amount automatically
function calculateTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
    const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    const shipping = parseFloat(document.getElementById('shipping_amount').value) || 0;
    const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    
    const total = subtotal + tax + shipping - discount;
    
    // Update total field
    document.getElementById('total_amount').value = total.toFixed(2);
    
    // Update preview
    document.getElementById('preview-subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('preview-tax').textContent = '$' + tax.toFixed(2);
    document.getElementById('preview-shipping').textContent = '$' + shipping.toFixed(2);
    document.getElementById('preview-discount').textContent = '-$' + discount.toFixed(2);
    document.getElementById('preview-total').textContent = '$' + total.toFixed(2);
    
    // Color coding for total
    const totalElement = document.getElementById('total_amount');
    if (total > 0) {
        totalElement.style.borderColor = '#10b981';
        totalElement.style.background = 'linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%)';
    } else {
        totalElement.style.borderColor = '#3182ce';
        totalElement.style.background = 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)';
    }
}

// Fill user data when user is selected
function fillUserData(select) {
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        const name = selectedOption.dataset.name;
        const email = selectedOption.dataset.email;
        
        document.getElementById('customer_name').value = name;
        document.getElementById('customer_email').value = email;
        
        // Visual feedback
        document.getElementById('customer_name').style.borderColor = '#10b981';
        document.getElementById('customer_email').style.borderColor = '#10b981';
        
        setTimeout(function() {
            document.getElementById('customer_name').style.borderColor = '#e2e8f0';
            document.getElementById('customer_email').style.borderColor = '#e2e8f0';
        }, 2000);
    }
}

// Copy shipping address to billing address
function copyShippingToBilling() {
    const checkbox = document.getElementById('same_as_shipping');
    const shippingAddress = document.getElementById('shipping_address').value;
    const billingAddress = document.getElementById('billing_address');
    
    if (checkbox.checked) {
        billingAddress.value = shippingAddress;
        billingAddress.style.borderColor = '#10b981';
        billingAddress.style.background = '#f0fdf4';
        billingAddress.readOnly = true;
    } else {
        billingAddress.value = '';
        billingAddress.style.borderColor = '#e2e8f0';
        billingAddress.style.background = '#ffffff';
        billingAddress.readOnly = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize calculations
    calculateTotal();
    
    // Auto-calculate tax (8% of subtotal)
    document.getElementById('subtotal').addEventListener('input', function() {
        const subtotal = parseFloat(this.value) || 0;
        const taxRate = 0.08; // 8%
        document.getElementById('tax_amount').value = (subtotal * taxRate).toFixed(2);
        calculateTotal();
    });
});
</script>
@endpush

@push('styles')
<style>
    /* CLEAN ORDERS CREATE PAGE - Professional Styling */
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
    
    .form-control::placeholder {
        color: #718096 !important;
        opacity: 1 !important;
        font-weight: 400 !important;
    }
    
    .preview-section {
        transition: all 0.2s ease !important;
    }
    
    .preview-section:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }
    
    #total_amount {
        transition: all 0.3s ease !important;
    }
    
    .form-check-input:checked {
        background-color: #3182ce !important;
        border-color: #3182ce !important;
    }
</style>
@endpush
@endsection
