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
                        <button type="button" onclick="showSubCategoryForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="subCategoryFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addSubcategoryTitle">add Sub Category</h4>
                            <h4 class="text-capitalize d-none" id="updateSubcategoryTitle">Update Sub Category</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="subCategoryForm">
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
                                            <label class="form-label" for="category_id">Select Category</label>
                                            <select name="category_id"  class="form-control select2" id="category_id">

                                            </select>
                                            <span class="text-danger" id="categoryError"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name">Sub Category Name</label>
                                            <input type="hidden" id="update_id" value="">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Sub Category Name...">
                                            <span class="text-danger" id="nameError"></span>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="image">Image ( <small>170 X 100</small> )</label>
                                            <input type="file" name="image" class="form-control" id="image">
                                            <span class="text-danger" id="imageError"></span>
                                        </div>

                                        <div class="mb-3">
                                            <button type="button" onclick="addSubCategory();" class="btn btn-outline-success"id="addSubCategoryBtn"><i class="fa fa-plus me-2"></i>Add Sub Category</button>
                                            <button type="button" onclick="updateSubCategory();" class="btn btn-outline-success d-none me-2" id="updateSubCategoryBtn"><i class="fa fa-share me-2"></i>Update Sub Category</button>
                                            <button type="button" onclick="resetSubCategory();" class="btn btn-outline-danger d-none" id="cancelSubCategoryBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Sub Category Name</th>
                                        <th>Category Name</th>
                                        <th>Image</th>
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
    @include('layouts.admin.all_select2')
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


    $(document).ready(function () {
        getCategory();
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
                    data: 'category_id',
                    name: 'category_id',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'image',
                    name: 'image',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
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

    function showSubCategoryForm() {
        $('#subCategoryFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#categoryError').text('');
        $('#category_id').val('').trigger('change');

        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#addSubcategoryTitle').removeClass('d-none');
        $('#updateSubcategoryTitle').addClass('d-none');

        $('#addSubCategoryBtn').removeClass('d-none');
        $('#updateSubCategoryBtn').addClass('d-none');
        $('#cancelSubCategoryBtn').addClass('d-none');
    }

    function addSubCategory() {
        let url = "{{ route('admin.subcategories.store') }}";

        let category_id = $('#category_id').val();
        let name = $('#name').val();
        let image = $('#image')[0].files[0];

        // Prepare form data
        let formData = new FormData();
        formData.append('category_id', category_id);
        formData.append('name', name);
        formData.append('image', image);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetSubCategory();
                show_success('Sub Category Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.category_id) {
                    $('#categoryError').text(errors.category_id);
                    $('#category_id').val('').trigger('change');
                }
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
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.subcategories.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#subCategoryFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#category_id').val(data.category_id).trigger('change');
                $('#name').val(data.name);
                if (data.image) {
                    let baseUrl = "{{ asset('') }}";
                    let fullImageUrl = baseUrl + data.image;
                    $('#imagePreview').attr('src', fullImageUrl);
                }

                $('#addSubcategoryTitle').addClass('d-none');
                $('#updateSubcategoryTitle').removeClass('d-none');

                $('#addSubCategoryBtn').addClass('d-none');
                $('#updateSubCategoryBtn').removeClass('d-none');
                $('#cancelSubCategoryBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateSubCategory() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.subcategories.update', ':id') }}";
        url = url.replace(':id', update_id);

        let category_id = $('#category_id').val();
        let name = $('#name').val();
        let image = $('#image')[0].files[0];

        // Prepare form data
        let formData = new FormData();
        formData.append('category_id', category_id);
        formData.append('name', name);
        formData.append('image', image);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetSubCategory();
                show_success('Sub Category Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.category_id) {
                    $('#categoryError').text(errors.category_id);
                    $('#category_id').val('').trigger('change');
                }
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
            }
        });
    }

    function deleteImage() {
        let id = $('#update_id').val();
        let preview = $('#imagePreview').attr('src');

        if(id !== null && id !== '' && preview !== '') {
            let url = "{{ route('admin.subcategories.removeImage', ':id') }}";
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
        let url = "{{ route('admin.subcategories.destroy', ':id') }}";
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
                        if(data == 'have_data') {
                            show_error('Cannot delete the subcategory because it has related child category.');
                            return;
                        }else {
                            show_success('Subcategory deleted successfully!');
                            $('.DataTable').DataTable().ajax.reload();
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the subcategory. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetSubCategory() {
        $('#update_id').val('');
        $('#categoryError').text('');
        $('#category_id').val('').trigger('change');

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#subCategoryFormBox').removeClass('show');

        $('#addSubcategoryTitle').removeClass('d-none');
        $('#updateSubcategoryTitle').addClass('d-none');

        $('#addSubCategoryBtn').removeClass('d-none');
        $('#updateSubCategoryBtn').addClass('d-none');
        $('#cancelSubCategoryBtn').addClass('d-none');
    }


</script>
@endpush
