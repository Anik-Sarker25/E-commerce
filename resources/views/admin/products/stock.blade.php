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
                    <div class="btn-group">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">Add Products</a>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover DataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Item Code</th>
                                        <th>Total Quantity</th>
                                        <th>Total Sales Quantity</th>
                                        <th>Total Stock</th>
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
                url: "{{ url()->current() }}",
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
                    data: 'name',
                    name: 'name',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'item_code',
                    name: 'item_code',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'stock_quantity',
                    name: 'stock_quantity',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'total_sale',
                    name: 'total_sale',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'stock',
                    name: 'stock',
                    className: 'text-center',
                    orderable: false
                }
            ],
            responsive: true
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

</script>
@endpush
