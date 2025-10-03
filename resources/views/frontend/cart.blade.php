@extends('frontend.layouts.layout')
@section('content')
<main class="bg_gray">
    <div class="container margin_30">
        <div class="page_header">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li>Cart</li>
                </ul>
            </div>
            <h1>Cart page</h1>
        </div>

        <!-- /page_header -->
        <table class="table table-striped cart-list">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @forelse(session('cart', []) as $id => $item)
                    @php $itemSubtotal = $item['price'] * $item['qty']; $subtotal += $itemSubtotal; @endphp
                    <tr>
                        <td>
                            <div class="thumb_cart">
  <img src="{{ isset($item['image']) ? asset('storage/' . $item['image']) : asset('img/product.png') }}"
       class="card-img-top" alt="Product Image" style="height: 65px;width:55px ;object-fit: cover;">
                            </div>
                            <span class="item_cart">{{ $item['name'] }}</span>
                        </td>
                        <td><strong>${{ number_format($item['price'], 2) }}</strong></td>
                        <td>
                            <form action="{{ route('cart.add') }}" method="POST" class="update-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control" style="width:70px; display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td><strong>${{ number_format($itemSubtotal, 2) }}</strong></td>
                        <td class="options">
                            <a href="{{ route('cart.remove', $id) }}"><i class="ti-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Your cart is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="row add_top_30 flex-sm-row-reverse cart_actions">
            <div class="col-sm-4 text-end">
                <button type="button" class="btn_1 gray">Update Cart</button>
            </div>
            <div class="col-sm-8">
                <div class="apply-coupon">
                    <div class="form-group">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="coupon-code" value="" placeholder="Promo code" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn_1 outline">Apply Coupon</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /cart_actions -->

    </div>
    <!-- /container -->

    <div class="box_cart">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <ul>
                        <li><span>Subtotal</span> ${{ number_format($subtotal, 2) }}</li>
                        <li><span>Shipping</span> $7.00</li>
                        <li><span>Total</span> ${{ number_format($subtotal + 7, 2) }}</li>
                    </ul>
                    <a href="{{ url('checkout') }}" class="btn_1 full-width cart">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /box_cart -->
</main>
@endsection
