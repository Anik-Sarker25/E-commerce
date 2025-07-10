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
                            </div>
                        </div>
                        <div class="col-md-12">
                            @foreach ($invoices as $key => $invoice)
                                <div class="panel panel-default">
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
                                                @case('cancelled') label-danger @break
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
                                                    @if (!empty($item))
                                                        <tr style="{{ $loop->last ? '' : 'border-bottom: 10px solid transparent;' }}">
                                                            <td class="text-left" style="width: 40%;">
                                                                <div class="d-flex">
                                                                    <img src="{{ asset($item->products->thumbnail) }}" alt="image" class="product-image" width="64px">
                                                                    @php
                                                                        $orderGroupKey = "ORDERSL_" . $invoice->id . "_" . rand(1000, 9999) . "_DT" . time();
                                                                        $tradeOrderId = $invoice->id;

                                                                    @endphp
                                                                    <div class="context">
                                                                        <p>
                                                                            <a href="{{ route('customer.order.invoice.view', [
                                                                                'orderGroupKey' => $orderGroupKey,
                                                                                'tradeOrderId' => $tradeOrderId
                                                                            ]) }}">
                                                                                {{ $item->products->name }}
                                                                            </a>
                                                                        </p>
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
                                                                                    case \App\Helpers\Constant::VARIANT_TYPES['size']:
                                                                                        $label = 'Size';
                                                                                        break;
                                                                                    case \App\Helpers\Constant::VARIANT_TYPES['storage_capacity']:
                                                                                        $label = 'Storage Capacity';
                                                                                        break;
                                                                                    case \App\Helpers\Constant::VARIANT_TYPES['instalment']:
                                                                                        $label = 'Instalment';
                                                                                        break;
                                                                                    case \App\Helpers\Constant::VARIANT_TYPES['case_size']:
                                                                                        $label = 'Case Size';
                                                                                        break;
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        @if ($label && !empty($variant->variant_value))
                                                                            <span class="text-muted">{{ $label }}: {{ $variant->variant_value }}</span>
                                                                        @endif
                                                                        
                                                                        @if ($invoice->status == Constant::ORDER_STATUS['cancelled'])
                                                                        @php
                                                                            $orderTRkKey = "TOrRDerK_" . $invoice->tracking_code . "_" . rand(1000, 9999) . "_TRKC" . time();
                                                                            $tradeOrderId = $invoice->id;
                                                                        @endphp
                                                                            <p class="cancel-details text-capitalize">
                                                                                {{ array_flip(Constant::ORDER_STATUS)[$invoice->status] }} - 
                                                                                <a href="{{ route('customer.order.track.cancelation', [
                                                                                    'orderTRkKey' => $orderTRkKey,
                                                                                    'TrkOrdErId' => $tradeOrderId
                                                                                ]) }}" class="color">View Details</a>
                                                                            </p>
                                                                        @endif


                                                                    </div>
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
                                                    @endif
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
