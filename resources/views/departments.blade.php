			@foreach($data['departments'] as $Key => $department)
												<!--single-department-->
												<div class="single-department">
													<div class="edit-dlt">
														<button class="blt-btn" data-id="{{$department->id}}"><i class="fas fa-trash"></i></button>
														<button><i class="fas fa-pen btn-edit"></i></button>
													</div>
											<form method="POST" action="{{ route('vendor.department.update') }}" class="update-department-form">
												@csrf
												{{method_field('PUT')}}
												<input type="hidden" name="department_id" value="{{$department->id}}">
													<div class="form-group">
														<label>Department Name</label>
														<input type="text" disabled placeholder="Department Name" value="{{$department->name}}" name="department_name" required>
													</div>

													<div class="form-group">
														<label>Contact Number</label>
														<input type="text" disabled placeholder="Contact Number" value="{{$department->phone}}" name="department_phone" required>
													</div>

													<div class="form-group">
														<label>Email Address</label>
														<input type="text" disabled placeholder="Email Address" value="{{$department->email}}" name="department_email" required>
													</div>
													<div class="add-btn update-department-btn" style="display: none">
													   <button>Update Department</button>
													</div>
											</form>
												</div><!--end single-department-->
											@endforeach