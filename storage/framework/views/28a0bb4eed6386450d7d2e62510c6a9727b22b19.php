			<?php $__currentLoopData = $data['departments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Key => $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<!--single-department-->
												<div class="single-department">
													<div class="edit-dlt">
														<button class="blt-btn" data-id="<?php echo e($department->id); ?>"><i class="fas fa-trash"></i></button>
														<button><i class="fas fa-pen btn-edit"></i></button>
													</div>
											<form method="POST" action="<?php echo e(route('vendor.department.update')); ?>" class="update-department-form">
												<?php echo csrf_field(); ?>
												<?php echo e(method_field('PUT')); ?>

												<input type="hidden" name="department_id" value="<?php echo e($department->id); ?>">
													<div class="form-group">
														<label>Department Name</label>
														<input type="text" disabled placeholder="Department Name" value="<?php echo e($department->name); ?>" name="department_name" required>
													</div>

													<div class="form-group">
														<label>Contact Number</label>
														<input type="text" disabled placeholder="Contact Number" value="<?php echo e($department->phone); ?>" name="department_phone" required>
													</div>

													<div class="form-group">
														<label>Email Address</label>
														<input type="text" disabled placeholder="Email Address" value="<?php echo e($department->email); ?>" name="department_email" required>
													</div>
													<div class="add-btn update-department-btn" style="display: none">
													   <button>Update Department</button>
													</div>
											</form>
												</div><!--end single-department-->
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>