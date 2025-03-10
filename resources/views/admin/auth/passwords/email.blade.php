@extends('admin.auth.app')

@section('content')

		<!-- BEGIN login -->
		<div class="login">
			<!-- BEGIN login-content -->
			<div class="login-content">
				<form action="{{ route('admin.password.email') }}" method="POST" name="login_form">
                    @csrf
					<h1 class="text-center">Reset Password</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<div class="mb-3">
						<label class="form-label">Email Address <span class="text-danger">*</span></label>
						<input type="text" name="email" class="form-control form-control-lg bg-inverse bg-opacity-5" value="{{ old('email') }}" required>

                        @error('email')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<button type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3"> Send Password Reset Link </button>
					<div class="text-center text-inverse text-opacity-50">
						Don't want to change? <a href="{{ route('admin.login') }}">Go back</a>.
					</div>
				</form>
			</div>
			<!-- END login-content -->
		</div>
		<!-- END login -->

@endsection
