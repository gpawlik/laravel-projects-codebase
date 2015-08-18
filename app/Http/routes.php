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

  //reminders
  Route::get('/reminders','ReminderController@index');
  Route::get('/reminders/add','ReminderController@add');
  Route::post('/reminders/create','ReminderController@create');
  Route::get('/reminders/view/{id}','ReminderController@view');
  Route::get('/reminders/edit/{id}','ReminderController@edit');
  Route::post('/reminders/update/{id}','ReminderController@update');
  Route::get('/reminders/delete/{id}','ReminderController@delete');

  Route::get('/reminders/complete/{id}','ReminderController@complete');
  Route::get('/reminders/undo/{id}','ReminderController@undoComplete');

  //messages
  Route::get('/messages','MessageController@index');
  Route::get('/messages/add','MessageController@add');
  Route::post('/messages/create','MessageController@create');
  Route::get('/messages/view/{id}','MessageController@view');


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

      //branches routes
      Route::get('/branches','BranchController@index');
      Route::get('/branches/add','BranchController@add');
      Route::post('/branches/create','BranchController@create');
      Route::get('/branches/edit/{id}','BranchController@edit');
      Route::post('/branches/update/{id}','BranchController@update');
      Route::get('/branches/delete/{id}','BranchController@delete');
      Route::get('/branches/view/{id}','BranchController@view');
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
      Route::get('/employees/search','EmployeeController@search');

      //departments routes
      Route::get('/departments','DepartmentController@index');
      Route::get('/departments/add','DepartmentController@add');
      Route::post('/departments/create','DepartmentController@create');
      Route::get('/departments/edit/{id}','DepartmentController@edit');
      Route::post('/departments/update/{id}','DepartmentController@update');
      Route::get('/departments/delete/{id}','DepartmentController@delete');
      Route::get('/departments/view/{id}','DepartmentController@view');
      Route::get('/departments/search','DepartmentController@search');

      //jobs routes
      Route::get('/jobs','JobController@index');
      Route::get('/jobs/add','JobController@add');
      Route::post('/jobs/create','JobController@create');
      Route::get('/jobs/edit/{id}','JobController@edit');
      Route::post('/jobs/update/{id}','JobController@update');
      Route::get('/jobs/delete/{id}','JobController@delete');
      Route::get('/jobs/view/{id}','JobController@view');
      Route::get('/jobs/search','JobController@search');

      //pay grades routes
      Route::get('/pay_grades','PayGradeController@index');
      Route::get('/pay_grades/add','PayGradeController@add');
      Route::post('/pay_grades/create','PayGradeController@create');
      Route::get('/pay_grades/edit/{id}','PayGradeController@edit');
      Route::post('/pay_grades/update/{id}','PayGradeController@update');
      Route::get('/pay_grades/delete/{id}','PayGradeController@delete');
      Route::get('/pay_grades/view/{id}','PayGradeController@view');

      //applications routes
      Route::get('/applications','ApplicationController@index');
      Route::get('/applications/add','ApplicationController@add');
      Route::post('/applications/create','ApplicationController@create');
      Route::get('/applications/edit/{id}','ApplicationController@edit');
      Route::post('/applications/update/{id}','ApplicationController@update');
      Route::get('/applications/delete/{id}','ApplicationController@delete');
      Route::get('/applications/view/{id}','ApplicationController@view');
      Route::get('/applications/accept_application/{id}','ApplicationController@acceptApplication');
      Route::get('/applications/decline_application/{id}','ApplicationController@declineApplication');
      Route::get('/applications/search','ApplicationController@search');

      //ranks routes
      Route::get('/ranks','RankController@index');
      Route::get('/ranks/add','RankController@add');
      Route::post('/ranks/create','RankController@create');
      Route::get('/ranks/edit/{id}','RankController@edit');
      Route::post('/ranks/update/{id}','RankController@update');
      Route::get('/ranks/delete/{id}','RankController@delete');
      Route::get('/ranks/view/{id}','RankController@view');
      Route::get('/ranks/search','RankController@search');

      //ranks routes
      Route::get('/leaves','LeaveController@index');
      Route::get('/leaves/add','LeaveController@add');
      Route::post('/leaves/create','LeaveController@create');
      Route::get('/leaves/edit/{id}','LeaveController@edit');
      Route::post('/leaves/update/{id}','LeaveController@update');
      Route::get('/leaves/delete/{id}','LeaveController@delete');
      Route::get('/leaves/view/{id}','LeaveController@view');
      Route::get('/leaves/search','LeaveController@search');

      //orientations routes
      Route::get('/orientations','OrientationController@index');
      Route::get('/orientations/add','OrientationController@add');
      Route::post('/orientations/create','OrientationController@create');
      Route::get('/orientations/edit/{id}','OrientationController@edit');
      Route::post('/orientations/update/{id}','OrientationController@update');
      Route::get('/orientations/delete/{id}','OrientationController@delete');
      Route::get('/orientations/view/{id}','OrientationController@view');

      //terminations routes
      Route::get('/job_terminations','TerminationController@index');
      Route::get('/job_terminations/add','TerminationController@add');
      Route::post('/job_terminations/create','TerminationController@create');
      Route::get('/job_terminations/edit/{id}','TerminationController@edit');
      Route::post('/job_terminations/update/{id}','TerminationController@update');
      Route::get('/job_terminations/delete/{id}','TerminationController@delete');
      Route::get('/job_terminations/view/{id}','TerminationController@view');
      Route::get('/job_terminations/terminated_employee/{id}','TerminationController@terminatedEmployeeDetails');
      Route::get('/job_terminations/revert_termination/{id}','TerminationController@revertTermination');

      //training routes
      Route::get('/training','TrainingController@index');
      Route::get('/training/add','TrainingController@add');
      Route::post('/training/create','TrainingController@create');
      Route::get('/training/edit/{id}','TrainingController@edit');
      Route::post('/training/update/{id}','TrainingController@update');
      Route::get('/training/delete/{id}','TrainingController@delete');
      Route::get('/training/view/{id}','TrainingController@view');
      Route::get('/training/trained_employee/{id}','TrainingController@trainedEmployee');

});

//inner application API routes
Route::group(['middleware' => 'auth', 'prefix' => "api/v1"], function()
{
  	Route::get('/users/{id}','UserController@apiGetUsers');
    Route::get('/employees/{id}','EmployeeController@apiGetEmployees');
    Route::get('/employee_search/{id}','EmployeeController@apiSearch');
    Route::get('/department_search/{id}','DepartmentController@apiSearch');
    Route::get('/rank_search/{id}','RankController@apiSearch');
    Route::get('/application_search/{id}','ApplicationController@apiSearch');
    Route::get('/job_search/{id}','JobController@apiSearch');
    Route::get('/leave_search/{id}','LeaveController@apiSearch');
});
