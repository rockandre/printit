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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');



// Routes admin
Route::get('/requests', 'RequestController@show')->name('requests.show');
Route::get('/admin/users', 'AdministratorController@showUsers')->name('users.admin');
Route::get('/admin/comments', 'AdministratorController@showComments')->name('comments.admin');

Route::get('request/refuse/{id}', 'RequestController@refuseRequest')->name('refuse.request');
Route::post('request/refuse/{id}', 'RequestController@updateRefuseRequest')->name('refuse.request');
Route::get('request/finish/{id}', 'RequestController@finishRequest')->name('finish.request');
Route::post('request/finish/{id}', 'RequestController@updateFinishRequest')->name('finish.request');