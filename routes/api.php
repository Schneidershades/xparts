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

	Route::group(['prefix' => 'share', 'namespace' => 'Api\Share'], function(){
		Route::post('check-vin', 'VinCheckerController');
		Route::Resource('addresses', 'AddressController')->middleware('auth:api');
		Route::Resource('parts', 'PartsController');
	});

});

