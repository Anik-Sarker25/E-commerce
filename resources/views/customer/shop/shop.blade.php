@extends('layouts.customer.app')

@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">

            <!-- Block  Breadcrumb-->
            <x-breadcrumbs :items="$breadcrumbs" />
            <!-- Block  Breadcrumb-->

            <div class="row">

                <!-- Main Content -->
                <div class="col-md-9 col-md-push-3  col-main">

                    <div class="toolbar-products toolbar-top">
                        <h1 class="cate-title" style="text-transform: capitalize;">
                            @if (Route::currentRouteName() == 'shop')
                                {{ 'shop has ' .$products->count() . ' Items' }}
                            @else
                                {{ $pageTitle }}
                            @endif

                        </h1>
                    </div>

                    <!-- List Products -->
                    <div class="products  products-grid">
                        <ol class="product-items row">
                            @forelse ($products as $product)
                                <li class="col-sm-3 product-item ">
                                    <div class="product-item-opt-1">
                                        <div class="product-item-info">
                                            <div class="product-item-photo">
                                                <a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}" class="product-item-img">
                                                    <div class="img-contain">
                                                        <img alt="{{ $product->name }}" src="{{ asset($product->thumbnail) }}">
                                                    </div>
                                                </a>
                                                <div class="product-item-actions">
                                                    <a href="" class="btn btn-wishlist"><span>wishlist</span></a>
                                                    <a href="" class="btn btn-compare"><span>compare</span></a>
                                                    <a href="" class="btn btn-quickview"><span>quickview</span></a>
                                                </div>

                                                @if (availableStock($product->id) > 0)
                                                    <button type="button" class="btn btn-cart" onclick="addCart({{ $product->id }}, 1)"><span>Add to Cart</span></button>
                                                @else
                                                    <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                @endif

                                                @if ($product->discount_price > 0)
                                                    <span class="product-item-label label-price">{{ $product->discount_price }}% <span>off</span></span>
                                                @endif
                                            </div>
                                            <div class="product-item-detail">
                                                <strong class="product-item-name">
                                                    <a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a>
                                                </strong>
                                                <div class="clearfix">
                                                    <div class="product-item-price">
                                                        <span class="price">{{ country()->symbol.$product->sell_price }}</span>
                                                        <span class="old-price">{{ country()->symbol.$product->mrp_price }}</span>
                                                    </div>
                                                    <div class="product-reviews-summary">
                                                        <div class="rating-summary">
                                                            <div title="80%" class="rating-result">
                                                                <span style="width:80%">
                                                                    <span><span>80</span>% of <span>100</span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            @empty
                                <p class="text-center" style="color: red; padding: 20px 0;">No products found.</p>
                            @endforelse

                        </ol>
                        <!-- list product -->
                    </div>
                    <!-- List Products -->

                    <!-- Toolbar -->
                    <div class=" toolbar-products toolbar-bottom">

                        <div class="modes">
                            <strong  class="label">View as:</strong>
                            <strong  class="modes-mode active mode-grid" title="Grid">
                                <span>grid</span>
                            </strong>
                            <a  href="Category2.html" title="List" class="modes-mode mode-list">
                                <span>list</span>
                            </a>
                        </div><!-- View as -->

                        <div class="toolbar-option">

                            <div class="toolbar-sorter ">
                                <label    class="label">Short by:</label>
                                <select class="sorter-options form-control" >
                                    <option selected="selected" value="position">Product name</option>
                                    <option value="name">Name</option>
                                    <option value="price">Price</option>
                                </select>
                                <a href="" class="sorter-action"></a>
                            </div><!-- Short by -->

                            <div class="toolbar-limiter">
                                <label   class="label">
                                    <span>Show:</span>
                                </label>

                                <select class="limiter-options form-control" >
                                    <option selected="selected" value="9"> Show 18</option>
                                    <option value="15">Show 15</option>
                                    <option value="30">Show 30</option>
                                </select>

                            </div><!-- Show per page -->

                        </div>

                        <ul class="pagination">


                            <li class="active">
                                <a href="#">1</a>
                            </li>
                            <li>
                                <a href="#">2</a>
                            </li>
                            <li>
                                <a href="#">3</a>
                            </li>
                            <li>
                                <a href="#">4</a>
                            </li>
                            <li>
                                <a href="#">5</a>
                            </li>
                            <li class="action action-next">
                                <a href="#">
                                    Next <span><i aria-hidden="true" class="fa fa-angle-double-right"></i></span>
                                </a>
                            </li>
                        </ul>

                    </div><!-- Toolbar -->

                </div>
                <!-- Main Content -->

                @include('layouts.customer.shop_sidebar')

            </div>
        </div>


    </main>
    <!-- end MAIN -->

