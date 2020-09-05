@extends('layouts.loggedOutApp')
@section('content')
	<section class="login-register clearfix">
		<div class="container-fluid">
			<div class="body">
				<div class="clearfix">
					<div class="custom-col-left">
						<div class="bg-wrapper">
							<img src="{{asset('public')}}/images/nav-logo2.png">
						</div>
					</div>

					<div class="custom-col-right">
						<div class="lr-wrapper">
							<div class="lr-wrapper-inner">
								<div class="input-field">
									<div class="logo">
										<img src="{{asset('public')}}/images/nav-logo1.png">
									</div>
									<div class="heading">
										<h2>Reset Password</h2>
									</div>
									@if (session('status'))
										<div class="alert alert-success" role="alert">
										{{ session('status') }}
										</div>
									@endif
										<form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
										@csrf
       	                                <input type="hidden" name="token" value="{{ $token }}">
										<div class="all-inputs">
											<div class="form-group">
												<input type="email" placeholder="Enter Email" name="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
												@if ($errors->has('email'))
													<span class="invalid-feedback" role="alert">
													   <strong>{{ $errors->first('email') }}</strong>
													</span>
												@endif
											</div>
											<div class="form-group">
												<input type="password" placeholder="Enter Password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" required autofocus>
												@if ($errors->has('password'))
													<span class="invalid-feedback" role="alert">
													   <strong>{{ $errors->first('password') }}</strong>
													</span>
												@endif
											</div>
											<div class="form-group">
												<input type="password" placeholder="Enter Confirm Password" name="password_confirmation" required>
											</div>
											<div class="lr-btn">
												<a href="#"><button>  {{ __('Reset Password') }} <i class="fa fa-arrow-right"></i></button></a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection