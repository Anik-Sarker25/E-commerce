@extends('layouts.customer.app')
@push('css')
    <style>
        .site-main {
            background-color: #f5f5f5;
        }
        .col-sidebar .block-sidebar {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .user {
            padding: 10px 0 0 27px;
            margin-bottom: 0;
            text-transform: capitalize;
        }
        .custom-menu * {
            color: #666;
        }
        .custom-menu li>ul>li {
            display: block;
            text-indent: 15px;
            font-size: 14px;
            padding: 3px 0;
            text-transform: capitalize;
        }
        .custom-menu .upper-item {
            font-size: 16px;
            font-weight: 400;
            text-transform: capitalize;
        }
        .custom-menu .upper-item.active,
        .custom-menu .lower-item.active {
            color: #f36;
        }
        .color {
            color: #f36 !important;
        }
        .custom-menu .list-item {
            padding-bottom: 10px;
            text-transform: capitalize;
        }
        .custom-menu .list-item ul {
            padding-bottom: 10px;
        }
        .col-main .panel {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .address-left {
            padding-right: 0;
        }
        .address-right {
            padding-left: 0;
        }

        .panel-heading .address {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 12px;
            text-transform: uppercase;
        }
        .panel-title.billing {
            visibility: hidden;
        }
        .profile {
            display: flex;
            flex-wrap: wrap; /* Ensures flexibility across columns */
        }

        .profile > .col-md-4 {
            display: flex;
            flex-direction: column; /* Ensures the child panels inside each column stretch vertically */
        }

        .panel {
            flex: 1; /* Ensures the panels inside each column stretch to the same height */
        }

        .itemTable tbody td {
            border-top: none !important;
        }
        .border_bottom {
            border-bottom: 1px solid #ddd !important;
        }
        .bg-secondary {
            background-color: #6c757d; /* Greyish color like Bootstrap 4/5 */
            color: white;
            padding: 3px 6px;
            border-radius: 5px;
            text-transform: capitalize;
        }
        .product-image {
            border-radius: 5px;
            margin-right: 10px;
        }



    </style>

@endpush

@section('content')

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
                            </div>
                        </div>
                        <div class="col-md-12">
                            @foreach ($invoices as $key => $invoice)
                                <div class="panel panel-default">
                                    <div class="panel-heading border_bottom d-flex align-items-center justify-content-between">
                                        <h5 class="panel-title"><i class="fas fa-barcode"></i> {{ customerFormatedInvoiceId($invoice->id) }}</h5>
                                        <span class="bg-secondary">completed</span>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive mt-0">
                                            <table class="table itemTable mb-0">
                                                <tbody>
                                                    @foreach ($invoice->invoiceItem as $key => $item)
                                                        <tr style="{{ $loop->last ? '' : 'border-bottom: 10px solid transparent;' }}">
                                                            <td class="text-left" style="width: 40%;">
                                                                <div class="d-flex">
                                                                    <img src="{{ asset($item->products->thumbnail) }}" alt="image" class="product-image" width="64px">
                                                                    <p>{{ $item->products->name }}</p>
                                                                </div>
                                                            </td>
                                                            <td class="text-center" style="width: 30%;">
                                                                Qty:
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td class="text-center" style="width: 30%;">
                                                                {{ country()->symbol . number_format2($item->total_price) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
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
