                <!-- Sidebar -->
                <div class="col-md-3 col-md-pull-9  col-sidebar">

                    <!-- block filter products -->
                    <div id="layered-filter-block" class="block-sidebar block-filter no-hide">

                        <div class="block-content">

                            <!-- Filter Item  categori-->
                            <div class="filter-options-item filter-options-categori">
                                <div class="filter-options-title">Categories</div>
                                <div class="filter-options-content">
                                    <ol class="items">
                                        @foreach ($categories as $key => $category)
                                            @if ($category->products()->exists())
                                                <li class="item">
                                                    <label>
                                                        <input class="category_check" type="checkbox" id="{{ $category->id }}">
                                                        <span>
                                                            {{ $category->name }}
                                                            @if ($category->products()->count() > 0)
                                                                <span class="count">({{ $category->products()->count() }})</span>
                                                            @endif
                                                        </span>
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </div>
                            </div><!-- Filter Item  categori-->

                            <!-- filter price -->
                            <div class="filter-options-item filter-options-price">
                                <div class="filter-options-title">Price</div>
                                <div class="filter-options-content">
                                    <div class="slider-range">
                                        <div class="input-group input-group-sm">
                                            <label class="input-group-addon">{{ country()->symbol }}</label>
                                            <input type="text" id="min_price" value="0" class="form-control" name="min_price" placeholder="Min" value="">
                                            <span class="input-group-addon">{{ country()->symbol }}</span>
                                            <input type="text" id="max_price" class="form-control" name="max_price" placeholder="Max" value="">
                                        </div>

                                    </div>
                                </div>
                            </div><!-- filter price -->

                            <!-- filter brad-->
                            <div class="filter-options-item filter-options-brand">
                                <div class="filter-options-title">BRAND</div>
                                <div class="filter-options-content">
                                    <ol class="items">

                                        @foreach ($brands as $brand)
                                        @if ($brand->products()->exists())
                                            <li class="item ">
                                                <label>
                                                    <input class="brand_check" id="{{ $brand->id }}" type="checkbox">
                                                    <span>
                                                        {{ $brand->name }}
                                                        @if ($brand->products()->count() > 0)
                                                            <span class="count">({{ $brand->products()->count() }})</span>
                                                        @endif
                                                    </span>
                                                </label>
                                            </li>
                                        @endif
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <!-- Filter Item -->

                            <!-- filter brad-->
                            <div class="filter-options-item filter-options-brand">
                                <div class="filter-options-title">Colors</div>
                                <div class="filter-options-content">
                                    <ol class="items">
                                        @foreach (colors() as $color)
                                            <li class="item ">
                                                <label>
                                                    <input class="color_check" id="{{ $color }}" type="checkbox">
                                                    <span>
                                                        {{ $color }}
                                                    </span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <!-- Filter Item -->

                            <!-- filter brad-->
                            <div class="filter-options-item filter-options-brand">
                                <div class="filter-options-title">Warranty</div>
                                <div class="filter-options-content">
                                    <ol class="items">
                                        @php
                                            $warranties = App\Helpers\Constant::PRODUCT_WARRANTY;
                                        @endphp
                                        @foreach ($warranties as $warranty)
                                            <li class="item ">
                                                <label>
                                                    <input class="warranty_check" id="{{ $warranty }}" type="checkbox">
                                                    <span>
                                                        {{ $warranty }}
                                                    </span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <!-- Filter Item -->


                        </div>
                    </div>
                    <!-- Filter -->


                </div><!-- Sidebar -->
