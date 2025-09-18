@extends('admin.dashboard')

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Products</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All Products</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." name="name" required>
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="add-product.html"><i class="icon-plus"></i>Add new</a>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>SalePrice</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Featured</th>
                                <th>Stock</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>6</td>
                                <td class="pname">
                                    <div class="image">
                                        <img src="1718623519.html" alt="" width="40">
                                    </div>
                                    <div class="name">
                                        <a href="#" class="body-title-2">Product6</a>
                                        <div class="text-tiny mt-3">product6</div>
                                    </div>
                                </td>
                                <td>$128.00</td>
                                <td>$110.00</td>
                                <td>SKU7868</td>
                                <td>Category3</td>
                                <td>Brand2</td>
                                <td>Yes</td>
                                <td>instock</td>
                                <td>11</td>
                                <td class="text-center">
                                    <a href="#" class="text-primary me-3 fs-5"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="text-success me-3 fs-5"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="text-danger fs-5"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination"></div>
            </div>
        </div>
    </div>
</div>
@endsection
