@extends('layouts.admin.app')
@push('css')
<style>
    .iconpicker-popover {
        opacity: 1 !important;
        width: 100% !important;
        position: absolute;
        top: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999 !important;
    }
    .iconpicker .iconpicker-item {
        color: #333;
    }input.form-control.iconpicker-search {
    border: 1px solid #333;
    color: #333;
    box-shadow: 0 0 0 1px #ddd;
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
                    <div class="btn-group">
                        <button type="button" onclick="showServiceForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="ServiceFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addServiceTitle">add Service</h4>
                            <h4 class="text-capitalize d-none" id="updateServiceTitle">update service</h4>

                        </div>
                        <div class="card-body pb-2">
                            <form id="ServiceForm">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Service Name</label>
                                    <input type="hidden" id="update_id" value="">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Free Shipping">
                                    <span class="text-danger" id="nameError"></span>
                                </div>

                                <div class="mb-3">
                                    <label for="icon" class="form-label">Select Icon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="icon" placeholder="Select an icon" value="">
                                        <span class="input-group-text" id="iconPickerBtn"><i class="fas fa-icons"></i></span>
                                    </div>
                                    <strong class="text-danger" id="iconError"></strong>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">Description (<small>around 1 line</small>)</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="On order over $200">
                                    <span class="text-danger" id="descriptionError"></span>
                                </div>

                                <div class="mb-3">
                                    <button type="button" onclick="addService();" class="btn btn-outline-success"id="addServiceBtn"><i class="fa fa-plus me-2"></i>Add Service</button>
                                    <button type="button" onclick="updateService();" class="btn btn-outline-success d-none me-2" id="updateServiceBtn"><i class="fa fa-share me-2"></i>Update Service</button>
                                    <button type="button" onclick="resetService();" class="btn btn-outline-danger d-none" id="cancelServiceBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Service Name</th>
                                        <th>Icon</th>
                                        <th>Description</th>
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

    $(document).ready(function () {
        // Initialize the icon picker
        $('#icon').iconpicker({
            placement: 'bottom',
            animation: true,
        });
        $('#icon').on('click', function() {
            $('.iconpicker-popover').css('display', 'block');
        });
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
                    data: 'icon',
                    name: 'icon',
                    className: 'text-center',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'description',
                    name: 'description',
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

    function showServiceForm() {
        $('#ServiceFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#iconError').text('');
        $('#icon').val('');
        $('#icon').removeClass('is-invalid');

        $('#descriptionError').text('');
        $('#description').val('');
        $('#description').removeClass('is-invalid');

        $('#addServiceTitle').removeClass('d-none');
        $('#updateServiceTitle').addClass('d-none');

        $('#addServiceBtn').removeClass('d-none');
        $('#updateServiceBtn').addClass('d-none');
        $('#cancelServiceBtn').addClass('d-none');
    }

    function addService() {
        let url = "{{ route('admin.services.store') }}";

        let name = $('#name').val();
        let icon = $('#icon').val();
        let description = $('#description').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('icon', icon);
        formData.append('description', description);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetService();
                show_success('Service Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.icon) {
                    $('#iconError').text(errors.icon);
                    $('#icon').val('');
                    $('#icon').addClass('is-invalid');
                }
                if(errors.description) {
                    $('#descriptionError').text(errors.description);
                    $('#description').val('');
                    $('#description').addClass('is-invalid');
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.services.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#ServiceFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#name').val(data.name);
                $('#icon').val(data.icon);
                $('#description').val(data.description);
                $('#addServiceTitle').addClass('d-none');
                $('#updateServiceTitle').removeClass('d-none');
                $('#addServiceBtn').addClass('d-none');
                $('#updateServiceBtn').removeClass('d-none');
                $('#cancelServiceBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateService() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.services.update', ':id') }}";
        url = url.replace(':id', update_id);

        let name = $('#name').val();
        let icon = $('#icon').val();
        let description = $('#description').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('icon', icon);
        formData.append('description', description);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetService();
                show_success('Service Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.icon) {
                    $('#iconError').text(errors.icon);
                    $('#icon').val('');
                    $('#icon').addClass('is-invalid');
                }
                if(errors.description) {
                    $('#descriptionError').text(errors.description);
                    $('#description').val('');
                    $('#description').addClass('is-invalid');
                }
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.services.destroy', ':id') }}";
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
                        show_success('Service deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the service. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetService() {
        $('#iconError').text('');
        $('#icon').val('');
        $('#icon').removeClass('is-invalid');

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#descriptionError').text('');
        $('#description').val('');
        $('#description').removeClass('is-invalid');

        $('#ServiceFormBox').removeClass('show');

        $('#addServiceTitle').removeClass('d-none');
        $('#updateServiceTitle').addClass('d-none');

        $('#addServiceBtn').removeClass('d-none');
        $('#updateServiceBtn').addClass('d-none');
        $('#cancelServiceBtn').addClass('d-none');
    }


</script>
@endpush
