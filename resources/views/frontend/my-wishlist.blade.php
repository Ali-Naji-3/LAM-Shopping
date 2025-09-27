
@extends('frontend.layouts.layout')

@section('content')

	<main class="bg_gray">
		<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
			</div>
			<h1>My Wishlist page</h1>
		</div>
		<!-- /page_header -->
		<table class="table table-striped product-list whislist mb-5">
			<thead>
				<tr>
					<th>
						Product
					</th>
					<th>
						Price
					</th>
					<th>
						Product id
					</th>
					<th>
                        Action
					</th>
                    <th>
                        Remove
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
				<tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
                <tr>
					<td>
						<div class="thumb_product">
							<img src="img/products/product_placeholder_square_small.jpg" data-src="img/products/shoes/1.jpg"
								class="lazy" alt="Image">
						</div>
						<span class="item_product"><a href="#">Armor Air x Fear</a></span>
					</td>
					<td>
						<strong>$140.00</strong>
					</td>
					<td>
						<strong>#ew33r4</strong>
					</td>
					<td>
						<a href="#0" class="btn_1">Add to cart</a>
					</td>
                    <td class="options">
                        <a href="#"><i class="ti-trash"></i></a>
                    </td>
				</tr>
			</tbody>
		</table>
		</div>
		<!-- /container -->
	</main>
    @endsection

