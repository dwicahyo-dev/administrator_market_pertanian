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

Route::get('/', function () {
	return redirect()->route('login');
});

Auth::routes(['verify' => true]);

Route::group([
	'middleware' => ['auth', 'check.admin']
], function() {
		Route::get('/home', 'HomeController@index')->name('home');
		Route::resource('commodity', 'CommodityController');
		Route::resource('quality', 'QualityController');
		Route::resource('agriculture', 'AgricultureController');
		// Route::resource('quality_of_agriculture', 'QualityOfAgricultureController');
		Route::resource('standard_price', 'StandardPriceController');
		Route::resource('users', 'UserController');
		Route::resource('users_role', 'UserRoleController');

		Route::get('/profile', 'HomeController@profile')->name('profile');
		Route::match(['put', 'patch'], '/profile/update', 'HomeController@updateProfile')->name('profile.update');
		Route::match(['put', 'patch'], '/profile/password/update', 'HomeController@updatePassword')->name('profile.password.update');
	});
