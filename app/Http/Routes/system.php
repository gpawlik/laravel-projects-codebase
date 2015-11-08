<?php

Route::group(['middleware' => ['auth'], 'prefix' => "system"], function()
{
      //users routes
      Route::get('/users/search','UserController@search');
      Route::get('/users/delete/{id}','UserController@delete');
      Route::get('/users/reset_password/{id}','UserController@resetUserPassword');
      Route::resource('users','UserController');

      //Role routes
      Route::get('/roles/search','RoleController@search');
      Route::get('/roles/delete/{id}','RoleController@delete');
      Route::get('/roles/permissions/{id}','RoleController@permissions');
      Route::post('/roles/save_permissions/{id}','RoleController@savePermissions');
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