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
                                    @if($invoice->status !== Constant::ORDER_STATUS['pending'] && $invoice->status !== Constant::ORDER_STATUS['cancelled'])
                                        <div class="track-package-box">
                                            <div class="row" style="position: relative;">
                                                <div class="col-sm-8">
                                                    <p>{{ $invoice->deliveryType->name }} <strong>{{ $invoice->tracking_code }}</strong></p>
                                                    <p>Yay! Your order has been delivered, we hope you like it 10 May</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="track-btn-wrapper">
                                                        @php
                                                            $orderTRkKey = "TOrRDerK_" . $invoice->tracking_code . "_" . rand(1000, 9999) . "_TRKC" . time();
                                                            $tradeOrderId = $invoice->id;
                                                        @endphp
                                                        <a href="{{ route('customer.order.track.package', [
                                                            'orderTRkKey' => $orderTRkKey,
                                                            'TrkOrdErId' => $tradeOrderId
                                                        ]) }}" class="btn btn-sm text-capitalize btn-default">Track Package</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

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
                                                        <td class="text-center" style="width: 20%;">
                                                            Qty:
                                                            {{ $item->quantity }}
                                                        </td>
                                                        @php
                                                            $itemPrice = $item->price * $item->quantity;
                                                            $subtotal += $itemPrice;
                                                        @endphp
                                                        <td class="text-center" style="width: 20%;">
                                                            {{ country()->symbol . ' ' . number_format2($itemPrice) }}
                                                        </td>
                                                        @php
                                                            $orderRevKey = "OrRDerRv_" . $invoice->tracking_code . "_" . rand(1000, 9999) . "_TRKC" . time();
                                                            $revOrderId = $invoice->id;
                                                            $revProId = $item->product_id;
                                                            $userId = $user->id;
                                                        @endphp
                                                        <td class="text-center" style="width: 20%;">
                                                            @if (in_array($invoice->status, [Constant::ORDER_STATUS['pending'], Constant::ORDER_STATUS['confirmed'], Constant::ORDER_STATUS['processing']]))
                                                                <a href="javascript::" class="color " onclick="cancelOrder({{ $revOrderId }}, {{ $item->id }});">Cancel</a> <br>
                                                            @else
                                                                <span class="text-muted" style="cursor: not-allowed; opacity: 0.8;">Cancel</span>
                                                            @endif

                                                           @if (in_array($invoice->status, [Constant::ORDER_STATUS['delivered'], Constant::ORDER_STATUS['refunded'], Constant::ORDER_STATUS['returned']]) && !isReviewedByUser($userId, $revOrderId, $revProId))
                                                                <a href="{{ route('customer.order.review', [
                                                                    'orderRevKey' => $orderRevKey,
                                                                    'revOrderId' => $revOrderId,
                                                                    'revProId' => $revProId
                                                                ]) }}" class="color">Write a Review</a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                
                                    <hr>

                                    <!-- Order Timeline -->
                                    <div class="section-title">Order Timeline</div>
                                    <div class="timeline_items">
                                        @php
                                            $steps = [
                                                'confirmed_at' => 'Confirmed',
                                                'processed_at' => 'Processed',
                                                'shipped_at' => 'Shipped',
                                                'delivered_at' => 'Delivered',
                                                'cancelled_at' => 'Cancelled',
                                                'returned_at' => 'Returned',
                                                'refund_at' => 'Refunded',
                                            ];
                                        @endphp

                                        <span class="text-muted">Placed on {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y h:i:s A') }}</span>

                                        @foreach ($steps as $field => $label)
                                            @php
                                                $value = $shipment->$field ?? null;
                                            @endphp

                                            @if ($value)
                                                <span class="text-muted">
                                                    {{ $label }} on {{ \Carbon\Carbon::parse($value)->format('d M Y h:i:s A') }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>

                                    @php
                                        $media = $invoice->payment_method == Constant::PAYMENT_METHOD['cod'] ? 'Cash On Delivery' : '';
                                        $statusLabel = array_flip(Constant::PAYMENT_STATUS)[$invoice->payment_status];
                                    @endphp

                                    @if ($invoice->payment_status == Constant::PAYMENT_STATUS['unpaid'])
                                        <p class="unpaid">{{ $statusLabel }}</p>
                                    @else
                                        <p class="paidR text-capitalize">Paid By {{ $media }}</p>
                                    @endif 

                                    <hr>

                                    <div class="row">
                                        <!-- Shipping Info -->
                                        <div class="col-sm-8">
                                            <div class="section-title">Shipping Info</div>


                                            <p>{{ $address->name }} <i class="fa fa-phone" style="color: #999;"></i> {{ $address->phone ?? '' }}</p>

                                             <p class="delivery-text address">
                                                @if ($address)
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
                                        @php
                                            $grandTotal = $subtotal + $invoice->shipping_cost;
                                        @endphp
                                        <!-- Total Summary -->
                                        <div class="col-sm-4">
                                            <div class="summary-box">
                                                <div class="section-title">Total Summary</div>
                                                <p>Subtotal: {{ country()->symbol . ' ' . $subtotal }}</p>
                                                <p>Shipping Fee: {{ country()->symbol . ' ' . $invoice->shipping_cost }}</p>
                                                <hr>
                                                <p class="total">Total: {{ country()->symbol . ' ' . $grandTotal }}</p>

                                                @if ($invoice->payment_status == Constant::PAYMENT_STATUS['unpaid'])
                                                    <p class="unpaid">{{ $statusLabel }}</p>
                                                @else
                                                    <p class="text-capitalize">Paid via: {{ $media }}</p>
                                                @endif
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

    function cancelOrder(invoice_id, item_id) {
        let url = "{{ route('customer.order.cancel', ':id') }}";
        url = url.replace(':id', invoice_id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: 'transparent',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'my-custom-popup',
                confirmButton: 'my-custom-confirm',
                cancelButton: 'my-custom-cancel',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                // Prepare form data
                let formData = new FormData();
                formData.append('item_id', item_id);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data == 'invoice_cancelled') {
                            show_success('Order Cancelled successfully!');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }else {
                            show_success('Item Cancelled successfully!');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Cancellation Failed!. Please try again.');
                        }
                    }
                });
            }
        });
    }
</script>
@endpush