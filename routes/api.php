<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'user', 'namespace' => 'Api\Auth'], function(){

		Route::post('register', 'UserController@register');
    	Route::post('login', 'UserController@login');
    	Route::post('logout', 'UserController@logout');
        Route::get('profile', 'UserController@profile')->middleware('auth:api');
        Route::post('update', 'UserController@updateUser')->middleware('auth:api');
        Route::post('update', 'ForgotPasswordController@updateUser')->middleware('auth:api');

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
		Route::Resource('parts', 'PartsController');
		Route::Resource('banks', 'BankController');
		Route::Resource('banks-details', 'BankDetailController');
		Route::Resource('addresses', 'AddressController')->middleware('auth:api');

		Route::Resource('part-categories', 'Part\PartCategoryController');
		Route::Resource('part-condition', 'Part\PartConditionController');
		Route::Resource('part-grade', 'Part\PartGradeController');
		Route::Resource('part-subcategories', 'Part\PartSubcategoryController');

		Route::Resource('category-one', 'Category\CategoryOneController');


	});

	Route::group(['prefix' => 'vendor', 'middleware' => 'auth:api', 'namespace' => 'Api\Vendor'], function(){
		Route::Resource('assigned-xpart-requests', 'UserXpartRequestController');
		Route::Resource('quotes', 'QuoteController');
		Route::Resource('business-details', 'DetailController');
	});

});

