<?php

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user','User');
Route::model('estudio','Estudio');
Route::model('familia','Famila');
Route::model('unidad', 'Unidad');
Route::model('solicitud', 'Solicitud');
Route::model('folio', 'Folio');

//index route
Route::get('/', function()
{
	return View::make('hello');
});

Route::get('sol', function()
{
	return View::make('emails.solicitud');
});

// Confide routes
/*Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');*/

/*Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');*/

//Usuarios
Route::get('users/login', function(){
	return View::make('users.login');
});
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/forgot_password', function(){
	return View::make('users.forgot');
});
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', function($token){
	return View::make('users.reset')->with(['token' => $token]);
});
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
Route::get('users/confirm/{code}', 'UsersController@confirm');

//App Routes
Route::group(array('prefix'=>'app'), function(){
	//Estudios
	Route::get('estudios/data', 'EstudiosController@data');
	Route::resource('estudios', 'EstudiosController');
	//Familias
	Route::get('familias/data', 'FamiliasController@data');
	Route::resource('familias', 'FamiliasController');
	//Unidades
	Route::get('unidades/data', 'UnidadesController@data');
	Route::get('unidades/prueba', 'UnidadesController@prueba');
	Route::get('unidades/pruebadata', 'UnidadesController@pruebadata');
	Route::resource('unidades', 'UnidadesController');
	//Solicitudes
	Route::get('solicitudes/data', 'SolicitudesController@data');
	Route::post('solicitudes/send', 'SolicitudesController@send');
	Route::get('solicitudes/{solicitud}/mail', 'SolicitudesController@viewMail');
	Route::resource('solicitudes', 'SolicitudesController');
});

Route::resource('formulario', 'FormularioController');
