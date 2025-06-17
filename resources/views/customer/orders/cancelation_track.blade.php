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
        .status-list {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .status-list .status-item {
            display: flex;
            align-items: center;
        }
        .status-list .status-item .status-line {
            border: 1px dashed #a19999;
            width: 200px;
        }
        .status-list .status-item .status-line.dark {
            border: 1px dashed #000000;
            width: 200px;
        }
        .status-list .status-item .desc-item {
            position: relative;
        }
        .status-list .status-item .desc-item .label {
            color: #000;
            position: absolute;
            top: -50%;
            left: 50%;
            font-size: 12px;
            transform: translate(-50%, -50%);
            white-space: nowrap;
        }
        .status-list .status-item .desc-item .sicon svg{
            width: 16px;
            height: 16px;
            background: rgb(58, 63, 59);
            color: #fff;
            border-radius: 50%;
            padding: 5px;
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
                                    <h5 class="panel-title"><i class="fas fa-barcode"></i> {{ customerFormatedInvoiceId($invoice->id) }} <small class="text-muted ">Cancelled On 
                                        @if ($cancellation)
                                            {{ \Carbon\Carbon::parse($cancellation)->format('d M Y h:i:s A') }}
                                            
                                        @endif
                                    </small> </h5>
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
                                    <div class="track-status-box">
                                        <ul class="status-list">
                                            <li class="status-item">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-circle"></i></span>
                                                    <p class="label">Cancellation Ongoing</p>
                                                </div>
                                            </li>
                                            <li class="status-item">
                                                <hr class="status-line">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-check"></i></span>
                                                    <p class="label">Cancelled</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="table-responsive mt-0">
                                        <table class="table itemTable mb-0">
                                            <tbody>
                                                @php
                                                    $subtotal = 0;
                                                @endphp
                                                @foreach ($invoice->invoiceItem as $key => $item)
                                                    <tr style="{{ $loop->last ? '' : 'border-bottom: 10px solid transparent;' }}">
                                                        <td class="text-left" style="width: 40%;">
                                                            <div class="d-flex">
                                                                <img src="{{ asset($item->products->thumbnail) }}" alt="image" class="product-image" width="64px">
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
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center" style="width: 30%;">
                                                            Qty:
                                                            {{ $item->quantity }}
                                                        </td>
                                                        @php
                                                            $itemPrice = $item->price * $item->quantity;
                                                            $subtotal += $itemPrice;
                                                        @endphp
                                                        <td class="text-center" style="width: 30%;">
                                                            {{ country()->symbol . ' ' . number_format2($itemPrice) }}
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
