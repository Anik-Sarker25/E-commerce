@extends('layouts.customer.app')
@push('css')
    <style>
        .site-main {
            background-color: #f5f5f5;
        }
        .btn {
            background-color: #f36;
            color: #fff !important;
            border-radius: 3px;
        }
        .panel {
            border: none;
        }
        .btn:hover  {
            background-color: #e50039;
        }
        #sendBtn {
            background: transparent;
            color: #e50039 !important;
            border: 1px solid #ececec;
            height: 34px;
        }
        .buttons button {
            margin-right: 5px;
        }
        .p-5 {
            padding: 40px;
        }

    </style>

@endpush

@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <div class="row" style="padding-top: 20px;">
                <!-- Main Content -->
                <div class="col-md-12  col-main">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <h3>Create New Password</h3>
                            <br>

                            <div class="panel panel-default">
                                <div class="panel-body p-5">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form action="{{ route('customer.password.update') }}" method="POST">
                                                @csrf
                                                <!-- Email Display -->
                                                <input type="hidden" name="email" value="{{ $user->email }}">
                                                <div class="form-group">
                                                    <label for="password" class="control-label">Password</label>
                                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="">
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="control-label">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="">
                                                </div>

                                                <!-- Verify Button -->
                                                <div class="form-group text-center">
                                                    <br>
                                                    <button type="submit" id="changePassword" class="btn btn-block">Change Password</button>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>



                </div>
                <!-- Main Content -->



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

    // $('#changePassword').on('click', function() {
    //     let url = "{{ route('customer.password.update') }}";

    //     let email = $('#email').val();
    //     let password = $('#password').val();
    //     let password_confirmation = $('#password_confirmation').val();

    //     let formData = new FormData();
    //     formData.append('email', email);
    //     formData.append('password', password);
    //     formData.append('password_confirmation', password_confirmation);

    //     $.ajax({
    //         url: url,
    //         type: 'POST',
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             window.location.href = "{{ route('customer.password.create', ['id' => '__id__']) }}".replace('__id__', response.user.id);
    //         },
    //         error: function(error) {
    //             let errors = error.responseJSON.errors;

    //             if(errors.verification_code) {
    //                 $('#verificationCodeError').text(errors.verification_code);
    //                 $('#verification_code').val('');
    //                 $('#verification_code').addClass('is-invalid');
    //             }

    //         }
    //     });
    // });
</script>
@endpush
