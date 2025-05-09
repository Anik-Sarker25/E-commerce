
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        showCartData(); // show data after page load

        @if (Route::currentRouteName() == 'checkout.buy-now')
            buyNowDeliveryTypeSet();
        @endif
        
    });

    function updateNavAfterLogin() {
        $(".nav-right li:has(a[href='{{ route('login') }}'])").replaceWith(`
            <li class="dropdown setting">
                <a data-toggle="dropdown" role="button" href="#" class="dropdown-toggle">
                    <span>My Account</span> <i aria-hidden="true" class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="account">
                        <li><a href="{{ route('customer.dashboard') }}">My Account</a></li>
                        <li><a href="">Wishlist</a></li>
                        <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                        </form>
                    </ul>
                </div>
            </li>
        `);
    }

    function addCart(product_id, quantity) {

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('cart.auth.check') }}",
            success: function(data) {
                if (data.logged_in) {
                    cartStore(product_id, quantity);
                }else {
                    $('.loginModal').modal('show');
                    $("#modalLoginForm #product_id").val(product_id);
                    $("#modalLoginForm #quantity").val(quantity);
                }
            }
        });

    }
    function increment(id) {

        let url = "{{ route('cart.increment', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            success: function(data) {
                if (data == 'increased') {
                    showCartData();
                }else if(data == 'stockout') {
                    $('.stockOut').html('Out Of Stock').show();
                    $('#quantity').val(1);

                    setTimeout(function() {
                        $('.stockOut').fadeOut();
                        showCartData();
                    }, 2000);
                }
            }
        });

    }
    function decrement(id) {

        let url = "{{ route('cart.decrement', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            success: function(data) {
                showCartData();
            }
        });

    }


    function cartLogin() {
        let url = "{{ route('login') }}";
        let product_id = $("#modalLoginForm #product_id").val();
        let quantity = $("#modalLoginForm #quantity").val();

        let email = $("#modalLoginForm #email").val();
        let password = $("#modalLoginForm #password").val();

        // Show the loading spinner and disable the button
        $("#loadingSpinner").show();
        $(".cartLoginBtn").prop('disabled', true);

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                email: email,
                password: password,
            },
            success: function (response) {
                $("#loadingSpinner").hide();
                $(".cartLoginBtn").prop('disabled', false);
                if (response.cartLoginSuccess === true) {
                    if (response.csrf_token) {
                        $('meta[name="csrf-token"]').attr('content', response.csrf_token);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': response.csrf_token
                            }
                        });
                    }
                    $(".loginModal").modal("hide"); // Hide modal after login
                    if (product_id !== "" && quantity !== "") {
                        addCart(product_id, quantity);
                    }
                    updateNavAfterLogin();
                } else if(response.cartLoginSuccess === 'unverified') {
                    if(response.redirectUrl === true) {
                        window.location.href = "{{ route('verification.notice') }}";
                    }
                }
            },
            error: function(error) {
                $('#emailError').html('');
                $('#passwordError').html('');

                $('#email').removeClass('is-invalid');
                $('#password').removeClass('is-invalid');

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;

                    if (errors.email) {
                        $('#emailError').html(errors.email);
                        $('#email').val('');
                        $('#email').addClass('is-invalid');
                    }
                    if (errors.password) {
                        $('#passwordError').html(errors.password);
                        $('#password').val('');
                        $('#password').addClass('is-invalid');
                    }

                }else {
                    $("#modalLoginForm #genaralError").val("An error occured!");
                }
            }
        });
    }

    function cartStore(product_id, quantity) {

        let url = "{{ route('cart.store') }}";
        
        let qty = parseInt($('#quantity').val());
        if (isNaN(qty) || qty <= 0) {
            qty = (typeof quantity !== 'undefined') ? quantity : 1;
        }

        // let qty = (typeof quantity !== 'undefined') ? quantity : parseInt($('#quantity').val());
        let color_id = $('.swatch-option.color.active').attr('id');
        let size_id = $('.swatch-option.size.active').attr('id');
        let sell_price = $('.sell_price').attr('id');


        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                product_id: product_id,
                quantity: qty,
                color: color_id,
                size: size_id,
                sell_price: sell_price,
            },
            success: function(data) {
                if (data == 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: "Product added to cart successfully.",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        customClass: {
                            popup: 'my-custom-popup',
                            confirmButton: 'my-custom-confirm-solid',
                        },
                    });
                    $('#quantity').val(1);
                    showCartData();
                } else if (data == 'increased') {
                    let currentRoute = "{{ Route::currentRouteName() }}";
                    if(currentRoute !== 'checkout.index') {
                        Swal.fire({
                            title: 'Success',
                            text: "Product quantity increased to cart successfully.",
                            icon: 'info',
                            showCancelButton: false,
                            confirmButtonText: 'Ok',
                            customClass: {
                                popup: 'my-custom-popup',
                                confirmButton: 'my-custom-confirm-solid',
                            },

                        });
                    }
                    $('#quantity').val(1);
                    showCartData();
                } else if (data == 'decreased') {
                    $('#quantity').val(1);
                    showCartData();
                } else if (data == 'min_quantity') {
                    $('.stockOut').html('Minimum quantity is 1.').show();
                    $('#quantity').val(1);

                    setTimeout(function() {
                        $('.stockOut').fadeOut();
                        showCartData();
                    }, 2000);
                } else if (data == 'stockout') {
                    $('.stockOut').html('Out Of Stock').show();
                    $('#quantity').val(1);

                    setTimeout(function() {
                        $('.stockOut').fadeOut();
                        showCartData();
                    }, 2000);
                } else {
                    Swal.fire({
                        title: 'Failed',
                        text: "An Error Occoured!.",
                        icon: 'warning',
                        showCancelButton: false,
                        confirmButtonText: 'Ok',
                        customClass: {
                            popup: 'my-custom-popup',
                            confirmButton: 'my-custom-confirm-solid',
                        },
                    });
                }
            }
        });
    }

    function showCartData() {
        let url = "{{ route('cart.index') }}"; // Adjust to your route

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (data) {
                if (data.status === 'success') {
                    // Update cart counter
                    $('.counter-number').text(data.total_items);
                    $('.counter-label').html(`${data.total_items} <span>Items</span>`);
                    $('.counter-price').text(`{{ country()->symbol }}${data.total_price}`);
                    $('.cart-item-count').text(data.total_items);
                    $('.subtitle').text(`You have ${data.total_items} item(s) in your cart`);

                    let currentRoute = "{{ Route::currentRouteName() }}";

                    // Render cart items
                    let cartItemsHTML = '';
                    let cartItemsHTML2 = '';

                    if (data.cart_items.length !== 0) {
                        data.cart_items.forEach(item => {
                            cartItemsHTML += `
                                <li class="product-item">
                                    <a class="product-item-photo" href="${item.product_url}" title="${item.name}">
                                        <img class="product-image-photo" src="${item.image_url}" alt="${item.name}">
                                    </a>
                                    <div class="product-item-details">
                                        <strong class="product-item-name">
                                            <a href="${item.product_url}">${item.name}</a>
                                        </strong>
                                        <div class="product-item-price">
                                            <span class="price">{{ country()->symbol }}${item.price}</span>
                                        </div>
                                        <div class="product-item-qty">
                                            <span class="label">Qty: </span><span class="number">${item.quantity}</span>
                                        </div>
                                        <div class="product-item-actions">
                                            <a class="action delete-item" href="javascript:void(0);" onclick="removeCartItem(${item.id})" title="Remove item">
                                                <span>X</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            `;
                            cartItemsHTML2 += `
                                <div class="row product-items">
                                    <div class="col-sm-2">
                                        <img src="${item.image_url}" class="img-responsive" alt="${item.name}">
                                    </div>
                                    <div class="col-sm-10" style="padding-left: 0;">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-xs-7">
                                                <a href="${item.product_url}">${item.name}</a>
                                                <p class="text-muted">Brand: ${item.brand || 'No Brand'}</p>
                                                <p class="text-muted">Price: {{ country()->symbol }}${item.price}</p>
                                                <a href="#" class="text-muted small">Move to Wishlist</a>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm decrement" onclick="decrement(${item.id})">-</button>
                                                    <input type="text" class="form-control input-sm text-center quantity" min="1" value="${item.quantity}">
                                                    <button type="button" class="btn btn-sm increment" onclick="increment(${item.id})">+</button>
                                                </div>
                                                <span class="stockOut text-danger" style="display: none;"></span>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="javascript:void(0);" class="text-danger small" onclick="removeCartItem(${item.id})">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        cartItemsHTML = `
                            <li class="product-item">
                                <p class="text-center">No Item...</p>
                            </li>
                        `;
                        cartItemsHTML2 = `
                            <div class="row product-items">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">There are no items in this cart.</p>
                                    <a href="{{ route('shop') }}" class="btn btn-default mt-20">Continue Shopping</a>
                                </div>
                            </div>
                        `;

                        if (currentRoute === 'checkout.index') {
                            $('.proceedToPayBtn, .couponApply').prop('disabled', true);
                        }
                    }

                    $('.subtotal .price').text(`{{ country()->symbol }}${data.total_price}`);

                    $('.minicart-items').html(cartItemsHTML);

                    if (currentRoute === 'checkout.index') {

                        if (data.delivery && data.delivery.length > 0) {
                            deliveryType = `
                                <input type="hidden" id="delivery_type" value="${data.delivery[0].id}">
                                <input type="hidden" id="estimated_delivery_date" value="${data.delivery[0].time2}">
                                <input type="hidden" id="shipping_fee" value="${data.delivery[0].amount}">
                                <p id="dvAmount">{{ country()->symbol }}${data.delivery[0].amount}</p>
                                <p id="dvName">${data.delivery[0].name || 'Standard Delivery'}</p>
                                <p class="mb-0" id="dvTime">${data.delivery[0].time}</p>
                            `;
                            $('label.standard_delivery .right').html(deliveryType);

                            $('.order_shipping_fee').text(`{{ country()->symbol }}${data.delivery[0].amount}`);
                        } else {
                            deliveryType = `
                                <p>{{ country()->symbol }}100</p>
                                <p>Standard Delivery</p>
                                <p class="mb-0">Grunted by 1 jan to 7</p>
                            `;
                            $('label.standard_delivery .right').html(deliveryType);
                            $('.order_shipping_fee').text(`{{ country()->symbol }}0`);
                        }

                        $itemCount = data.total_items;
                        if($itemCount > 0) {
                            let headingHtml = `
                                <h3 class="panel-title">Cart Items(${data.total_items})</h3>
                            `;
                            $('.panel-heading.cart-heading').html(headingHtml);
                            $('.order-summery .sub_label').text(`Subtotal(${data.total_items} items) :`);
                        }else {
                            $('.panel-heading.cart-heading').html('');
                            $('.order-summery .sub_label').text('Subtotal(0 items):');
                        }

                        $('.panel-body.cart-items').html(cartItemsHTML2);
                        $('.order_subtotal').text(`{{ country()->symbol }}${data.total_price}`);

                        if (data.delivery && data.delivery.length > 0) {
                            let totalPrice = data.total_price;
                            let totalShippingFee = Number(data.delivery[0].amount) || 0;
                            let totalOrderPrice = totalPrice + totalShippingFee;
                            $('.order_total').text(`{{ country()->symbol }}${totalOrderPrice}`);
                        } else {
                            $('.order_total').text(`{{ country()->symbol }}0`);
                        }

                    }

                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching cart data:", error);
            }
        });
    }

    function buyNowDeliveryTypeSet() {

        let bnDeliveryType = $('#bnDeliveryType').val();
        let bnDeliveryName = $('#bnDeliveryName').val();
        let bnDeliveryAmount = $('#bnDeliveryAmount').val();
        let bnDeliveryTime = $('#bnDeliveryTime').val();
        let bnDeliveryTime2 = $('#bnDeliveryTime2').val();
        let bnSubTotal = $('#bnSubTotal').val();

        bnDeliveryType = `
                    <input type="hidden" id="delivery_type" value="${bnDeliveryType}">
                    <input type="hidden" id="estimated_delivery_date" value="${bnDeliveryTime2}">
                    <input type="hidden" id="shipping_fee" value="${bnDeliveryAmount}">
                    <p id="dvAmount">{{ country()->symbol }}${bnDeliveryAmount}</p>
                    <p id="dvName">${bnDeliveryName || 'Standard Delivery'}</p>
                    <p class="mb-0" id="dvTime">${bnDeliveryTime}</p>
                `;
        $('label.standard_delivery .right').html(bnDeliveryType);
        $('.order_shipping_fee').text(`{{ country()->symbol }}${bnDeliveryAmount}`);
        $('.order_subtotal').text(`{{ country()->symbol }}${bnSubTotal}`);
        
        let bnTotalPrice = Number(bnSubTotal) || 0;
        let bnTotalShippingFee = Number(bnDeliveryAmount) || 0;
        let bnTotalOrderPrice = bnTotalPrice + bnTotalShippingFee;

        $('.order_total').text(`{{ country()->symbol }}${bnTotalOrderPrice}`);

        $('.proceedToPayBtn, .couponApply').prop('disabled', false);

    }



    function removeCartItem(id) {
        let url = "{{ route('cart.remove', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            type: "DELETE",
            url: url,
            dataType: "json",
            success: function (data) {
                if (data =='success') {
                    showCartData();
                }
            },
            error: function (error) {
                if (error.responseJSON.error) {
                    show_error(error.responseJSON.error);
                }else {
                    show_error('Failed to remove the item. Please try again.');
                }
            }
        });
    };


</script>
