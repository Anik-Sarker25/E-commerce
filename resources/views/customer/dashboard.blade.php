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


    </style>

@endpush

@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <div class="row" style="padding-top: 20px;">
                <!-- Main Content -->
                <div class="col-md-9 col-md-push-3  col-main">
                    <div class="row profile">
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Manage Profile | <a class="color" href="{{ route('customer.profile.index') }}?edit">Edit</a></h5>
                                </div>
                                <div class="panel-body">
                                    <p>{{ $user->name }}</p>
                                    <p>{{ maskEmail($user->email) }}</p>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4 address-left">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Address Book | <a class="color" href="#">Edit</a></h5>
                                    <p class="address">default shipping address</p>
                                </div>
                                <div class="panel-body">
                                    <p>{{ $user->name }}</p>
                                    <p>{{ maskEmail($user->email) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 address-right">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title billing">Address Book | <a class="color" href="#">Edit</a></h5>
                                    <p class="address">default billing address</p>
                                </div>
                                <div class="panel-body">
                                    <p>{{ $user->name }}</p>
                                    <p>{{ maskEmail($user->email) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Recent Orders</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive mt-0">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Placed On</th>
                                                    <th class="text-center">Total Amount</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    use App\Helpers\Constant;
                                                @endphp
                                                @foreach ($invoices as $key => $invoice)
                                                    <tr>
                                                        <td>{{ customerFormatedInvoiceId($invoice->id) }}</td>
                                                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                                                        <td class="text-center">{{ country()->symbol . number_format($invoice->total_price, 2) }}</td>
                                                        <td class="text-center">
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

                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" class="color">Manage</a>
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
