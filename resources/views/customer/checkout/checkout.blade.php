@extends('layouts.customer.app')
@push('css')

<style>
    .mb-20 {
        margin-bottom: 20px;
    }
    .mt-10 {
        margin-top: 10px;
    }
    .mt-20 {
        margin-top: 20px;
    }
    .pt-10 {
        padding-top: 10px;
    }
    .border-top {
        border-top: 1px solid #ddd;
    }
    .checkout {
        position: relative;
        overflow: hidden;
    }
    .checkout .btn {
        background: #f36;
        color: #fff;
        border-radius: 3px;
    }
    .checkout .btn:hover {
        background: #e50039;
        color: #fff;
    }
    .btn-success {
        background: #5cb85c !important;
        color: #fff;
        text-transform: capitalize;
    }
    .btn-success:hover {
        background-color: #4cae4c !important;
        color: #fff;
    }
    .btn-padding {
        padding: 0 10px !important;
    }
    .quantity {
        width: 35px;
        padding: 0 10px;
        height: 28px;
    }
    .increment,
    .decrement {
        font-size: 15px;
        cursor: pointer;
        padding: 0 10px;
    }
    .product-items {
        font-size: 12px;
        margin-block: 10px;
    }

    .delivery_point label {
        font-size: 12px;
        border: 1px solid #ddd;
        padding: 12px;
        border-radius: 4px;
        overflow: hidden;
        color: #666666;
        font-weight: normal;
        font-weight: bold;
    }
    .delivery_point input {
        display: none;
    }
    .delivery_point label svg {
        font-size: 16px;
        margin-right: 5px;
        color: #666;
    }

    .delivery_point label.active,
    .delivery_point label.active svg {
        border-color: #4cae4c;
    }
    .cancelPaymentBtn {
         display: none;
    }


</style>

