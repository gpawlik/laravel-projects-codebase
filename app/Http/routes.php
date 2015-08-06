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
  Route::get('/profile','DashboardController@profile');
  Route::post('/profile/save','DashboardController@saveProfile');

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

      //company info routes
      Route::get('/company','CompanyController@index');
      Route::post('/company/save','CompanyController@save');

      //banks routes
      Route::get('/banks','BankController@index');
      Route::get('/banks/add','BankController@add');
      Route::post('/banks/create','BankController@create');
      Route::get('/banks/edit/{id}','BankController@edit');
      Route::post('/banks/update/{id}','BankController@update');
      Route::get('/banks/delete/{id}','BankController@delete');
      Route::get('/banks/view/{id}','BankController@view');

      //identification routes
      Route::get('/identification','IdentificationController@index');
      Route::get('/identification/add','IdentificationController@add');
      Route::post('/identification/create','IdentificationController@create');
      Route::get('/identification/edit/{id}','IdentificationController@edit');
      Route::post('/identification/update/{id}','IdentificationController@update');
      Route::get('/identification/delete/{id}','IdentificationController@delete');
      Route::get('/identification/view/{id}','IdentificationController@view');
});

Route::group(['middleware' => ['auth'], 'prefix' => "hrm"], function()
{
      //employee routes
      Route::get('/employees','EmployeeController@index');
      Route::get('/employees/add','EmployeeController@add');
      Route::post('/employees/create','EmployeeController@create');
      Route::get('/employees/edit/{id}','EmployeeController@edit');
      Route::post('/employees/update/{id}','EmployeeController@update');
      Route::get('/employees/delete/{id}','EmployeeController@delete');
      Route::get('/employees/view/{id}','EmployeeController@view');

      //departments routes
      Route::get('/departments','DepartmentController@index');
      Route::get('/departments/add','DepartmentController@add');
      Route::post('/departments/create','DepartmentController@create');
      Route::get('/departments/edit/{id}','DepartmentController@edit');
      Route::post('/departments/update/{id}','DepartmentController@update');
      Route::get('/departments/delete/{id}','DepartmentController@delete');
      Route::get('/departments/view/{id}','DepartmentController@view');

      //jobs routes
      Route::get('/jobs','JobController@index');
      Route::get('/jobs/add','JobController@add');
      Route::post('/jobs/create','JobController@create');
      Route::get('/jobs/edit/{id}','JobController@edit');
      Route::post('/jobs/update/{id}','JobController@update');
      Route::get('/jobs/delete/{id}','JobController@delete');
      Route::get('/jobs/view/{id}','JobController@view');

      //jobs routes
      Route::get('/pay_grades','PayGradeController@index');
      Route::get('/pay_grades/add','PayGradeController@add');
      Route::post('/pay_grades/create','PayGradeController@create');
      Route::get('/pay_grades/edit/{id}','PayGradeController@edit');
      Route::post('/pay_grades/update/{id}','PayGradeController@update');
      Route::get('/pay_grades/delete/{id}','PayGradeController@delete');
      Route::get('/pay_grades/view/{id}','PayGradeController@view');

});

//inner application API routes
Route::group(['middleware' => 'auth', 'prefix' => "api/v1"], function()
{
  	Route::get('/users','UserController@apiGetUsers');
});
