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