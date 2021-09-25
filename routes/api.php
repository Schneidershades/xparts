<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'Api\Auth'], function(){

		Route::post('register', 'UserController@register');
    	Route::post('login', 'UserController@login');
    	Route::post('logout', 'UserController@logout');
        Route::get('profile', 'UserController@profile')->middleware('auth:api');
        Route::post('update', 'UserController@updateUser')->middleware('auth:api');
        // Route::post('update', 'ForgotPasswordController@updateUser')->middleware('auth:api');

		Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
		Route::post('/password/reset', 'ResetPasswordController@reset');
		
		Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
		Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
	});

	Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function(){
		Route::Resource('cart', 'Cart\CartController');
		Route::Resource('empty-cart', 'Cart\EmptyCartController');
		Route::Resource('orders', 'Order\OrderController');
		Route::Resource('vendor-quote', 'User\VendorQuoteController');
		Route::Resource('xpart-requests', 'User\XpartRequestController');
	});

	Route::group(['prefix' => 'shared', 'namespace' => 'Api\Shared'], function(){
		Route::post('check-vin', 'VinCheckerController');
		Route::Resource('banks', 'BankController');
		Route::Resource('banks-details', 'BankDetailController')->middleware('auth:api');
		Route::Resource('addresses', 'AddressController')->middleware('auth:api');

		Route::Resource('states', 'StateController');
		Route::Resource('countries', 'CountryController');

		Route::Resource('parts', 'Parts\PartsController');
		Route::Resource('part-grade', 'Parts\PartGradeController');
		Route::Resource('part-specialization', 'Parts\PartSpecializationController');
		Route::Resource('vehicle-specialization', 'Vehicle\VehicleSpecializationController');
	});

	Route::group(['prefix' => 'vendor', 'middleware' => 'auth:api', 'namespace' => 'Api\Vendor'], function(){
		Route::Resource('assigned-xpart-requests', 'UserXpartRequestController')->middleware('auth:api');
		Route::Resource('quotes', 'QuoteController')->middleware('auth:api');
		Route::Resource('business-details', 'DetailController')->middleware('auth:api');
	});

	Route::group(['prefix' => 'admin', 'middleware' => 'auth:api', 'namespace' => 'Api\Admin'], function(){
		Route::Resource('orders', 'UOrderController');
		Route::Resource('quotes', 'QuoteController');
		Route::Resource('part-specialization', 'PartSpecializationController');
		Route::Resource('part-grades', 'PartGradeController');
		Route::Resource('roles', 'RoleController');
		Route::Resource('users', 'UserController');
		Route::Resource('vehicle-specialization', 'VehicleSpecializationController');
		Route::Resource('vins', 'VinController');
		Route::Resource('xpart-request', 'XpartRequestController');
	});
});