@endpush
@section('content')

		<!-- MAIN -->
		<main class="site-main">

            <div class="columns container">
                <!-- Block  Breadcrumb-->

                <!-- Block  Breadcrumb-->
                <x-breadcrumbs :items="$breadcrumbs" />
                <!-- Block  Breadcrumb-->

                <div class="checkout">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12 collapse" id="itemsView">
                                    <!-- shipping and billing address -->

                                    <div id="shippingBilling" class="collapse">
                                        <div class="panel panel-default">
                                            <div class="panel-heading  bg-light d-flex justify-content-between">
                                                <h4 class="panel-title">Shipping & Billing</h4>
                                                <button type="button" id="editShippingBilling" class="btn btn-sm btn-success btn-padding">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </button>
                                            </div>
                                            @php
                                                $user = auth()->user();
                                            @endphp
                                            <div class="panel-body shipping-item">
                                                <p class="delivery-text address">
                                                    <input type="hidden" id="customer_name" value="{{ $user->name ?? '' }}">
                                                    <input type="hidden" id="customer_email" value="{{ $user->email ?? '' }}">
                                                    @if ($address)
                                                        <input type="hidden" id="shipping_address_id" value="{{ $address->id }}">
                                                        <input type="hidden" id="customer_phone" value="{{ $address->phone }}">
                                                        @if ($address && $address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['home'])
                                                            <span class="label label-success">Home</span>
                                                        @elseif ($address && $address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['office'])
                                                            <span class="label label-primary">Office</span>
                                                        @endif

                                                        {{ $address->address ? $address->address . ', ' : '' }}
                                                        {{ optional($address->upazilas)->name ? optional($address->upazilas)->name . ', ' : '' }}
                                                        {{ optional($address->district)->name ? optional($address->district)->name . ', ' : '' }}
                                                        {{ optional($address->division)->name ?? 'Set Your Address' }}
                                                    @else
                                                        <div class="text-center">Set Your Address</div>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>



                                    <div id="shippingBillingCollapse" class="collapse">
                                        <div class="panel panel-default">
                                            <div class="panel-heading  bg-light d-flex justify-content-between">
                                                <h4 class="panel-title">Edit Shipping & Billing</h4>
                                                <div class="buttons">
                                                    <button type="button" id="cancelBtn" class="btn btn-danger btn-sm btn-padding">
                                                        <i class="fa fa-times me-1"></i> Cancel
                                                    </button>
                                                    <button type="button" id="save"  onclick="changeStatus();" class="btn btn-success btn-sm btn-padding">
                                                        <i class="fa fa-save me-1"></i> Save
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="panel-body shipping-item">
                                                <div class="delivery_point">
                                                    <div class="row">
                                                        @forelse ($addresses as $address)
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-0">
                                                                    <input type="radio" name="address" value="{{ $address->id }}" id="standard_delivery_{{ $address->id }}" >

                                                                    <label for="standard_delivery_{{ $address->id }}" class="standard_delivery  {{ ($address->status === App\Helpers\Constant::DELIVERY_PLACE['home'] || $address->status !== null) ? 'active' : '' }}">
                                                                        <p class="delivery-text address mb-0">
                                                                            @if ($address && $address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['home'])
                                                                                <span class="label label-success">Home</span>
                                                                            @elseif ($address && $address->delivery_place == App\Helpers\Constant::DELIVERY_PLACE['office'])
                                                                                <span class="label label-primary">Office</span>
                                                                            @endif

                                                                            {{ $address->address }},
                                                                            {{ $address->upazilas->name }},
                                                                            {{ $address->district->name }},
                                                                            {{ $address->division->name }},
                                                                        </p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <p class="text-danger text-center">No Address Found</p>
                                                        @endforelse
                                                    </div>
                                                    <span class="text-danger" id="deliveryError"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- cart items  --}}
                                    <div class="panel panel-default">
                                        <div class="panel-heading cart-heading bg-light">
                                        </div>
                                        <div class="panel-body cart-items">
                                            {{-- <div class="row product-items">
                                                <div class="col-sm-2">
                                                    <img src="https://img.lazcdn.com/3rd/q/aHR0cHM6Ly9zdGF0aWMtMDEuZGFyYXouY29tLmJkL3AvOGYwOTk0MTMzMTFjZjBmNmZiMjM2NDQ1NDY5MWQ1NTcuanBn_2200x2200q75.png_.webp" class="img-responsive" alt="Product Image">
                                                </div>
                                                <div class="col-sm-10" style="padding-left: 0;">

                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-xs-7">
                                                            <a href="#">Product Name</a>
                                                            <p class="text-muted">Brand: Brand Name</p>
                                                            <p class="text-muted">Price: $100</p>
                                                            <a href="#" class="text-muted small">Move to Wishlist</a>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <div class="d-flex align-items-center">
                                                                <button type="button" class="btn btn-sm decrement">-</button>
                                                                <input type="text" class="form-control input-sm text-center" id="quantity" min="1" value="1">
                                                                <button type="button" class="btn btn-sm increment">+</button>
                                                            </div>

                                                        </div>
                                                        <div class="col-xs-2">
                                                            <a href="#" class="text-danger small">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <!-- Repeat this panel for each product -->
                                </div>

                                <div class="col-md-12 collapse" id="confirmOrder">
                                    <h3>Select Payment Method</h3>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="paymentTabs" role="tablist">
                                        <li>
                                            <a href="#creditCard" role="tab" data-toggle="tab">Credit Card</a>
                                        </li>
                                        <li>
                                            <a href="#bkash" role="tab" data-toggle="tab">Bkash</a>
                                        </li>
                                        <li>
                                            <a href="#nagad" role="tab" data-toggle="tab">Nagad</a>
                                        </li>
                                        <li>
                                            <a href="#rocket" role="tab" data-toggle="tab">Rocket</a>
                                        </li>
                                        <li class="active">
                                            <a href="#cod" role="tab" data-toggle="tab">Cash on Delivery</a>
                                        </li>
                                    </ul>

                                    {{-- default cash on delivery  --}}
                                    <input type="hidden" id="payment_method" name="payment_method" value="{{ App\Helpers\Constant::PAYMENT_METHOD['cod'] }}">

                                    <!-- Tab panes -->
                                    <div class="tab-content" id="paymentTabsContent">
                                        <div class="tab-pane fade" id="creditCard" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade" id="paypal" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade" id="bkash" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade" id="nagad" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade" id="rocket" role="tabpanel">

                                        </div>
                                        <div class="tab-pane fade in active" id="cod" role="tabpanel">
                                            <p>- You may pay in cash to our courier upon receiving your parcel at the doorstep</p>
                                            <p>- Before agreeing to receive the parcel, check if your delivery status has been updated to 'Out for Delivery'</p>
                                            <p>- Before receiving, confirm that the airway bill shows that the parcel is from Daraz</p>
                                            <p>- Before you make payment to the courier, confirm your order number, sender information and tracking number on the parcel</p>

                                            <button type="button" class="btn mt-20" id="confirmOrderBtn"><span>Confirm Order</span></button>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Right Section: Order Summary -->
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="location">
                                        <h5 class="panel-title mb-20">Coupon Code</h5>

                                        <div class="input-group">
                                            <input type="text" name="coupon_code" class="form-control" placeholder="Enter your coupon code">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default couponApply" type="button">Apply</button>
                                            </span>
                                        </div>
                                    </div>
                                    {{-- <hr> --}}
                                    <div class="delivery-option mt-10">
                                        {{-- <h5 class="panel-title mb-20">Delivery Option</h5> --}}
                                        <div class="delivery_point">
                                            <div class="form-group">
                                                <input type="radio" name="place" value="{{ App\Helpers\Constant::DELIVERY_PLACE['home'] }}" id="standard_delivery" checked>

                                                <label for="standard_delivery" class="standard_delivery d-flex align-items-justify">

                                                    <i class="fa-solid fa-circle-check"></i>
                                                    <div class="right">
                                                        {{-- <input type="hidden" id="delivery_type" value=""> --}}
                                                        {{-- <input type="hidden" id="estimated_delivery_date" value=""> --}}
                                                        {{-- <p>$100</p>
                                                        <p>Standard Delivery</p>
                                                        <p class="mb-0">Grunted by 1 jan to 7</p> --}}
                                                    </div>
                                                </label>
                                            </div>

                                            <span class="text-danger" id="deliveryError"></span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="order-summery">
                                        <h5 class="panel-title mb-20">Order Summary</h5>
                                        <div class="row">
                                            <div class="col-xs-6 sub_label">Subtotal(0 items):</div>
                                            <div class="col-xs-6 text-right order_subtotal">{{ country()->symbol }}200</div>
                                        </div>
                                        <div class="row pt-10">
                                            <div class="col-xs-6">Shipping Fee:</div>
                                            <div class="col-xs-6 text-right order_shipping_fee">{{ country()->symbol }}100</div>
                                        </div>
                                        <div class="row pt-10">
                                            <div class="col-xs-6"><strong>Total:</strong></div>
                                            <div class="col-xs-6 text-right"><strong class="order_total">{{ country()->symbol }}380</strong></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-block mt-20 proceedToPayBtn"><span>Proceed to Pay</span></button>
                                    <button type="button" class="btn btn-block mt-20 cancelPaymentBtn"><span>cancel</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
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

    // Set the payment method
    $('#paymentTabs a').on('shown.bs.tab', function (e) {
        var selectedMethod = $(e.target).attr('href').replace('#', '');
        $('#payment_method').val(selectedMethod);
    });

    $(document).ready(function() {
        $('#shippingBilling').collapse('show'); // Ensure correct ID
        $('#itemsView').collapse('show'); // Ensure correct ID
    });

    $('#editShippingBilling').on('click', function() {
        showAddressCollapse();
    });

    function showAddressCollapse() {
        $('#shippingBillingCollapse').collapse('show');
        $('#shippingBilling').collapse('hide');
        document.title = 'Edit Shipping & Billing';
    }

    $('#cancelBtn').on('click', function() {
        cancelEdit();
    });

    $('.cancelPaymentBtn').on('click', function() {
        cancelPaymentBtn();
    });

    function cancelPaymentBtn() {
        $('#confirmOrder').collapse('hide');
        $('#itemsView').collapse('show');
        $('.proceedToPayBtn').css('display', 'block');
        $('.cancelPaymentBtn').css('display', 'none');
    }


    function cancelEdit() {
        $('#shippingBillingCollapse').collapse('hide');
        $('#shippingBilling').collapse('show');
        document.title = "{{ $pageTitle }}";
    }

    $(document).on('click', '.delivery_point label', function() {
        $('.delivery_point label').removeClass('active');
        $(this).addClass('active');
    });

    // change delivery address
    function changeStatus() {

        let id = $('input[name="address"]:checked').val();

        let url = "{{ route('checkout.change.status', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                if(data === 'already_exist') {
                    Swal.fire({
                        text: "This address is already selected!",
                        timer: 2000,
                        showConfirmButton: false,
                        showCancelButton: false,
                        toast: true,
                        customClass: {
                            popup: 'my-custom-popup-2',
                        },
                    });
                }else {
                    $.ajax({
                        url: "{{ route('checkout.get.selected.address') }}",
                        type: "GET",
                        success: function(response) {
                            $('.shipping-item').html(response); // Load new address content
                        }
                    });
                    cancelEdit();
                    Swal.fire({
                        text: "Successful!",
                        timer: 2000,
                        showConfirmButton: false,
                        showCancelButton: false,
                        toast: true,
                        customClass: {
                            popup: 'my-custom-popup-2',
                        },
                    });

                }

            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                Swal.fire({
                    text: "Failed!",
                    timer: 2000,
                    showConfirmButton: false,
                    showCancelButton: false,
                    toast: true,
                    customClass: {
                        popup: 'my-custom-popup-2',
                    },
                    icon: "error",
                });
            }
        });
    }


    $('.proceedToPayBtn').on('click', function() {
        proceedToPayBtn();
    });

    function proceedToPayBtn() {
        $('#confirmOrder').collapse('show');
        $('#itemsView').collapse('hide');
        $('.proceedToPayBtn').css('display', 'none');
        $('.cancelPaymentBtn').css('display', 'block');
    }

    $('#confirmOrderBtn').on('click', function() {
        storeOrderInvoice();
    });

    function storeOrderInvoice() {
        let url = "{{ route('customer.order.store') }}";

        let name = $('#customer_name').val();
        let email = $('#customer_email').val();
        let shipping_id = $('#shipping_address_id').val() ?? null;
        let phone = $('#customer_phone').val() ?? null;
        let payment_method = $('#payment_method').val();
        let delivery_type = $('#delivery_type').val();
        let estimated_delivery_date = $('#estimated_delivery_date').val();
        let shipping_fee = $('#shipping_fee').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('shipping_id', shipping_id);
        formData.append('phone', phone);
        formData.append('payment_method', payment_method);
        formData.append('delivery_type', delivery_type);
        formData.append('estimated_delivery_date', estimated_delivery_date);
        formData.append('shipping_fee', shipping_fee);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == 'success') {
                    let routeUrl = "{{ route('customer.addressBook.index') }}";
                    Swal.fire({
                        html: `
                            <div style="text-align: center;">
                                <span style="font-size: 16px;">&#9989;</span>
                                <h4 style="margin-top: 10px;">Your order placed successfully.</h4>
                                <p style="font-size: 14px;">
                                    Thank you for shopping with us. <br>
                                    Your order <strong>${data.invoice_id}</strong> has been placed.
                                </p>
                            </div>
                        `,
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'View Order Details',
                        customClass: {
                            popup: 'my-custom-popup',
                            confirmButton: 'my-custom-confirm-solid',
                        },
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = routeUrl;
                        }
                    });
                    cancelPaymentBtn();
                    showCartData();
                }
            },
            error: function(error) {

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    console.log(errors);
                    if (errors.name) {
                        showErrorMessage(errors.name)
                    }
                    if (errors.email) {
                         showErrorMessage(errors.email);
                    }
                    if (errors.shipping_id) {
                        showErrorMessage(errors.shipping_id);
                    }
                    if (errors.phone) {
                        showErrorMessage(errors.phone);
                    }
                    if (errors.payment_method) {
                        showErrorMessage(errors.payment_method);
                    }
                    if (errors.delivery_type) {
                        showErrorMessage(errors.delivery_type);
                    }
                    if (errors.estimated_delivery_date) {
                        showErrorMessage(errors.estimated_delivery_date);
                    }
                    if (errors.shipping_fee) {
                        showErrorMessage(errors.shipping_fee);
                    }
                }else {
                    showErrorMessage('An unknown error occurred!');
                }
            }
        });
    }




</script>
@endpush
