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
					<div class="mx-auto">
						<h3>Discover the powerful admin template 🥳</h3>
						<p>
							Perfectly suited for all level of developers which helps you to <br> kick start your next big projects &
							Applications.
						</p>
					</div>
				</div>
			</div>
			<!-- /Left Text -->

			<!-- Login -->
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
					<h4 class="mb-2">Welcome to ! 👋</h4>
					<p class="mb-4">Please sign-in to your account and start the adventure</p>

					<form method="POST" action="{{ route('login') }}">
						@csrf
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="text" class="form-control" id="email" name="email"
								placeholder="Enter your email or username" autofocus>
							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password">Password</label>
								<a href="{{ url('auth/forgot-password-cover') }}">
									<small>Forgot Password?</small>
								</a>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password"
									placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
									aria-describedby="password" />
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="remember-me">
								<label class="form-check-label" for="remember-me">
									Remember Me
								</label>
							</div>
						</div>
						<button class="btn btn-primary d-grid w-100">
							Sign in
						</button>
					</form>

					<p class="text-center">
						<span>New on our platform?</span>
						<a href="{{ url('auth/register-cover') }}">
							<span>Create an account</span>
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
			<!-- /Login -->
		</div>
	</div>
@endsection
