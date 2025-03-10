
@extends('layouts.customer.app')
@push('css')
<style>
    .box-authentication input {
        width: 100%;
    }
</style>

@endpush
@section('content')

    <!-- MAIN -->
    <main class="site-main">

        <div class="columns container">
            <!-- Block  Breadcrumb-->
            <x-breadcrumbs :items="$breadcrumbs" />
            <!-- Block  Breadcrumb-->

            <h2 class="page-heading">
                <span class="page-heading-title2">Authentication</span>
            </h2>

            <div class="page-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-authentication">
                            <form action="{{ route('register') }}" method="POST" id="registerForm">
                                @csrf
                                <h3>Create an account</h3>
                                <p>Please enter your email address to create an account.</p>
                                <div class="form-group">
                                    <label for="name">Full name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                    @error('name')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email address</label>
                                    <input type="email" class="form-control" name="email_address" id="email_address">
                                    @error('email_address')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="account_password">Password (<small>Example abc123!@</small>)</label>
                                    <input type="password" class="form-control" name="account_password" id="account_password">
                                    @error('account_password')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="button"><i class="fa fa-user"></i> Create an account</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box-authentication">
                            <form action="{{ route('login') }}" method="POST" id="loginForm">
                                @csrf
                                <h3>Already registered?</h3>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="text" name="email" class="form-control" id="email">
                                    @error('email')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                     <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                    @error('password')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="forgot-pass"><a href="#">Forgot your password?</a></p>
                                <button type="submit" class="button"><i class="fa fa-lock"></i> Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!-- end MAIN -->

@endsection

@push('js')

<script>
    // $(document).ready(function() {
    //     $("#loginForm").on("keypress", function(event) {
    //         if (event.which === 13) {
    //             event.preventDefault();
    //             $(this).submit();
    //         }
    //     });
    // });

</script>

@endpush

