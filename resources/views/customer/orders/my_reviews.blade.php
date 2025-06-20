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

        /* for star rating */
        .star-filled {
            color: #f1c40f; /* Gold */
            transition: color 0.2s;
        }

        .star-empty {
            color: #ccc; /* Light gray */
            transition: color 0.2s;
        }
        .feedback {
            border-left: 3px solid #ccc;
            padding-left: 20px;
            min-height: 100%;
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
                                        @foreach ($invoice->invoiceItem as $key => $item)
                                        @if (!empty($item))
                                            <div class="d-flex">
                                                <img src="{{ asset($item->products->thumbnail) }}" alt="image" class="product-image" width="84px">
                                                <div class="context me-3">
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
                                                        <span class="text-muted mb-4">{{ $label }}: {{ $variant->variant_value }}</span>
                                                    @endif


                                                    @php
                                                        $orderRevKey = "OrRDerRv_" . $invoice->tracking_code . "_" . rand(1000, 9999) . "_TRKC" . time();
                                                        $revOrderId = $invoice->id;
                                                        $revProId = $item->product_id;

                                                        $review = getReviewByUser($user->id, $item->product_id, $invoice->id);
                                                    @endphp

                                                    @if (in_array($invoice->status, [
                                                            Constant::ORDER_STATUS['delivered'],
                                                            Constant::ORDER_STATUS['refunded'],
                                                            Constant::ORDER_STATUS['returned']
                                                        ]))
                                                        <div class="mt-2">
                                                            @if (!$review)
                                                                <a href="{{ route('customer.order.review', [
                                                                    'orderRevKey' => $orderRevKey,
                                                                    'revOrderId' => $revOrderId,
                                                                    'revProId' => $revProId
                                                                ]) }}" class="color">Write a Review</a>
                                                            @else
                                                                <div id="star-rating" class="flex items-center space-x-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="fa fa-star {{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}"></i>
                                                                    @endfor
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                </div>

                                                @if ($review)
                                                    <div class="feedback">
                                                        {{ $review->review }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        @endforeach

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
