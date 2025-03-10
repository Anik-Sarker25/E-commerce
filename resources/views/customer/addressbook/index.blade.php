@extends('layouts.customer.app')
@push('css')
@include('layouts.customer.sidebar_css')
<style>
    td {
        border: none !important;
    }
    tr {
        border-bottom: 1px solid #ddd;
    }
    th {
        padding: 15px 8px !important;
    }
    .table {
        text-transform: capitalize;
    }
    .table-responsive {
        margin-top: 0 !important;
    }

    .delivery_point {
        display: flex;
    }
    .delivery_point label {
        border: 1px solid #ddd;
        margin-right: 12px;
        padding: 18px;
        border-radius: 4px;
        overflow: hidden;
        color: #666666;
        font-weight: normal;
    }
    .delivery_point input {
        display: none;
    }
    .delivery_point label svg {
        font-size: 18px;
        margin-right: 5px;
        color: #ddd;
    }

    .delivery_point label.active,
    .delivery_point label.active svg {
        border-color: #f36;
        color: #f36;
    }
    .editBtn, .deleteBtn {
        border: none !important;
        background: transparent;
        color: #333333 !important;
        padding: 0;
    }
    .editBtn:hover,
    .deleteBtn:hover {
        color: #f36 !important;
        background: none !important;
    }
    .table.dataTable {
        border-collapse: collapse !important;
    }
    table.dataTable thead th {
        border-bottom: none !important;
        font-size: 12px;
    }
    table.dataTable tbody td {
        font-size: 12px;
    }

    .d-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .distance {
        padding: 0 12px;
    }
    .default_address_cl {
        display: none;
    }
</style>
@endpush

@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <div class="row" style="padding-top: 20px;">
                <!-- Main Content -->
                <div class="col-md-9 col-md-push-3  col-main">

                    <div class="row addressBook">
                        <div class="col-md-12">

                            <!-- Add New Address collapse -->
                            <div id="addAddressCollapse" class="collapse">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title addAddress">Add New Address</h5>
                                        <h5 class="panel-title updateAddress hidden">Edit Address</h5>
                                    </div>
                                    <div class="panel-body">
                                        <form id="addAddressForm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name...">
                                                        <span class="text-danger" id="nameError"></span>
                                                        <input type="hidden" id="update_id" value="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phoneNumber">Phone Number <span class="text-danger">*</span></label>
                                                        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="01XXXXXXXXX">
                                                        <span class="text-danger" id="phoneError"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="form-label">Select delivery point</label>
                                                    </div>
                                                    <div class="delivery_point">
                                                        <div class="form-group">
                                                            <input type="radio" name="place" value="{{ App\Helpers\Constant::DELIVERY_PLACE['home'] }}" id="home" checked>
                                                            <label for="home" class="active home"><i class="fa-solid fa-house"></i>home</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="radio"name="place" value="{{ App\Helpers\Constant::DELIVERY_PLACE['office'] }}" id="office">
                                                            <label for="office" class="office"><i class="fa-solid fa-briefcase"></i>office</label>
                                                        </div>

                                                        <span class="text-danger" id="placeError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="division">Division <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="division" id="division">
                                                        </select>
                                                        <span class="text-danger" id="divisionError"></span>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="district">District <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="district" id="district">
                                                        </select>
                                                        <span class="text-danger" id="districtError"></span>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="upazila">Upazila <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="upazila" id="upazila">
                                                        </select>
                                                        <span class="text-danger" id="upazilaError"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" name="address" placeholder="please enter your address">
                                                        <span class="text-danger" id="addressError"></span>
                                                    </div>

                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-default" id="cancelBtn">Cancel</button>
                                                        <button type="button" id="storeAddressBtn" class="btn">Add Address</button>
                                                        <button type="button" id="updateAddressBtn" class="btn hidden">Update Address</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div id="showAddress" class="collapse">
                                <div class="panel panel-default">
                                    <div class="panel-heading d-flex">
                                        <h5 class="panel-title">Address Book</h5>
                                        <div class="text-right text-capitalize">
                                            <a href="javascript:void(0);" class="make-default-billing">
                                                Make Default Billing Address
                                            </a>
                                            <span class="distance">/</span>
                                            <a href="javascript:void(0);" class="make-default-shipping">
                                                Make Default Shipping Address
                                            </a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover DataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th style="width: 250px;">Address</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">By Default</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="buttons view text-right" style="margin-top: 16px;">
                                            <button type="button" id="addAddressBtn" class="btn"><i class="fa-solid fa-plus"></i> Add New Address</button>
                                            <button type="button" id="saveBtn" class="btn btn-default hidden"><i class="fa-solid fa-check"></i> save</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!-- Main Content -->

                <!-- Sidebar -->
                <div class="col-md-3 col-md-pull-9  col-sidebar">

                   @include('layouts.customer.sidebar')


                </div>
                <!-- Sidebar -->



            </div>
        </div>


    </main>
    <!-- end MAIN -->

