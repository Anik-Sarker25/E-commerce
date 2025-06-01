@extends('layouts.customer.app')
@push('css')
@include('layouts.customer.sidebar_css')
<style>
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
        width: 100px;
    }
    .status-list .status-item .status-line.dark {
        border: 1px dashed #000000;
        width: 100px;
    }
    .status-list .status-item .desc-item {
        position: relative;
    }
    .status-list .status-item .desc-item .label {
        color: #000;
        position: absolute;
        top: -25%;
        left: 50%;
        font-size: 12px;
        transform: translate(-50%, -50%);
        white-space: nowrap;
    }
    .status-list .status-item .desc-item .sicon svg{
        width: 24px;
        height: 24px;
        background: #000;
        color: #fff;
        border-radius: 50%;
        padding: 10px;
    }



    
/* BOTTOM SECTION: VERTICAL TIMELINE */
.track-container {
    border-radius: 6px;
    padding: 20px;
}

.track-timeline {
    list-style: none;
    padding-left: 0;
    position: relative;
}

.track-timeline:before {
    content: '';
    position: absolute;
    left: 25px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.track-timeline li {
    position: relative;
    padding-left: 60px;
    margin-bottom: 24px;
}

.track-timeline li::before {
    content: '\f192';
    font-family: FontAwesome;
    position: absolute;
    left: 17px;
    top: 0;
    font-size: 12px;
    color: #ccc;
    background: #fff;
}

.track-timeline li.completed::before {
    content: '\f00c';
    color: #fff;
    background-color: #28a745;
    border-radius: 50%;
    padding: 2px 5px;
}

.track-timeline li.current::before {
    content: '\f192';
    color: #ff2e83;
    font-size: 18px;
    background-color: #fff;
}

.track-timeline .timestamp {
    font-size: 12px;
    color: #888;
}

.track-timeline .status {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.track-timeline .message {
    font-size: 13px;
    color: #555;
    margin-top: 5px;
}

.track-timeline li.current .status {
    color: #ff2e83;
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
                                <div class="panel-body">
                                    <div class="track-status-box">
                                        <ul class="status-list">
                                            <li class="status-item">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-credit-card"></i></span>
                                                    <p class="label">Processing</p>
                                                </div>
                                            </li>
                                            <li class="status-item">
                                                <hr class="status-line dark">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-cube"></i></span>
                                                    <p class="label">Packed</p>
                                                </div>
                                            </li>
                                            <li class="status-item">
                                                <hr class="status-line dark">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-truck"></i></span>
                                                    <p class="label">Shipped</p>
                                                </div>
                                            </li>
                                            <li class="status-item">
                                                <hr class="status-line">
                                                <div class="desc-item">
                                                    <span class="sicon"><i class="fa fa-check"></i></span>
                                                    <p class="label">Delivered</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <h4 class="text-center">Track Your Package</h4>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="courier">
                                                <h5 class="panel-title">Courier Information -</h5>
                                                <div class="courier-details">
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Delivery partner</td>
                                                                    <td>:</td>
                                                                    <td>REDX</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Courier Person</td>
                                                                    <td>:</td>
                                                                    <td>Motiur Rahman - Sl23</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tracking Number</td>
                                                                    <td>:</td>
                                                                    <td onclick="copyToClipboard(this)">
                                                                        <a href="javascript::" style="color: #f36;">
                                                                            TRK-DYUYRP-3420250510
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Current Status</td>
                                                                    <td>:</td>
                                                                    <td class="text-success">Processing</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="track-container">
                                                <ul class="track-timeline">
                                                    <li class="completed">
                                                        <div class="status">Confirmed <span class="timestamp">10 May 2025 - 4:40 PM</span></div>
                                                        <div class="message">We’ve received your order and will start processing it soon.</div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="status">Processing <span class="timestamp">10 May 2025 - 5:00 PM</span></div>
                                                        <div class="message">Your order is processing.</div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="status">Ready For Shipping <span class="timestamp">11 May 2025 - 12:00 PM</span></div>
                                                        <div class="message">Your order is processed! It's ready to shipped.</div>
                                                    </li>
                                                    <li class="completed">
                                                        <div class="status">Shipped <span class="timestamp">11 May 2025 - 9:00 AM</span></div>
                                                        <div class="message">Your order is on the move! It’s one step away from your doorstep.</div>
                                                    </li>
                                                    <li class="current">
                                                        <div class="status">Out for Delivery <span class="timestamp">12 May 2025 - 3:00 PM</span></div>
                                                        <div class="message">Our delivery agent is on the way. Get ready to receive your package today!</div>
                                                    </li>
                                                    <li>
                                                        <div class="status">Delivered <span class="timestamp">12 May 2025 - 6:00 PM</span></div>
                                                        <div class="message">Your package has been delivered [address]</div>
                                                    </li>
                                                    <li>
                                                        <div class="status">Returned <span class="timestamp">13 May 2025 - 2:00 PM</span></div>
                                                        <div class="message">Your return is in progress. We'll keep you posted.</div>
                                                    </li>
                                                    <li>
                                                        <div class="status">Refunded <span class="timestamp">13 May 2025 - 5:00 PM</span></div>
                                                        <div class="message">Refund processed. It should reflect in your account soon.</div>
                                                    </li>
                                                </ul>
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
    function copyToClipboard(element) {
        var text = element.innerText;
        var tempInput = document.createElement("input");
        tempInput.style.position = "absolute";
        tempInput.style.left = "-9999px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        show_success("Tracking number copied: " + text);
    }   
</script>    
@endpush
