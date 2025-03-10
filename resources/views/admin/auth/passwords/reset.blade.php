@extends('admin.auth.app')

@section('content')

		<!-- BEGIN login -->
		<div class="login">
			<!-- BEGIN login-content -->
			<div class="login-content">
				<form action="{{ route('admin.password.update') }}" method="POST" name="login_form">
                    @csrf
					<h1 class="text-center">Reset Password</h1>
                    @if (session('token'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{ session('token') }}
                        </div>
                    @endif

					<div class="mb-3">

                        <input type="text" name="token" value="{{ $token }}">
						<label class="form-label">Email Address <span class="text-danger">*</span></label>
						<input type="text" readonly name="email" class="form-control form-control-lg bg-inverse bg-opacity-5" value="{{ $email }}" required>

                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="mb-3">
						<label class="form-label">Password <span class="text-danger">*</span></label>
						<input type="password" name="password" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" value="">

                        @error('password')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="mb-3">
						<label class="form-label">Confirm Password <span class="text-danger">*</span></label>
						<input type="password" name="password_confirmation" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" value="">
					</div>

					<button type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3"> Reset Password </button>
					<div class="text-center text-inverse text-opacity-50">
						Don't want to change? <a href="{{ route('admin.login') }}">Go back</a>.
					</div>
				</form>
			</div>
			<!-- END login-content -->
		</div>
		<!-- END login -->

@endsection
