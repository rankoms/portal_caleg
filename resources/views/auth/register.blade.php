@extends('layouts.app_auth')

@section('page-style')
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection
@section('content')
	<div class="authentication-wrapper authentication-cover">
		<div class="authentication-inner row m-0">

			<!-- /Left Text -->
			<div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
				<div class="flex-row text-center mx-auto">
					<img src="{{ asset('assets/img/pages/register-light.png') }}" alt="Auth Cover Bg color" width="520"
						class="img-fluid authentication-cover-img" data-app-light-img="pages/register-light.png"
						data-app-dark-img="pages/register-dark.png">
					<div class="mx-auto">
						<h3>A few clicks to get started 🚀</h3>
						<p>
							Let’s get started with your 14 days free trial and <br> start building your application today.
						</p>
					</div>
				</div>
			</div>
			<!-- /Left Text -->

			<!-- Register -->
			<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
				<div class="w-px-400 mx-auto">
					<!-- Logo -->
					<div class="app-brand mb-4">
						<a href="{{ url('/') }}" class="app-brand-link gap-2 mb-2">
							<span class="app-brand-logo demo"></span>
							<span class="app-brand-text demo h3 mb-0 fw-bold"></span>
						</a>
					</div>
					<!-- /Logo -->
					<h4 class="mb-2">Adventure starts here 🚀</h4>
					<p class="mb-4">Make your app management easy and fun!</p>

					<form class="mb-3" method="POST" action="{{ route('register') }}">
						@csrf
						<div class="mb-3">
							<label for="name" class="form-label">{{ __('Name') }}</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
								placeholder="Enter your username" value="{{ old('name') }}" required autocomplete="name" autofocus>
							@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
								value="{{ old('email') }}" required autocomplete="email" id="email" name="email"
								placeholder="Enter your email">
						</div>
						<div class="mb-3 form-password-toggle">
							<label class="form-label" for="password">Password</label>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password"
									placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
									aria-describedby="password" />
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<div class="mb-3 form-password-confirmation-toggle">
							<label class="form-label" for="password_confirmation">Password</label>
							<div class="input-group input-group-merge">
								<input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
									placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
									aria-describedby="password_confirmation" />
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
								<label class="form-check-label" for="terms-conditions">
									I agree to
									<a href="javascript:void(0);">privacy policy & terms</a>
								</label>
							</div>
						</div>
						<button class="btn btn-primary d-grid w-100">Sign up</button>
					</form>

					<p class="text-center">
						<span>Already have an account?</span>
						<a href="{{ url('auth/login-cover') }}">
							<span>Sign in instead</span>
						</a>
					</p>

					<div class="divider my-4">
						<div class="divider-text">or</div>
					</div>

					<div class="d-flex justify-content-center">
						<a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
							<i class="tf-icons bx bxl-facebook"></i>
						</a>

						<a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
							<i class="tf-icons bx bxl-google-plus"></i>
						</a>

						<a href="javascript:;" class="btn btn-icon btn-label-twitter">
							<i class="tf-icons bx bxl-twitter"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- /Register -->
		</div>
	</div>
@endsection
