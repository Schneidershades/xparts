<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'Api\Auth'], function(){
		Route::post('register', 'UserController@register');
    	Route::post('login', 'UserController@login');
    	Route::post('logout', 'UserController@logout');
        Route::get('profile', 'UserController@profile')->middleware('auth:api');
        Route::post('update', 'UserController@updateUser')->middleware('auth:api');
        Route::post('refresh/token', 'UserController@refresh');
        Route::post('change/password', 'ChangePasswordController')->middleware('auth:api');
		Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
		Route::post('/password/reset', 'ResetPasswordController@reset');
		Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
		Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
	});

	Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function(){
		Route::Resource('cart', 'Cart\CartController');
		Route::Resource('empty-cart', 'Cart\EmptyCartController');
		Route::Resource('orders', 'Order\OrderController');
		Route::Resource('coupons', 'Order\CouponController');
		Route::Resource('vendor-quote', 'User\VendorQuoteController');
		Route::Resource('xpart-requests', 'User\XpartRequestController');
		Route::Resource('multiple-xpart-requests', 'User\MultipleXpartRequestController');
		Route::Resource('fcm-token-subcriptions', 'User\FcmPushSubscriptionController');
	});

	Route::group(['prefix' => 'shared', 'namespace' => 'Api\Shared'], function(){
		Route::post('check-vin', 'VinCheckerController');
		Route::post('check-part-vin-price-estimates', 'PartVinPriceCheckerController');
		Route::get('pages/{slug}', 'PageController');
		Route::Resource('banks', 'BankController');
		Route::Resource('bank-details', 'BankDetailController')->middleware('auth:api');
		Route::Resource('addresses', 'AddressController')->middleware('auth:api');
		Route::Resource('payment-methods', 'PaymentMethodController');

		Route::post('upload', 'UploadController@store')->middleware('auth:api');

		Route::Resource('states', 'StateController');
		Route::Resource('countries', 'CountryController');

		Route::Resource('parts', 'Parts\PartsController');
		Route::Resource('part-grade', 'Parts\PartGradeController');
		Route::Resource('part-specialization', 'Parts\PartSpecializationController');
		Route::Resource('vehicle-specialization', 'Vehicle\VehicleSpecializationController');

		Route::Resource('funds', 'Wallet\FundController')->middleware('auth:api');
		Route::Resource('withdrawals', 'Wallet\WithdrawalController')->middleware('auth:api');
		Route::Resource('wallet-transactions', 'Wallet\WalletTransactionController')->middleware('auth:api');
	});
	
	Route::group(['prefix' => 'vendor', 'middleware' => 'auth:api', 'namespace' => 'Api\Vendor'], function(){
		Route::Resource('assigned-xpart-requests', 'UserXpartRequestController')->middleware('auth:api');
		Route::Resource('quotes', 'QuoteController')->middleware('auth:api');
		Route::get('quotes/recent/others', 'QuoteController@othersRecentQuote')->middleware('auth:api');
		Route::Resource('business-details', 'DetailController')->middleware('auth:api');
		Route::Resource('statistics', 'DashboardController');
	});

	Route::group(['prefix' => 'export', /*'middleware' => 'auth:api',*/ 'namespace' => 'Api\ExportImport'], function(){
		Route::get('/excel/model', 'ModelImportExportController@export');
	});

	Route::group(['prefix' => 'admin', 'middleware' => 'auth:api', 'namespace' => 'Api\Admin'], function(){
		Route::Resource('orders', 'OrderController', array("as"=>"userOrders"));
		Route::Resource('coupons', 'CouponController', array("as"=>"adminCoupons"));
		Route::Resource('quotes', 'QuoteController', array("as"=>"userQuotes"));
		Route::Resource('parts', 'PartController', array("as"=>"partList"));
		Route::Resource('part-specialization', 'PartSpecializationController', array("as"=>"partSpecItems"));
		Route::Resource('part-grades', 'PartGradeController', array("as"=>"partGradesItems"));
		Route::Resource('payment-charges', 'PaymentChargeContoller', array("as"=>"paymentCharges"));
		Route::Resource('payment-methods', 'PaymentMethodController', array("as"=>"paymentMethods"));
		Route::Resource('roles', 'RoleController', array("as"=>"userRoles"));
		Route::Resource('users', 'UserController', array("as"=>"regUsers"));
		Route::put('users/password/{id}', 'UserController@changePassword');
		Route::Resource('vendors', 'VendorController', array("as"=>"regVendors"));
		Route::Resource('vehicle-specialization', 'VehicleSpecializationController', array("as"=>"vehicleSpecItems"));
		Route::Resource('vins', 'VinController', array("as"=>"regVin"));
		Route::Resource('xpart-requests', 'XpartRequestController', array("as"=>"userXpartRequests"));
		Route::Resource('statistics', 'DashboardController', array("as"=>"dashboard"));
		Route::Resource('wallet-transactions', 'WalletTransactionController', array("as"=>"dashboard"));
		Route::Resource('markup-pricing', 'MarkupPricingController', array("as"=>"markupPricing"));
		Route::Resource('withdrawals', 'WithdrawalController', array("as"=>"userWithdrawals"));
		Route::Resource('delivery-rates', 'DeliveryRateController', array("as"=>"deliveryRates"));
		Route::post('withdrawals/finalize', 'WithdrawalController@paystackPaymentFinalize');
		Route::get('withdrawals/verify/{receipt_number}', 'WithdrawalController@paystackVerifyTransferPayment');
		Route::post('vin-parts', 'VinPartsController@store');
		Route::get('user/{id}/orders', 'UserPropertyController@orders');
		Route::get('user/{id}/wallet-transactions', 'UserPropertyController@walletTransactions');
		Route::get('user/{id}/quotes', 'UserPropertyController@quotes');
		Route::get('user/{id}/xparts-requests', 'UserPropertyController@xpartRequests');
		Route::Resource('statuses', 'StatusController');
		Route::Resource('pages', 'PageController');
		Route::Resource('operators', 'AdminOperatorController');
	});

	Route::get('process-all-orders', 'Api\Test\TestController@quoteProcessing');
	// Route::get('process-all-vins', 'Api\Test\TestController@processVins');
	Route::get('capitalize', 'Api\Test\TestController@capitalizeAllPartsAndVins');
	Route::get('send-requests', 'Api\Test\TestController@giveVendorsBidRequest');
	Route::get('send-push', 'Api\Test\TestController@sendPushNotification');
	Route::get('fill-quote-parts', 'Api\Test\TestController@partFill');
});

