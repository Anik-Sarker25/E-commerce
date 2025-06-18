@extends('layouts.admin.app')

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
                        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success">Add Users</a>
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
                                        <th>Customer</th>
                                        <th style="width: 10%;">Invoice Id</th>
                                        <th>Amount</th>
                                        <th>Transaction Type</th>
                                        <th>Transaction ID</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th style="width: 18%;">Note</th>
                                        <th style="width: 10%;">Date</th>
                                        {{-- <th style="width: 10%;">action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                 <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right !important;">Total :</th>
                                        <th id="totalAmountFooter" class="text-center">৳0</th>
                                        <th colspan="6"></th>
                                    </tr>
                                </tfoot>
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

        var url = "{{ url()->current() }}";

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
                    data: 'user_id',
                    name: 'user_id',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'order_id',
                    name: 'order_id',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'transaction_id',
                    name: 'transaction_id',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'payment_method',
                    name: 'payment_method',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'transaction_status',
                    name: 'transaction_status',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'remarks',
                    name: 'remarks',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'date',
                    name: 'date',
                    className: 'text-center',
                    orderable: false
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     className: 'text-center print-disabled',
                //     orderable: false
                // }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Helper function to clean and convert amount
                var parseAmount = function (value) {
                    return typeof value === 'string'
                        ? parseFloat(value.replace(/[৳,]/g, '')) || 0
                        : typeof value === 'number'
                            ? value : 0;
                };

                // Calculate page total
                var pageTotal = api
                    .column(3, { page: 'current' }) // 3 = amount column
                    .data()
                    .reduce(function (a, b) {
                        return parseAmount(a) + parseAmount(b);
                    }, 0);

                $(api.column(3).footer())
                    .html('৳' + pageTotal.toLocaleString())
                    .css('text-align', 'right'); // force alignment
                        }
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

    function destroy(id) {
        let url = "{{ route('admin.transactions.destroy', ':id') }}";
        url = url.replace(':id', id);

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
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'JSON',
                    success: function(data) {
                        show_success('Transaction deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the transaction. Please try again.');
                        }
                    }
                });
            }
        });
    }

</script>
@endpush
