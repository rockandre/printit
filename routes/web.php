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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@users')->name('users.show');
Route::get('/showUser/{id}', 'UserController@showUser')->name('showUser');
Route::get('/statistics', 'UserController@statistics')->name('statistics');

Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');

Route::get('request/create', 'RequestController@create')->name('request.create');
Route::post('request/create', 'RequestController@store')->name('request.create');
Route::get('request/edit/{request}', 'RequestController@edit')->name('request.edit');
Route::post('request/edit/{requestToUpdate}', 'RequestController@update')->name('request.update');

Route::post('requests', 'RequestController@filter')->name('request.filter');

// Routes requests
Route::get('/requests', 'RequestController@listRequests')->name('requests.list');
Route::delete('/request/delete/{request}', 'RequestController@deleteRequest')->name('delete.request');
Route::get('request/refuse/{id}', 'RequestController@refuseRequest')->name('refuse.request');
Route::post('request/refuse/{id}', 'RequestController@updateRefuseRequest')->name('refuse.request');
Route::get('request/finish/{id}', 'RequestController@finishRequest')->name('finish.request');
Route::post('request/finish/{id}', 'RequestController@updateFinishRequest')->name('finish.request');
Route::get('request/show/{id}', 'RequestController@showRequest')->name('show.request');
Route::post('request/evaluate/{id}', 'RequestController@evaluateRequest')->name('evaluate.request');


/*Route::get('/requests/{search?}', 'RequestController@search')->name('requests.search');
Route::get('/requests/{orderParam?}/{orderType?}', 'RequestController@orderBy')->name('requests.search');*/


// Routes admin
Route::get('/users/blocked', 'UserController@showBlockedUsers')->name('users.blocked');
Route::post('/user/unlock/{id}', 'UserController@unlockUser')->name('unlock.user');
//Route::get('/admin/comments', 'AdministratorController@showComments')->name('comments.admin');


//Route Image
Route::get('/profileImage/{filename}', function ($filename)
{
	return Image::make(Storage::disk('local')->get('public/profiles/'.$filename))->response();
})->name('profile.image');
