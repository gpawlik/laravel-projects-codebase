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
      Route::post('/users/update/{id}','UserController@update');
      Route::get('/users/delete/{id}','UserController@delete');
      Route::get('/users/view/{id}','UserController@view');

      //Role routes
      Route::get('/roles','RoleController@index');
      Route::get('/roles/add','RoleController@add');
      Route::post('/roles/create','RoleController@create');
      Route::get('/roles/edit/{id}','RoleController@edit');
      Route::post('/roles/update/{id}','RoleController@update');
      Route::get('/roles/delete/{id}','RoleController@delete');
      Route::get('/roles/view/{id}','RoleController@view');
      Route::get('/roles/permissions/{id}','RoleController@permissions');
      Route::post('/roles/save_permissions/{id}','RoleController@savePermissions');

      //permission routes
      Route::get('/permissions','PermissionController@index');
      Route::get('/permissions/add','PermissionController@add');
      Route::post('/permissions/create','PermissionController@create');
      Route::get('/permissions/edit/{id}','PermissionController@edit');
      Route::post('/permissions/update/{id}','PermissionController@update');
      Route::get('/permissions/delete/{id}','PermissionController@delete');
      Route::get('/permissions/view/{id}','PermissionController@view');
});

//inner application API routes
Route::group(['middleware' => 'auth', 'prefix' => "api/v1"], function()
{
  	Route::get('/users','UserController@apiGetUsers');
});