

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
			<h1>My Profile page</h1>
		</div>
		<!-- /page_header -->

		<div class="row">
            <div class="col-lg-6">
                <div class="box_profile_details">
                    <h3>User Details</h3>
                    <div class="data_profile">
                        <p>Name: Jhon<p>
                            <p>Last Name: Doe<p>
                            <p>Telephone: 0948433423</p>
                    </div>
                    <p><a href="#0">Edit/Change</a></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box_profile_details">
                    <h3>Login Details</h3>
                    <div class="data_profile">
                        <p>Email Address: user@gmail.com<p>
                        <p>Password: th******er</p>
                        <p></p>
                    </div>
                    <p><a href="#0">Edit/Change</a></p>
                </div>
            </div>
        </div>
        <!-- /row -->

        <div class="row">
            <div class="col-lg-6">
                <div class="box_profile_details">
                    <h3>Billing Address</h3>
                    <div class="data_profile">
                        <p>Address: 97845 Baker st. 567<p>
                        <p>City/Country: Los Angeles - US</p>
                        <p>Postal code: 60515</p>
                    </div>
                    <p><a href="#0">Edit/Change</a></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box_profile_details">
                    <h3>Shipping Address</h3>
                    <div class="data_profile">
                        <p>Address: 97845 Baker st. 567<p>
                        <p>City/Country: Los Angeles - US</p>
                        <p>Postal code: 60515</p>
                    </div>
                    <p><a href="#0">Edit/Change</a></p>
                </div>
            </div>
        </div>
        <!-- /row -->

		<div class="row">
			<div class="col-lg-4 col-md-6">
				<a class="box_topic" href="{{ url('my-orders') }}">
					<i class="ti-bag"></i>
					<h3>My Orders</h3>
				</a>
			</div>
			<div class="col-lg-4 col-md-6">
				<a class="box_topic" href="{{ url('my-wishlist') }}">
					<i class="ti-heart"></i>
					<h3>My Wishlist</h3>
				</a>
			</div>
			<div class="col-lg-4 col-md-6">
				<a class="box_topic" href="{{ url('leave-review') }}">
					<i class="ti-comment"></i>
					<h3>Leave a review</h3>
				</a>
			</div>
		</div>
		<!-- /row -->

		</div>
		<!-- /container -->
	</main>
@endsection
