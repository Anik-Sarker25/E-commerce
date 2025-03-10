@extends('layouts.customer.app')

@push('css')
@include('layouts.customer.sidebar_css')

<style>
    .panel-title.billing {
        visibility: hidden;
    }
    .muted {
        color: #666;
        margin: 10px 0 0 0;
        font-size: 12px;
    }
    .profile .buttons {
        margin-top: 80px;
    }
    .cancelBtn {
        background-color: #e50039;
    }
    .buttons button {
        margin-right: 5px;
    }
    select {
        text-transform: capitalize !important;
    }
    .ui-datepicker {
        font-size: 14px;
    }
    .edit {
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
                    <div class="row profile">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">{{ $pageTitle }}</h5>
                                </div>
                                <div class="panel-body">

                                    <!-- Profile View -->
                                    <div class="profile-view">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="view">
                                                    <p>Full Name</p>
                                                    <p id="show_name">{{ $user->name }}</p>
                                                </div>

                                                <div class="form-group edit">
                                                    <input type="hidden" id="update_id" value="{{ $user->id }}">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name ?? '' }}">
                                                    <span class="text-danger" id="nameError"></span>

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="view">
                                                    <p>Email Address</p>
                                                    <p id="show_email">{{ maskEmail($user->email) }}</p>
                                                </div>

                                                <div class="form-group edit">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email ?? 'Enter email address' }}">
                                                    <span class="text-danger" id="emailError"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="view">
                                                    <p>Phone Number</p>
                                                    @if (!empty($user->phone))
                                                        <p id="show_phone">{{ $user->phone }}</p>
                                                    @else
                                                        <p class="muted">Please enter your number</p>
                                                    @endif
                                                </div>

                                                <div class="form-group edit">
                                                    <label for="phone">Phone Number</label>
                                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter your number" value="{{ $user->phone }}">
                                                    <span class="text-danger" id="phoneError"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="view">
                                                    <p>Birthday</p>
                                                    @if (!empty($user->birthday))
                                                        <p id="show_birthday">{{ dateFormat($user->birthday) }}</p>
                                                    @else
                                                        <p class="muted">Please enter your birthday</p>
                                                    @endif
                                                </div>

                                                <div class="form-group edit">
                                                    <label for="birthday">Birthday</label>
                                                    <input type="text" id="birthday" name="birthday" class="form-control" placeholder="Enter your Birthday" value="{{ dateFormat2($user->birthday) }}">
                                                    <span class="text-danger" id="birthdayError"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="view">
                                                    <p>Gender</p>
                                                    @if ($user->gender === App\Helpers\Constant::GENDER['male'])
                                                        <p id="show_gender">Male</p>
                                                    @elseif ($user->gender === App\Helpers\Constant::GENDER['female'])
                                                        <p id="show_gender">Female</p>
                                                    @elseif ($user->gender === App\Helpers\Constant::GENDER['others'])
                                                        <p id="show_gender">Others</p>
                                                    @else
                                                        <p id="show_gender" class="muted">Please enter your gender</p>
                                                    @endif

                                                </div>

                                                @php
                                                    $genders = App\Helpers\Constant::GENDER;
                                                @endphp
                                                <div class="form-group edit">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control" name="gender" id="gender">
                                                        <option value="">Select Gender</option>
                                                        @foreach ($genders as $key => $gender)
                                                            <option {{ ($user->gender == $gender) ? 'selected' : '' }} value="{{ $gender }}">{{ $key }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="buttons view">
                                            <button type="button" class="btn" id="editProfileBtn">Edit Profile</button>
                                            <a href="{{ route('customer.password.vetification') }}" class="btn">Change Password</a>
                                        </div>
                                        <div class="buttons edit">
                                            <button type="button" id="editCustomer" class="btn">Save Changes</button>
                                            <button type="button" class="btn cancelBtn" id="cancelEditBtn">Cancel</button>
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
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#birthday").datepicker({
            showAnim: "fadeIn",
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2100"
        });

        if (window.location.search.indexOf("edit") !== -1) {
            // find query string ?edit
            // Show profile-edit view if ?edit is in the URL
            $(".edit").css("display", "block");
            $(".view").css("display", "none");
            $('.panel-title').val('Edit Profile');

            $("#cancelEditBtn").click(function() {
                window.location = "{{ route('customer.profile.index') }}";
            });
        }else {
            $("#editProfileBtn").click(function() {
                document.title = "Edit Profile";
                $(".edit").css("display","block");
                $(".view").css('display', 'none');
                $('.panel-title').html('Edit Profile');
            });

            $("#cancelEditBtn").click(function() {
                document.title = "{{ $pageTitle }}";
                $(".view").css("display","block");
                $(".edit").css('display', 'none');
                $('.panel-title').html("{{ $pageTitle }}");
            });
        }

    });

    $('#editCustomer').on('click', function () {
        editCustomer();
    });
    function editCustomer() {
        let id = $('#update_id').val();
        let url = "{{ route('customer.profile.update', ':id') }}";
        url = url.replace(':id', id);

        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let gender = $('#gender').val();
        let birthday = $('#birthday').val();

        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);
        formData.append('gender', gender);
        formData.append('birthday', birthday);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = response[0];
                let birthday = response[1];



                document.title = "{{ $pageTitle }}";
                $(".view").css("display","block");
                $(".edit").css('display', 'none');

                $('#show_name').html(data.name);
                $('#show_email').html(data.email);
                $('#show_phone').html(data.phone);

                if (data.gender === "{{ App\Helpers\Constant::GENDER['male'] }}") {
                    $('#show_gender').html('Male');
                } else if (data.gender === "{{ App\Helpers\Constant::GENDER['female'] }}") {
                    $('#show_gender').html('Female');
                } else if (data.gender === "{{ App\Helpers\Constant::GENDER['others'] }}") {
                    $('#show_gender').html('Others');
                } else {
                    $('#show_gender').html('Please enter your gender');
                }

                $('#show_birthday').html(birthday);
                formReset();

                show_success('Customer information has been updated successfully');
            },
            error: function(error) {
                $('#nameError').html('');
                $('#emailError').html('');
                $('#phoneError').html('');
                $('#birthdayError').html('');

                $('#name').removeClass('is-invalid');
                $('#email').removeClass('is-invalid');
                $('#phone').removeClass('is-invalid');
                $('#birthday').removeClass('is-invalid');

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
            }
        });
    }

    function formReset() {
        $('#nameError').html('');
        $('#emailError').html('');
        $('#phoneError').html('');
        $('#birthdayError').html('');
        $('#name').removeClass('is-invalid');
        $('#email').removeClass('is-invalid');
        $('#phone').removeClass('is-invalid');
        $('#birthday').removeClass('is-invalid');
    }


</script>
@if (session('success'))
    <script>
    $(document).ready(function() {
        // Safely escape the session message for JavaScript
        const successMessage = @json(session('success'));
        show_success(successMessage);
    });
    </script>
@endif


@endpush
