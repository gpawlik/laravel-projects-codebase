<?php

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