@endsection

@push('js')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on('change', '.items .category_check', function () {
        // Uncheck all other checkboxes
        $('.items .category_check').not(this).prop('checked', false);

        // Trigger the filter function
        filterProducts();
    });

    $(document).on('change', '.items .brand_check', function () {
        // Uncheck all other checkboxes
        $('.items .brand_check').not(this).prop('checked', false);

        // Trigger the filter function
        filterProducts();
    });

    $(document).on('change', '.items .color_check', function () {
        // Uncheck all other checkboxes
        // $('.items .color_check').not(this).prop('checked', false);

        // Trigger the filter function
        filterProducts();
    });

    $(document).on('change', '.items .warranty_check', function () {
        // Uncheck all other checkboxes
        // $('.items .warranty_check').not(this).prop('checked', false);

        // Trigger the filter function
        filterProducts();
    });

    $('#min_price, #max_price').on('input', function () {
        // Trigger the filter function
        filterProducts();
    });

    function filterProducts() {
        let url = "{{ route('shop') }}";

        // Get the selected checkbox ID
        let category_id = $('.items .category_check:checked').attr('id');
        let brand_id = $('.items .brand_check:checked').attr('id');
        let warrenties = [];
        $('.items .warranty_check:checked').each(function () {
            warrenties.push($(this).attr('id'));
        });

        let colors = [];
        $('.items .color_check:checked').each(function () {
            colors.push($(this).attr('id'));
        });


        // Get the price range values
        let min = $('#min_price').val();
        let max = $('#max_price').val();

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                category_id: category_id,
                filterBrand_id: brand_id,
                filterColor: colors,
                filterWarranty: warrenties,
                min: min,
                max: max
            },
            success: function (products) {
                // Call a function to render the product list
                renderProductList(products);
            },
            error: function (error) {
                console.error('Error fetching products:', error);
            }
        });
    }



    // Function to render the product list dynamically
    function renderProductList(products) {
        let productListContainer = $('.products .product-items'); // Select the product list container
        productListContainer.empty(); // Clear the existing products

        let title = $('.cate-title');
        let baseTitle = "{{ ucwords(siteInfo()->company_name) }}"; // Base title from Blade
        // Count of products
        let productCount = products.length;

        // Update the page title based on the product count
        if (productCount > 0) {
            title.html(`${productCount} items`);
            document.title = `${baseTitle} | ${productCount} items`;
        } else {
            document.title = `${baseTitle} | No products found`;
        }

        let baseUrl = "{{ asset('') }}";
        let baseRoute = "{{ route('product.show', ['slug' => ':slug']) }}";

        if (products.length > 0) {
            products.forEach(product => {

                let productRoute = baseRoute.replace(':slug', product.slug);
                let productHTML = `
                    <li class="col-sm-3 product-item">
                        <div class="product-item-opt-1">
                            <div class="product-item-info">
                                <div class="product-item-photo">
                                    <a href="${productRoute}?itemcode=${product.item_code}&pro=${product.id}" class="product-item-img">
                                        <div class="img-contain">
                                            <img alt="${product.name}" src="${baseUrl}${product.thumbnail}">
                                        </div>
                                    </a>
                                    <div class="product-item-actions">
                                        <a href="" class="btn btn-wishlist"><span>wishlist</span></a>
                                        <a href="" class="btn btn-compare"><span>compare</span></a>
                                        <a href="" class="btn btn-quickview"><span>quickview</span></a>
                                    </div>
                                    ${
                                        product.stock_quantity > 0
                                            ? `<button type="button" class="btn btn-cart" onclick="addCart(${product.id}, 1)"><span>Add to Cart</span></button>`
                                            : `<button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>`
                                    }
                                    ${
                                        product.discount_price > 0
                                            ? `<span class="product-item-label label-price">${product.discount_price}% <span>off</span></span>`
                                            : ''
                                    }
                                </div>
                                <div class="product-item-detail">
                                    <strong class="product-item-name">
                                        <a href="/product/${product.slug}?itemcode=${product.item_code}&pro=${product.id}">${product.name}</a>
                                    </strong>
                                    <div class="clearfix">
                                        <div class="product-item-price">
                                            <span class="price">${product.sell_price}</span>
                                            <span class="old-price">${product.mrp_price}</span>
                                        </div>
                                        <div class="product-reviews-summary">
                                            <div class="rating-summary">
                                                <div title="80%" class="rating-result">
                                                    <span style="width:80%">
                                                        <span><span>80</span>% of <span>100</span></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
                productListContainer.append(productHTML);
            });
        } else {
            productListContainer.html('<p class="text-center" style="color: red; padding: 20px 0;">No products found.</p>');
        }
    }






</script>

@endpush


