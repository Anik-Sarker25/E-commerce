@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')

    @php
        $estimated_time = App\Helpers\Constant::ESTIMATED_TIME;
        $tracking_available = App\Helpers\Constant::TRACKING_AVAILABLE;
    @endphp
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
                        <button type="button" onclick="showDeliveryForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="deliveryFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addDeliveryTitle">add Delivery Option</h4>
                            <h4 class="text-capitalize d-none" id="updateDeliveryTitle">update Delivery Option</h4>

                        </div>
                        <div class="card-body pb-2">
                            <form id="deliveryForm">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Delivery Option Name <span class="text-danger">*</span></label>
                                            <input type="hidden" id="update_id" value="">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Standard Delivery ....">
                                            <span class="text-danger" id="nameError"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="cost">Delivery Costing <span class="text-danger">*</span></label>
                                            <input type="number" name="cost" class="form-control" id="cost">
                                            <span class="text-danger" id="costError"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="estimated_time">Estimated Time/Day <span class="text-danger">*</span></label>
                                            <select class="form-control select2" id="estimated_time" name="estimated_time">
                                                <option value="">Select Option</option>
                                                @foreach ($estimated_time as $key => $time)
                                                    <option value="{{ $time }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="estimatedTimeError"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tracking_available" class="form-label">Tracking Available</label>
                                            <select class="form-control select2" id="tracking_available" name="tracking_available">
                                                <option value="">Select Option</option>
                                                @foreach ($tracking_available as $key => $value)
                                                    <option value="{{ $value }}">{{ $key }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="trackingAvailableError"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="mb-3">
                                            <button type="button" onclick="addDeliveryOption();" class="btn btn-outline-success"id="addDeliveryOptionBtn"><i class="fa fa-plus me-2"></i>Add Delivery Option</button>
                                            <button type="button" onclick="updateDeliveryOption();" class="btn btn-outline-success d-none me-2" id="updateDeliveryOptionBtn"><i class="fa fa-share me-2"></i>Update Delivery Option</button>
                                            <button type="button" onclick="resetDeliveryOption();" class="btn btn-outline-danger d-none" id="cancelDeliveryOptionBtn"><i class="fa fa-times me-2"></i>Cencel</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <x-card-arrow />
                    </div>
                </div>
                <!-- END Notice Form -->


                <!-- Notice Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover DataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Delivery Time</th>
                                        <th>Tracking Available</th>
                                        <th>Amount</th>
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
                    data: 'estimated_time',
                    name: 'estimated_time',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'tracking_available',
                    name: 'tracking_available',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'cost',
                    name: 'cost',
                    className: 'text-center',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center print-disabled',
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

    function showDeliveryForm() {
        $('#deliveryFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#costError').text('');
        $('#cost').val('');
        $('#cost').removeClass('is-invalid');

        $('#estimatedTimeError').text('');
        $('#estimated_time').val('');
        $('#estimated_time').removeClass('is-invalid');

        $('#trackingAvailableError').text('');
        $('#tracking_available').val('1').trigger('change');
        $('#tracking_available').removeClass('is-invalid');

        $('#addDeliveryTitle').removeClass('d-none');
        $('#updateDeliveryTitle').addClass('d-none');

        $('#addDeliveryOptionBtn').removeClass('d-none');
        $('#updateDeliveryOptionBtn').addClass('d-none');
        $('#cancelDeliveryOptionBtn').addClass('d-none');
    }

    function addDeliveryOption() {
        let url = "{{ route('admin.settings.delivery.store') }}";

        let name = $('#name').val();
        let cost = $('#cost').val();
        let estimeted_time = $('#estimated_time').val();
        let tracking_available = $('#tracking_available').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('cost', cost);
        formData.append('estimated_time', estimeted_time);
        formData.append('tracking_available', tracking_available);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDeliveryOption();
                show_success('Delivery Option Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.cost) {
                    $('#costError').text(errors.cost);
                    $('#cost').val('');
                    $('#cost').addClass('is-invalid');
                }
                if(errors.estimeted_time) {
                    $('#estimatedTimeError').text(errors.estimeted_time);
                    $('#estimated_time').val('');
                    $('#estimated_time').addClass('is-invalid');
                }
                if(errors.tracking_available) {
                    $('#trackingAvailableError').text(errors.tracking_available);
                    $('#tracking_available').val('1').trigger('change');
                    $('#tracking_available').addClass('is-invalid');
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.settings.delivery.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                $('#deliveryFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#name').val(data.name);
                $('#cost').val(data.cost);
                $('#estimated_time').val(data.estimated_time).trigger('change');
                $('#tracking_available').val(data.tracking_available).trigger('change');

                $('#addDeliveryTitle').addClass('d-none');
                $('#updateDeliveryTitle').removeClass('d-none');
                $('#addDeliveryOptionBtn').addClass('d-none');
                $('#updateDeliveryOptionBtn').removeClass('d-none');
                $('#cancelDeliveryOptionBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateDeliveryOption() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.settings.delivery.update', ':id') }}";
        url = url.replace(':id', update_id);

        let name = $('#name').val();
        let cost = $('#cost').val();
        let estimeted_time = $('#estimated_time').val();
        let tracking_available = $('#tracking_available').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('cost', cost);
        formData.append('estimated_time', estimeted_time);
        formData.append('tracking_available', tracking_available);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDeliveryOption();
                show_success('Delivery Options Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.cost) {
                    $('#costError').text(errors.cost);
                    $('#cost').val('');
                    $('#cost').addClass('is-invalid');
                }
                if(errors.estimeted_time) {
                    $('#estimatedTimeError').text(errors.estimeted_time);
                    $('#estimated_time').val('');
                    $('#estimated_time').addClass('is-invalid');
                }
                if(errors.tracking_available) {
                    $('#trackingAvailableError').text(errors.tracking_available);
                    $('#tracking_available').val('1').trigger('change');
                    $('#tracking_available').addClass('is-invalid');
                }
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.settings.delivery.destroy', ':id') }}";
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
                        show_success('Delivery Option deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the Option. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetDeliveryOption() {

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#costError').text('');
        $('#cost').val('');
        $('#cost').removeClass('is-invalid');

        $('#estimatedTimeError').text('');
        $('#estimated_time').val('').trigger('change');
        $('#estimated_time').removeClass('is-invalid');

        $('#trackingAvailableError').text('');
        $('#tracking_available').val('1').trigger('change');
        $('#tracking_available').removeClass('is-invalid');

        $('#deliveryFormBox').removeClass('show');

        $('#addDeliveryTitle').removeClass('d-none');
        $('#updateDeliveryTitle').addClass('d-none');

        $('#addDeliveryOptionBtn').removeClass('d-none');
        $('#updateDeliveryOptionBtn').addClass('d-none');
        $('#cancelDeliveryOptionBtn').addClass('d-none');
    }


</script>
@endpush
