<?php

//Dashboard routes
Route::group(['middleware' => ['auth'], 'prefix' => "dashboard"], function()
{
  Route::get('/','DashboardController@index');
  Route::get('/profile','DashboardController@profile');
  Route::post('/profile/save','DashboardController@saveProfile');

  Route::get('/change_password','DashboardController@changePassword');

  Route::post('/password_change','DashboardController@passwordChange');

});