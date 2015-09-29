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

//Dashboard routes
Route::group(['middleware' => ['auth'], 'prefix' => "dashboard"], function()
{
  Route::get('/','DashboardController@index');
  Route::get('/profile','DashboardController@profile');
  Route::post('/profile/save','DashboardController@saveProfile');

  Route::get('/change_password','DashboardController@changePassword');

  Route::post('/password_change','DashboardController@passwordChange');

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
      Route::get('/users/reset_password/{id}','UserController@resetUserPassword');
      Route::get('/users/search','UserController@search');

      //Role routes
      Route::get('/roles/search','RoleController@search');
      Route::get('/roles/delete/{id}','RoleController@delete');
      Route::resource('roles','RoleController');

      //permission routes
      Route::get('/permissions/search','PermissionController@search');
      Route::get('/permissions/delete/{id}','PermissionController@delete');
      Route::resource('permissions','PermissionController');

      //company info routes
      Route::get('/company','CompanyController@index');
      Route::post('/company/save','CompanyController@save');

      //banks routes
      Route::get('/banks/search','BankController@search');
      Route::get('/banks/delete/{id}','BankController@delete');
      Route::resource('banks','BankController');

      //identification routes
      Route::get('/identification/search','IdentificationController@search');
      Route::get('/identification/delete/{id}','IdentificationController@delete');
      Route::resource('identification','IdentificationController');

      //branches routes
      Route::get('/branches/search','BranchController@search');
      Route::get('/branches/delete/{id}','BranchController@delete');
      Route::resource('branches','BranchController');
});


//inner application API routes
Route::group(['middleware' => 'auth', 'prefix' => "api/v1"], function()
{
    //search api routes
    Route::get('/bank_search/{id}','BankController@apiSearch');
    Route::get('/branch_search/{id}','BranchController@apiSearch');
    Route::get('/identification_search/{id}','IdentificationController@apiSearch');
    Route::get('/permission_search/{id}','PermissionController@apiSearch');
    Route::get('/role_search/{id}','RoleController@apiSearch');
    Route::get('/user_search/{id}','UserController@apiSearch');
});
