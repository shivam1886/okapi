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
										<h2>Login</h2>
										<p>Welcome Back..! Enter all the Login Details</p>
									</div>
									@include('common.alert')
									<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                        @csrf
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
												<input type="password" placeholder="Enter Password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" required>
												@if ($errors->has('password'))
													<span class="invalid-feedback" role="alert">
													    <strong>{{ $errors->first('password') }}</strong>
													</span>
												@endif
											</div>
											<div class="lr-btn">
												<a href="{{route('login')}}"><button>Login <i class="fa fa-arrow-right"></i></button></a>
											</div>
										</div>
									</form>
									 <div class="all-inputs">
										<div class="lr-links">
											<p>Don’t have an account? <a href="{{route('register')}}">Sign Up</a></p>
											<p>Did You <a href="{{ route('password.request') }}">Forget your Password?</a></p>
										</div>
									 </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection