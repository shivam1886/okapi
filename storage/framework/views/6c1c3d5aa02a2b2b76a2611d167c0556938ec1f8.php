<?php $__env->startSection('content'); ?>
	<section class="login-register clearfix">
		<div class="container-fluid">
			<div class="body">
				<div class="clearfix">
					<div class="custom-col-left">
						<div class="bg-wrapper">
							<img src="<?php echo e(asset('public')); ?>/images/nav-logo2.png">
						</div>
					</div>

					<div class="custom-col-right">
						<div class="lr-wrapper">
							<div class="lr-wrapper-inner">
								<div class="input-field">
									<div class="logo">
										<img src="<?php echo e(asset('public')); ?>/images/nav-logo1.png">
									</div>
									<div class="heading">
										<h2>Sign Up</h2>
										<p>Enter All the details</p>
									</div>
									<form method="POST" action="<?php echo e(route('register.store')); ?>" aria-label="<?php echo e(__('Register')); ?>" autocomplete="off">
										<?php echo csrf_field(); ?>
										<input type="hidden" name="latitude" value="">
										<input type="hidden" name="longitude" value="">
										<div class="all-inputs">
											<div class="form-group">
												<label>Chhose Your Type:</label>
												<select class="<?php echo e($errors->has('user_type') ? ' is-invalid' : ''); ?>" name="user_type" required>
													<option value="">Choose Your Type</option>
													<option <?php if(old('user_type') == '2'): ?> selected <?php endif; ?> value="2">You are Vendor</option>
													<option <?php if(old('user_type') == '3'): ?> selected <?php endif; ?> value="3">You are Supplier</option>
													<option <?php if(old('user_type') == '4'): ?> selected <?php endif; ?> value="4">You are Vendor & Supplier </option>
												</select>
												<?php if($errors->has('user_type')): ?>
													<span class="invalid-feedback" role="alert">
													   <strong><?php echo e($errors->first('user_type')); ?></strong>
													</span>
													<?php endif; ?>
											</div>
											<div class="form-group">
												<input type="text" placeholder="Your Name" class="<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
													<?php if($errors->has('name')): ?>
														<span class="invalid-feedback" role="alert">
														<strong><?php echo e($errors->first('name')); ?></strong>
														</span>
													<?php endif; ?>
											</div>
											<div class="form-group">
												<input type="number" placeholder="Phone Number" class="<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>" required autofocus>
													<?php if($errors->has('phone')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('phone')); ?></strong>
														</span>
													<?php endif; ?>
											</div>
											<div class="form-group">
												<input type="email" placeholder="Enter Email" class="<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="new-email">
													<?php if($errors->has('email')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('email')); ?></strong>
														</span>
													<?php endif; ?>
											</div>
											<div class="form-group">
												<input type="password" placeholder="Enter Password" class="<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" value="<?php echo e(old('password')); ?>" required autofocus autocomplete="new-password">
													<?php if($errors->has('password')): ?>
														<span class="invalid-feedback" role="alert">
														   <strong><?php echo e($errors->first('password')); ?></strong>
														</span>
													<?php endif; ?>
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
												<p>Alredy Member? <a href="<?php echo e(route('login')); ?>">Sign In</a></p>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.loggedOutApp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>