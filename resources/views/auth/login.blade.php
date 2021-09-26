<x-guest-layout>
    <div class="container">
		<div class="row align-items-center">
			<div class="col-md-6 col-lg-7">
				<img src="assets/vendors/images/login-page-img.png" alt="">
			</div>
			<div class="col-md-6 col-lg-5">
				<div class="login-box bg-white box-shadow border-radius-10">
					<div class="login-title">
						<h2 class="text-center text-primary">Login To AnalyticalJ CMS</h2>
					</div>

					<!-- Session Status -->
					<x-auth-session-status class="mb-4" :status="session('status')" />

					<!-- Validation Errors -->
					<x-auth-validation-errors class="mb-4" :errors="$errors" />

					<form method="POST" action="{{ route('login') }}">
						@csrf
						<div class="select-role">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<label class="btn active">
									<input type="radio" name="options" id="admin">
									<div class="icon"><img src="assets/vendors/images/briefcase.svg" class="svg" alt=""></div>
									<span>AnalyticalJ</span>
									CMS
								</label>
								<label class="btn">
									<input type="radio" name="options" id="user">
									<div class="icon"><img src="assets/vendors/images/person.svg" class="svg" alt=""></div>
									<span>User</span>
									Login
								</label>
							</div>
						</div>
						<div class="input-group custom">
							<input type="email" name="email" :value="old('email')" class="form-control form-control-lg" placeholder="Email" required autofocus>
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
							</div>
						</div>
						<div class="input-group custom">
							<input type="password" class="form-control form-control-lg" placeholder="**********" name="password" required autocomplete="current-password">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
							</div>
						</div>
						<div class="row pb-30">
							<div class="col-6">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
									<label class="custom-control-label" for="remember_me">Remember</label>
								</div>
							</div>
							<div class="col-6">
								<div class="forgot-password">
									{{-- @if (Route::has('password.request'))
										<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
											{{ __('Forgot password?') }}
										</a>
									@endif --}}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="input-group mb-0">
									<x-button class="btn btn-primary btn-lg btn-block">
										{{ __('Log in') }}
									</x-button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-guest-layout>
