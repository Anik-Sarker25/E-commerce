@extends('layouts.admin.app')
@push('css')
<style>
    .image-preview-container,
    #image-previewdd{
        position: relative;
        display: inline-block;
        color: red;
    }
    .cancel-icon {
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        font-size: 16px;
    }
    .addVrBtn .btn {
        padding: 0 5px;
    }
</style>

@endpush
@section('title', 'Settings')
@section('content')
    @php
        $units = App\Helpers\Constant::UNIT;
        $activeStatus = App\Helpers\Constant::STATUS;
        $sizes = App\Helpers\Constant::SIZES;
        $colors = App\Helpers\Constant::COLORS;
        $conditions = App\Helpers\Constant::CONDITIONS;
        $product_type = App\Helpers\Constant::PRODUCT_TYPE;
        $returns = App\Helpers\Constant::PRODUCT_RETURNS;
        $warranties = App\Helpers\Constant::PRODUCT_WARRANTY;
    @endphp

    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-12 -->
            <div class="col-xl-12">
                <x-breadcrumbs :items="$breadcrumbs" />

                <div class="d-flex justify-content-between">
                    <h1 class="page-header text-capitalize mb-0">{{ $pageTitle }}</h1>
                    <div class="btn-group">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success">Product list</a>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Users Form -->
                <div class="card">
                    <div class="card-body pb-2">
                        <form id="userForm">
                            <div class="row">
                                <!-- Product Title -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Product Name <span class="text-danger">*</span></label>
                                        <input type="hidden" id="update_id" value="{{ $data->id ?? '' }}">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Product Name..." value="{{ $data->name ?? '' }}">
                                        <span class="text-danger" id="nameError"></span>
                                    </div>
                                </div>

                                <!-- Buy Price -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="buy_price">Buy Price <span class="text-danger">*</span></label>
                                        <input type="number" name="buy_price" class="form-control" id="buy_price" placeholder="Enter Buy Price..." value="{{ $data->buy_price ?? '' }}">
                                        <span class="text-danger" id="buyPriceError"></span>
                                    </div>
                                </div>

                                <!-- MRP Price -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="mrp_price">MRP Price <span class="text-danger">*</span></label>
                                        <input type="number" name="mrp_price" class="form-control" id="mrp_price" placeholder="Enter MRP Price..." value="{{ $data->mrp_price ?? '' }}">
                                        <span class="text-danger" id="mrpPriceError"></span>
                                    </div>
                                </div>

                                <!-- Discount Price -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="discount_price">Discount Price <span class="text-danger">(%) *</span></label>
                                        <input type="number" name="discount_price" class="form-control" id="discount_price" placeholder="Enter Discount Price..." value="{{ $data->discount_price ?? '' }}">
                                        <span class="text-danger" id="discountPriceError"></span>
                                    </div>
                                </div>

                                <!-- Sell Price -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="sell_price">Sell Price <span class="text-danger">*</span></label>
                                        <input type="number" name="sell_price" class="form-control" id="sell_price" placeholder="Enter Sell Price..." value="{{ $data->sell_price ?? '' }}" readonly>
                                        <span class="text-danger" id="sellPriceError"></span>
                                    </div>
                                </div>

                                <!-- Product Category -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="category_id">Product Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control select2" id="category_id">
                                        </select>
                                        <span class="text-danger" id="category_idError"></span>
                                    </div>
                                </div>

                                <!-- Product Sub Category -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="subcategory_id">Product Sub Category <span class="text-muted">(optional)</span></label>
                                        <select name="subcategory_id" class="form-control select2" id="subcategory_id">
                                        </select>
                                        <span class="text-danger" id="subcategory_idError"></span>
                                    </div>
                                </div>

                                <!-- Product Child Category -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="childcategory_id">Product Child Category <span class="text-muted">(optional)</span></label>
                                        <select name="childcategory_id" class="form-control select2" id="childcategory_id">
                                        </select>
                                        <span class="text-danger" id="childcategory_idError"></span>
                                    </div>
                                </div>

                                <!-- Product Brand -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="brand_id">Select Brand<span class="text-muted">(optional)</span></label>
                                        <select name="brand_id" class="form-control select2" id="brand_id">
                                        </select>
                                        <span class="text-danger" id="brand_idError"></span>
                                    </div>
                                </div>

                                <!-- Product Keywords -->
                                <div class="col-xl-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="keywords">Keywords <span class="text-muted">(optional use ',')</span></label>
                                        <input type="text" name="keywords" class="form-control" id="keywords" placeholder="product name, brand name, etc.." value="{{ $data->keywords ?? '' }}">
                                        <span class="text-danger" id="keywordsError"></span>
                                    </div>
                                </div>

                                <!-- Thumbnail Image -->
                                <div class="col-xl-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="thumbnail">Thumbnail Image <span class="text-danger">*</span> ( <small>420 X 510</small> )</label>
                                        <input type="file" name="thumbnail" class="form-control" id="thumbnail" onchange="previewThumbnail()">
                                        <span class="text-danger" id="thumbnailError"></span>

                                        <div id="thumbnailPreview" class="mt-2">
                                            @if(isset($data->thumbnail))
                                                <div class="image-preview-container">
                                                    <img src="{{ asset($data->thumbnail) }}" alt="Thumbnail Preview" style="width: 64px; margin: 10px 16px 0 0;">
                                                    <i class="fas fa-times cancel-icon" onclick="clearThumbnailPreview({{ $data->id }})"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Featured Images (Multiple) -->
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="featured_images">Featured Images <span class="text-muted">(optional, multiple)</span> ( <small>850 X 1036</small> )</label>
                                        <input type="file" name="featured_images[]" class="form-control" id="featured_images" multiple onchange="previewFeaturedImages()">
                                        <span class="text-danger" id="featuredImagesError"></span>

                                        <div class="d-flex">
                                            @if(isset($data->featuredImages))
                                                <div id="featuredImagesPreviewUpdate" class="mt-2">
                                                    @foreach($data->featuredImages as $index => $image)
                                                        <div id="image-previewdd" class="image-preview-{{ $image->id }}">
                                                            <img src="{{ asset($image->image) }}" alt="Featured Image Preview" style="width: 64px; margin: 10px 16px 0 0;">
                                                            <i class="fas fa-times cancel-icon" onclick="removeFeaturedImageDb({{ $image->id }}, true)"></i>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div id="featuredImagesPreview" class="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Variants -->
                                <div class="col-xl-12">
                                    <div id="variant-container">
                                        <div class="d-flex">
                                            <h5 class="me-4">Product Variants Options</h5>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" onchange="toggleVariants();" class="form-check-input" id="customSwitch1"
                                                @if (isset($data->variants) && count($data->variants) > 0)
                                                    checked
                                                @endif
                                                >
                                            </div>
                                            <div class="addVrBtn"></div>
                                        </div>

                                        @php
                                            $variantIndex = 0;
                                        @endphp

                                        @forelse ($data->variants ?? [] as $key => $variant)
                                            <div class="variant d-flex" id="variant-{{ $variantIndex }}">
                                                <strong class="me-3">{{ $variantIndex + 1 }}</strong>
                                                <input type="hidden" class="up_variant-{{ $variantIndex }}" value="{{ $variant->id }}">
                                                <div class="row mb-2">
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Color Name</label>
                                                        <input type="text" class="form-control form-control-sm cname-{{ $variantIndex }}" name="variants[{{ $variantIndex }}][color_name]" value="{{ $variant->color_name }}">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Color</label>
                                                        <input type="text" id="color-picker-{{ $variantIndex }}" class="form-control form-control-sm color-picker color-{{ $variantIndex }}" name="variants[{{ $variantIndex }}][color]" value="{{ $variant->color_code }}">
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" id="color_image-{{ $variantIndex }}" class="form-control form-control-sm variant-image" name="variants[{{ $variantIndex }}][image]" onchange="previewVImage(event, {{ $variantIndex }})">
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <div class="vimage-preview" style="position: relative;">
                                                            <img id="preview-{{ $variantIndex }}" src="{{ asset($variant->color_image) }}" alt="image-preview" style="width: 50px; height: 50px; margin-top: 8px; display: block;">
                                                            <button type="button" id="remove-btn-{{ $variantIndex }}" class="btn btn-danger btn-sm" onclick="removeVImage({{ $variantIndex }})" style="position: absolute; top: 0; right: 0;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <label class="form-label">Buy Price</label>
                                                        <input type="number" class="form-control form-control-sm vbp-{{ $variantIndex }}" name="variants[{{ $variantIndex }}][buy_price]" value="{{ $variant->buy_price }}" oninput="updateVSellPrice({{ $variantIndex }})">
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <div class="d-flex flex-column justify-content-end" style="height: 100%;">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-success btn-sm" onclick="addVariant({{ $variantIndex }})">+</button>

                                                                <button type="button" class="btn btn-light btn-sm" onclick="removeVariant({{ $variantIndex }})">-</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @php $variantIndex++; @endphp
                                        @empty
                                            <!-- Default empty variant form -->
                                            <div class="variant d-none d-flex" id="variant-0">
                                                <strong class="me-3">1</strong>
                                                <div class="row w-100 mb-2">
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Color Name</label>
                                                        <input type="text" class="form-control form-control-sm cname-0" name="variants[0][color_name]">
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Color</label>
                                                        <input type="text" id="color-picker-0" class="form-control form-control-sm color-picker color-0" name="variants[0][color]">
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" id="color_image-0" class="form-control form-control-sm variant-image" name="variants[0][image]" onchange="previewVImage(event, 0)">
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <div class="vimage-preview" style="position: relative;">
                                                            <img id="preview-0" src="" alt="image-preview" style="width: 50px; height: 50px; margin-top: 8px; display: none;">
                                                            <button type="button" id="remove-btn-0" class="btn btn-danger btn-sm" onclick="removeVImage(0)" style="display: none; position: absolute; top: 0; right: 0;">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- Only show the button inside the first (empty) variant -->
                                                    <div class="col-xl-2">
                                                        <div class="d-flex flex-column justify-content-end" style="height: 100%;">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-success btn-sm" onclick="addVariant(0)">+</button>
                                                                <button type="button" class="btn btn-light btn-sm" onclick="removeVariant(0)">-</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>


                                <!-- Product Description -->
                                <div class="col-xl-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="description">Product Details <span class="text-danger">*</span></label>
                                        <div class="card">
                                            <textarea name="description" class="form-control summernote" id="description" placeholder="Enter Description...">{{ $data->description ?? '' }}</textarea>

                                            <x-card-arrow />
                                        </div>
                                        <span class="text-danger" id="descriptionError"></span>
                                    </div>
                                </div>

                                <!-- Product type -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="product_type">Product Type ( <small>Optional</small> )</label>
                                        <select class="form-control select2" name="product_type" id="product_type">
                                            <option value="">Select type</option>
                                            @foreach ($product_type as $type => $key)
                                                <option value="{{$key }}" {{ isset($data->product_type) && ($data->product_type == $key) ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="productTypeError"></span>
                                    </div>
                                </div>

                                <!-- Latest Deals ends -->
                                <div class="col-xl-4 {{ isset($data->deals_time) && ($data->deals_time) ? 'd-block' : 'd-none' }}" id="deals">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="deals_time">Latest Deals Ends<span class="text-danger"></span></label>
                                        <input type="text" name="deals_time" class="form-control datepicker" id="deals_time" value="{{ isset($data->deals_time) ? dateFormat2($data->deals_time) : '' }}">
                                        <span class="text-danger" id="dealsTimeError"></span>
                                    </div>
                                </div>

                                <!-- Product Unit -->
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="unit">Unit ( <small>default PCS</small> )</label>
                                        <select class="form-control select2" name="unit" id="unit">
                                            @foreach ($units as $unit => $key)
                                                <option value="{{$key }}" {{ isset($data->unit) && ($data->unit == $key) ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="unitError"></span>
                                    </div>
                                </div>

                                <!-- Product return -->
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="product_return">Return Policy [Default ( <small>Non-returnable</small> )]</label>
                                        <select class="form-control select2" name="product_return" id="product_return">
                                            @foreach ($returns as $return)
                                                <option value="{{ $return }}" {{ isset($data->return) && ($data->return === $return) ? 'selected' : '' }}>{{ ucfirst($return) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="productReturnError"></span>
                                    </div>
                                </div>

                                <!-- Product Warranty -->
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="warranty">Warranty [Default ( <small>No Warranty</small> )]</label>
                                        <select class="form-control select2" name="warranty" id="warranty">
                                            @foreach ($warranties as $warranty)
                                                <option value="{{ $warranty }}" {{ isset($data->warranty) && ($data->warranty === $warranty) ? 'selected' : '' }}>{{ ucfirst($warranty) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="warrantyError"></span>
                                    </div>
                                </div>

                                <!-- Delivery Type -->
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="delivery_type">Delivery Type </label>
                                        <select class="form-control select2" name="delivery_type" id="delivery_type">

                                        </select>
                                        <span class="text-danger" id="deliveryTypeError"></span>
                                    </div>
                                </div>

                                <!-- Product Status -->
                                <div class="col-xl-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="status">Status ( <small>default active</small> )</label>
                                        <select class="form-control select2" name="status" id="status">
                                            @foreach ($activeStatus as $status => $key)
                                                <option value="{{$key }}" {{ isset($data->status) && ($data->status == $key) ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="statusError"></span>
                                    </div>
                                </div>


                                <div class="col-xl-12">
                                    <div class="text-left">
                                        @if (Request::is('admin/products/create'))
                                            <button type="button" onclick="addProduct();" class="btn btn-outline-success mr-2 mb-2"><i class="fa fa-plus me-2"></i>Add Product</button>
                                        @elseif (Request::is('admin/products/edit*'))
                                            <button type="button" onclick="updateProduct();" class="btn btn-outline-success mr-2 mb-2"><i class="fa fa-share me-2"></i>Update Product</button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <x-card-arrow />
                </div>
                <!-- END Users Form -->

            </div>
            <!-- END col-12-->
        </div>
        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

@push('js')
@include('layouts.admin.all_select2')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('.summernote').summernote({minHeight: 200});

        getBrand();
        getDeliveryType();
        getCategory();

        // Sub categories selection
        $('#category_id').on('change', function() {
            const categoryId = $(this).val();

            if (categoryId) {
                getSubCategory(categoryId);
            } else {
                $('#subcategory_id').empty();
            }
        });
        $('#subcategory_id').on('change', function() {
            const subcategoryId = $(this).val();

            if (subcategoryId) {
                getChildCategory(subcategoryId);
            } else {
                $('#childcategory_id').empty();
            }
        });

        setTimeout(() => {
            $("#category_id").val('{{ $data->category_id ?? '' }}').trigger('change');
        }, 500);

        setTimeout(() => {
            $("#subcategory_id").val('{{ $data->subcategory_id ?? '' }}').trigger('change');
        }, 1000);

        setTimeout(() => {
            $("#childcategory_id").val('{{ $data->childcategory_id ?? '' }}').trigger('change');
        }, 1500);

        setTimeout(() => {
            $("#brand_id").val('{{ $data->brand_id ?? '' }}').trigger('change');
        }, 2000);

        setTimeout(() => {
            $("#delivery_type").val('{{ $data->delivery_type ?? '1' }}').trigger('change');
        }, 2500);

        // Product price Calculations
        $('#buy_price, #mrp_price, #discount_price').on('input', function() {
            calculateSellPrice();
        });

        const PRODUCT_TYPE = @json($product_type);

        $('#product_type').on('change', function () {
            const type_id = $(this).val();

            if (parseInt(type_id) === PRODUCT_TYPE.Latest_deals) {
                $('#deals').removeClass('d-none');
            } else {
                $('#deals').addClass('d-none');
                $('#deals_time').val('');
            }
        });


    });


    // function to calculate product prices
    function calculateSellPrice() {
        const buyPrice = parseFloat($('#buy_price').val()) || 0;
        const mrpPrice = parseFloat($('#mrp_price').val()) || 0;
        const discountPercentage = parseFloat($('#discount_price').val()) || 0;

        let discountAmount = (mrpPrice * (discountPercentage / 100));

        let sellPrice = mrpPrice - discountAmount;

        // Ensure sell price isn’t below buy price
        if (sellPrice < buyPrice) {
            $('#sellPriceError').text("Sell Price cannot be less then buy Price");
            $('#sell_price').val(buyPrice.toFixed(2));

        }else {
            $('#sellPriceError').text("");
            $('#sell_price').val(sellPrice.toFixed(2));
        }

    }

    // function to validate nagetive quantity
    // function validateStockQuantity() {
    //     const stockQuantity = parseInt($('#stock').val()) || 0;

    //     if (stockQuantity < 0) {
    //         $('#stock').val(0); // Reset to 0 if negative
    //         $('#stockError').text("Stock quantity cannot be negative.");
    //     } else {
    //         $('#stockError').text('');
    //     }
    // }

    // function to remove thumbnail images
    function clearThumbnailPreview(id) {
        removeImage(id);
    }
    // function to remove the product freatured image
    function removeFeaturedImageDb(imageId, isExisting = false) {

        let url = "{{ route('admin.products.removeFeaturedImage', ':id') }}";
        url = url.replace(':id', imageId);

        Swal.fire({
            title: `Are you sure you want to remove this banner?`,
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: 'transparent',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'my-custom-popup',
                confirmButton: 'my-custom-confirm',
                cancelButton: 'my-custom-cancel',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'Delete',
                    dataType: 'JSON',
                    success: function(data) {
                        show_success('Image removed successfully.');
                        if (isExisting) {
                            const imageContainer = $(`.image-preview-${imageId}`);
                            if (imageContainer) {
                                imageContainer.remove();
                            }
                        }
                    },
                    error: function(error) {
                        let message = error.responseJSON.message || 'An error occurred';
                        show_error(message);
                    }
                });
            }
        });

    }

    // function to preview product thumbnail
    function previewThumbnail() {
        const $thumbnailInput = $('#thumbnail');
        const $previewContainer = $('#thumbnailPreview');
        $previewContainer.empty(); // Clear previous content

        if ($thumbnailInput[0].files && $thumbnailInput[0].files[0]) {
            const file = $thumbnailInput[0].files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const $imageContainer = $('<div>').addClass('image-preview-container');

                const $img = $('<img>')
                    .attr('src', e.target.result)
                    .attr('alt', 'Thumbnail Preview')
                    .css({ width: '64px', margin: '10px 16px 0 0' });

                const $cancelIcon = $('<i>')
                    .addClass('fas fa-times cancel-icon') // Font Awesome close icon
                    .on('click', function() {
                        $thumbnailInput.val(''); // Clear the file input
                        $previewContainer.empty(); // Clear the preview container
                    });

                $imageContainer.append($img).append($cancelIcon);
                $previewContainer.append($imageContainer);
            };

            reader.readAsDataURL(file);
        }
    }

    // function to preview featured images
    function previewFeaturedImages() {
        const $featuredInput = $('#featured_images');
        const $previewContainer = $('#featuredImagesPreview');
        $previewContainer.empty(); // Clear previous content to avoid duplicates

        $.each($featuredInput[0].files, function(index, file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const $imageContainer = $('<div>')
                    .addClass('image-preview-container')
                    .data('index', index); // Save index for removal

                const $img = $('<img>')
                    .attr('src', e.target.result)
                    .attr('alt', 'Featured Image Preview')
                    .css({ width: '64px', margin: '10px 16px 0 0' });

                const $cancelIcon = $('<i>')
                    .addClass('fas fa-times cancel-icon') // Font Awesome close icon
                    .on('click', function() {
                        removeFeaturedImage(index);
                    });

                $imageContainer.append($img).append($cancelIcon);
                $previewContainer.append($imageContainer);
            };

            reader.readAsDataURL(file);
        });
    }

    // function to remove featured images
    function removeFeaturedImage(index) {
        const $featuredInput = $('#featured_images');
        const $previewContainer = $('#featuredImagesPreview');

        // Convert FileList to an array to remove the specific file by index
        const filesArray = Array.from($featuredInput[0].files);
        filesArray.splice(index, 1);

        // Clear and re-assign the FileList by re-creating a DataTransfer object
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        $featuredInput[0].files = dataTransfer.files;

        // Refresh the preview
        previewFeaturedImages();
    }

    // function for toggle variants content
    function toggleVariants() {
        let variantContainers = $(".variant");
        let switchInput = $("#customSwitch1");

        if (switchInput.is(":checked")) {
            variantContainers.removeClass('d-none');
            variantContainers.addClass('d-block');
            setAddVariantBtn();
        } else {
            variantContainers.removeClass('d-block');
            variantContainers.addClass('d-none');
            $('.addVrBtn').html('');
        }
    }

    // function to add variants
    let variantIndex = 1;
    let columnindex = 1;

    function addVariant(clickedIndex) {
        let container = document.getElementById('variant-container');

        let vcname = $(`.cname-${clickedIndex}`).val();
        let vcolor = $(`.color-${clickedIndex}`).val();

        let newVariant = document.createElement('div');
        newVariant.classList.add('variant', 'd-flex');
        newVariant.setAttribute('id', `variant-${variantIndex}`);

        columnindex++;
        newVariant.innerHTML = `

            <strong class="me-3 variant-number">${columnindex}</strong>
            <div class="row w-100 mb-2">
                <div class="col-xl-3">
                    <label class="form-label">Color Name</label>
                    <input type="text" class="form-control form-control-sm cname-${variantIndex}" name="variants[${variantIndex}][color_name]" value="${vcname}">
                </div>
                <div class="col-xl-3">
                    <label class="form-label">Color</label>
                    <input type="text" id="color-picker-${variantIndex}" class="form-control form-control-sm color-${variantIndex} color-picker" name="variants[${variantIndex}][color]" value="${vcolor}">
                </div>
                <div class="col-xl-2">
                    <label class="form-label">Image</label>
                    <input type="file" id="color_image-${variantIndex}" class="form-control form-control-sm variant-image" name="variants[${variantIndex}][image]" onchange="previewVImage(event, ${variantIndex})">
                </div>
                <div class="col-xl-2">
                    <div class="vimage-preview" style="position: relative;">
                        <img id="preview-${variantIndex}" src="" alt="image-preview" style="width: 50px; height: 50px; margin-top: 8px; display: none;">
                        <button type="button" id="remove-btn-${variantIndex}" class="btn btn-danger btn-sm" onclick="removeVImage(${variantIndex})" style="display: none; position: absolute; top: 0; right: 0;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="d-flex flex-column justify-content-end" style="height: 100%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-theme btn-sm" onclick="addVariant(${variantIndex})">+</button>
                            <button type="button" class="btn btn-light btn-sm" onclick="removeVariant(${variantIndex})">-</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('.addVrBtn').html('');

        container.appendChild(newVariant);
        variantIndex++;
    }
    // function to remove variants items
    function removeVariant(index) {
        let variantToRemove = document.getElementById(`variant-${index}`);
        if (variantToRemove) {
            variantToRemove.remove();

            setAddVariantBtn();
        }
    }
    // function to set add variants btn
    function setAddVariantBtn() {
        let remainingVariants = $('.variant').length;

        let buttonContainer = $('.addVrBtn');
        if (remainingVariants === 0) {
            let btnHtml = `<button type="button" class="btn btn-theme btn-sm" onclick="addVariant(variantIndex)">+ add variant</button>`;
            buttonContainer.html(btnHtml);
        }else {
            buttonContainer.html('');
        }
    }

    // function to preview variants images
    function previewVImage(event, index) {
        let input = event.target;
        let file = input.files[0];
        let preview = document.getElementById(`preview-${index}`);
        let removeBtn = document.getElementById(`remove-btn-${index}`);

        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
                removeBtn.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

    // function to remove variants images
    function removeVImage(index) {
        let preview = document.getElementById(`preview-${index}`);
        let removeBtn = document.getElementById(`remove-btn-${index}`);
        let fileInput = document.getElementById(`color_image-${index}`);

        preview.src = "";
        preview.style.display = "none";
        removeBtn.style.display = "none";
        fileInput.value = ""; // Reset file input
    }

    // function to reset variants
    function resetVariants() {
        $('.variant').each(function () {
            let variantId = $(this).attr('id').split('-')[1]; // Extract Variant Index
            // Clear input fields
            $(`.cname-${variantId}`).val('');
            $(`.color-${variantId}`).val('');
            $(`#color_image-${variantId}`).val('');
            $(`#preview-${variantId}`).attr('src', '');
            $(`#preview-${variantId}`).addClass('d-none');
            $(`#remove-btn-${variantId}`).hide();

            if (variantId !== "0") {
                $(this).remove();
            }
        });
    }

    // variants ends here

    // function to add new products information
    function addProduct() {

        let url = "{{ route('admin.products.store') }}";

        let name = $('#name').val();
        let buy_price = $('#buy_price').val();
        let mrp_price = $('#mrp_price').val();
        let discount_price = $('#discount_price').val();
        let sell_price = $('#sell_price').val();
        let category_id = $('#category_id').val();
        let subcategory_id = $('#subcategory_id').val() || null;
        let childcategory_id = $('#childcategory_id').val() || null;
        let brand_id = $('#brand_id').val();
        let keywords = $('#keywords').val();
        let thumbnail = $('#thumbnail')[0].files[0];
        let featured_images = $('#featured_images')[0].files;
        let description = $('#description').summernote('code');
        let product_type = $('#product_type').val();
        let deals_time = $('#deals_time').val();
        let unit = $('#unit').val();
        let product_return = $('#product_return').val();
        let warranty = $('#warranty').val();
        let delivery_type = $('#delivery_type').val();
        let status = $('#status').val();

        let formData = new FormData();
        // Append Product Data
        formData.append('name', name);
        formData.append('buy_price', buy_price);
        formData.append('mrp_price', mrp_price);
        formData.append('discount_price', discount_price);
        formData.append('sell_price', sell_price);
        formData.append('category_id', category_id);
        formData.append('subcategory_id', subcategory_id);
        formData.append('childcategory_id', childcategory_id);
        formData.append('brand_id', brand_id);
        formData.append('keywords', keywords);
        formData.append('description', description);
        formData.append('product_type', product_type);
        formData.append('deals_time', deals_time);
        formData.append('unit', unit);
        formData.append('product_return', product_return);
        formData.append('warranty', warranty);
        formData.append('delivery_type', delivery_type);
        formData.append('status', status);

        // Append Images
        if (thumbnail) {
            formData.append('thumbnail', thumbnail);
        }

        for (let i = 0; i < featured_images.length; i++) {
            formData.append('featured_images[]', featured_images[i]);
        }

        // Collect and Append Variants
        $('.variant').each(function (index) {
            let variantId = $(this).attr('id').split('-')[1]; // Extract Variant Index

            let color_name = $(`.cname-${variantId}`).val();
            let color = $(`.color-${variantId}`).val();
            let image = $(`#color_image-${variantId}`)[0].files[0];

            formData.append(`variants[${index}][color_name]`, color_name);
            formData.append(`variants[${index}][color]`, color);

            if (image) {
                formData.append(`variants[${index}][image]`, image);
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.success === false) {
                    show_error('Failed to add product');
                }else {
                    show_success('Product Added Successfully');
                    resetForm();
                    resetVariants();

                }
            },
            error: function(error) {
                // clearErrors();
                let errors = error.responseJSON.errors;

                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }

            }
        });
    }
    // function to add new products information
    function updateProduct() {
        let id = $('#update_id').val();
        let url = "{{ route('admin.products.update', ':id') }}";
        url = url.replace(':id', id);

        let name = $('#name').val();
        let buy_price = $('#buy_price').val();
        let mrp_price = $('#mrp_price').val();
        let discount_price = $('#discount_price').val();
        let sell_price = $('#sell_price').val();
        let category_id = $('#category_id').val();
        let subcategory_id = $('#subcategory_id').val() || null;
        let childcategory_id = $('#childcategory_id').val() || null;
        let brand_id = $('#brand_id').val();
        let keywords = $('#keywords').val();
        let thumbnail = $('#thumbnail')[0].files[0];
        let featured_images = $('#featured_images')[0].files;
        let description = $('#description').summernote('code');
        let product_type = $('#product_type').val();
        let deals_time = $('#deals_time').val();
        let unit = $('#unit').val();
        let product_return = $('#product_return').val();
        let warranty = $('#warranty').val();
        let delivery_type = $('#delivery_type').val();
        let status = $('#status').val();

        let formData = new FormData();
        // Append Product Data
        formData.append('name', name);
        formData.append('buy_price', buy_price);
        formData.append('mrp_price', mrp_price);
        formData.append('discount_price', discount_price);
        formData.append('sell_price', sell_price);
        formData.append('category_id', category_id);
        formData.append('subcategory_id', subcategory_id);
        formData.append('childcategory_id', childcategory_id);
        formData.append('brand_id', brand_id);
        formData.append('keywords', keywords);
        formData.append('description', description);
        formData.append('product_type', product_type);
        formData.append('deals_time', deals_time);
        formData.append('unit', unit);
        formData.append('product_return', product_return);
        formData.append('warranty', warranty);
        formData.append('delivery_type', delivery_type);
        formData.append('status', status);

        // Append Images
        if (thumbnail) {
            formData.append('thumbnail', thumbnail);
        }

        for (let i = 0; i < featured_images.length; i++) {
            formData.append('featured_images[]', featured_images[i]);
        }

        let variantSwitch = $("#customSwitch1");
        let remainingVariants = $('.variant').length;

        if (!variantSwitch.is(":checked") || remainingVariants < 1) {
            formData.append("variants_delete", "1");
        }

        // Collect and Append Variants
        $('.variant').each(function (index) {
            let variantId = $(this).attr('id').split('-')[1]; // Extract Variant Index

            let variant_updateId = $(`.up_variant-${variantId}`).val();
            let color_name = $(`.cname-${variantId}`).val();
            let color = $(`.color-${variantId}`).val();
            let image = $(`#color_image-${variantId}`)[0].files[0];

            formData.append(`variants[${index}][variant_id]`, variant_updateId);

            formData.append(`variants[${index}][color_name]`, color_name);
            formData.append(`variants[${index}][color]`, color);

            if (image) {
                formData.append(`variants[${index}][image]`, image);
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.success === false) {
                    show_error('Failed to Update Product');
                }else {
                    show_success('Product Updated Successfully');
                    resetForm();
                    resetVariants();
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.products.index') }}";
                    }, 2000);
                }
            },
            error: function(error) {
                // clearErrors();
                let errors = error.responseJSON.errors;

                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }

            }
        });
    }

    // function to remove images
    function removeImage(id) {
        let url = "{{ route('admin.products.removeImage', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: `Are you sure you want to remove this banner?`,
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: 'transparent',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'my-custom-popup',
                confirmButton: 'my-custom-confirm',
                cancelButton: 'my-custom-cancel',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'Delete',
                    dataType: 'JSON',
                    success: function(data) {
                        show_success('Image removed successfully.');
                        $('#thumbnailPreview').empty();
                    },
                    error: function(error) {
                        let message = error.responseJSON.message || 'An error occurred';
                        show_error(message);
                    }
                });
            }
        });
    }

    // function to reset error messages
    function resetForm() {
        $('#update_id').val('');

        $('#nameError').html('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#buyPriceError').html('');
        $('#buy_price').val('');
        $('#buy_price').removeClass('is-invalid');

        $('#mrpPriceError').html('');
        $('#mrp_price').val('');
        $('#mrp_price').removeClass('is-invalid');

        $('#discountPriceError').html('');
        $('#discount_price').val('');
        $('#discount_price').removeClass('is-invalid');

        $('#sellPriceError').html('');
        $('#sell_price').val('');
        $('#sell_price').removeClass('is-invalid');

        $('#category_idError').html('');
        $('#category_id').val('').trigger('change');
        $('#category_id').removeClass('is-invalid');

        $('#subcategory_idError').html('');
        $('#subcategory_id').val('').trigger('change');
        $('#subcategory_id').removeClass('is-invalid');

        $('#childcategory_idError').html('');
        $('#childcategory_id').val('').trigger('change');
        $('#childcategory_id').removeClass('is-invalid');

        $('#brand_idError').html('');
        $('#brand_id').val('').trigger('change');
        $('#brand_id').removeClass('is-invalid');

        $('#keywordsError').html('');
        $('#keywords').val('');
        $('#keywords').removeClass('is-invalid');

        $('#thumbnailError').html('');
        $('#thumbnail').val('');
        $('#thumbnail').removeClass('is-invalid');
        $('#thumbnailPreview').empty();

        $('#featuredImagesError').html('');
        $('#featured_images').val('');
        $('#featured_images').removeClass('is-invalid');
        $('#featuredImagesPreview').empty();
        $('#featuredImagesPreviewUpdate').empty();

        $('#descriptionError').html('');
        $('#description').summernote('code', '');
        $('#description').removeClass('is-invalid');

        $('#productTypeError').html('');
        $('#product_type').val('').trigger('change');
        $('#product_type').removeClass('is-invalid');

        $('#dealsTimeError').html('');
        $('#deals_time').val('');
        $('#deals_time').removeClass('is-invalid');

        $('#product_return').val($('#product_return option:first').val()).trigger('change');
        $('#warranty').val($('#warranty option:first').val()).trigger('change');

        $('#unitError').html('');
        $('#deliveryTypeError').html('');
        $('#statusError').html('');

    }



</script>
@endpush
