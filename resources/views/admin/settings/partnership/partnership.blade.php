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
                        <button type="button" onclick="showPartnershipForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="partnershipFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addPartnershipTitle">add Partnership</h4>
                            <h4 class="text-capitalize d-none" id="updatePartnershipTitle">update Partnership</h4>

                        </div>
                        <div class="card-body pb-2">
                            <form id="PartnershipForm">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="card">
                                            <div class="d-flex align-items-center justify-content-center" style="height: 200px;) center center no-repeat">
                                                <div class="imageBox mb-2 position-relative">
                                                    <button id="removeImage" onclick="deleteImage();" class="btn text-danger position-absolute top-0 end-0" title="Remove Image" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <img src="" id="imagePreview" class="w-100 d-block rounded" alt="image-preview">
                                                </div>
                                            </div>
                                            <x-card-arrow />
                                        </div>

                                    </div>
                                    <div class="col-xl-10">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Company Name</label>
                                            <input type="hidden" id="update_id" value="">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Company Name...">
                                            <span class="text-danger" id="nameError"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="image">Image ( <small>max 100px</small> )</label>
                                            <input type="file" name="image" class="form-control" id="image">
                                            <span class="text-danger" id="imageError"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="link">Link</label>
                                            <input type="url" class="form-control" name="link" id="link" placeholder="https://www.example.com/...">
                                            <span class="text-danger" id="linkError"></span>
                                        </div>

                                        <div class="mb-3">
                                            <button type="button" onclick="addPartnership();" class="btn btn-outline-success"id="addPartnershipBtn"><i class="fa fa-plus me-2"></i>Add Partnership</button>
                                            <button type="button" onclick="updatePartnership();" class="btn btn-outline-success d-none me-2" id="updatePartnershipBtn"><i class="fa fa-share me-2"></i>Update Partnership</button>
                                            <button type="button" onclick="resetPartnership();" class="btn btn-outline-danger d-none" id="cancelPartnershipBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Company Name</th>
                                        <th>Image</th>
                                        <th>link</th>
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
       // When a user selects an image
    $('#image').change(function(event) {
        let file = event.target.files[0]; // Get the selected file
        let reader = new FileReader();    // Create a FileReader instance

        reader.onload = function(e) {
            let imagePreview = $('#imagePreview');
            imagePreview.attr('src', e.target.result); // Set the source of the image
            imagePreview.removeClass('d-none'); // Show the image preview

            $('#removeImage').removeClass('d-none'); // Show the "Remove" button
        };

        if (file) {
            reader.readAsDataURL(file);
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
                    data: 'image',
                    name: 'image',
                    className: 'text-center',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'link',
                    name: 'link',
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

    function showPartnershipForm() {
        $('#partnershipFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#linkError').text('');
        $('#link').val('');
        $('#link').removeClass('is-invalid');

        $('#imageBox').html('');

        $('#addPartnershipTitle').removeClass('d-none');
        $('#updatePartnershipTitle').addClass('d-none');

        $('#addPartnershipBtn').removeClass('d-none');
        $('#updatePartnershipBtn').addClass('d-none');
        $('#cancelPartnershipBtn').addClass('d-none');
    }

    function addPartnership() {
        let url = "{{ route('admin.settings.partnerships.store') }}";

        let name = $('#name').val();
        let image = $('#image')[0].files[0];
        let link = $('#link').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('image', image);
        formData.append('link', link);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetPartnership();
                show_success('Partnership Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.image) {
                    $('#imageError').text(errors.image);
                    $('#image').val('');
                    $('#image').addClass('is-invalid');
                }
                if(errors.link) {
                    $('#linkError').text(errors.link);
                    $('#link').val('');
                    $('#link').addClass('is-invalid');
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.settings.partnerships.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#imagePreview').attr('src', '');
                $('#partnershipFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#name').val(data.name);
                if (data.image) {
                    let baseUrl = "{{ asset('') }}";
                    let fullImageUrl = baseUrl + data.image;
                    $('#imagePreview').attr('src', fullImageUrl);
                }
                $('#link').val(data.link);
                $('#addPartnershipTitle').addClass('d-none');
                $('#updatePartnershipTitle').removeClass('d-none');
                $('#addPartnershipBtn').addClass('d-none');
                $('#updatePartnershipBtn').removeClass('d-none');
                $('#cancelPartnershipBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updatePartnership() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.settings.partnerships.update', ':id') }}";
        url = url.replace(':id', update_id);

        let name = $('#name').val();
        let image = $('#image')[0].files[0];
        let link = $('#link').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('image', image);
        formData.append('link', link);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetPartnership();
                show_success('Partnership Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if(errors.image) {
                    $('#imageError').text(errors.image);
                    $('#image').val('');
                    $('#image').addClass('is-invalid');
                }
                if(errors.link) {
                    $('#linkError').text(errors.link);
                    $('#link').val('');
                    $('#link').addClass('is-invalid');
                }
            }
        });
    }


    function deleteImage() {
        let id = $('#update_id').val();
        let preview = $('#imagePreview').attr('src');

        if(id !== null && id !== '' && preview !== '') {
            let url = "{{ route('admin.settings.partnerships.removeImage', ':id') }}";
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
                            show_success('Image deleted successfully!');
                            $('#imagePreview').attr('src', '');
                        },
                        error: function(error) {
                            if (error.responseJSON.error) {
                                show_error(error.responseJSON.error);
                            }else {
                                show_error('Failed to delete the image. Please try again.');
                            }
                        }
                    });
                }
            });
        } else {
            $('#imagePreview').attr('src', '');
            $('#image').val('');
        }
    }

    function destroy(id) {
        let url = "{{ route('admin.settings.partnerships.destroy', ':id') }}";
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
                        show_success('Partnership deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the partnership. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetPartnership() {
        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#linkError').text('');
        $('#link').val('');
        $('#link').removeClass('is-invalid');

        $('#partnershipFormBox').removeClass('show');

        $('#addPartnershipTitle').removeClass('d-none');
        $('#updatePartnershipTitle').addClass('d-none');

        $('#addPartnershipBtn').removeClass('d-none');
        $('#updatePartnershipBtn').addClass('d-none');
        $('#cancelPartnershipBtn').addClass('d-none');
    }


</script>
@endpush
