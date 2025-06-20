@extends('layouts.customer.app')
@push('css')
@include('layouts.customer.sidebar_css')
    <style>
        .itemTable tbody td {
            border-top: none !important;
        }
        .border_bottom {
            border-bottom: 1px solid #ddd !important;
        }
        .product-image {
            border-radius: 5px;
            margin-right: 10px;
        }
        .section-title {
            margin-block: 5px;
        }
        .timeline_items span {
            font-size: 13px;
            display: block;
            margin-bottom: 3px;
        }
        .unpaid {
            color: #f36;
            text-transform: capitalize;
        }
        .paidR {
            margin-top: 10px;
            font-size: 13px;
        }
        hr {
            margin-bottom: 10px;
        }
        /* .summary-box {
            border-left: 3px solid #eee;
            padding-left: 10px;
        } */
        .track-package-box {
            background: #F4F4F4;
            padding: 12px;
            border-radius: 5px;
            widows: 100%;
        }
        .track-btn-wrapper {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(50%);
        }

        /* for star rating */
        .star-filled {
            color: #f1c40f; /* Gold */
            transition: color 0.2s;
        }

        .star-empty {
            color: #ccc; /* Light gray */
            transition: color 0.2s;
        }

        .fa-star {
            cursor: pointer;
            font-size: 2.5rem;
        }
    </style>

@endpush

@section('content')
    @php
        use App\Helpers\Constant;
    @endphp
    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <div class="row" style="padding-top: 20px;">
                <!-- Main Content -->
                <div class="col-md-9 col-md-push-3  col-main">
                    <!-- Orders -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">{{ $pageTitle ?? '' }}</h5>
                                </div>
                                <div class="panel-heading">
                                    <h6 class="panel-title"><span class="text-muted">Placed on {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y h:i:s A') }}</span> <h6>
                                </div>
                                <div class="panel-body">

                                    <input type="hidden" name="pro_id" id="pro_id" value="{{ $product_id }}">
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $item->invoice_id }}">
                                    <div class="row">
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset($item->products->thumbnail) }}" alt="image" class="product-image" width="84px">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="context">
                                                <p><a href="{{ route('product.show', $item->products->slug) }}?itemcode={{ $item->products->item_code }}&pro={{ $item->products->id }}">{{ $item->products->name }}</a></p>
                                                @if(!empty($item->color->color_name))
                                                    <span class="text-muted">
                                                        Color-Family: {{ $item->color->color_name }},
                                                    </span>
                                                @endif
                                                @php
                                                    $variant = $item->size ?? null;
                                                    $label = null;

                                                    if ($variant && $variant->variant_type && $variant->variant_value) {
                                                        switch ($variant->variant_type) {
                                                            case Constant::VARIANT_TYPES['size']:
                                                                $label = 'Size';
                                                                break;
                                                            case Constant::VARIANT_TYPES['storage_capacity']:
                                                                $label = 'Storage Capacity';
                                                                break;
                                                            case Constant::VARIANT_TYPES['instalment']:
                                                                $label = 'Instalment';
                                                                break;
                                                            case Constant::VARIANT_TYPES['case_size']:
                                                                $label = 'Case Size';
                                                                break;
                                                        }
                                                    }
                                                @endphp

                                                @if ($label && !empty($variant->variant_value))
                                                    <span class="text-muted">{{ $label }}: {{ $variant->variant_value }}</span>
                                                @endif

                                                <!-- Star Rating -->
                                                <div style="margin: 10px 0;">
                                                    <div id="star-rating" class="flex items-center space-x-2">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star star-filled" onclick="setRating('quality', {{ $i }})" id="quality-star-{{ $i }}"></i>
                                                        @endfor
                                                        <span id="quality-rating-label" class="ml-4 text-sm font-semibold text-gray-700">Select Rating</span>
                                                    </div>
                                                    <input type="hidden" name="quality_rating" id="quality_rating" value="5">
                                                    <span class="text-danger" id="quality_ratingError"></span>
                                                </div>

                                            </div>
                                            <div class="mb-4">
                                                <label for="quality_review" class="form-label">Your Response <span class="text-danger">*</span></label>
                                                <textarea name="quality_review" id="quality_review" rows="4" class="form-control" placeholder="Write your review..."></textarea>
                                                <span class="text-danger" id="quality_reviewError" ></span>
                                            </div>
                                            <div class="mb-4">
                                                <label for="image" class="form-label">Upload Image<span class="text-danger"></span></label>
                                                <input type="file" class="form-control" name="image" id="image">
                                                <span class="text-danger" id="imageError" ></span>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <p>Delivery Review</p>

                                            <!-- Star Rating -->
                                            <div style="margin: 10px 0;">
                                                <div id="star-rating" class="flex items-center space-x-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star star-filled" onclick="setRating('delivery', {{ $i }})" id="delivery-star-{{ $i }}"></i>
                                                    @endfor
                                                    <span id="delivery-rating-label" class="ml-4 text-sm font-semibold text-gray-700">Select Rating</span>
                                                </div>
                                                <input type="hidden" name="delivery_rating" id="delivery_rating" value="5">
                                                <span class="text-danger" id="delivery_ratingError"></span>
                                            </div>

                                            <div class="mb-4">
                                                <label for="delivery_review" class="form-label">Your Response <span class="text-danger"></span></label>
                                                <textarea name="delivery_review" id="delivery_review" rows="4" class="form-control" placeholder="Write your review..."></textarea>
                                                <span class="text-danger" id="delivery_reviewError" ></span>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-default" onclick="storeReview();">
                                                    Submit Review
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    
                                
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!-- Main Content -->

                <!-- Sidebar -->
                <div class="col-md-3 col-md-pull-9  col-sidebar">

                   @include('layouts.customer.sidebar')


                </div>
                <!-- Sidebar -->



            </div>
        </div>


    </main>
    <!-- end MAIN -->

