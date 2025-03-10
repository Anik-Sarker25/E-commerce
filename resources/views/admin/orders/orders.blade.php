@extends('layouts.admin.app')
@push('css')
{{-- invoice style  --}}
@include('admin.orders.models.invoice_style')
<style>
    .viewBody {
        max-height: 600px;
        overflow-y: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .viewBody::-webkit-scrollbar {
        width: 0;
        height: 0;
        display: none;
    }
    /* Apply only for computer screens (desktops) */
    @media (min-width: 1024px) {
        .custom-dropdown-menu {
            position: fixed !important;
            z-index: 9999 !important;
        }
    }

</style>

@endpush
@section('title', 'Settings')
@section('content')

    <!-- BEGIN #content -->
    <div id="content" class="app-content">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-12 -->
            <div class="col-xl-12">
                <x-breadcrumbs :items="$breadcrumbs" />

                <div class="d-flex justify-content-between">
                    <h1 class="page-header text-capitalize mb-0">{{ $pageTitle }}</h1>
                    {{-- <div class="btn-group">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">Add Products</a>
                    </div> --}}
                </div>

                <hr class="mb-4">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover DataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Invoice Id</th>
                                        <th>Username</th>
                                        <th>Tracking Code</th>
                                        <th>Order Amount</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Date</th>
                                        <th>Final_D_Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <x-card-arrow />
                </div>

            </div>
            <!-- END col-12-->
        </div>

        <!-- END row -->
    </div>
    <!-- END #content -->
@endsection

@push('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        var dataTable;

        let url = "{{ url()->current() }}";

        @if (request()->has('confirmed_orders'))
            url += "?confirmed_orders";
        @elseif (request()->has('processing_orders'))
            url += "?processing_orders";
        @elseif (request()->has('shipped_orders'))
            url += "?shipped_orders";
        @elseif (request()->has('delivered_orders'))
            url += "?delivered_orders";
        @elseif (request()->has('canceled_orders'))
            url += "?canceled_orders";
        @elseif (request()->has('refunded_orders'))
            url += "?refunded_orders";
        @elseif (request()->has('returned_orders'))
            url += "?returned_orders";
        @endif

        dataTable = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10,
            dom: 'lBfrtip',
            buttons: [
                // 'copy',
                'excel',
                'csv',
                'pdf',
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(.print-disabled)'
                    }
                },
                'reset',
            ],
            ajax: {
                url: url,
                data: function(d) {
                    // Add any additional parameters if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the error, e.g., display a message or take appropriate action
                    console.error("Error: " + textStatus, errorThrown);
                    alert('Failed to load data. Please try again.'); // Notify user
                },
            },
            columns: [
                {
                    data: 'sl',
                    name: 'sl',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'invoice_id',
                    name: 'invoice_id',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'username',
                    name: 'username',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'tracking_code',
                    name: 'tracking_code',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'total_price',
                    name: 'total_price',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'payment_method',
                    name: 'payment_method',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'created_date',
                    name: 'created_date',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'final_d_date',
                    name: 'final_d_date',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center print-disabled',
                    orderable: false
                }
            ]
        });

    });

    // Custom reset button extension
    $.fn.dataTable.ext.buttons.reset = {
        text: '<i class="fas fa-undo d-inline"></i> Reset',
        action: function (e, dt, node, config) {
            dt.search('').draw(); // Reset the search input
            dt.ajax.reload(); // Reload the data
        }
    };

    function copyToClipboard(text) {
        let tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = text;
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        show_success('Tracking Code copied to clipboard: ' + text);
    }

    function userView(id){
        let url = "{{ route('admin.orders.userView', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                $('.viewBody').html('');
                $('.modal-title').html(response.modalTitle); // Set modal title dynamically
                $('.viewBody').html(response.view); // Inject the view
                $('#viewModel').modal('show');
                $('#print-btn').addClass('d-none').removeClass('d-block');
            },
            error: function(){
                show_warning('User Data Not Found!');
            }
        });
    }
    function invoiceView(id){
        let url = "{{ route('admin.orders.invoiceView', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                $('.viewBody').html('');
                $('.modal-title').html(response.modalTitle); // Set modal title dynamically
                $('.viewBody').html(response.view); // Inject the view
                $('#viewModel').modal('show');
                $('#print-btn').removeClass('d-none').addClass('d-block');

            },
            error: function(){
                show_warning('Product Data Not Found!');
            }
        });
    }

    function printContent() {
        var printableArea = document.getElementById('printable-area').innerHTML;

        var windowWidth = 1000;
        var windowHeight = 800;
        var left = (window.innerWidth / 2) - (windowWidth / 2);
        var top = (window.innerHeight / 2) - (windowHeight / 2);

        // Replace the content of the page with the invoice HTML
        var invoiceHtml = `
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Invoice</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

                    <style>
                        /* genarals */
                        #printable-area {
                            position: relative;
                            width: 210mm;
                            min-height: 297mm;
                            background: white;
                            margin: auto;
                            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
                        }
                        #printable-area article *{
                            font-size: 12px;
                        }
                        #printable-area h1 {
                            font-size: 16px;
                        }
                        #printable-area p {
                            margin-bottom: 0;
                        }
                        body {
                            font-family:  'Open Sans', sans-serif;
                        }
                        #printable-area th, td {
                            border: 1px solid #BBB;
                            vertical-align: middle;
                            border-radius: 4px;
                            padding: 6px;
                        }
                        #printable-area table {
                            border-collapse: separate;
                            border-spacing: 2px;
                        }

                        /* header part  */
                        #printable-area .invoice-header {
                            background: #EEE;
                            width: 100%;
                            padding: 5mm 12mm;
                            border-radius: 8px 8px 0 0;
                            overflow: hidden;
                        }
                        #printable-area .invoice-header::before {
                            content: "";
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100px;
                            background: linear-gradient(to left, #eaebec, #d4dde7);
                            clip-path: polygon(100% 0%, 0% 100%, 0% 100%, 24% 13%);
                            z-index: 1000;
                        }
                        #printable-area .invoice-header::after {
                            content: "";
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100px;
                            background: linear-gradient(to left, #e6e8ea, #c0beb8);
                            clip-path: polygon(100% 0%, 0% 100%, 0% 100%, 0% 0%);
                        }
                        #printable-area .header-items {
                            z-index: 1000;
                        }
                        #printable-area .invoice-title {
                            font-size: 24px;
                            font-weight: bold;
                            color: #44586b;
                            text-transform: uppercase;
                        }
                        #printable-area .company-logo img {
                            max-height: 50px;
                        }

                        /* main-content  */
                        #printable-area article {
                            padding: 8mm 12mm 20mm;
                        }
                        #printable-area article::before {
                            content: "";
                            position: absolute;
                            bottom: 0;
                            left: 0;
                            width: 100%;
                            height: 100px;
                            background: linear-gradient(to right, #eaebec, #d4dde7);
                            clip-path: polygon(0% 100%, 100% 0%, 100% 0%, 76% 87%);
                            z-index: 1000;
                        }
                        #printable-area article::after {
                            content: "";
                            position: absolute;
                            bottom: 0;
                            left: 0;
                            width: 100%;
                            height: 100px;
                            background: linear-gradient(to right, #e6e8ea, #c0beb8);
                            clip-path: polygon(0% 100%, 100% 0%, 100% 0%, 100% 100%);
                        }
                        #printable-area .details {
                            position: relative;
                        }
                        #printable-area .details table th,
                        #printable-area .details table td {
                            border: none;
                        }
                        #printable-area .spacl {
                            padding-left: 20px;
                            padding-right: 5px;
                        }
                        #printable-area .urTable th, .table th, .brTable th {
                            background: #EEE;
                        }
                        #printable-area .urTable th {
                            font-weight: normal;
                        }
                        #printable-area .product-item-table th {
                            text-align: center;
                        }
                        #printable-area .brTable th{
                            width: 120px;
                        }
                        #printable-area .unpaid {
                            color: #e46060;
                            border: 5px solid #fa4646;
                            border-radius: 10px;
                            font-size: 18px;
                            display: inline-block;
                            padding: 5px 10px;
                            text-transform: uppercase;
                            transform: rotate(-45deg);
                            position: absolute;
                            left: 66%;
                            bottom: 0%;
                        }
                        #printable-area img.unpaid {
                            border: none;
                            display: block;
                            transform: rotate(-45deg);
                            position: absolute;
                            left: 66%;
                            bottom: 0%;
                        }

                        /* footer section  */
                        #printable-area .signature-line {
                            position: relative;
                            width: 50%;
                            height: 1px;
                            border-top: 1px solid #000000;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        #printable-area .signature-line p {
                            margin: 0;
                            padding-top: 25px;
                        }
                        .product-item-table th,
                        .product-item-table td {
                            border-bottom: 1px solid #BBB !important;
                            border-top: none !important;
                            border-left: none !important;;
                            border-right: none !important;;
                        }

                        /* Print-specific Styles */
                        @media print {
                            #printable-area .signature-line {
                                width: 30% !important;
                            }
                        }

                    </style>
                </head>
                <body style="background: #999999;">
                    <div id="printable-area">
                        ${printableArea}
                    </div>
                </body>
            </html>
        `;

        // Create a temporary print window
        var printWindow = window.open('', '', `width=${windowWidth},height=${windowHeight},top=${top},left=${left}`);

        printWindow.document.write(invoiceHtml);
        printWindow.document.close();

        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        };
    }

    function changeOrderStatus(id, status) {
        let url = "{{ route('admin.orders.updateStatus', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the order status!",
            showCancelButton: true,
            confirmButtonColor: 'transparent',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes',
            customClass: {
                popup: 'my-custom-popup',
                confirmButton: 'my-custom-confirm',
                cancelButton: 'my-custom-cancel',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { status: status },
                    dataType: 'JSON',
                    success: function(data) {
                        if (typeof data === 'string') {
                            if (data === 'already_exist') {
                                show_warning('You are not allowed to change to the same status.');
                            } else if (data === 'invalid_transition') {
                                show_warning('This status change is not allowed.');
                            } else {
                                show_warning('An unexpected error occurred.');
                            }
                        } else if (typeof data === 'object' && data.status) {
                            show_success(`Order status updated to ${data.status} successfully!`);
                            $('.DataTable').DataTable().ajax.reload();
                        } else if (typeof data === 'object' && data.error) {
                            show_warning(data.error);
                        } else {
                            show_warning('An unknown error occurred.');
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        } else {
                            show_error('Failed to update the order status. Please try again.');
                        }
                    }
                });
            }
        });

    }


    // Delete the Product
    // function destroy(id) {
    //     let url = "{{ route('admin.products.destroy', ':id') }}";
    //     url = url.replace(':id', id);

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         showCancelButton: true,
    //         confirmButtonColor: 'transparent',
    //         cancelButtonColor: 'transparent',
    //         confirmButtonText: 'Yes, delete it!',
    //         customClass: {
    //             popup: 'my-custom-popup',
    //             confirmButton: 'my-custom-confirm',
    //             cancelButton: 'my-custom-cancel',
    //         },
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: url,
    //                 type: 'DELETE',
    //                 dataType: 'JSON',
    //                 success: function(data) {
    //                     show_success('Product deleted successfully!');
    //                     $('.DataTable').DataTable().ajax.reload();
    //                 },
    //                 error: function(error) {
    //                     if (error.responseJSON.error) {
    //                         show_error(error.responseJSON.error);
    //                     }else {
    //                         show_error('Failed to delete the product. Please try again.');
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // }

</script>
@endpush
