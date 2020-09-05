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
									<div class="all-inputs">
										<div class="form-group">
											<label>Chhose Your Type:</label>
											<select>
												<option selected disabled>Choose Your Type</option>
												<option>You are Vendor</option>
												<option>You are Supplier</option>
												<option>You are Vendor & Supplier </option>
											</select>
										</div>
										<div class="form-group">
											<input type="text" placeholder="Your Name" name="">
										</div>
										<div class="form-group">
											<input type="number" placeholder="Phone Number" name="">
										</div>
										<div class="form-group">
											<input type="email" placeholder="Enter Email" name="">
										</div>
										<div class="form-group">
											<input type="password" placeholder="Enter Password" name="">
										</div>
										<div class="lr-btn">
											<a href="login.html"><button>Login <i class="fa fa-arrow-right"></i></button></a>
										</div>

										<div class="lr-links">
											<p>Alredy Member? <a href="login.html">Sign In</a></p>
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