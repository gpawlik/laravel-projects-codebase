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
      Route::get('/roles','RoleController@index');
      Route::get('/roles/add','RoleController@add');
      Route::post('/roles/create','RoleController@create');
      Route::get('/roles/edit/{id}','RoleController@edit');
      Route::post('/roles/update/{id}','RoleController@update');
      Route::get('/roles/delete/{id}','RoleController@delete');
      Route::get('/roles/view/{id}','RoleController@view');
      Route::get('/roles/permissions/{id}','RoleController@permissions');
      Route::post('/roles/save_permissions/{id}','RoleController@savePermissions');
      Route::get('/roles/search','RoleController@search');

      //permission routes
      Route::get('/permissions','PermissionController@index');
      Route::get('/permissions/add','PermissionController@add');
      Route::post('/permissions/create','PermissionController@create');
      Route::get('/permissions/edit/{id}','PermissionController@edit');
      Route::post('/permissions/update/{id}','PermissionController@update');
      Route::get('/permissions/delete/{id}','PermissionController@delete');
      Route::get('/permissions/view/{id}','PermissionController@view');
      Route::get('/permissions/search','PermissionController@search');

      //company info routes
      Route::get('/company','CompanyController@index');
      Route::post('/company/save','CompanyController@save');

      //banks routes
      Route::get('/banks/search','BankController@search');
      Route::get('/banks/delete/{id}','BankController@delete');
      Route::resource('banks','BankController');

      //identification routes
      Route::get('/identification','IdentificationController@index');
      Route::get('/identification/add','IdentificationController@add');
      Route::post('/identification/create','IdentificationController@create');
      Route::get('/identification/edit/{id}','IdentificationController@edit');
      Route::post('/identification/update/{id}','IdentificationController@update');
      Route::get('/identification/delete/{id}','IdentificationController@delete');
      Route::get('/identification/view/{id}','IdentificationController@view');
      Route::get('/identification/search','IdentificationController@search');

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