@endsection

@push('js')
<script>

    const ratingLabels = ["Very Bad", "Poor", "Average", "Good", "Excellent"];

    function setRating(type, value) {
        // Set value to the correct hidden input
        document.getElementById(`${type}_rating`).value = value;

        // Update stars
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`${type}-star-${i}`);
            if (i <= value) {
                star.classList.remove('star-empty');
                star.classList.add('star-filled');
            } else {
                star.classList.remove('star-filled');
                star.classList.add('star-empty');
            }
        }

        // Update label
        document.getElementById(`${type}-rating-label`).innerText = ratingLabels[value - 1];
    }


    function storeReview() {
        let url = "{{ route('customer.order.review.store') }}";

        let invoice_id = $('#invoice_id').val();
        let user_id = $('#user_id').val();
        let product_id = $('#pro_id').val();
        let quality_rating = $('#quality_rating').val();
        let delivery_rating = $('#delivery_rating').val();
        let quality_review = $('#quality_review').val();
        let delivery_review = $('#delivery_review').val();
        let image = $('#image')[0].files[0];

        // Prepare form data
        let formData = new FormData();
        formData.append('invoice_id', invoice_id);
        formData.append('user_id', user_id);
        formData.append('product_id', product_id);
        formData.append('quality_rating', quality_rating);
        formData.append('delivery_rating', delivery_rating);
        formData.append('quality_review', quality_review);
        formData.append('delivery_review', delivery_review);
        formData.append('image', image);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                if(response == 'already_exist') {
                    show_warning('You have already reviewed this product.')
                }else {
                    resetReview();
                    show_success('Thanks for your feedback!');
                    // redirect to review page 
                    setTimeout(function() {
                        window.location.href = "{{ route('customer.order.my.review') }}";
                    }, 3000);
                }

            },
            error: function(error) {
                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

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

    function resetReview() {
        $('#quality_ratingError').text('');
        $('#delivery_ratingError').text('');

        $('#imageError').text('');
        $('#image').val('');


        $('#quality_reviewError').text('');
        $('#quality_review').val('');
        $('#quality_review').removeClass('is-invalid');
        
        $('#delivery_review').val('');

    }

</script>
@endpush
