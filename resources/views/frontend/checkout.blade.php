@extends('frontend.layouts.layout')
@section('content')
<main class="bg_gray">
    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
            <h1>Checkout</h1>
        </div>
        <!-- /page_header -->

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6>Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('frontend.order.place') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row">
                <!-- Left Column: Billing & Shipping -->
                <div class="col-lg-8">
                    <!-- Customer Information -->
                    <div class="step first">
                        <h3>1. Customer Information</h3>
                        <div class="tab-content checkout">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="customer_name">Full Name *</label>
                                    <input type="text" 
                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           placeholder="John Doe" 
                                           value="{{ old('customer_name', $user->name ?? '') }}"
                                           required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="customer_email">Email *</label>
                                    <input type="email" 
                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                           id="customer_email" 
                                           name="customer_email" 
                                           placeholder="john@example.com" 
                                           value="{{ old('customer_email', $user->email ?? '') }}"
                                           required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="customer_phone">Phone Number *</label>
                                <input type="tel" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       placeholder="+1234567890" 
                                       value="{{ old('customer_phone') }}"
                                       required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <!-- Shipping Address -->
                            <h5 class="mt-4 mb-3">Shipping Address</h5>
                            <div class="form-group">
                                <label for="shipping_address">Street Address *</label>
                                <input type="text" 
                                       class="form-control @error('shipping_address') is-invalid @enderror" 
                                       id="shipping_address" 
                                       name="shipping_address" 
                                       placeholder="123 Main Street, Apartment 4B" 
                                       value="{{ old('shipping_address') }}"
                                       required>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="shipping_city">City *</label>
                                    <input type="text" 
                                           class="form-control @error('shipping_city') is-invalid @enderror" 
                                           id="shipping_city" 
                                           name="shipping_city" 
                                           placeholder="New York" 
                                           value="{{ old('shipping_city') }}"
                                           required>
                                    @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="shipping_postal_code">Postal Code *</label>
                                    <input type="text" 
                                           class="form-control @error('shipping_postal_code') is-invalid @enderror" 
                                           id="shipping_postal_code" 
                                           name="shipping_postal_code" 
                                           placeholder="10001" 
                                           value="{{ old('shipping_postal_code') }}"
                                           required>
                                    @error('shipping_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipping_country">Country *</label>
                                <select class="form-control @error('shipping_country') is-invalid @enderror" 
                                        id="shipping_country" 
                                        name="shipping_country" 
                                        required>
                                    <option value="">Select Country</option>
                                    <option value="Lebanon" {{ old('shipping_country') == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
                                    <option value="United States" {{ old('shipping_country') == 'United States' ? 'selected' : '' }}>United States</option>
                                    <option value="Canada" {{ old('shipping_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="United Kingdom" {{ old('shipping_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="Australia" {{ old('shipping_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Germany" {{ old('shipping_country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                    <option value="France" {{ old('shipping_country') == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Other" {{ old('shipping_country') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('shipping_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="container_check">
                                    Use different billing address
                                    <input type="checkbox" id="other_billing_address">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <!-- Billing Address (Hidden by default) -->
                            <div id="billing_address_fields" style="display: none;">
                                <h5 class="mt-4 mb-3">Billing Address</h5>
                                <div class="form-group">
                                    <label for="billing_address">Street Address</label>
                                    <input type="text" class="form-control" id="billing_address" name="billing_address" value="{{ old('billing_address') }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="billing_city">City</label>
                                        <input type="text" class="form-control" id="billing_city" name="billing_city" value="{{ old('billing_city') }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="billing_postal_code">Postal Code</label>
                                        <input type="text" class="form-control" id="billing_postal_code" name="billing_postal_code" value="{{ old('billing_postal_code') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="billing_country">Country</label>
                                    <select class="form-control" id="billing_country" name="billing_country">
                                        <option value="">Select Country</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="France">France</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /step -->

                    <!-- Payment & Shipping Methods -->
                    <div class="step middle payments mt-4">
                        <h3>2. Payment and Shipping</h3>
                        
                        <h6 class="pb-2">Payment Method *</h6>
                        <ul>
                            <li>
                                <label class="container_radio">Credit Card
                                    <input type="radio" name="payment_method" value="credit_card" {{ old('payment_method') == 'credit_card' ? 'checked' : 'checked' }} required>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_radio">PayPal
                                    <input type="radio" name="payment_method" value="paypal" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_radio">Cash on Delivery
                                    <input type="radio" name="payment_method" value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_radio">Bank Transfer
                                    <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>

                        <h6 class="pb-2 mt-4">Shipping Method *</h6>
                        <ul>
                            <li>
                                <label class="container_radio">Standard Shipping ($10.00)
                                    <input type="radio" name="shipping_method" value="standard" {{ old('shipping_method') == 'standard' ? 'checked' : 'checked' }} required>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                            <li>
                                <label class="container_radio">Express Shipping ($20.00)
                                    <input type="radio" name="shipping_method" value="express" {{ old('shipping_method') == 'express' ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                </label>
                            </li>
                        </ul>

                        <div class="form-group mt-4">
                            <label for="notes">Order Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <!-- /step -->
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-4">
                    <div class="step last">
                        <h3>3. Order Summary</h3>
                        <div class="box_general summary">
                            <ul>
                                @foreach($cart as $item)
                                    <li class="clearfix">
                                        <em>{{ $item['qty'] }}x {{ $item['name'] }}</em>
                                        <span>${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <ul>
                                <li class="clearfix">
                                    <em><strong>Subtotal</strong></em>
                                    <span id="subtotal-display">${{ number_format($subtotal, 2) }}</span>
                                </li>
                                <li class="clearfix">
                                    <em><strong>Shipping</strong></em>
                                    <span id="shipping-display">${{ number_format($shipping, 2) }}</span>
                                </li>
                            </ul>
                            <div class="total clearfix">
                                TOTAL <span id="total-display">${{ number_format($total, 2) }}</span>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
    @csrf
    <!-- Your fields here -->

    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>

</form>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

                            
                            <button type="submit" class="btn_1 full-width" id="place-order-btn">
                                <i class="bi bi-lock"></i> Confirm and Place Order
                            </button>
                        </div>
                        <!-- /box_general -->
                    </div>
                    <!-- /step -->
                </div>
            </div>
            <!-- /row -->
        </form>
    </div>
    <!-- /container -->
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle billing address fields
    const billingCheckbox = document.getElementById('other_billing_address');
    const billingFields = document.getElementById('billing_address_fields');
    
    if (billingCheckbox) {
        billingCheckbox.addEventListener('change', function() {
            billingFields.style.display = this.checked ? 'block' : 'none';
        });
    }

    // Update shipping cost when shipping method changes
    const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
    const shippingDisplay = document.getElementById('shipping-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = {{ $subtotal }};

    shippingInputs.forEach(input => {
        input.addEventListener('change', function() {
            const shipping = this.value === 'express' ? 20.00 : 10.00;
            const total = subtotal + shipping;
            
            shippingDisplay.textContent = '$' + shipping.toFixed(2);
            totalDisplay.textContent = '$' + total.toFixed(2);
        });
    });

    // Form submission
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('place-order-btn');
    
    form.addEventListener('submit', function(e) {
        // Check reCAPTCHA if present
        const recaptchaContainer = document.querySelector('.g-recaptcha');
        if (recaptchaContainer) {
            const recaptchaResponse = document.querySelector('[name="g-recaptcha-response"]');
            if (!recaptchaResponse || !recaptchaResponse.value) {
                e.preventDefault();
                alert('🔒 Please complete the security verification (reCAPTCHA) before placing your order.');
                return false;
            }
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    });
});
</script>
@endsection