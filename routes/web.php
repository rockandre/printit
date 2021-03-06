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

// ROUTES AUTHENTICATION AND EMAIL CONFIRMATION
Auth::routes();
Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');


// ROUTES PAGINA INICIAL
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

// ROUTES USERS
// Listar e filtrar utilizadores
Route::get('/users', 'UserController@listUsers')->name('users.list');

// Mostrar utilizador
Route::get('/user/{id}', 'UserController@showUser')->name('user.show');


// ROUTES REQUESTS

Route::group(['middleware' => 'auth'], function() {
	// Listar e Filtrar requests
	Route::get('/requests', 'RequestController@listRequests')->name('requests.list');

	// Eliminar request
	Route::delete('/request/delete/{request}', 'RequestController@deleteRequest')->name('delete.request');

	// Recusar request
	Route::get('/request/refuse/{id}', 'RequestController@refuseRequest')->name('refuse.request');
	Route::post('/request/refuse/{id}', 'RequestController@updateRefuseRequest')->name('refuse.request');

	// Concluir request
	Route::get('/request/finish/{id}', 'RequestController@finishRequest')->name('finish.request');
	Route::post('/request/finish/{id}', 'RequestController@updateFinishRequest')->name('finish.request');

	// Mostrar e Avaliar request
	Route::get('/request/show/{id}', 'RequestController@showRequest')->name('show.request');
	Route::post('/request/evaluate/{id}', 'RequestController@evaluateRequest')->name('evaluate.request');

	// Criar request
	Route::get('/request/create', 'RequestController@create')->name('request.create');
	Route::post('/request/create', 'RequestController@store')->name('request.store');

	// Editar request
	Route::get('/request/edit/{request}', 'RequestController@edit')->name('request.edit');
	Route::post('/request/edit/{requestToUpdate}', 'RequestController@update')->name('request.update');

	// Comentar request
	Route::post('/request/comment/{request_id}/{comment_id?}', 'CommentController@create')->name('request.comment');
});


// Routes admin
Route::group(['middleware' => 'admin'], function() {
	Route::get('/users/blocked', 'UserController@showBlockedUsers')->name('users.blocked');
	Route::get('/comments/blocked', 'CommentController@showBlockedComments')->name('comments.blocked');
	Route::post('/user/unlock/{id}', 'UserController@unlockUser')->name('unlock.user');
	Route::post('/user/block/{id}', 'UserController@blockUser')->name('block.user');
	Route::post('/user/admin/{id}', 'UserController@makeUserAdmin')->name('admin.user');
	Route::post('/user/normal/{id}', 'UserController@revokeUserAdmin')->name('normal.user');
	Route::post('/comment/block/{comment}/{request_id}', 'CommentController@blockComment')->name('comment.block');
	Route::post('/comment/unlock/{comment}', 'CommentController@unlockComment')->name('comment.unlock');
});



Route::get('/department/{id}', 'DepartmentController@statistics')->name('department.stats');

// Route Image
Route::get('/profileImage/{filename}', function ($filename)
{
	return Image::make(Storage::disk('local')->get('public/profiles/'.$filename))->response();
})->name('profile.image')->middleware('auth');
