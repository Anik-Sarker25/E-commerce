@extends('admin.auth.app')

@section('content')

		<!-- BEGIN register -->
		<div class="register">
			<!-- BEGIN register-content -->
			<div class="register-content">
				<form action="{{ route('admin.register') }}" method="POST" name="register_form">
                    @csrf
					<h1 class="text-center">Sign Up</h1>
					<p class="text-inverse text-opacity-50 text-center">One Admin ID is all you need to access all the Admin services.</p>
					<div class="mb-3">
						<label class="form-label">Name <span class="text-danger">*</span></label>
						<input type="text" name="name" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="Enter name..." value="">

                        @error('name')
                            <span class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="mb-3">
						<label class="form-label">Email Address <span class="text-danger">*</span></label>
						<input type="text" name="email" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="username@address.com" value="">

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
					<div class="mb-3">
						<button type="submit" class="btn btn-outline-theme btn-lg d-block w-100">Sign Up</button>
					</div>
					<div class="text-inverse text-opacity-50 text-center">
						Already have an Admin ID? <a href="{{ route('admin.login') }}">Sign In</a>
					</div>
				</form>
			</div>
			<!-- END register-content -->
		</div>
		<!-- END register -->

@endsection
