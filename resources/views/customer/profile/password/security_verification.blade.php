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
                            <h3>Security Verification</h3>
                            <br>

                            <div class="panel panel-default">
                                <div class="panel-body p-5">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <form>
                                                <p class="text-muted" style="margin-bottom: 25px;">
                                                    We will send a one-time code to your registered email address.
                                                </p>

                                                <!-- Email Display -->
                                                <div class="form-group">
                                                    <label for="email" class="control-label">Email</label>
                                                    <input type="text" name="email" id="email" readonly class="form-control" value="{{ $user->email }}">
                                                </div>

                                                <!-- Verification Code Input -->
                                                <div class="form-group">
                                                    <label for="verification_code" class="control-label">Verification Code</label>
                                                    <div class="input-group">
                                                        <input type="text" name="verification_code" id="verification_code" class="form-control" placeholder="Enter 6-digit code">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn" id="sendBtn">Send</button>
                                                        </span>
                                                    </div>
                                                    <span class="text-danger" id="verificationCodeError"></span>
                                                </div>


                                                <!-- Verify Button -->
                                                <div class="form-group text-center">
                                                    <br>
                                                    <button type="button" class="btn btn-block" id="verifyBtn">Verify</button>
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

    $(document).ready(function () {
        let timer; // Variable for the countdown timer
        const countdownDuration = 60; // Countdown duration in seconds

        $('#sendBtn').on('click', function () {
            const $button = $(this);
            let timeLeft = countdownDuration;

            // Disable the button and show the countdown text
            $button.prop('disabled', true).text(`Sending...`);

            // Trigger your send code logic here
            sendVerificationCode($button, timeLeft);
        });

        function sendVerificationCode($button, timeLeft) {
            let url = "{{ route('customer.password.sendVerificationCode') }}";
            let email = $('#email').val();

            let formData = new FormData();
            formData.append('email', email);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    show_success(response.message);

                    // Start countdown after code is sent successfully
                    startCountdown($button, timeLeft);
                },
                error: function(error) {
                    show_error(error.responseJSON.error);

                    // Enable button if there's an error so the user can retry
                    $button.prop('disabled', false).text('Resend');
                }
            });
        }

        function startCountdown($button, timeLeft) {
            // Disable button and start countdown
            let timer = setInterval(() => {
                timeLeft -= 1;
                $button.text(`Resend in ${timeLeft}s`);

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    $button.prop('disabled', false).text('Resend');
                }
            }, 1000);
        }
    });

    $('#verifyBtn').on('click', function() {
        let url = "{{ route('customer.password.verifyCode') }}";

        let email = $('#email').val();
        let verificationCode = $('#verification_code').val();

        let formData = new FormData();
        formData.append('email', email);
        formData.append('verification_code', verificationCode);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.success === true) {
                    window.location.href = "{{ route('customer.password.create', ['id' => '__id__']) }}".replace('__id__', response.user.id);

                }else if(response.page === 'expired')  {
                    window.location.href = "{{ route('customer.password.expired.index') }}";
                }else {
                    window.location.href = "{{ route('customer.password.expired.invalidCode') }}";
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;

                if(errors.verification_code) {
                    $('#verificationCodeError').text(errors.verification_code);
                    $('#verification_code').val('');
                    $('#verification_code').addClass('is-invalid');
                }

            }
        });
    });




</script>

@endpush
