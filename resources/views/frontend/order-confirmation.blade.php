@extends('frontend.layouts.layout')
@section('content')
<main class="bg_gray">
    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Order Confirmation</li>
                </ul>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Order Success Message -->
        <div class="text-center mb-5">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill" style="font-size: 80px; color: #10b981;"></i>
            </div>
            <h1 class="mb-3">Thank You for Your Order!</h1>
            <p class="lead">Your order has been successfully placed.</p>
            <p class="text-muted">Order Number: <strong>{{ $order->order_number }}</strong></p>
        </div>

        <div class="row">
            <!-- Order Details -->
            <div class="col-lg-8">
                <!-- Order Information -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Order Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Order Number:</strong><br>{{ $order->order_number }}</p>
                                <p><strong>Order Date:</strong><br>{{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                                <p><strong>Order Status:</strong><br>
                                    <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Method:</strong><br>{{ $order->payment_method }}</p>
                                <p><strong>Payment Status:</strong><br>
                                    <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                </p>
                                <p><strong>Email:</strong><br>{{ $order->customer_email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="white-space: pre-line;">{{ $order->shipping_address }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-cart3 me-2"></i>Order Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                                    @endif
                                                    <span>{{ $item->product->name ?? 'Product Not Found' }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="text-end">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                        <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    @if($order->tax_amount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                            <td class="text-end">${{ number_format($order->tax_amount, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                        <td class="text-end">${{ number_format($order->shipping_amount, 2) }}</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td colspan="3" class="text-end"><strong>TOTAL:</strong></td>
                                        <td class="text-end"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- What's Next -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">What's Next?</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="bi bi-envelope-check text-success me-2"></i>
                                <strong>Confirmation Email</strong><br>
                                <small class="text-muted">We've sent a confirmation email to {{ $order->customer_email }}</small>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-box-seam text-primary me-2"></i>
                                <strong>Processing</strong><br>
                                <small class="text-muted">We'll prepare your order for shipping</small>
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-truck text-info me-2"></i>
                                <strong>Shipping</strong><br>
                                <small class="text-muted">You'll receive tracking information once shipped</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg w-100 mb-2">
                            <i class="bi bi-house-door me-2"></i>Continue Shopping
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-printer me-2"></i>Print Order
                        </button>
                    </div>
                </div>

                <!-- Need Help -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <h6>Need Help?</h6>
                        <p class="text-muted small mb-2">Contact our customer service</p>
                        <p class="text-muted small">Email: support@example.com<br>Phone: +1 234-567-8900</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
@media print {
    .btn, .card-header, nav, footer, .breadcrumbs {
        display: none !important;
    }
}
</style>
@endsection
