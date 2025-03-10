
    <!-- Style CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- ================== BEGIN DataTables-css ================== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">


	<!-- ================== Sweet Alert css ================== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css">


    <style>
        .catalog-view_op1 .product-item-opt-1 .product-item-img {
            height: 200px;
            display: block;
        }
        .cms-index-index .block-tab-products-opt1 .product-item .product-item-img {
            height: 300px !important;
            display: block;
        }
        .custompro .owl-stage .owl-item {
            width: 56px;
            height: 56px;
        }
        .custompro .owl-stage .owl-item a,
        .custompro .owl-stage .owl-item img{
            width: 100%;
            height: 100%;
        }

        .image_preview_container {
            height: 400px !important;
        }
        .img-contain {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            color: #c9c9c9;
            background: #fff;
            font-weight: 700;
        }
        .footer-opt-1 .footer-column .block-social .block-content .facebook,
        .footer-opt-1 .footer-column .block-social .block-content .twitter,
        .footer-opt-1 .footer-column .block-social .block-content .instagram,
        .footer-opt-1 .footer-column .block-social .block-content .youtube,
        .footer-opt-1 .footer-column .block-social .block-content .linkedin {
            background: transparent;
            border-radius: 3px;
            font-size: 35px;
        }

        .footer-opt-1 .footer-column .block-social .block-content .facebook {
            color: #3b5998;
        }
        .footer-opt-1 .footer-column .block-social .block-content .twitter {
            color: #1da1f2;
        }
        .footer-opt-1 .footer-column .block-social .block-content .instagram {
            color: #c13584;
        }
        .footer-opt-1 .footer-column .block-social .block-content .youtube {
            color: #ff0000;
        }
        .footer-opt-1 .footer-column .block-social .block-content .linkedin {
            color: #0077b5;
        }

        .footer-opt-1 .footer-column .block-social .block-content a:hover {
            background: transparent;
            transform: scale(1.1);

        }

        .back-to-top svg {
            line-height: 36px;
            width: 36px;
            border-radius: 100%;
            background-color: #f36;
            font-size: 22px;
            color: #fff;
            padding: 5px 0;
        }

        .me-1 {
            margin-right: 5px;
        }
        .me-2 {
            margin-right: 10px;
        }
        .me-3 {
            margin-right: 15px;
        }
        .me-4 {
            margin-right: 20px;
        }
        .me-5 {
            margin-right: 25px;
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .mt-0 {
            margin-top: 0;
        }
        .panel-heading {
            border: 0;
            background: transparent !important;;
        }
        .d-flex {
            display: flex;
        }
        .align-items-center {
            align-items: center;
        }
        .justify-content-center {
            justify-content: center;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .justify-content-around {
            justify-content: space-around;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }


        .my-custom-popup {
            background: rgb(255, 255, 255,);
            color: #333;
            border-radius: 5px;
            padding: 20px;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .my-custom-popup-2 {
            background: rgb(255, 255, 255,);
            color: #333;
            border-radius: 5px;
            font-size: 14px;
            padding: 20px;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .my-custom-confirm {
            background: transparent;
            color: #333;
            padding: 5px 16px;
            border: 2px solid #1F8567;
        }
        .my-custom-confirm-solid {
            background: #f36;
            color: #fff;
            padding: 5px 16px;
            border: 2px solid #f36;
        }
        .my-custom-confirm:hover {
            background: #1F8567 !important;
            color: #ffffff;
            border: 2px solid #1F8567;
        }
        .my-custom-cancel {
            background: transparent;
            color: #333;
            padding: 5px 16px;
            border: 2px solid #be0000;
        }
        .my-custom-cancel:hover {
            background: #be0000 !important;
            color: #ffffff;
            border: 2px solid #be0000;
        }

        .text-capitalize {
            text-transform: capitalize;
        }
        .text-uppercase {
            text-transform: uppercase;
        }
        .text-lowercase {
            text-transform: lowercase;
        }

        /* add to cart css */
        a.delete-item span {
            color: #ff0000;
            cursor: pointer;
            position: absolute;
            top: 0;
            right: 5px;
        }
        .block-minicart .minicart-items .product-item .product-item-photo {
            width: 48px;
        }
        strong.product-item-name {
            padding-right: 12px;
        }
        .counter-number.floating {
            position: absolute;
            top: 10%;
            right: 20%;
        }
        .block-minicart>.dropdown-menu {
            padding: 0;
        }
        .block-minicart .subtitle {
            padding: 20px 20px 0 20px;
        }
        .block-minicart .subtotal {
            padding: 10px 20px 0 20px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 0;
        }
        .block-minicart .actions {
            padding: 0 20px 20px;
        }
        .minicart-items {
            max-height: 220px;
            overflow-y: auto;
            padding-left: 20px;
        }

        .input-group-btn .btn {
            height: 35px !important;
            padding: 0 24px;
        }


        /* Error message container */
        .error-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 5px;
            display: none;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            text-align: center;
            width: 300px;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .error-message .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
        .error-message .times-icon span {
            font-size: 16px;
            margin-bottom: 10px;
            background: red;
            color: rgba(0, 0, 0, 0.8);
            border-radius: 50%;
            padding: 4px 7px;
        }
        .error-message .message-text {
            flex-grow: 1;
            margin-top: 16px;
        }
        /* end error message  */

        /* box-authentication  */
        .box-authentication {
            border: none;
        }
        .box-authentication input {
            border-radius: 10px;
            padding-left: 12px !important;
        }
        .box-authentication label {
            text-transform: capitalize !important;
        }
        .box-authentication .btn {
            border-radius: 10px;
        }
        .glyphicon-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }


    </style>
