<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect("auth/login");
});

Route::get('/home', function () {
    return redirect("/dashboard");
});

//Auth Routes: not explicit
Route::controllers([
    'auth' => '\App\Http\Controllers\Auth\AuthController',
    'password' => '\App\Http\Controllers\Auth\PasswordController',
]);

Route::get('/auth/change_password',function(){
  return "ddd";
});


//Dashboard routes
Route::group(['middleware' => ['auth'], 'prefix' => "dashboard"], function()
{
    	Route::get('/','DashboardController@index');

});

Route::group(['middleware' => ['auth'], 'prefix' => "system"], function()
{
      //users routes
      Route::get('/users','UserController@index');
      Route::get('/users/add','UserController@add');
      Route::post('/users/create','UserController@create');
      Route::get('/users/edit/{id}','UserController@edit');
      Route::post('/users/update','UserController@update');
});

//inner application API routes
Route::group(['middleware' => 'auth', 'prefix' => "api/v1"], function()
{
  	Route::get('/users','UserController@apiGetUsers');
});
