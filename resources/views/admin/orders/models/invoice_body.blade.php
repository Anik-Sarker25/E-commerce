@php
    $payment_status = App\Helpers\Constant::PAYMENT_STATUS;
@endphp
<div id="printable-area">
    <div class="invoice-header d-flex justify-content-between align-items-center">
        <!-- Left: Company Info -->
        <div class="header-items">
            <h1 class="invoice-title">Invoice</h1>
            <p class="mb-0 fw-bold text-capitalize">{{ siteInfo()->company_name ?? 'Set company name' }}</p>
            <p class="mb-0">{{ siteInfo()->address }}</p>
            <p class="mb-0">Email: {{ siteInfo()->email }} | Phone: {{ siteInfo()->phone }}</p>
        </div>

        <!-- Right: Company Logo -->
        <div class="company-logo">
            <img src="{{ asset(siteInfo()->site_logo) }}" alt="Company Logo">
        </div>
    </div>
    <article>
        <div class="row mb-4">
            <div class="col-md-6 col-sm-6">
                <div class="details">
                    <table>
                        <tr>
                            <td>Name</td>
                            <td class="spacl">:</td>
                            <td>{{ $address->name }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td class="spacl">:</td>
                            <td>{{ $address->phone }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td class="spacl">:</td>
                            <td>{{ $address->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="d-flex align-items-end justify-content-end">
                    <table class="urTable">
                        <tr>
                            <th>Invoice #</th>
                            <td>{{ adminFormatedInvoiceId($invoice->id) }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Amount Due</th>
                            <td>
                                @if ($invoice->payment_status == $payment_status['unpaid'])
                                    {{ country()->symbol . number_Format($invoice->total_price, 2) }}

                                @elseif ($invoice->payment_status == $payment_status['paid'])
                                    {{ country()->symbol . '0.00' }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- product items table  -->
        <div class="table-responsive">
            <table class="table product-item-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($invoiceItem as $key => $item)
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td>
                                <img src="{{ asset($item->products->thumbnail) }}" class="rounded" width="24px" alt="image">
                                {{ $item->product_name }}
                                @if($item->color)
                                    <span class="color">(Color: {{ $item->color->color_name  ?? ''}}) </span>
                                @endif
                                @if($item->size)
                                    <span class="size">(Size: {{ $item->size->variant_value  ?? ''}}) </span>
                                @endif

                            </td>
                            <td class="text-center">{{ country()->symbol . $item->price }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ country()->symbol . $item->total_price }}</td>
                        </tr>
                        @php
                            $subtotal += $item->total_price;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- calculation section  -->
        <div class="row mt-4">
            <div class="col-md-7 details">
                <!-- left introduction table  -->
                <table>
                    <tr>
                        <td><strong>In Word</strong></td>
                        <td>:</td>
                        <td>{{ numberToWord(number_format2($invoice->total_price)) }} {{ (country()->currency == 'BDT') ? 'Taka' : country()->currency }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>:</td>
                        <td>
                            @if ($invoice->payment_method == App\Helpers\Constant::PAYMENT_METHOD['cod'])
                                Cash On Delivery
                            @else
                                Online Payment
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Approved By</td>
                        <td>:</td>
                        <td>{{ admin()->name }}</td>
                    </tr>

                </table>

                @if ($invoice->payment_status == $payment_status['unpaid'])
                {{-- <div class="unpaid">Unpaid</div> --}}
                <img class="unpaid" src="{{ asset('backend/assets/img/invoice/unpaid.png') }}" alt="unpaid-image" width="100px">

                @elseif ($invoice->payment_status == $payment_status['paid'])
                    {{-- paid image or design  --}}
                @endif
            </div>
            <div class="col-md-5">
                <!-- right total table  -->
                <table class="d-flex align-items-end justify-content-end brTable">
                    <tr>
                        <th>Total</th>
                        <td>
                            {{ country()->symbol . number_Format($subtotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Shipping Fee</th>
                        <td>{{ country()->symbol . number_Format($invoice->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>{{ country()->symbol . number_Format($invoice->total_price, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- footer details and signature  -->
        <div class="row d-flex justify-content-center align-items-center" style="margin-top: 50px;">
            <!-- Left Column: Text content -->
            <div class="col-md-6 d-flex justify-content-start align-items-center ps-5">
                <div class="text-center">
                    <p>Thank you for your business</p>
                    <p>Regards,</p>
                    <p>admin</p>
                </div>
            </div>

            <!-- Right Column: Signature Line -->
            <div class="col-md-6 d-flex justify-content-end align-items-center pe-5">
                <div class="signature-line">
                    <p>Signature</p>
                </div>
            </div>
        </div>
    </article>
</div>
