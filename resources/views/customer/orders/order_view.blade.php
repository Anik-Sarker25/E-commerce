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
                                <div class="panel-heading border_bottom d-flex align-items-center justify-content-between">
                                    <h5 class="panel-title"><i class="fas fa-barcode"></i> {{ customerFormatedInvoiceId($invoice->id) }}</h5>
                                    @php
                                        $statusLabel = array_search($invoice->status, Constant::ORDER_STATUS);
                                    @endphp
                                    <span class="label
                                        @switch($statusLabel)
                                            @case('pending') label-warning @break
                                            @case('confirmed') label-info @break
                                            @case('processing') label-primary @break
                                            @case('shipped') label-default @break
                                            @case('delivered') label-success @break
                                            @case('canceled') label-danger @break
                                            @case('refunded') label-default @break
                                            @case('returned') label-default @break
                                            @default label-default
                                        @endswitch
                                    ">
                                        {{ ucfirst($statusLabel) }}
                                    </span>
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
                                                                <p><a href="{{ route('customer.order.invoice.view') }}">{{ $item->products->name }}</a></p>
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
