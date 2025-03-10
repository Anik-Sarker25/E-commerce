@extends('admin.auth.app')

@section('content')

    <!-- BEGIN login -->
    <div class="login">
        <!-- BEGIN login-content -->
        <div class="login-content">
            <form action="{{ route('admin.login') }}" method="POST" name="login_form">
                @csrf
                <h1 class="text-center">Sign In</h1>
                @if (session('status'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="text-inverse text-opacity-50 text-center mb-4">
                    For your protection, please verify your identity.
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror form-control-lg bg-inverse bg-opacity-5">

                    @error('email')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        @if (Route::has('admin.password.request'))
                            <a href="{{ route('admin.password.request') }}" class="ms-auto text-inverse text-decoration-none text-opacity-50">Forgot password?</a>
                        @endif
                    </div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror form-control-lg bg-inverse bg-opacity-5" value="" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                    @error('password')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="customCheck1">
                        <label class="form-check-label" for="customCheck1">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>
                <div class="text-center text-inverse text-opacity-50">
                    Don't have an account yet? <a href="{{ route('admin.register') }}">Sign up</a>.
                </div>
            </form>
        </div>
        <!-- END login-content -->
    </div>
    <!-- END login -->

@endsection

@push('js')
<script>

    $(document).ready(function () {
        @if(session('info'))
            show_info(@json(session('info')));
        @endif
    });

</script>
@endpush
