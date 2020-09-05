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
										<h2>Login</h2>
										<p>Welcome Back..! Enter all the Login Details</p>
									</div>
									<?php echo $__env->make('common.alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<form method="POST" action="<?php echo e(route('login')); ?>" aria-label="<?php echo e(__('Login')); ?>">
                                        <?php echo csrf_field(); ?>
										<div class="all-inputs">
											<div class="form-group">
												<input type="email" placeholder="Enter Email" name="email" class="<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" required autofocus>
												<?php if($errors->has('email')): ?>
													<span class="invalid-feedback" role="alert">
													   <strong><?php echo e($errors->first('email')); ?></strong>
													</span>
												<?php endif; ?>
											</div>
											<div class="form-group">
												<input type="password" placeholder="Enter Password" name="password" class="<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" required>
												<?php if($errors->has('password')): ?>
													<span class="invalid-feedback" role="alert">
													    <strong><?php echo e($errors->first('password')); ?></strong>
													</span>
												<?php endif; ?>
											</div>
											<div class="lr-btn">
												<a href="<?php echo e(route('login')); ?>"><button>Login <i class="fa fa-arrow-right"></i></button></a>
											</div>
										</div>
									</form>
									 <div class="all-inputs">
										<div class="lr-links">
											<p>Don’t have an account? <a href="<?php echo e(route('register')); ?>">Sign Up</a></p>
											<p>Did You <a href="<?php echo e(route('password.request')); ?>">Forget your Password?</a></p>
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