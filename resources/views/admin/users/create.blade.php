@extends('layouts.admin.app')

@section('title', 'Settings')
@section('content')
    @php
        $genders = App\Helpers\Constant::GENDER;
        $activeStatus = App\Helpers\Constant::USER_STATUS;
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
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success">Users list</a>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- BEGIN Users Form -->
                <div class="card">
                    <div class="card-body pb-2">
                        <form id="userForm">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name">Username <span class="text-danger">*</span></label>
                                        <input type="hidden" id="update_id" value="{{ $user->id ?? '' }}">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name..." value="{{ $user->name ?? '' }}">
                                        <span class="text-danger" id="nameError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="example@address.com" value="{{ $user->email ?? '' }}">
                                        <span class="text-danger" id="emailError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="01XXXXXXXX" value="{{ $user->phone ?? '' }}">
                                        <span class="text-danger" id="phoneError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="gender">Gender</label>
                                        <select class="form-select" name="gender" id="gender">
                                            <option value="">Select Gender</option>
                                            @foreach ($genders as $gender => $key)
                                                <option value="{{ $key }}" {{ isset($user->gender) && $user->gender == $key ? 'selected' : '' }}>{{ ucfirst($gender) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="genderError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="birthday">Date of Birth</label>
                                        <input type="text" name="birthday" class="form-control datepicker" id="birthday" placeholder="Select Date" value="{{ isset($user->birthday) && $user->birthday ? dateFormat2($user->birthday) : '' }}">
                                        <span class="text-danger" id="birthdayError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="country">Country</label>
                                        <select class="form-select" name="country" id="country">
                                        </select>
                                        <span class="text-danger" id="countryError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="division">Division</label>
                                        <select class="form-select" name="division" id="division">
                                        </select>
                                        <span class="text-danger" id="divisionError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="district">District</label>
                                        <select class="form-select" name="district" id="district">
                                        </select>
                                        <span class="text-danger" id="districtError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="upazila">Upazila</label>
                                        <select class="form-select" name="upazila" id="upazila">
                                        </select>
                                        <span class="text-danger" id="upazilaError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="address">Address <span class="text-danger">*</span></label>
                                        <textarea name="address" class="form-control" id="address" rows="1" placeholder="Enter Address...">{{ $user->address ?? '' }}</textarea>
                                        <span class="text-danger" id="addressError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4 {{ isset($user->password) && $user->password ? 'd-none' : '' }}">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" {{ isset($user->password) && $user->password ? 'readonly' : '' }} name="password" class="form-control" id="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                        <span class="text-danger" id="passwordError"></span>
                                    </div>
                                </div>
                                <div class="col-xl-4 {{ isset($user->password) && $user->password ? 'd-none' : '' }}">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" {{ isset($user->password) && $user->password ? 'readonly' : '' }} name="confirm_password" class="form-control" id="confirm_password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                        <span class="text-danger" id="confirm_passwordError"></span>
                                    </div>
                                </div>
                                <div class="@if(isset($user->status)) col-xl-4 @else col-xl-12 @endif">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="status">Status (default active)</label>
                                        <select class="form-select" name="status" id="status">
                                            @foreach ($activeStatus as $status => $key)
                                                <option value="{{$key }}" {{ isset($user->status) && $user->status == $key ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="statusError"></span>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="text-left">
                                        @if (Request::is('admin/users/create'))
                                            <button type="button" onclick="addUser();" class="btn btn-outline-success mr-2 mb-2"><i class="fa fa-plus me-2"></i>Add User</button>
                                        @elseif (Request::is('admin/users/edit*'))
                                            <button type="button" onclick="updateUser();" class="btn btn-outline-success mr-2 mb-2"><i class="fa fa-share me-2"></i>Update User</button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <x-card-arrow />
                </div>
                <!-- END Users Form -->

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
        @if ($user != '')
            setTimeout(() => {
                $('#country').val({{ $user->country_id }}).trigger('change');
                $('#division').val({{ $user->division_id }}).trigger('change');

                setTimeout(() => {
                    $('#district').val({{ $user->district_id }}).trigger('change');
                }, 1000);

                setTimeout(() => {
                    $('#upazila').val({{ $user->upazila_id }}).trigger('change');
                }, 1500);
            }, 500);
        @endif
        getCountry();
        getDivision();
        division();
        district();
        upazila();
    });

    function addUser() {

        let url = "{{ route('admin.users.store') }}";

        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let gender = $('#gender').val();
        let birthday = $('#birthday').val();
        let country = parseInt($('#country').val()) || 0;
        let division = parseInt($('#division').val()) || 0;
        let district = parseInt($('#district').val()) || 0;
        let upazila = parseInt($('#upazila').val()) || 0;
        let address = $('#address').val();
        let password = $('#password').val();
        let confirm_password = $('#confirm_password').val();
        let status = $('#status').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('gender', gender);
        formData.append('birthday', birthday);
        formData.append('country', country);
        formData.append('division', division);
        formData.append('district', district);
        formData.append('upazila', upazila);
        formData.append('address', address);
        formData.append('password', password);
        formData.append('confirm_password', confirm_password);
        formData.append('status', status);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                show_success('User Added Successfully');
                resetForm();
            },
            error: function(error) {
                $('#nameError').html('');
                $('#emailError').html('');
                $('#phoneError').html('');
                $('#birthdayError').html('');
                $('#addressError').html('');
                $('#passwordError').html('');
                $('#confirm_passwordError').html('');

                $('#name').removeClass('is-invalid');
                $('#email').removeClass('is-invalid');
                $('#phone').removeClass('is-invalid');
                $('#birthday').removeClass('is-invalid');
                $('#address').removeClass('is-invalid');
                $('#password').removeClass('is-invalid');
                $('#confirm_password').removeClass('is-invalid');

                let errors = error.responseJSON.errors;

                if (errors.name) {
                    $('#nameError').html(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if (errors.email) {
                    $('#emailError').html(errors.email);
                    $('#email').val('');
                    $('#email').addClass('is-invalid');
                }
                if (errors.phone) {
                    $('#phoneError').html(errors.phone);
                    $('#phone').val('');
                    $('#phone').addClass('is-invalid');
                }
                if (errors.birthday) {
                    $('#birthdayError').html(errors.birthday);
                    $('#birthday').val('');
                    $('#birthday').addClass('is-invalid');
                }
                if (errors.address) {
                    $('#addressError').html(errors.address);
                    $('#address').val('');
                    $('#address').addClass('is-invalid');
                }
                if (errors.password) {
                    $('#passwordError').html(errors.password);
                    $('#password').val('');
                    $('#password').addClass('is-invalid');
                }
                if (errors.confirm_password) {
                    $('#confirm_passwordError').html(errors.confirm_password);
                    $('#confirm_password').val('');
                    $('#confirm_password').addClass('is-invalid');
                }
            }
        });
    }


    function updateUser() {
        let id = $('#update_id').val();
        let url = "{{ route('admin.users.update', ':id') }}";
        url = url.replace(':id', id);

        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let gender = $('#gender').val();
        let birthday = $('#birthday').val();
        let country = parseInt($('#country').val()) || 0;
        let division = parseInt($('#division').val()) || 0;
        let district = parseInt($('#district').val()) || 0;
        let upazila = parseInt($('#upazila').val()) || 0;
        let address = $('#address').val();
        let password = $('#password').val();
        let confirm_password = $('#confirm_password').val();
        let status = $('#status').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('gender', gender);
        formData.append('birthday', birthday);
        formData.append('country', country);
        formData.append('division', division);
        formData.append('district', district);
        formData.append('upazila', upazila);
        formData.append('address', address);
        formData.append('password', password);
        formData.append('confirm_password', confirm_password);
        formData.append('status', status);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                show_success('User Updated Successfully');
                resetForm();
                setTimeout(function() {
                    window.location.href = "{{ route('admin.users.index') }}";
                }, 3000);
            },
            error: function(error) {
                $('#nameError').html('');
                $('#emailError').html('');
                $('#phoneError').html('');
                $('#birthdayError').html('');
                $('#addressError').html('');
                $('#passwordError').html('');
                $('#confirm_passwordError').html('');

                $('#name').removeClass('is-invalid');
                $('#email').removeClass('is-invalid');
                $('#phone').removeClass('is-invalid');
                $('#birthday').removeClass('is-invalid');
                $('#address').removeClass('is-invalid');
                $('#password').removeClass('is-invalid');
                $('#confirm_password').removeClass('is-invalid');

                let errors = error.responseJSON.errors;

                if (errors.name) {
                    $('#nameError').html(errors.name);
                    $('#name').val('');
                    $('#name').addClass('is-invalid');
                }
                if (errors.email) {
                    $('#emailError').html(errors.email);
                    $('#email').val('');
                    $('#email').addClass('is-invalid');
                }
                if (errors.phone) {
                    $('#phoneError').html(errors.phone);
                    $('#phone').val('');
                    $('#phone').addClass('is-invalid');
                }
                if (errors.birthday) {
                    $('#birthdayError').html(errors.birthday);
                    $('#birthday').val('');
                    $('#birthday').addClass('is-invalid');
                }
                if (errors.address) {
                    $('#addressError').html(errors.address);
                    $('#address').val('');
                    $('#address').addClass('is-invalid');
                }
                if (errors.password) {
                    $('#passwordError').html(errors.password);
                    $('#password').val('');
                    $('#password').addClass('is-invalid');
                }
                if (errors.confirm_password) {
                    $('#confirm_passwordError').html(errors.confirm_password);
                    $('#confirm_password').val('');
                    $('#confirm_password').addClass('is-invalid');
                }
            }
        });
    }

    function resetForm() {
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#birthday').val('');
        $('#address').val('');
        $('#password').val('');
        $('#confirm_password').val('');
        $('#gender').val('').trigger('change');
        $('#division').val('').trigger('change');
        $('#district').val('').trigger('change');
        $('#upazila').val('').trigger('change');

        $('#nameError').html('');
        $('#emailError').html('');
        $('#phoneError').html('');
        $('#birthdayError').html('');
        $('#addressError').html('');
        $('#passwordError').html('');
        $('#confirm_passwordError').html('');

        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#phone').removeClass('is-invalid');
        $('#birthday').removeClass('is-invalid');
        $('#address').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');
        $('#confirm_password').removeClass('is-invalid');
    }



</script>
@endpush