@endsection

@push('js')

@include('layouts.admin.all_select2')

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
            paging: false, // Enable pagination
            searching: false, // Disable search bar
            info: false,
            ajax: {
                url: "{{ url()->current() }}", // Replace with your route
                type: 'GET',
                data: function(d) {
                    // Pass additional parameters here if needed
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error("Error: " + textStatus, errorThrown);
                    alert('Failed to load data. Please try again.'); // Notify user
                },
            },
            columns: [
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-left',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'address',
                    name: 'address',
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
                    data: 'is_default',
                    name: 'is_default',
                    className: 'text-center',
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ]
        });

    });



    $(document).ready(function() {
        $('#showAddress').collapse('show');

        getDivision();
        division();
        district();
        upazila();

    });

    $('#addAddressBtn').on('click', function() {
        showAddressCollapse();
    });
    function showAddressCollapse() {
        $('#addAddressCollapse').collapse('show');
        $('#showAddress').collapse('hide');
        document.title = 'Create Address';
    }

    $('#cancelBtn').on('click', function() {
        $('#addAddressCollapse').collapse('hide');
        $('#showAddress').collapse('show');
        document.title = "{{ $pageTitle }}";
        formReset();
    });

    $(document).on('click', '.delivery_point label', function() {
        $('.delivery_point label').removeClass('active');
        $(this).addClass('active');
    });

    // shipping and billing changes
    $(document).ready(function () {
        let billing = "{{ App\Helpers\Constant::DEFAULT_ADDRESS['billing'] }}";
        let shipping = "{{ App\Helpers\Constant::DEFAULT_ADDRESS['shipping'] }}";
        let both = "{{ App\Helpers\Constant::DEFAULT_ADDRESS['both'] }}";

        $('.make-default-billing').on('click', function (event) {
            event.preventDefault();

            // Show the address input and remove hidden classes
            $('.default_address_cl').css({
                'display': 'block',
                'margin': 'auto',
            });
            $('#saveBtn').removeClass('hidden');
            $('.hide_show, #addAddressBtn').css({
                'display': 'none',
            });

            // Set the radio button for the correct default address
            $('.default_address_cl').each(function () {
                if ($(this).val() === both || $(this).val() === billing) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            // On click of the radio button, assign "billing" value
            $('.default_address_cl').on('click', function () {
                if ($(this).prop('checked')) {
                    $(this).val(billing);
                }
            });
        });

        $('.make-default-shipping').on('click', function (event) {
            event.preventDefault();

            // Show the address input and remove hidden classes
            $('.default_address_cl').css({
                'display': 'block',
                'margin': 'auto',
            });
            $('#saveBtn').removeClass('hidden');
            $('.hide_show, #addAddressBtn').css({
                'display': 'none',
            });

            // Set the radio button for the correct default address
            $('.default_address_cl').each(function () {
                if ($(this).val() === both || $(this).val() === shipping) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            // On click of the radio button, assign "shipping" value
            $('.default_address_cl').on('click', function () {
                if ($(this).prop('checked')) {
                    $(this).val(shipping);
                }
            });
        });
    });




    // backend data processing
    $('#storeAddressBtn').on('click', function() {
        let url = "{{ route('customer.addressBook.store') }}";

        let name = $('#name').val();
        let phone = $('#phoneNumber').val();
        let place = $('input[name="place"]:checked').val() || '';
        let division = $('#division').val();
        let district = $('#district').val();
        let upazila = $('#upazila').val();
        let address = $('#address').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('place', place);
        formData.append('division', division);
        formData.append('district', district);
        formData.append('upazila', upazila);
        formData.append('address', address);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                formReset();
                $('#addAddressCollapse').collapse('hide');
                $('#showAddress').collapse('show');
                document.title = "{{ $pageTitle }}";

                $('.DataTable').DataTable().ajax.reload();

                show_success('Address Created Successfully');

            },
            error: function(error) {
                $('#nameError').html('');
                $('#phoneError').html('');
                $('#divisionError').html('');
                $('#districtError').html('');
                $('#upazilaError').html('');
                $('#addressError').html('');

                $('#name').removeClass('is-invalid');
                $('#phoneNumber').removeClass('is-invalid');
                $('#division').removeClass('is-invalid');
                $('#district').removeClass('is-invalid');
                $('#upazila').removeClass('is-invalid');
                $('#address').removeClass('is-invalid');

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;

                    if (errors.name) {
                        $('#nameError').html(errors.name);
                        $('#name').val('');
                        $('#name').addClass('is-invalid');
                    }
                    if (errors.phone) {
                        $('#phoneError').html(errors.phone);
                        $('#phoneNumber').val('');
                        $('#phoneNumber').addClass('is-invalid');
                    }
                    if (errors.division) {
                        $('#divisionError').html(errors.division);
                        $('#division').val('');
                        $('#division').addClass('is-invalid');
                    }
                    if (errors.district) {
                        $('#districtError').html(errors.district);
                        $('#district').val('');
                        $('#district').addClass('is-invalid');
                    }
                    if (errors.upazila) {
                        $('#upazilaError').html(errors.upazila);
                        $('#upazila').val('');
                        $('#upazila').addClass('is-invalid');
                    }
                    if (errors.address) {
                        $('#addressError').html(errors.address);
                        $('#address').val('');
                        $('#address').addClass('is-invalid');
                    }
                }
            }
        });
    });

    function edit(id){
        var url = "{{ route('customer.addressBook.edit', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                showAddressCollapse();
                document.title = 'Edit Address';
                $('.addAddress').addClass('hidden');
                $('.updateAddress').removeClass('hidden');
                $('#storeAddressBtn').addClass('hidden');
                $('#updateAddressBtn').removeClass('hidden');

                $('#update_id').val(data.id);
                $('#name').val(data.name);
                $('#phoneNumber').val(data.phone);

                let home = "{{ App\Helpers\Constant::DELIVERY_PLACE['home'] }}";
                let office = "{{ App\Helpers\Constant::DELIVERY_PLACE['office'] }}";

                if(data.delivery_place === home) {
                    $('#home').val(data.delivery_place).prop('checked', true);
                    $('label.home').addClass('active');
                    $('label.office').removeClass('active');
                }
                else if(data.delivery_place === office) {
                    $('#office').val(data.delivery_place).prop('checked', true);
                    $('label.office').addClass('active');
                    $('label.home').removeClass('active');
                }

                $('#division').val(data.state).trigger('change');

                setTimeout(() => {
                    $('#district').val(data.city).trigger('change');
                }, 500);

                setTimeout(() => {
                    $('#upazila').val(data.upazila).trigger('change');
                }, 1000);
                $('#address').val(data.address);
            }

        });
    }

    $('#updateAddressBtn').on('click', function() {
        let id = $('#update_id').val();
        let url = "{{ route('customer.addressBook.update', ':id') }}";
        url = url.replace(':id', id);

        let name = $('#name').val();
        let phone = $('#phoneNumber').val();
        let place = $('input[name="place"]:checked').val() || '';
        let division = $('#division').val();
        let district = $('#district').val();
        let upazila = $('#upazila').val();
        let address = $('#address').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('place', place);
        formData.append('division', division);
        formData.append('district', district);
        formData.append('upazila', upazila);
        formData.append('address', address);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                formReset();
                $('#addAddressCollapse').collapse('hide');
                $('#showAddress').collapse('show');
                document.title = "{{ $pageTitle }}";

                $('.DataTable').DataTable().ajax.reload();

                show_success('Address Updated Successfully');
            },
            error: function(error) {
                $('#nameError').html('');
                $('#phoneError').html('');
                $('#divisionError').html('');
                $('#districtError').html('');
                $('#upazilaError').html('');
                $('#addressError').html('');

                $('#name').removeClass('is-invalid');
                $('#phoneNumber').removeClass('is-invalid');
                $('#division').removeClass('is-invalid');
                $('#district').removeClass('is-invalid');
                $('#upazila').removeClass('is-invalid');
                $('#address').removeClass('is-invalid');

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;

                    if (errors.name) {
                        $('#nameError').html(errors.name);
                        $('#name').val('');
                        $('#name').addClass('is-invalid');
                    }
                    if (errors.phone) {
                        $('#phoneError').html(errors.phone);
                        $('#phoneNumber').val('');
                        $('#phoneNumber').addClass('is-invalid');
                    }
                    if (errors.division) {
                        $('#divisionError').html(errors.division);
                        $('#division').val('');
                        $('#division').addClass('is-invalid');
                    }
                    if (errors.district) {
                        $('#districtError').html(errors.district);
                        $('#district').val('');
                        $('#district').addClass('is-invalid');
                    }
                    if (errors.upazila) {
                        $('#upazilaError').html(errors.upazila);
                        $('#upazila').val('');
                        $('#upazila').addClass('is-invalid');
                    }
                    if (errors.address) {
                        $('#addressError').html(errors.address);
                        $('#address').val('');
                        $('#address').addClass('is-invalid');
                    }
                }
            }
        });
    });

    function destroy(id) {
        let url = "{{ route('customer.addressBook.destroy', ':id') }}";
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
                        show_success('address deleted successfully!');
                        $('.DataTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.error) {
                            show_error(error.responseJSON.error);
                        }else {
                            show_error('Failed to delete the address. Please try again.');
                        }
                    }
                });
            }
        });
    }


    // set default billing or shipping address
    $('#saveBtn').on('click', function() {

        let id = $('.default_address_cl:checked').attr('id');
        let url = "{{ route('customer.addressBook.defaultAddress', ':id') }}";
        url = url.replace(':id', id);

        let default_address = $('input[name="default_address"]:checked').val();

        let formData = new FormData();
        formData.append('default_address', default_address);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                formReset();
                $('.DataTable').DataTable().ajax.reload();

                show_success(response.message);
                // show_success('Address Updated Successfully');
            },
            error: function(error) {
                show_error('An error occurred! Please try again')

                // let errors = error.responseJSON.errors;

                // if (errors.default_address) {
                //     show_error(errors.default_address);
                // }
            }
        });
    });


    function formReset() {
        $('#update_id').val('');
        $('#name').val('');
        $('#phoneNumber').val('');
        $('#division').val('').trigger('change');
        $('#district').val('').trigger('change');
        $('#upazila').val('').trigger('change');
        $('#address').val('');

        $('#nameError').html('');
        $('#phoneError').html('');
        $('#divisionError').html('');
        $('#districtError').html('');
        $('#upazilaError').html('');
        $('#addressError').html('');

        $('#name').removeClass('is-invalid');
        $('#phoneNumber').removeClass('is-invalid');
        $('#division').removeClass('is-invalid');
        $('#district').removeClass('is-invalid');
        $('#upazila').removeClass('is-invalid');
        $('#address').removeClass('is-invalid');

        $('#home').val('').prop('checked', true);
        $('#office').val('').prop('checked', false);

        $('.addAddress').removeClass('hidden');
        $('.updateAddress').addClass('hidden');
        $('#storeAddressBtn').removeClass('hidden');
        $('#updateAddressBtn').addClass('hidden');

        $('label.home').addClass('active');
        $('label.office').removeClass('active');

        document.title = "{{ $pageTitle }}";
    }
</script>


@endpush
