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
                                    <h5 class="panel-title text-capitalize">{{ $pageTitle ?? '' }}</h5>
                                </div>
                                <div class="panel-body">

                                    {{-- <input type="hidden" name="pro_id" id="pro_id" value="{{ $product_id }}">
                                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                    <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $item->invoice_id }}"> --}}
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="order_id">Select Order</label>
                                            <select name="order_id" id="order_id" class="form-control" required>
                                                <option value="">-- Select Order --</option>
                                                @foreach ($invoices as $invoice)
                                                    <option value="{{ $invoice->id }}">{{ customerFormatedInvoiceId($invoice->id) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="product_id">Select Product</label>
                                            <select name="product_id" id="product_id" class="form-control" required>
                                                <option value="">-- Select Product --</option>
                                                {{-- This will be populated by JS/AJAX based on order selection --}}
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="reason">Reason for Return</label>
                                            <select name="reason" id="reason" class="form-control" required>
                                                <option value="Damaged">Damaged</option>
                                                <option value="Wrong item received">Wrong item received</option>
                                                <option value="Product not as described">Product not as described</option>
                                                <option value="Size/Fit issue">Size/Fit issue</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="details">Additional Details (optional)</label>
                                            <textarea name="details" id="details" class="form-control" rows="3" placeholder="Describe the issue..."></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Upload Image (optional)</label>
                                            <input type="file" name="image" class="form-control-file" accept="image/*">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit Return Request</button>
                                    </form>
                                    
                                
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
                        window.location.href = "{{ route('customer.order.my.reviews') }}";
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
