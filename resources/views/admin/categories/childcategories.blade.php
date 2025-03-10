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
                        <button type="button" onclick="showChildCategoryForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="childCategoryFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addChildcategoryTitle">add Child Category</h4>
                            <h4 class="text-capitalize d-none" id="updateChildcategoryTitle">Update Child Category</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="childCategoryForm">
                                <!-- Product Sub Category -->
                                <div class="form-group mb-3">
                                    <label class="form-label" for="allSubcategory_id">Select Sub Category <span class="text-muted"></span></label>
                                    <select name="allSubcategory_id" class="form-control select2" id="allSubcategory_id">
                                    </select>
                                    <span class="text-danger" id="subCategoryError"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Child Category Name</label>
                                    <input type="hidden" id="update_id" value="">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Child Category Name...">
                                    <span class="text-danger" id="nameError"></span>
                                </div>

                                <div class="mb-3">
                                    <button type="button" onclick="addChildCategory();" class="btn btn-outline-success"id="addChildCategoryBtn"><i class="fa fa-plus me-2"></i>Add Child Category</button>
                                    <button type="button" onclick="updateChildCategory();" class="btn btn-outline-success d-none me-2" id="updateChildCategoryBtn"><i class="fa fa-share me-2"></i>Update Child Category</button>
                                    <button type="button" onclick="resetChildCategory();" class="btn btn-outline-danger d-none" id="cancelChildCategoryBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Child Category Name</th>
                                        <th>Sub Category Name</th>
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

    $(document).ready(function () {
        getAllSubCategory();
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
                    data: 'subcategory_id',
                    name: 'subcategory_id',
                    className: 'text-center',
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

    function showChildCategoryForm() {
        $('#childCategoryFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#categoryError').text('');
        $('#allSubcategory_id').val('').trigger('change');

        $('#addChildcategoryTitle').removeClass('d-none');
        $('#updateChildcategoryTitle').addClass('d-none');

        $('#addChildCategoryBtn').removeClass('d-none');
        $('#updateChildCategoryBtn').addClass('d-none');
        $('#cancelChildCategoryBtn').addClass('d-none');
    }

    function addChildCategory() {
        let url = "{{ route('admin.childcategories.store') }}";

        let subcategory_id = $('#allSubcategory_id').val();
        let name = $('#name').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('subcategory_id', subcategory_id);
        formData.append('name', name);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetChildCategory();
                show_success('Child Category Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.subcategory_id) {
                    $('#subcategoryError').text(errors.subcategory_id);
                    $('#subcategory_id').val('').trigger('change');
                }
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.childcategories.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {

                $('#childCategoryFormBox').addClass('show');
                $('#update_id').val(data.id);
                $('#allSubcategory_id').val(data.subcategory_id).trigger('change');
                $('#name').val(data.name);

                $('#addChildcategoryTitle').addClass('d-none');
                $('#updateChildcategoryTitle').removeClass('d-none');

                $('#addChildCategoryBtn').addClass('d-none');
                $('#updateChildCategoryBtn').removeClass('d-none');
                $('#cancelChildCategoryBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateChildCategory() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.childcategories.update', ':id') }}";
        url = url.replace(':id', update_id);

        let subcategory_id = $('#allSubcategory_id').val();
        let name = $('#name').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('subcategory_id', subcategory_id);
        formData.append('name', name);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetChildCategory();
                show_success('Child Category Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if(errors.category_id) {
                    $('#subcategoryError').text(errors.subcategory_id);
                    $('#subcategory_id').val('').trigger('change');
                }
                if(errors.name) {
                    $('#nameError').text(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
            }
        });
    }

    function destroy(id) {
        let url = "{{ route('admin.childcategories.destroy', ':id') }}";
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
                        show_success('Category deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the category. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetChildCategory() {
        $('#update_id').val('');
        $('#subcategoryError').text('');
        $('#allSubcategory_id').val('').trigger('change');

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#childCategoryFormBox').removeClass('show');

        $('#addChildcategoryTitle').removeClass('d-none');
        $('#updateChildcategoryTitle').addClass('d-none');

        $('#addChildCategoryBtn').removeClass('d-none');
        $('#updateChildCategoryBtn').addClass('d-none');
        $('#cancelChildCategoryBtn').addClass('d-none');
    }


</script>
@endpush
