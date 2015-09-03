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

// Need to append valid user_id and token to the query string
Route::group(['middleware' => 'auth.access'], function() {
    // Retrieve user info by primary key: id/username/email
    Route::get('/v1/user/{key}', [
        'uses' => 'User@read',
    ]);
    // Update user info by primary key: id/username/email
    Route::put('/v1/user/{key}', [
        'uses' => 'User@update',
    ]);
    // Delete user by primary key: id/username/email
    Route::delete('/v1/user/{key}', [
        'uses' => 'User@delete',
    ]);
    // Create new blog
    Route::post('/v1/blog', [
        'uses' => 'Blog@create',
    ]);
    // Retrieve all blogs belong to user with user_id
    Route::get('/v1/blog', [
        'uses' => 'Blog@readAll',
    ]);
    // Retrieve blog info by blog id
    Route::get('/v1/blog/{id}', [
        'uses' => 'Blog@read',
    ]);
    // Update blog info by blog id
    Route::put('/v1/blog/{id}', [
        'uses' => 'Blog@update',
    ]);
    // Delete blog info by blog id
    Route::delete('/v1/blog/{id}', [
        'uses' => 'Blog@delete',
    ]);
});

// Sign up new user
Route::post('/v1/user', [
    'uses' => 'Auth\AuthController@register',
]);

// User login by username or email
Route::post('/login', [
    'uses' => 'Auth\AuthController@login',
]);

// User logout with user id and access token
Route::post('/logout', [
    'uses' => 'Auth\AuthController@logout',
]);
