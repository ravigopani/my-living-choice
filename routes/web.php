<?php

use Illuminate\Support\Facades\Route;

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

/*---------- START - Admin Routes ----------*/
Route::group(['middleware' => ['auth','checkAdminDetail'],'prefix'=>'admin'], function (){

	Route::resource('/','UserController');	
	Route::resource('/user','UserController');
	Route::get('/list_user','UserController@list');

	Route::resource('/property','PropertyController');
	Route::get('/list_property','PropertyController@list');
	Route::post('/add_photo','PropertyController@add_photo');

	Route::resource('/blog','BlogController');
	Route::get('/list_blog','BlogController@list');

	Route::resource('/care','CareController');
	Route::get('/list_care','CareController@list');

	Route::resource('/amenity','AmenityController');
	Route::get('/list_amenity','AmenityController@list');

	Route::resource('/package','PackageController');
	Route::get('/list_package','PackageController@list');

	Route::resource('/state','StateController');
	Route::get('/list_state','StateController@list');

	Route::resource('/city','CityController');
	Route::get('/list_city','CityController@list');

	Route::resource('/tag','TagController');
	Route::get('/list_tag','TagController@list');
	
	Route::post('/delete_common','CommonController@delete_common');
	Route::post('/active_inactive_common','CommonController@active_inactive_common');		
	Route::get('/download_doc_common','CommonController@download_doc_common');		

	Route::get('/profile_edit','UserController@profile_edit');
	Route::post('/profile_update','UserController@profile_update');

	Route::get('/content_manage','ContentManageController@edit');
	Route::post('/content_manage','ContentManageController@update');

	Route::get('test',function(){
		return view('admin.test');
	});
});
/*---------- END - Admin Routes ----------*/

/*---------- START - Front Routes ----------*/
Route::get('/','HomeController@index')->name('home');

Route::get('/best-senior-living','HomeController@bestSeniorLiving')->name('best-senior-living');
Route::post('/get-property-by-care','HomeController@getPropertyByCare')->name('get-property-by-care');

Route::get('/blog','HomeController@blog')->name('blog');
Route::post('/blog-list-data','HomeController@blogListData')->name('blog-list-data');
Route::get('/blog/{id}','HomeController@singleBlog')->name('single-blog');

Route::get('/properties-list','HomeController@propertiesList')->name('properties-list');
Route::post('/properties-list-data','HomeController@propertiesListData')->name('properties-list-data');
Route::get('/properties-single/{id}','HomeController@propertiesSingle')->name('properties-single');

Route::get('/list-community','HomeController@listCommunity')->name('list-community');
Route::post('/list-community','HomeController@postlistCommunity')->name('post-list-community');
Route::get('/about','HomeController@about')->name('about');
Route::get('/contact-us','HomeController@contactus')->name('contact-us');
Route::post('/contact-us','HomeController@postContactUs')->name('post-contact-us');

Route::get('/terms-of-service','HomeController@termsofservice')->name('terms-of-service');
Route::get('/privacy-policy','HomeController@privacypolicy')->name('privacy-policy');

Route::get('/maptest','HomeController@maptest');
Route::get('/maptest1','HomeController@maptest1');

Route::get('/login','HomeController@login');
/*---------- END - Front Routes ----------*/

/*---------- START - Extra Common routes ----------*/
Route::post('/refresh_captcha_image','CommonController@refresh_captcha_image');
Route::post('/get_city_by_state','CommonController@get_city_by_state');
Route::get('/get_image/{file_path}/{file_name}/{any?}', 'CommonController@get_image');
/*---------- END - Extra Common routes ----------*/

// Auth::routes(); // Default Auth Routes
/*---------- START - Admin Auth routes ----------*/
Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/admin/register', 'Auth\RegisterController@register');

Route::get('/admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/admin/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/admin/reset_password_email','HomeController@adminResetPasswordEmail');
Route::get('/admin/reset_password','HomeController@adminResetPassword');
Route::get('/admin/verify','HomeController@verify');
/*---------- END - Admin Auth routes ----------*/

