@extends('layouts.customer.app')


@section('content')
    @php
        use App\Helpers\Constant;
        $banner1 = Constant::BANNER_TYPE['ads_banner1'];
        $banner2 = Constant::BANNER_TYPE['ads_banner2'];
        $banner3 = Constant::BANNER_TYPE['ads_banner3'];
        $banner4 = Constant::BANNER_TYPE['ads_banner4'];
    @endphp

        <!-- MAIN -->
        <main class="site-main">

            <!--  Popup Newsletter-->
            {{-- <div class="modal fade popup-newsletter" id="popup-newsletter" tabindex="-1" role="dialog" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background-image: url({{ asset('frontend/assets/images/media/index1/Popup.jpg') }});">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="block-newletter">
                            <div class="block-title">signup for our newsletter & promotions</div>
                            <div class="block-content">
                                <p class="text-title">GET <span>50% <span>off</span></span></p>
                                <form>
                                    <label>on your next purchase</label>
                                    <div class="input-group">
                                        <input type="text" placeholder="Enter your email..." class="form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-subcribe"><span>Subscribe</span></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="checkbox btn-checkbox">
                                <label>
                                    <input type="checkbox"><span>Dont’s show this popup again!</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!--  Popup Newsletter-->

            <div class="block-section-top block-section-top1">
                <div class="container">
                    <div class="box-section-top">

                        <!-- categori -->
                        <div class="block-nav-categori">

                            <div class="block-title">
                                <span>Categories</span>
                            </div>

                            <div class="block-content">
                                <ul class="ui-categori">
                                    @foreach ($categories as $key => $category)
                                    @if($category->products()->exists())
                                        <!-- Apply 'cat-link-orther' class to items after the 10th one -->
                                        <li class="parent {{ $key >= 11 ? 'cat-link-orther' : '' }}">
                                            <a href="{{ route('category.show', $category->slug) }}?cat_id={{ $category->id }}">
                                                <span class="icon">
                                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                                </span>
                                                {{ $category->name }}
                                            </a>

                                            @if ($category->subcategories->isNotEmpty())
                                                <span class="toggle-submenu"></span>
                                                <div class="submenu" style="min-height: 200px;">
                                                    <ul class="categori-list clearfix">
                                                        @foreach ($category->subcategories as $subcategory)
                                                            <li class="col-sm-3">
                                                                <strong class="title"><a href="{{ route('subcategory.show', $subcategory->slug) }}?subcat_id={{ $subcategory->id }}">{{ $subcategory->name }}</a></strong>

                                                                @if ($subcategory->childcategories->isNotEmpty())
                                                                    <ul>
                                                                        @foreach ($subcategory->childcategories as $childcategory)
                                                                            <li><a href="{{ route('childcategory.show', $childcategory->slug) }}?childcat_id={{ $childcategory->id }}">{{ $childcategory->name }}</a></li>

                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="toggle-submenu"></span>
                                                <div class="submenu" style="min-height: 200px;">
                                                    <p class="text-center text-danger mb-0">Subcategory Not Found!</p>
                                                </div>
                                            @endif
                                        </li>
                                    @endif
                                    @endforeach
                                </ul>

                                <div class="view-all-categori">
                                    <a  class="open-cate btn-view-all">All Categories</a>
                                </div>
                            </div>

                        </div>
                        <!-- categori -->

                        <!-- block slide top -->
                        <div class="block-slide-main slide-opt-1">

                            <!-- slide -->
                            <div class="owl-carousel dotsData"
                                data-nav="true"
                                data-dots="true"
                                data-margin="0"
                                data-items='1'
                                data-autoplayTimeout="700"
                                data-autoplay="true"
                                data-loop="true">
                                @forelse ($homePagebanners as $key => $banner)
                                    <div class="item item2" data-dot="{{ $key + 1 }}">
                                        <a href="{{ route('shop') }}?big_sale={{ App\Helpers\Constant::PRODUCT_TYPE['big_sale'] }}">
                                            <img src="{{ asset($banner->image) }}" alt="">
                                        </a>

                                    </div>
                                @empty
                                    <div class="item item2" data-dot="1">
                                        <a href="javascript::">
                                            <img src="{{ asset('frontend/assets/images/media/index1/slide2.jpg') }}" alt="banner-image">
                                        </a>
                                    </div>
                                    <div class="item item2" data-dot="2">
                                        <a href="javascript::">
                                            <img src="{{ asset('frontend/assets/images/media/index1/slide2.jpg') }}" alt="banner-image">
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                            <!-- slide -->

                        </div>
                        <!-- block slide top -->

                        <!-- banner -->
                        <div class="banner-slide">
                            @foreach ($big_saleProducts->take(2) as $key => $product)
                                <a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}" class="box-img">
                                    <img src="{{ asset($product->thumbnail) }}" alt="banner-slide">
                                </a>
                            @endforeach
                        </div>
                        <!-- banner -->

                    </div>
                </div>
            </div>

            <!-- block  service-->
            <div class="container ">
                <div class="block-service-opt1">
                    <div class="clearfix">
                        @php
                            $serviceCount = count($services->take(4));
                        @endphp
                        @foreach ($services->take(4) as $service)
                            @if ($serviceCount == 1)
                                <div class="col-md-12 col-sm-12">
                            @elseif ($serviceCount == 2)
                                <div class="col-md-6 col-sm-6">
                            @elseif ($serviceCount == 3)
                                <div class="col-md-4 col-sm-6">
                            @else
                                <div class="col-md-3 col-sm-6">
                            @endif
                                    <div class="item">
                                        <span class="icon">
                                            @if ($service->icon)
                                                <i class="{{ $service->icon }}" style="font-size: 24px;"></i>
                                            @else
                                                <img src="{{ asset('frontend/assets/images/media/index1/service1.png') }}" alt="service">
                                            @endif
                                        </span>
                                        <strong class="title">{{ $service->name ?? 'Name gose here' }}</strong>
                                        <span>{{ $service->description ?? 'Description gose here' }}</span>
                                    </div>
                                </div>

                        @endforeach

                    </div>
                </div>
            </div>
            <!-- block  service-->


            <div class="container">
                <div class="row">

                    <div class="col-md-9">
                        <!-- block tab products -->
                        <div class="block-tab-products-opt1">

                            <div class="block-title">
                                <ul class="nav" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#tabproduct1"  role="tab" data-toggle="tab">best SELLERS </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tabproduct2" role="tab" data-toggle="tab">ON SALE</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#tabproduct3"  role="tab" data-toggle="tab">NEW PRODUCTS</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="block-content tab-content">

                                <!-- tab 1 -->
                                <div role="tabpanel" class="tab-pane active fade in " id="tabproduct1">
                                    <div class="owl-carousel"
                                        data-nav="true"
                                        data-dots="false"
                                        data-margin="30"
                                        data-responsive='{
                                        "0":{"items":1},
                                        "480":{"items":2},
                                        "480":{"items":2},
                                        "768":{"items":3},
                                        "992":{"items":3}
                                    }'>

                                    @foreach($products as $product)
                                        <div class="product-item  product-item-opt-1 ">
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

                                                    
                                                    {{-- @if (availableStock($product->id) > 0)
                                                        <button type="button" onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                    @else
                                                        <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                    @endif --}}

                                                    @if ($product->discount_price > 0)
                                                        <span class="product-item-label label-price">{{ $product->discount_price }}% <span>off</span></span>
                                                    @endif
                                                </div>
                                                <div class="product-item-detail">
                                                    <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
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
                                    @endforeach

                                    </div>
                                </div>
                                <!-- tab 1 -->

                                <!-- tab 2 -->
                                <div role="tabpanel" class="tab-pane fade" id="tabproduct2">
                                    <div class="owl-carousel"
                                        data-nav="true"
                                        data-dots="false"
                                        data-margin="30"
                                        data-responsive='{
                                        "0":{"items":1},
                                        "480":{"items":2},
                                        "480":{"items":2},
                                        "768":{"items":3},
                                        "992":{"items":3}
                                    }'>

                                    @foreach($rendomproducts as $product)
                                        @if ($product->stock_quantity > 0)
                                            <div class="product-item  product-item-opt-1 ">
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

                                                        
                                                        {{-- @if (availableStock($product->id) > 0)
                                                            <button type="button"  onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                        @else
                                                            <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                        @endif --}}

                                                        <span class="product-item-label label-price">{{ $product->discount_price ?? '' }}% <span>off</span></span>
                                                    </div>
                                                    <div class="product-item-detail">
                                                        <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
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
                                        @endif
                                    @endforeach

                                    </div>
                                </div>
                                <!-- tab 2 -->

                                <!-- tab 3-->
                                <div role="tabpanel" class="tab-pane fade" id="tabproduct3">
                                    <div class="owl-carousel"
                                        data-nav="true"
                                        data-dots="false"
                                        data-margin="30"
                                        data-responsive='{
                                        "0":{"items":1},
                                        "480":{"items":2},
                                        "480":{"items":2},
                                        "768":{"items":3},
                                        "992":{"items":3}
                                    }'>

                                    @foreach($products as $product)
                                        <div class="product-item  product-item-opt-1 ">
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

                                                    
                                                    {{-- @if (availableStock($product->id) > 0)
                                                        <button type="button"  onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                    @else
                                                        <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                    @endif --}}

                                                    <span class="product-item-label label-price">{{ $product->discount_price ?? '' }}% <span>off</span></span>
                                                </div>
                                                <div class="product-item-detail">
                                                    <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
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
                                    @endforeach

                                    </div>
                                </div>
                                <!-- tab 3-->

                            </div>

                        </div>
                        <!-- block tab products -->
                    </div>

                    <div class="col-md-3">
                        <!-- block deals  of -->
                        <div class="block-deals-of block-deals-of-opt1">
                            <div class="block-title ">
                                <span class="icon"></span>
                                <div class="heading-title">latest deals</div>
                            </div>
                            <div class="block-content">

                                <div class="owl-carousel"
                                    data-nav="false"
                                    data-dots="false"
                                    data-margin="30"
                                    data-responsive='{
                                    "0":{"items":1},
                                    "480":{"items":2},
                                    "768":{"items":3},
                                    "992":{"items":1},
                                    "1200":{"items":1}
                                    }'>

                                    @if ($Latest_dealsProducts->isNotEmpty())
                                        @foreach($Latest_dealsProducts as $product)
                                            <div class="product-item  product-item-opt-1 ">
                                                <div class="deals-of-countdown">

                                                    <div class="count-down-time" data-countdown="{{ date('Y-m-d',$product->deals_time) }}"></div>
                                                </div>
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

                                                        
                                                        {{-- @if (availableStock($product->id) > 0)
                                                            <button type="button"  onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                        @else
                                                            <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                        @endif --}}

                                                        <span class="product-item-label label-price">{{ $product->discount_price ?? '' }}% <span>off</span></span>
                                                    </div>
                                                    <div class="product-item-detail">
                                                        <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
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
                                        @endforeach
                                    @else
                                        @foreach($products as $product)
                                            <div class="product-item  product-item-opt-1 ">
                                                <div class="deals-of-countdown">

                                                    <div class="count-down-time" data-countdown=""></div>
                                                </div>
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

                                                        
                                                        {{-- @if (availableStock($product->id) > 0)
                                                            <button type="button"  onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                        @else
                                                            <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                        @endif --}}

                                                        <span class="product-item-label label-price">{{ $product->discount_price ?? '' }}% <span>off</span></span>
                                                    </div>
                                                    <div class="product-item-detail">
                                                        <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
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
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                        <!-- block deals  of -->
                    </div>

                </div>
            </div>

            <div class="clearfix" style="background-color: #eeeeee;margin-bottom: 40px; padding-top:30px;">

                <!-- block -floor -products / floor 1 :Fashion-->

                @foreach ($categories->take(6) as $key => $category)
                    @if ($category->subcategories->isNotEmpty() && $category->products->isNotEmpty())
                        <div class="block-floor-products block-floor-products-opt1
                            floor-products{{ $key > 0 ? $key + 1 : '' }}"
                            id="floor0-{{ $key + 1 }}">
                            <div class="container">
                                <div class="block-title ">
                                    <span class="title"><img alt="img"  src="{{ asset($category->image ?? 'frontend/assets/images/media/index1/floor1.png') }}" class="d-block w-100" width="30px">{{ $category->name }}</span>

                                    <div class="links dropdown">
                                        <button class="dropdown-toggle"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" >
                                            <ul>
                                                <!-- Always display 'Best Seller' as the first tab -->
                                                <li role="presentation" class="active">
                                                    <a href="#floorb-bestseller{{ $category->id }}" role="tab" data-toggle="tab">Best Seller</a>
                                                </li>
                                                <!-- Loop through remaining subcategories -->
                                                @foreach ($category->subcategories->take('6') as $subcategory)
                                                    <li role="presentation">
                                                        <a href="#floor-{{ $subcategory->id }}" role="tab" data-toggle="tab">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <a href="#floor0-{{ $key }}" class="action action-up">
                                            <i class="fa fa-angle-up" aria-hidden="true"></i>
                                        </a>

                                        <!-- Down Button: Link to next section if it exists -->
                                        @if($key < $categories->count() - 1)
                                            <a href="#floor0-{{ $key + 2 }}" class="action action-down">
                                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Banner -->
                                <div class="block-banner-floor">
                                    @php
                                        $bannerType = [
                                            $banner1,
                                            $banner2,
                                            $banner3,
                                            $banner4,
                                        ][$key % 4]; // Cycle back to banner1 after key 3
                                    @endphp
                                    @foreach ($banners->where('banner_type', $bannerType)->take(2) as $key => $banner)
                                        <div class="col-sm-6">
                                            <a target="_blank" href="{{ $banner->url ?? '#' }}" class="box-img">
                                                <img src="{{ asset($banner->image) }}" alt="banner">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Banner -->
                                <div class="block-content">

                                    <div class="col-banner">
                                        <span class="label-featured"><img src="{{ asset('frontend/assets/images/icon/index1/label-featured.png') }}" alt="label-featured"></span>
                                        @php
                                            $singleProduct = $category->products()
                                                ->where('product_type', App\Helpers\Constant::PRODUCT_TYPE['featured'])
                                                ->orderBy('id', 'DESC')
                                                ->first();
                                        @endphp

                                        @if($singleProduct)
                                            <a href="{{ route('product.show', $singleProduct->slug) }}?itemcode={{ $singleProduct->item_code }}&pro={{ $singleProduct->id }}" class="box-img">
                                                <div class="img-contain">
                                                    <img src="{{ asset($singleProduct->thumbnail) }}" alt="featured-image">
                                                </div>
                                            </a>
                                        @else
                                            <a href="" class="box-img">
                                                <img src="{{ asset('frontend/assets/images/media/index1/baner-floor1.jpg') }}" alt="baner-floor">
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-products tab-content">

                                        <div class="tab-pane active fade " id="floorb-bestseller{{ $category->id }}" role="tabpanel">
                                            <div class="owl-carousel" data-nav="true" data-dots="false" data-margin="4" data-responsive='{
                                                "0":{"items":1},
                                                "420":{"items":2},
                                                "600":{"items":3},
                                                "768":{"items":3},
                                                "992":{"items":3},
                                                "1200":{"items":4}
                                            }'>
                                                @foreach ($category->products as $product)
                                                    <div class="product-item product-item-opt-1">
                                                        <div class="product-item-info">
                                                            <div class="product-item-photo">
                                                                <a class="product-item-img" href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">
                                                                    <div class="img-contain">
                                                                        <img alt="{{ $product->name }}" src="{{ asset($product->thumbnail ?? 'frontend/assets/images/media/index1/floor1-1.jpg' ) }}">
                                                                    </div>
                                                                </a>

                                                                <!-- Product actions here -->
                                                                <div class="product-item-actions">
                                                                    <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                                                    <a class="btn btn-compare" href=""><span>compare</span></a>
                                                                    <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                                                </div>

                                                                {{-- @if (availableStock($product->id) > 0)
                                                                    <button type="button"  onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                                @else
                                                                    <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                                @endif --}}
                                                            </div>
                                                            <div class="product-item-detail">
                                                                <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
                                                                <div class="product-item-price">
                                                                    <span class="price">{{ country()->symbol.$product->sell_price }}</span>
                                                                    @if($product->mrp_price)
                                                                        <span class="old-price">{{ country()->symbol.$product->mrp_price }}</span>
                                                                    @endif
                                                                </div>
                                                                <!-- Rating and other product details here -->
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
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Loop for remaining subcategories -->
                                        @foreach ($category->subcategories as $subcategory)
                                            <div class="tab-pane fade" id="floor-{{ $subcategory->id }}" role="tabpanel">
                                                <div class="owl-carousel" data-nav="true" data-dots="false" data-margin="4" data-responsive='{
                                                    "0":{"items":1},
                                                    "420":{"items":2},
                                                    "600":{"items":3},
                                                    "768":{"items":3},
                                                    "992":{"items":3},
                                                    "1200":{"items":4}
                                                }'>
                                                    @forelse ($subcategory->products as $product)
                                                        <div class="product-item product-item-opt-1">
                                                            <div class="product-item-info">
                                                                <div class="product-item-photo">
                                                                    <a class="product-item-img" href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">
                                                                        <div class="img-contain">
                                                                            <img alt="{{ $product->name }}" src="{{ asset($product->thumbnail ?? 'frontend/assets/images/media/index1/floor1-1.jpg' ) }}">
                                                                        </div>
                                                                    </a>
                                                                    <!-- Product actions here -->
                                                                    <div class="product-item-actions">
                                                                        <a class="btn btn-wishlist" href=""><span>wishlist</span></a>
                                                                        <a class="btn btn-compare" href=""><span>compare</span></a>
                                                                        <a class="btn btn-quickview" href=""><span>quickview</span></a>
                                                                    </div>

                                                                    {{-- @if (availableStock($product->id) > 0)
                                                                        <button type="button" onclick="addCart({{ $product->id }}, 1)" class="btn btn-cart add-to-cart"><span>Add to Cart</span></button>
                                                                    @else
                                                                        <button type="button" class="btn btn-cart btn-disabled"><span>Out of Stock</span></button>
                                                                    @endif --}}

                                                                </div>
                                                                <div class="product-item-detail">
                                                                    <strong class="product-item-name"><a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a></strong>
                                                                    <div class="product-item-price">
                                                                        <span class="price">{{ country()->symbol.$product->sell_price }}</span>
                                                                        @if($product->mrp_price)
                                                                            <span class="old-price">{{ country()->symbol.$product->mrp_price }}</span>
                                                                        @endif
                                                                    </div>
                                                                    <!-- Rating and other product details here -->
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
                                                    @empty
                                                        <div class="text-center">
                                                            <p class="text-danger">No products found.</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- Banner -->
                <div class="block-banner-opt1 effect-banner3">
                    <div class="container">
                        <div class="row">
                            @forelse ($banners->where('banner_type', $banner4)->take(2) as $key => $banner)
                                <div class="col-sm-6">
                                    <a href="{{ $banner->url ?? '' }}" class="box-img"><img src="{{ asset($banner->image) }}" alt="banner"></a>
                                </div>
                            @empty
                                <div class="col-sm-6">
                                    <a href="" class="box-img"><img src="{{ asset('frontend/assets/images/media/index1/banner7-1.jpg') }}" alt="banner"></a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="" class="box-img"><img src="{{ asset('frontend/assets/images/media/index1/banner7-2.jpg') }}" alt="banner"></a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Banner -->

            </div>

            <!-- block  showcase-->
            <div class="block-showcase block-showcase-opt1 block-brand-tabs">
                <div class="container">

                    <div class="block-title">
                        <span class="title">brand showcase</span>
                    </div>

                    <div class="block-content" >

                        <ul class="nav-brand owl-carousel"
                            data-nav="true"
                            data-loop="true"
                            data-dots="false"
                            data-margin="1"
                            data-responsive='{
                            "0":{"items":3},
                            "380":{"items":4},
                            "480":{"items":5},
                            "640":{"items":7},
                            "992":{"items":8}
                            }'>
                            @foreach ($brands as $key => $brand)
                                <li  class="{{ ($key == 0) ? 'active' : '' }}" data-tab="brand1-{{ $brand->id }}">
                                    <img src="{{ asset($brand->image ?? 'frontend/assets/images/media/index1/brand-nav1.png') }}" class="img-rounded" style="box-shadow: 5px 5px 1px #BCBCBC;" alt="img">
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">

                            @foreach ($brands as $key => $brand)
                                <div class="tab-pane {{ ($key == 0) ? 'active' : '' }}  " role="tabpanel" id="brand1-{{ $brand->id }}">
                                    <div class="row">
                                        <div class="col-md-4">

                                            <div class="col-title">
                                                <img src="{{ asset($brand->image ?? 'frontend/assets/images/media/index1/logo-showcase.jpg') }}" style="box-shadow: 5px 5px 1px #BCBCBC;" alt="logo" class="logo-showcase img-rounded">
                                                <div class="des">
                                                    Discover a diverse collection of stylish apparel, innovative electronics, premium beauty products, elegant home décor, performance sportswear, educational toys, and gourmet foods & much more.
                                                </div>
                                                <div class="actions">
                                                    <a href="{{ route('shop') }}?brand={{ $brand->id }}&brand_name={{ $brand->name }}" class="btn btn-default">shop this brand <i aria-hidden="true" class="fa fa-caret-right"></i></a>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-8">

                                            <div class="col-product">
                                                <div class="owl-carousel"
                                                    data-nav="true"
                                                    data-dots="false"
                                                    data-margin="0"
                                                    data-responsive='{
                                                    "0":{"items":1},
                                                    "380":{"items":1},
                                                    "480":{"items":1},
                                                    "640":{"items":2},
                                                    "992":{"items":2}
                                                }'>

                                                    @foreach ($brand->products->chunk(2) as $chunk)
                                                        <div class="item">
                                                            @foreach ($chunk as $product)
                                                                <div class="product-item  product-item-opt-1 ">
                                                                    <div class="product-item-info">
                                                                        <div class="product-item-photo" style="box-shadow: 0 0 10px #BCBCBC;">
                                                                            <a class="product-item-img" style="height: 140px;" href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">
                                                                                <img alt="product name" src="{{ asset($product->thumbnail) }}" style="display: block; width: 140px; height: 100%;" >
                                                                            </a>
                                                                        </div>
                                                                        <div class="product-item-detail">
                                                                            <strong class="product-item-name">
                                                                                <a href="{{ route('product.show', $product->slug) }}?itemcode={{ $product->item_code }}&pro={{ $product->id }}">{{ $product->name }}</a>
                                                                            </strong>
                                                                            <div class="clearfix">
                                                                                <div class="product-item-price">
                                                                                    <span class="price">{{ country()->symbol.$product->sell_price }}</span>
                                                                                </div>
                                                                                <div class="product-reviews-summary">
                                                                                    <div class="rating-summary">
                                                                                        <div title="80%" class="rating-result">
                                                                                            <span style="width:80%">
                                                                                                <span><span>100</span>% of <span>100</span></span>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>

                </div>
            </div><!-- block  showcase-->

            <!-- block  hot categories-->
            <div class="block-hot-categories-opt1">
                <div class="container">

                    <div class="block-title ">
                        <span class="title">Hot categories</span>
                    </div>

                    <div class="block-content">
                        <div class="row">
                            @foreach ($categories->take('8') as $category)
                                @if ($category->subcategories->isNotEmpty())
                                    <div class="col-md-3 col-sm-6">
                                        <div class="item">
                                            <div class="description" style="background-image: url({{ asset($category->image) }}); background-size: 30% auto;">
                                                <div class="title"><span>{{ $category->name }}</span></div>
                                                <a href="{{ route('category.show', $category->slug) }}?cat_id={{ $category->id }}" class="btn">shop now</a>
                                            </div>
                                            <ul>
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li>
                                                        <a href="{{ route('subcategory.show', $subcategory->slug) }}?subcat_id={{ $subcategory->id }}">{{ $subcategory->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <!--block  hot categories-->

        </main><!-- end MAIN -->

@endsection
