<?php

Route::namespace('Shahnewaz\CodeCanyonLicensor\Http\Controllers')->middleware('web')->group(function () {
	Route::get('verify-purchase/{license?}', 'AppController@verifyPurchase')->name('licensor.verify-purchase');
	Route::post('verify-purchase/{license?}', 'AppController@postVerifyPurchase')->name('licensor.verify-purchase-post');
	Route::get('not-licensed/{license?}', 'AppController@notLicensed')->name('licensor.not-licensed');
});
