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
										<h2>Sign Up</h2>
										<p>Enter All the details</p>
									</div>
									<form method="POST" action="{{ route('register.store') }}" aria-label="{{ __('Register') }}" autocomplete="off">
										@csrf
										<input type="hidden" name="latitude" value="">
										<input type="hidden" name="longitude" value="">
										<div class="all-inputs">
											<div class="form-group">
												<label>Chhose Your Type:</label>
												<select class="{{ $errors->has('user_type') ? ' is-invalid' : '' }}" name="user_type" required>
													<option value="">Choose Your Type</option>
													<option @if(old('user_type') == '2') selected @endif value="2">You are Vendor</option>
													<option @if(old('user_type') == '3') selected @endif value="3">You are Supplier</option>
													<option @if(old('user_type') == '4') selected @endif value="4">You are Vendor & Supplier </option>
												</select>
												@if ($errors->has('user_type'))
													<span class="invalid-feedback" role="alert">
													   <strong>{{ $errors->first('user_type') }}</strong>
													</span>
													@endif
											</div>
											<div class="form-group">
												<input type="text" placeholder="Your Name" class="{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
													@if ($errors->has('name'))
														<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('name') }}</strong>
														</span>
													@endif
											</div>
											<div class="form-group">
												<input type="number" placeholder="Phone Number" class="{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>
													@if ($errors->has('phone'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('phone') }}</strong>
														</span>
													@endif
											</div>
											<div class="form-group">
												<input type="email" placeholder="Enter Email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus autocomplete="new-email">
													@if ($errors->has('email'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif
											</div>
											<div class="form-group">
												<input type="password" placeholder="Enter Password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus autocomplete="new-password">
													@if ($errors->has('password'))
														<span class="invalid-feedback" role="alert">
														   <strong>{{ $errors->first('password') }}</strong>
														</span>
													@endif
											</div>
                                            <div class="form-group">
												<input type="password" placeholder="Confirm Password" name="password_confirmation">
											</div>

											<div class="lr-btn">
												<button>Register <i class="fa fa-arrow-right"></i></button>
											</div>
										</div>
									 </form>
                                         <div class="all-inputs">
											<div class="lr-links">
												<p>Alredy Member? <a href="{{route('login')}}">Sign In</a></p>
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