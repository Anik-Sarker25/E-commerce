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
                                                    <select class="form-select" name="blood_group" id="blood_group">
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
                                                    <select name="marital_status" id="marital_status" class="form-select">
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
                                                    <select class="form-select" name="status" id="status">
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
                                                    <select class="form-select" name="engage_status" id="engage_status">
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Active Status</th>
                                        <th>Work Status</th>
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
                    data: 'image',
                    name: 'image',
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
                    data: 'phone',
                    name: 'phone',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'active_status',
                    name: 'active_status',
                    className: 'text-center',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'work_status',
                    name: 'work_status',
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

    function showDeliveryAgentForm() {
        $('#DeliveryAgentFormBox').collapse('toggle');

        $('#update_id').val('');
        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#phone_numberError').text('');
        $('#phone_number').val('');
        $('#phone_number').removeClass('is-invalid');

        $('#vehicle_numberError').text('');
        $('#vehicle_number').val('');
        $('#vehicle_number').removeClass('is-invalid');

        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#nid_numberError').text('');
        $('#nid_number').val('');
        $('#nid_number').removeClass('is-invalid');

        $('#blood_groupError').text('');
        $('#blood_group').val('');
        $('#blood_group').val('').trigger('change');

        $('#addressError').text('');
        $('#address').val('');
        $('#address').removeClass('is-invalid');

        $('#marital_statusError').text('');
        $('#marital_status').val('');
        $('#marital_status').val('').trigger('change');

        $('#birthdayError').text('');
        $('#birthday').val('');
        $('#birthday').removeClass('is-invalid');

        $('#addDeliveryAgentTitle').removeClass('d-none');
        $('#updateDeliveryAgentTitle').addClass('d-none');

        $('#addDeliveryAgentBtn').removeClass('d-none');
        $('#updateDeliveryAgentBtn').addClass('d-none');
    }

    function addDeliveryAgent() {
        let url = "{{ route('admin.deliveryAgents.store') }}";

        let name = $('#name').val();
        let phone_number = $('#phone_number').val();
        let vehicle_number = $('#vehicle_number').val();
        let image = $('#image')[0].files[0];
        let nid_number = $('#nid_number').val();
        let blood_group = $('#blood_group').val();
        let address = $('#address').val();
        let marital_status = $('#marital_status').val();
        let birthday = $('#birthday').val();
        let status = $('#status').val();
        let engage_status = $('#engage_status').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone_number', phone_number);
        formData.append('vehicle_number', vehicle_number);
        formData.append('image', image);
        formData.append('nid_number', nid_number);
        formData.append('blood_group', blood_group);
        formData.append('address', address);
        formData.append('marital_status', marital_status);
        formData.append('birthday', birthday);
        formData.append('status', status);
        formData.append('engage_status', engage_status);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDeliveryAgent();
                show_success('Delivery Agent Added Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {

                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                // Handle Laravel validation errors (422)
                if (error.status === 422 && error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    for (let key in errors) {
                        if ($(`#${key}`).is('select')) {
                            $(`#${key}Error`).html(errors[key]);
                        } else {
                            $(`#${key}Error`).html(errors[key]);
                            $(`#${key}`).val('');
                            $(`#${key}`).addClass('is-invalid');
                        }
                    }
                } else {
                    // Handle other server errors like 500 or database constraint issues
                    let message = 'An unexpected error occurred.';

                    show_error(message);
                }
            }
        });
    }

    function edit(id){
        var url = "{{ route('admin.deliveryAgents.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                let data = response.data;
                let birthday = response.birthday;
                $('#DeliveryAgentFormBox').collapse('toggle');
                $('#update_id').val(data.id);
                $('#category_id').val(data.category_id).trigger('change');
                $('#name').val(data.name);
                $('#phone_number').val(data.phone);
                $('#vehicle_number').val(data.vehicle_number);
                $('#nid_number').val(data.nid_number);
                $('#blood_group').val(data.blood_group).trigger('change');
                $('#address').val(data.address);
                $('#marital_status').val(data.marital_status).trigger('change');
                $('#birthday').val(birthday);
                $('#status').val(data.active_status).trigger('change');
                $('#engage_status').val(data.work_status).trigger('change');
                $('#birthday').val();

                if (data.image) {
                    let baseUrl = "{{ asset('') }}";
                    let fullImageUrl = baseUrl + data.image;
                    $('#imagePreview').attr('src', fullImageUrl);
                }else {
                    $('#imagePreview').attr('src', '');
                }

                $('#addDeliveryAgentTitle').addClass('d-none');
                $('#updateDeliveryAgentTitle').removeClass('d-none');

                $('#addDeliveryAgentBtn').addClass('d-none');
                $('#updateDeliveryAgentBtn').removeClass('d-none');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

        });
    }

    function updateDeliveryAgent() {
        let update_id = $('#update_id').val();
        let url = "{{ route('admin.deliveryAgents.update', ':id') }}";
        url = url.replace(':id', update_id);


        let name = $('#name').val();
        let phone_number = $('#phone_number').val();
        let vehicle_number = $('#vehicle_number').val();
        let image = $('#image')[0].files[0];
        let nid_number = $('#nid_number').val();
        let blood_group = $('#blood_group').val();
        let address = $('#address').val();
        let marital_status = $('#marital_status').val();
        let birthday = $('#birthday').val();
        let status = $('#status').val();
        let engage_status = $('#engage_status').val();

        // Prepare form data
        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone_number', phone_number);
        formData.append('vehicle_number', vehicle_number);
        formData.append('image', image);
        formData.append('nid_number', nid_number);
        formData.append('blood_group', blood_group);
        formData.append('address', address);
        formData.append('marital_status', marital_status);
        formData.append('birthday', birthday);
        formData.append('status', status);
        formData.append('engage_status', engage_status);


        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                resetDeliveryAgent();
                show_success('Delivery Agent Updated Successfully!');

                $('.DataTable').DataTable().ajax.reload();
            },
            error: function(error) {
                $('[id$="Error"]').html(''); // Clear all error message containers
                $('.is-invalid').removeClass('is-invalid');

                // Handle Laravel validation errors (422)
                if (error.status === 422 && error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    for (let key in errors) {
                        if ($(`#${key}`).is('select')) {
                            $(`#${key}Error`).html(errors[key]);
                        } else {
                            $(`#${key}Error`).html(errors[key]);
                            $(`#${key}`).val('');
                            $(`#${key}`).addClass('is-invalid');
                        }
                    }
                } else {
                    // Handle other server errors like 500 or database constraint issues
                    let message = 'An unexpected error occurred.';

                    show_error(message);
                }
            }
        });
    }

    function deleteImage() {
        let id = $('#update_id').val();
        let preview = $('#imagePreview').attr('src');

        if(id !== null && id !== '' && preview !== '') {
            let url = "{{ route('admin.deliveryAgents.removeImage', ':id') }}";
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
        let url = "{{ route('admin.deliveryAgents.destroy', ':id') }}";
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
                            show_error('Cannot delete the agent because it has related data.');
                            return;
                        }else {
                            show_success('Agent deleted successfully!');
                            $('.DataTable').DataTable().ajax.reload();
                        }
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the agent. Please try again.');
                        }
                    }
                });
            }
        });
    }

    function resetDeliveryAgent() {
        $('#update_id').val('');

        $('#nameError').text('');
        $('#name').val('');
        $('#name').removeClass('is-invalid');

        $('#phone_numberError').text('');
        $('#phone_number').val('');
        $('#phone_number').removeClass('is-invalid');

        $('#vehicle_numberError').text('');
        $('#vehicle_number').val('');
        $('#vehicle_number').removeClass('is-invalid');

        $('#imageError').text('');
        $('#image').val('');
        $('#image').removeClass('is-invalid');
        $('#imagePreview').attr('src', '');

        $('#nid_numberError').text('');
        $('#nid_number').val('');
        $('#nid_number').removeClass('is-invalid');

        $('#blood_groupError').text('');
        $('#blood_group').val('');
        $('#blood_group').val('').trigger('change');

        $('#addressError').text('');
        $('#address').val('');
        $('#address').removeClass('is-invalid');

        $('#marital_statusError').text('');
        $('#marital_status').val('');
        $('#marital_status').val('').trigger('change');

        $('#birthdayError').text('');
        $('#birthday').val('');
        $('#birthday').removeClass('is-invalid');

        $('#DeliveryAgentFormBox').collapse('toggle');

        $('#addDeliveryAgentTitle').removeClass('d-none');
        $('#updateDeliveryAgentTitle').addClass('d-none');

        $('#addDeliveryAgentBtn').removeClass('d-none');
        $('#updateDeliveryAgentBtn').addClass('d-none');
    }

    function engageView(id){
        let url = "{{ route('admin.deliveryAgents.engageView', ':id') }}";
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
                show_warning('Product Data Not Found!');
            }
        });
    }


</script>
@endpush
