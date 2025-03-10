@extends('layouts.customer.app')
@push('css')
<style>
    .swatch-option.active {
        outline: #f36 solid 3px;
    }

    .form-qty input[type="number"]::-webkit-inner-spin-button,
    .form-qty input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: inner-spin-button;
        display: block;
        pointer-events: all;
        opacity: 1;
    }
    select#forSize {
        text-transform: capitalize;
    }
    .btn-buy {
        height: 36px;
        background-color: #f90;
        color: #fff;
        font-size: 14px;
        padding: 0 12px;
        border: none;
        box-shadow: none;
        line-height: 36px;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
        margin-bottom: 10px;
    }
    .btn-buy:hover {
        background-color: #f60;
        color: #fff;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s
    }

    /* Parent Container */
    .block-content.delivery {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding-block: 5px !important;
    }

    /* Icon Styling */
    .block-content.delivery .icon {
        flex: 0 0 auto;
        font-size: 18px;
        color: #666;
        margin-right: 10px;
    }

    /* Content Styling */
    .block-content.delivery .content {
        flex: 1;
        font-size: 14px;
        color: #666;
    }

    .block-content.delivery .content .delivery-text {
        font-weight: bold;
        margin: 0 0 5px;
    }

    .block-content.delivery .content small {
        color: #666;
    }

    /* Price Styling */
    .block-content.delivery .price {
        flex: 0 0 auto;
        font-size: 14px;
        font-weight: bold;
        color: #666;
        text-align: right;
    }
    .block-title .title {
        color: #666;
        font-size: 16px;
        font-weight: bold;
        text-transform: capitalize;
    }
    .block-sidebar.single {
        background-color: #f9f9f9;
        padding-block: 20px;
    }
    .circle-days {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #666;
        color: #ffffff;
        font-size: 12px;
        line-height: 30px;
        margin-right: 5px;
        text-align: center;
    }

</style>

