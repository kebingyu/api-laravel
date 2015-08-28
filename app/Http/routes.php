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
    return view('welcome');
});

// Retrieve user info by primary key: id/username/email
Route::get('/v1/user/{key}', [
    //'middleware' => 'auth.basic.once',
    'uses' => 'User@read',
]);

// Sign up new user
Route::post('/v1/user', [
    'uses' => 'Auth\AuthController@register',
]);

// Update user info by primary key: id/username/email
Route::put('/v1/user/{key}', [
    'uses' => 'User@update',
]);

// Update user by primary key: id/username/email
Route::delete('/v1/user/{key}', [
    'uses' => 'User@delete',
]);

// User login by username or email
Route::post('/v1/user/login', [
    'uses' => 'User@login',
]);

// User logout
Route::post('/v1/user/logout', [
    'uses' => 'User@logout',
]);
