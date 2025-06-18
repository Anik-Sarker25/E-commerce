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
                        <button type="button" onclick="showDivisionForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="divisionFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addDivisionTitle">add Division</h4>
                            <h4 class="text-capitalize d-none" id="updateDivisionTitle">update Division</h4>

                        </div>
                        <div class="card-body pb-2">
                            <form id="categoryForm">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Division Name (<small>EN</small>) <span class="text-danger">*</span> </label>
                                    <input type="hidden" id="update_id" value="">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Division Name...">
                                    <span class="text-danger" id="nameError"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bn_name">Division Name (<small>BN</small>) <span class="text-danger">*</span></label>
                                    <input type="text" name="bn_name" class="form-control" id="bn_name" placeholder="Enter Division Name...">
                                    <span class="text-danger" id="bn_nameError"></span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="link">Website link <span class="text-danger">*</span></label>
                                    <input type="text" name="link" class="form-control" id="link" placeholder="https://www.example.gov.bd">
                                    <span class="text-danger" id="linkError"></span>
                                </div>

                                <div class="mb-3">
                                    <button type="button" onclick="addDivision();" class="btn btn-outline-success"id="addDivisionBtn"><i class="fa fa-plus me-2"></i>Add Division</button>
                                    <button type="button" onclick="updateDivision();" class="btn btn-outline-success d-none me-2" id="updateDivisionBtn"><i class="fa fa-share me-2"></i>Update Division</button>
                                    <button type="button" onclick="resetDivision();" class="btn btn-outline-danger" id="cancelDivisionBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Name [EN]</th>
                                        <th>Name [BN]</th>
                                        <th>url</th>
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
                    data: 'bn_name',
                    name: 'bn_name',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'url',
                    name: 'url',
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

    function showDivisionForm() {
        $('#divisionFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#bn_nameError').text('');
        $('#bn_name').val('');
        $('#bn_name').removeClass('is-invalid');

        $('#linkError').text('');
        $('#link').val('');
        $('#link').removeClass('is-invalid');

        $('#addDivisionTitle').removeClass('d-none');
        $('#updateDivisionTitle').addClass('d-none');

        $('#addDivisionBtn').removeClass('d-none');
        $('#updateDivisionBtn').addClass('d-none');
    }

    function addDivision() {
        let url = "{{ route('admin.countries.divisions.store') }}";

        let name = $('#name').val();
        let bn_name = $('#bn_name').val();
        let link = $('#link').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('bn_name', bn_name);
        formData.append('link', link);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDivision();
                show_success('Division Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                let errors = error.responseJSON.errors;
                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.countries.divisions.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#divisionFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#name').val(data.name);
                $('#bn_name').val(data.bn_name);
                $('#link').val(data.url);

                $('#addDivisionTitle').addClass('d-none');
                $('#updateDivisionTitle').removeClass('d-none');
                $('#addDivisionBtn').addClass('d-none');
                $('#updateDivisionBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateDivision() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.countries.divisions.update', ':id') }}";
        url = url.replace(':id', update_id);

        let name = $('#name').val();
        let bn_name = $('#bn_name').val();
        let link = $('#link').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('bn_name', bn_name);
        formData.append('link', link);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDivision();
                show_success('Division Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                let errors = error.responseJSON.errors;
                for (let key in errors) {
                    // Check if the field is a select element
                    if ($(`#${key}`).is('select')) {
                        $(`#${key}Error`).html(errors[key]);
                    } else {
                        $(`#${key}Error`).html(errors[key]);
                        $(`#${key}`).val('');
                        $(`#${key}`).addClass('is-invalid');
                    }
                }
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.countries.divisions.destroy', ':id') }}";
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
                        if(data == 'have_district') {
                            show_error('Cannot delete the division because it has related district.');
                            return;
                        }else {
                            show_success('Division deleted successfully!');
                            $('.DataTable').DataTable().ajax.reload();
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the division. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetDivision() {
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');
        
        $('#bn_nameError').text('');
        $('#bn_name').val('');
        $('#bn_name').removeClass('is-invalid');

        $('#linkError').text('');
        $('#link').val('');
        $('#link').removeClass('is-invalid');

        $('#divisionFormBox').collapse('toggle');

        $('#addDivisionTitle').removeClass('d-none');
        $('#updateDivisionTitle').addClass('d-none');

        $('#addDivisionBtn').removeClass('d-none');
        $('#updateDivisionBtn').addClass('d-none');
    }


</script>
@endpush