@endpush
@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <!-- Block  Breadcrumb-->
            <x-breadcrumbs :items="$breadcrumbs" />
            <!-- Block  Breadcrumb-->

            <div class="row">



                <!-- Main Content -->
                <div class="col-md-9 col-main">

                    <div class="row">

                        <div class="col-sm-6 col-md-6 col-lg-6">

                            <div class="product-media media-horizontal">

                                <div class="image_preview_container images-large">

                                    <div class="img-contain">
                                        <img id="img_zoom" data-zoom-image="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}" src="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}" alt="">
                                    </div>

                                    <button class="btn-zoom open_qv"><span>zoom</span></button>

                                </div>

                                <div class="product_preview images-small">

                                    <div class="owl-carousel thumbnails_carousel custompro" id="thumbnails"  data-nav="true" data-dots="false" data-margin="10" data-responsive='{"0":{"items":3},"480":{"items":4},"600":{"items":5},"768":{"items":5}}'>

                                        <a href="#" data-image="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}" data-zoom-image="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}">

                                            <img src="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}" data-large-image="{{ asset($product->thumbnail ??'frontend/assets/images/media/detail/thumb-img1.jpg') }}" alt="">

                                        </a>

                                        @foreach ($product->featuredImages as $featuredImage)
                                            <a href="#" data-image="{{ asset($featuredImage->image ?? 'frontend/assets/images/media/detail/thumb-img2.jpg') }}" data-zoom-image="{{ asset($featuredImage->image ?? 'frontend/assets/images/media/detail/thumb-img2.jpg') }}">

                                                <img src="{{ asset($featuredImage->image ?? 'frontend/assets/images/media/detail/thumb-img2.jpg') }}" data-large-image="{{ asset($featuredImage->image ?? 'frontend/assets/images/media/detail/thumb-img2.jpg') }}" alt="">

                                            </a>
                                        @endforeach

                                    </div>
                                    <!--/ .owl-carousel-->

                                </div>
                                <!--/ .product_preview-->

                            </div>
                            <!-- image product -->
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6">

                            <div class="product-info-main">

                                <h1 class="page-title">
                                    {{ $product->name }}
                                </h1>
                                <div class="product-reviews-summary">
                                    <div class="rating-summary">
                                        <div class="rating-result" title="70%">
                                            <span style="width:70%">
                                                <span><span>70</span>% of <span>100</span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="reviews-actions">
                                        <a href="" class="action view">Based  on 3 ratings</a>
                                        <a href="" class="action add"><img alt="img" src="{{ asset('frontend/assets/images/icon/write.png') }}">&#160;&#160;write a review</a>
                                    </div>
                                </div>

                                <div class="product-info-price">
                                    <div class="price-box">
                                        <span class="price">{{ country()->symbol.$product->sell_price }}</span>
                                        <span class="old-price">{{ country()->symbol.$product->mrp_price }}</span>
                                        <span class="label-sale">-{{ $product->discount_price }}%</span>
                                    </div>
                                </div>
                                <div class="product-code">
                                    Item Code: #{{ $product->item_code }}
                                </div>
                                <div class="product-info-stock">
                                    @if ($product->stock_quantity > 0)
                                        <div class="stock available">
                                            <span class="label">Availability: </span>In stock
                                        </div>
                                    @else
                                        <div class="stock" style="color: #ff0000;">
                                            <span class="label">Availability: </span>Out of stock
                                        </div>
                                    @endif
                                </div>
                                @if ($product->condition)
                                    <div class="product-condition">
                                        @if ($product->condition == App\Helpers\Constant::CONDITIONS['new'])
                                                Condition: New
                                        @elseif ($product->condition == App\Helpers\Constant::CONDITIONS['used'])
                                                Condition: Used
                                        @elseif ($product->condition == App\Helpers\Constant::CONDITIONS['refurbished'])
                                                Condition: Refurbished
                                        @endif
                                    </div>
                                @endif
                                <div class="product-overview">
                                    <div class="overview-content">
                                        {{ $product->short_description }}
                                    </div>
                                </div>

                                <div class="product-add-form">
                                    <p>Available Options:</p>
                                    <form>

                                        <div class="product-options-wrapper">
                                            <div class="swatch-opt">
                                                <div class="swatch-attribute color">
                                                    <span class="swatch-attribute-label">Color:</span>
                                                    <div class="swatch-attribute-options">
                                                        @php
                                                            $colors = json_decode($product->color);
                                                        @endphp
                                                        <!-- Swatch buttons -->
                                                        @foreach ($colors ?? [] as $key => $color)
                                                            <div class="swatch-option {{ ($key == 0) ? 'active' : '' }}" style="background-color: {{ $color }};" id="{{ $color }}"></div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-qty">
                                                <label class="label">Qty: </label>
                                                <div class="control">
                                                    <input type="number" class="form-control input-qty" value='1' id="quantity" name="quantity" min="1">
                                                </div>
                                            </div>
                                            @if (json_decode($product->size) !== null)
                                                <div class="form-configurable">

                                                    <label for="forSize" class="label">Size: </label>
                                                    <div class="control">
                                                        @php
                                                            $sizes = App\Helpers\Constant::SIZES;
                                                            $dataSize = json_decode($product->size ?? '[]');
                                                        @endphp
                                                        <select  id="forSize" class="form-control attribute-select">
                                                            @foreach ($sizes as $key => $sizeName)

                                                                @if(is_array($dataSize) && in_array($sizeName, $dataSize))
                                                                    <option value="{{ $sizeName }}">{{ $key }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <a href="" class="size-chart">Size chart</a>
                                                </div>
                                            @endif
                                        </div>



                                        <div class="product-options-bottom clearfix">

                                            <div class="actions">

                                                <button type="submit" title="Buy Now" class="action btn-buy">
                                                    <span>Buy Now</span>
                                                </button>

                                                <button type="button" title="Add to Cart" onclick="addCart({{ $product->id }}, 1)" class="action btn-cart">
                                                    <span>Add to Cart</span>
                                                </button>
                                                <div class="product-addto-links">

                                                    <a href="#" class="action btn-wishlist" title="Wish List">
                                                        <span>Wishlist</span>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                </div>

                            </div><!-- detail- product -->

                        </div><!-- Main detail -->

                    </div>

                    <!-- product tab info -->

                    <div class="product-info-detailed ">

                        <!-- Nav tabs -->
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="active"><a href="#description"  role="tab" data-toggle="tab">Product Details   </a></li>
                            <li role="presentation"><a href="#reviews"  role="tab" data-toggle="tab">ratings & reviews</a></li>
                            <li role="presentation"><a href="#questions"  role="tab" data-toggle="tab">questions </a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="description">
                                <div class="block-title">Product Details</div>
                                <div class="block-content">
                                    @php
                                        echo $product->description;
                                    @endphp

                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="reviews">
                                <div class="block-content">
                                    <div class="text-center">
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                        <p>There are no reviews yet. <i class="fa-regular fa-face-frown"></i></p>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="questions">
                                <div class="block-content">
                                    <div class="text-center">
                                        <i class="fa-regular fa-circle-question"></i>
                                        <p>There are no questions yet.</p>
                                        <p><a href="#"><u>Login</u></a> or <a href="#"><u>Register</u></a> to ask your question now, and answer will show here.</p>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product tab info -->

                    <!-- block-related product -->
                    @if ($relatedProducts->count() > 0)
                        <div class="block-related ">
                            <div class="block-title">
                                <strong class="title">You might also like</strong>
                            </div>
                            <div class="block-content ">
                                <ol class="product-items owl-carousel " data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":3},"992":{"items":4}}'>

                                    @foreach ($relatedProducts as $product)
                                        <li class="product-item product-item-opt-1">
                                            <div class="product-item-info">
                                                <div class="product-item-photo">
                                                    <a class="product-item-img" href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">
                                                        <div class="img-contain">
                                                            <img alt="{{ $product->name }}" src="{{ asset($product->thumbnail) }}" class="d-block w-100">
                                                        </div>
                                                    </a>
                                                    <div class="product-item-actions">
                                                        <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                                        <a class="btn btn-compare" href=""><span>compare</span></a>
                                                        <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                                    </div>

                                                    @if ($product->stock_quantity > 0)
                                                        <button type="button" class="btn btn-cart"  onclick="addCart({{ $product->id }}, 1)"><span>Add to Cart</span></button>
                                                    @else
                                                        <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                    @endif

                                                </div>
                                                <div class="product-item-detail">
                                                    <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
                                                    <div class="clearfix">
                                                        <div class="product-item-price">
                                                            <span class="price">{{ country()->symbol.$product->sell_price }}</span> <br>
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
                                        </li>
                                    @endforeach


                                </ol>
                            </div>
                        </div>
                    @else
                        <!-- block-random product -->
                        <div class="block-related ">
                            <div class="block-title">
                                <strong class="title">You might also like</strong>
                            </div>
                            <div class="block-content ">
                                <ol class="product-items owl-carousel " data-nav="true" data-dots="false" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":3},"992":{"items":4}}'>

                                    @forelse ($randomProducts as $product)
                                        <li class="product-item product-item-opt-1">
                                            <div class="product-item-info">
                                                <div class="product-item-photo">
                                                    <a class="product-item-img" href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">
                                                        <div class="img-contain">
                                                            <img alt="{{ $product->name }}" src="{{ asset($product->thumbnail) }}" class="d-block w-100">
                                                        </div>
                                                    </a>
                                                    <div class="product-item-actions">
                                                        <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                                        <a class="btn btn-compare" href=""><span>compare</span></a>
                                                        <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                                    </div>

                                                    @if ($product->stock_quantity > 0)
                                                        <button type="button" class="btn btn-cart"  onclick="addCart({{ $product->id }}, 1)"><span>Add to Cart</span></button>
                                                    @else
                                                        <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                    @endif

                                                </div>
                                                <div class="product-item-detail">
                                                    <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
                                                    <div class="clearfix">
                                                        <div class="product-item-price">
                                                            <span class="price">{{ country()->symbol.$product->sell_price }}</span> <br>
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
                                        </li>
                                    @empty
                                    <p style="color: #f36;">Products Not Found!</p>

                                    @endforelse


                                </ol>
                            </div>
                        </div>
                        <!-- block-related product -->
                    @endif
                    <!-- block-related product -->



                </div>
                <!-- Main Content -->

                <!-- Sidebar -->
                <div class=" col-md-3 col-sidebar">

                    <!-- Block  bestseller products-->
                    <div class="block-sidebar single">
                        <div class="block-title" style="border: none;">
                            <h5 class="title">Delivery Options </h5>
                        </div>
                        <div class="block-content delivery">
                            <div class="icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="content">
                                <p class="delivery-text">Standard Delivery</p>
                                <p><small>Guaranteed by 2-7 dec</small></p>
                            </div>
                            <div class="price">
                                <span>{{ country()->symbol . '60' }}</span>
                            </div>
                        </div>
                        <div class="block-content delivery">
                            <div class="icon">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </div>
                            <div class="content">
                                <p class="delivery-text">Cash on Delivery Available</p>
                            </div>
                        </div>
                        <hr>
                        <div class="block-title" style="border: none;">
                            <h5 class="title">Warranty & Returns </h5>
                        </div>
                        <div class="block-content delivery">
                            <div class="icon">
                                <span class="circle-days">7</span>
                            </div>
                            <div class="content">
                                <p class="delivery-text">7 days easy return</p>
                            </div>
                        </div>
                        <div class="block-content delivery">
                            <div class="icon">
                                {{-- <i class="fa-regular fa-circle-check"></i> --}}
                                <i class="fa-regular fa-circle-xmark"></i>
                            </div>
                            <div class="content">
                                <p class="delivery-text">Warranty not Available</p>
                            </div>
                        </div>
                        <hr>
                        <div class="block-title" style="border: none;">
                            <h5 class="title">Delivery Address </h5>
                        </div>
                        <div class="block-content delivery" style="padding-bottom: 20px;">
                            <div class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="content">
                                <p class="delivery-text address">
                                    @if ($address)
                                        {{ $address->address ? $address->address . ', ' : '' }}
                                        {{ optional($address->upazilas)->name ? optional($address->upazilas)->name . ', ' : '' }}
                                        {{ optional($address->district)->name ? optional($address->district)->name . ', ' : '' }}
                                        {{ optional($address->division)->name ?? 'Set Your Address' }}
                                    @else
                                        Set Your Address
                                    @endif
                                </p>

                            </div>
                            <div class="price">
                                <a href="#">Change</a>
                            </div>
                        </div>

                    </div>
                    <!-- Block  bestseller products-->

                </div>
                <!-- Sidebar -->

            </div>
        </div>


    </main><!-- end MAIN -->

@endsection

@push('js')
{{-- select the current location of this device --}}
{{-- @include('layouts.customer.maps') --}}
<script>
    // jQuery to handle color selection
    $(document).ready(function () {
        $('.swatch-option').on('click', function () {
            // Remove the 'active' class from all options
            $('.swatch-option').removeClass('active');

            $(this).addClass('active');

        });
    });

</script>

@endpush
