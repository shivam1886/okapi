<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

     Auth::routes();
     Route::get('/', function () { return redirect('login');});  
     Route::get('/home', 'HomeController@index')->name('home');   
     Route::get('/register', 'HomeController@register')->name('register');
     Route::post('/register/store', 'HomeController@registerStore')->name('register.store');
     Route::put('/change/password','HomeController@changePassword')->name('change.password');

     Route::get('/get/notification',function(){
     	return view('notification_list');
     })->name('get.notifications');
	 
	 Route::name('admin.')->group(function(){

     		Route::get('admin/profile', 'Admin\HomeController@profile')->name('profile');
     		Route::put('admin/profile/update', 'Admin\HomeController@profileUpdate')->name('profile.update');
	     	Route::get('admin/vendors', 'Admin\HomeController@vendors')->name('vendors');
	     	Route::get('admin/vendor/details/{id}', 'Admin\HomeController@vendorDetails')->name('vendor.details');
  	     	Route::put('admin/vendor/status', 'Admin\HomeController@vendorStatus')->name('vendor.status');

  	     	Route::get('admin/supplier/vendors', 'Admin\HomeController@supplierVendors')->name('supplier.vendors');
	     	Route::get('admin/supplier/vendor/details/{id}', 'Admin\HomeController@supplierVendorDetails')->name('supplier.vendor.details');
  	     	Route::put('admin/supplier/vendor/status', 'Admin\HomeController@supplierVendorStatus')->name('supplier.vendor.status');
	   
	     	Route::get('admin/suppliers', 'Admin\HomeController@suppliers')->name('suppliers');
	     	Route::get('admin/supplier/details/{id}', 'Admin\HomeController@supplierDetails')->name('supplier.details');
	  	    Route::put('admin/supplier/status', 'Admin\HomeController@supplierStatus')->name('supplier.status');

   	  	    Route::put('admin/supplier/approve/document', 'Admin\HomeController@approveDocument')->name('approve.document');
   	  	    Route::put('admin/supplier/approve', 'Admin\HomeController@approveSupplier')->name('approve.supplier');
	 });
	 
	 Route::name('vendor.')->group(function(){

		//Profile
		Route::get('vendor/profile', 'Vendor\ProfileController@profile')->name('profile');
        Route::put('vendor/update/profile', 'Vendor\ProfileController@updateProfile')->name('update.profile');

        //Currency
   		Route::get('vendor/currency/list', 'Vendor\ProfileController@currencyList')->name('currency.list');
		Route::post('vendor/add/currency', 'Vendor\ProfileController@createCurrency')->name('currency.create');
		Route::put('vendor/update/currency/{id}', 'Vendor\ProfileController@updateCurrency')->name('currency.update');
		Route::delete('vendor/delete/currency/{id}', 'Vendor\ProfileController@destroyCurrency')->name('currency.destroy');
        
        // Department
		Route::put('vendor/department/update', 'Vendor\DepartmentController@departmentUpdate')->name('department.update');
		Route::post('vendor/department/create', 'Vendor\DepartmentController@departmentCreate')->name('department.create');
		Route::delete('vendor/department/delete', 'Vendor\DepartmentController@departmentDelete')->name('department.delete');
		Route::get('vendor/department/list', 'Vendor\DepartmentController@departmentsList')->name('department.list');

		Route::get('vendor/tendor', 'Vendor\TendorController@index')->name('tendor.index');
		Route::get('vendor/tendor/create', 'Vendor\TendorController@create')->name('tendor.create');
		Route::post('vendor/tendor/store', 'Vendor\TendorController@store')->name('tendor.store');
		Route::get('vendor/tendor/show/{id}', 'Vendor\TendorController@show')->name('tendor.show');
		Route::get('vendor/tendor/edit/{id}', 'Vendor\TendorController@edit')->name('tendor.edit');
 	    Route::put('vendor/tendor/update/{id}', 'Vendor\TendorController@update')->name('tendor.update');
 	    Route::delete('vendor/tendor/delete', 'Vendor\TendorController@destroy')->name('tendor.delete');

		Route::get('vendor/suppliers/request', 'Vendor\RequestController@index')->name('request.index');
		Route::get('vendor/supplier/request/list', 'Vendor\RequestController@requestList')->name('request.list');
		Route::post('vendor/supplier/accept', 'Vendor\RequestController@accept')->name('request.accept');
  	    Route::delete('vendor/supplier/decline', 'Vendor\RequestController@decline')->name('request.decline');

		Route::get('vendor/suppliers', 'Vendor\SupplierController@index')->name('supplier.index');
		Route::get('vendor/supplier/details/{id}', 'Vendor\SupplierController@show')->name('supplier.show');
		Route::get('vendor/supplier/list', 'Vendor\SupplierController@suppliertList')->name('supplier.list');
		Route::delete('vendor/supplier/remove', 'Vendor\SupplierController@remove')->name('supplier.remove');

  	    Route::get('vendor/quotation/list', 'Vendor\TendorController@quotationList')->name('quotation.list');

  	    Route::get('vendor/quotation/details/{id?}', 'Vendor\TendorController@quotationSupplierDetails')->name('quotation.details');

  	    Route::put('vendor/quotation/reject/{id}', 'Vendor\TendorController@quotationReject')->name('quotation.reject');

   	    Route::put('quotation/accept/{id}', 'Vendor\TendorController@quotationAccept')->name('quotation.accept');
	    Route::put('quotation/cancel/{id}', 'Vendor\TendorController@quotationCancel')->name('quotation.cancel');
        
  	    Route::get('vendor/orders', 'Vendor\OrderController@index')->name('order.index');
   	    Route::get('vendor/order/details/{id}', 'Vendor\OrderController@show')->name('order.show');
 		Route::put('vendor/cancel/order/{id}', 'Vendor\OrderController@cancelOrder')->name('cancel.order');

 		Route::get('vendor/order/pdf/{id}', 'Vendor\OrderController@pdf')->name('order.pdf');
        Route::get('vendor/quotation/pdf/{id}', 'Vendor\TendorController@quotationPdf')->name('quotation.pdf');

     });

	 Route::name('supplier.')->group(function(){
		//Profile
		Route::get('supplier/profile', 'Supplier\ProfileController@profile')->name('profile');
        Route::put('supplier/update/profile', 'Supplier\ProfileController@updateProfile')->name('update.profile');
   		Route::post('update/documents', 'Supplier\ProfileController@updateDocument')->name('update.document');
   		Route::put('remove/document/{id}', 'Supplier\ProfileController@removeDocument')->name('remove.document');
   		Route::get('document/list', 'Supplier\ProfileController@documentList')->name('document.list');
		
		Route::get('tax/list', 'Supplier\ProfileController@taxList')->name('tax.list');
		Route::post('add/tax', 'Supplier\ProfileController@addTax')->name('add.tax');
   	    Route::delete('remove/tax', 'Supplier\ProfileController@removeTax')->name('remove.tax');

    	Route::get('supplier/tendors', 'Supplier\TendorController@index')->name('tendor.index');
    	Route::get('supplier/tendor/details/{id}', 'Supplier\TendorController@show')->name('tendor.show');
	  	Route::post('supplier/tendor/quotation/submit', 'Supplier\TendorController@submitQuotation')->name('quotation.create');
    	Route::get('supplier/quotations', 'Supplier\QuotationController@index')->name('quotation.index');
    	Route::get('supplier/quotation/details/{id}', 'Supplier\QuotationController@show')->name('quotation.show');
    	Route::put('supplier/quotation/update/{id}', 'Supplier\QuotationController@update')->name('quotation.update');
    	Route::put('supplier/quotation/candel/{id}', 'Supplier\QuotationController@quotationCancel')->name('quotation.cancel');

		Route::get('supplier/product/index', 'Supplier\ProductController@index')->name('product.index');
		Route::post('supplier/product/store', 'Supplier\ProductController@store')->name('product.store');
		Route::get('supplier/product/edit', 'Supplier\ProductController@edit')->name('product.edit');
		Route::put('supplier/product/update', 'Supplier\ProductController@update')->name('product.update');
 	    Route::delete('supplier/product/destroy/{id}', 'Supplier\ProductController@destroy')->name('product.destroy');

		Route::get('supplier/vendors', 'Supplier\VendorController@index')->name('vendor.index');
		Route::get('supplier/vendor/details/{id}', 'Supplier\VendorController@show')->name('vendor.show');
	    Route::post('supplier/vendor/request/{id}', 'Supplier\VendorController@doRequest')->name('vendor.request');
  		Route::get('my/vendors', 'Supplier\VendorController@myVendor')->name('my.vendor');
  		Route::get('my/vendors/details/{id}', 'Supplier\VendorController@myVendorDetails')->name('my.vendor.details');
  		Route::post('remove/vendor/{id}', 'Supplier\VendorController@removeVendor')->name('vendor.remove');
  		Route::delete('cancel/request/{id}', 'Supplier\VendorController@cancelRequest')->name('cancel.request');

		Route::get('supplier/orders', 'Supplier\OrderController@index')->name('order.index');
		Route::get('supplier/order/details/{id}', 'Supplier\OrderController@show')->name('order.show');
		Route::put('supplier/cancel/order/{id}', 'Supplier\OrderController@cancelOrder')->name('cancel.order');
		Route::put('vendor/change/order/{id}', 'Vendor\OrderController@changeOrder')->name('change.order');
    	Route::put('vendor/received/order/{id}', 'Vendor\OrderController@receivedOrder')->name('received.order');

 	    Route::get('supplier/order/pdf/{id}', 'Supplier\OrderController@pdf')->name('order.pdf');

	 });

 	 Route::name('supplier.vendor.')->group(function(){

 	 	//Profile
		Route::get('supplier/vendor/profile', 'SupplierVendor\ProfileController@profile')->name('profile');
        Route::put('supplier/vendor/update/profile', 'SupplierVendor\ProfileController@updateProfile')->name('update.profile');

 	 });
