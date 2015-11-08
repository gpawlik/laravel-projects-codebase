<?php


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