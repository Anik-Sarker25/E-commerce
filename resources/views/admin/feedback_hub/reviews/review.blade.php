@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
    @php
        use App\Helpers\Constant;
        $activeStatus = Constant::STATUS;
        $engageStatus = Constant::AGENT_STATUS;
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
                        <button type="button" onclick="showDeliveryAgentForm();" class="btn btn-outline-success">
                            Add New
                        </button>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Notice Form -->
                <div class="collapse mb-4" id="DeliveryAgentFormBox">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-capitalize" id="addDeliveryAgentTitle">add agent</h4>
                            <h4 class="text-capitalize d-none" id="updateDeliveryAgentTitle">update agent</h4>
                        </div>
                        <div class="card-body pb-2">
                            <form id="deliveryAgentForm">
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
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="name">Delivery Agent Name <span class="text-danger">*</span></label>
                                                    <input type="hidden" id="update_id" value="">
                                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name...">
                                                    <span class="text-danger" id="nameError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="tel" name="phone_number" class="form-control" id="phone_number" placeholder="01XXXXXXXXX">
                                                    <span class="text-danger" id="phone_numberError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="vehicle_number">Vehicle  number ( <small>Dhaka-Metro-Gha 11-5432</small> ) <span class="text-danger">*</span></label>
                                                    <input type="text" name="vehicle_number" class="form-control" id="vehicle_number" placeholder="Enter Vehicle Number..."> 
                                                    <span class="text-danger" id="vehicle_numberError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="image">Image ( <small>170 X 100</small> )</label>
                                                    <input type="file" name="image" class="form-control" id="image">
                                                    <span class="text-danger" id="imageError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="nid_number">NID  number</label>
                                                    <input type="number" name="nid_number" class="form-control" id="nid_number" placeholder="Enter NID Number..."> 
                                                    <span class="text-danger" id="nid_numberError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="blood_group">Blood Group</label>
                                                    <select class="form-control select2" name="blood_group" id="blood_group">
                                                        <option value="">Select Option</option>
                                                        <option value="A+">A+</option>
                                                        <option value="A-">A-</option>
                                                        <option value="B+">B+</option>
                                                        <option value="B-">B-</option>
                                                        <option value="AB+">AB+</option>
                                                        <option value="AB-">AB-</option>
                                                        <option value="O+">O+</option>
                                                        <option value="O-">O-</option>
                                                    </select>
                                                    <span class="text-danger" id="blood_groupError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="address">Address</label>
                                                    <textarea name="address" class="form-control" id="address" rows="1" placeholder="Enter Address..."></textarea>
                                                    <span class="text-danger" id="addressError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="marital_status">Marital Status</label>
                                                    <select name="marital_status" id="marital_status" class="form-control select2">
                                                        <option value="">Select Option</option>
                                                        <option value="Married">Married</option>
                                                        <option value="Unmarried">Unmarried</option>
                                                    </select>
                                                    <span class="text-danger" id="marital_statusError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="birthday">Date of Birth</label>
                                                    <input type="text" name="birthday" class="form-control datepicker" id="birthday" placeholder="Select Date" value="">
                                                    <span class="text-danger" id="birthdayError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="status">Active Status (default active)</label>
                                                    <select class="form-control select2" name="status" id="status">
                                                        @foreach ($activeStatus as $status => $key)
                                                            <option value="{{ $key }}">{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="statusError"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="engage_status">Engage Status (default Free)</label>
                                                    <select class="form-control select2" name="engage_status" id="engage_status">
                                                        @foreach ($engageStatus as $status => $key)
                                                            <option value="{{ $key }}">{{ ucfirst($status) }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger" id="engage_statusError"></span>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="mb-3">
                                            <button type="button" onclick="addDeliveryAgent();" class="btn btn-outline-success"id="addDeliveryAgentBtn"><i class="fa fa-plus me-2"></i>Add Agent</button>
                                            <button type="button" onclick="updateDeliveryAgent();" class="btn btn-outline-success d-none me-2" id="updateDeliveryAgentBtn"><i class="fa fa-share me-2"></i>Update Agent</button>
                                            <button type="button" onclick="resetDeliveryAgent();" class="btn btn-outline-danger" id="cancelDeliveryAgentBtn"><i class="fa fa-times me-2"></i>Cencel</button>
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
                                        <th>Product Name</th>
                                        <th>Invoice Id</th>
                                        <th>Customer Name</th>
                                        <th>Quality Rating</th>
                                        <th>Delivery Rating</th>
                                        <th>Quality Review</th>
                                        <th>Delivery Review</th>
                                        <th>Image</th>
                                        <th>Admin Response</th>
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
                    data: 'product_id',
                    name: 'product_id',
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
                    data: 'user_id',
                    name: 'user_id',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'rating',
                    name: 'rating',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'delivery_rating',
                    name: 'delivery_rating',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'review',
                    name: 'review',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'delivery_review',
                    name: 'delivery_review',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'image',
                    name: 'image',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'admin_comment',
                    name: 'admin_comment',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'status',
                    name: 'status',
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

    function changeStatus(status, id) {
        let url = "{{ route('admin.feedbackHub.reviews.updateStatus', ':id') }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change status!",
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
                        let label = data.label; // pending, approved, rejected
                        show_success(`Review ${label} successfully!`);
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        } else {
                            show_error('Failed to change status. Please try again.');
                        }
                    }
                });
            }
        });

    }

  

    function destroy(id) {
        let url = "{{ route('admin.feedbackHub.reviews.destroy', ':id') }}";
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
                        show_success('Review deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the review. Please try again.');
                        }
                    }
                });
            }
        });
    }



</script>
@endpush
