<?php

//Route::group([
//
//    'prefix' => 'auth',
//
//], function () {
//
//    Route::post('login', 'AuthController@login');
//    Route::post('logout', 'AuthController@logout');
//    Route::post('refresh', 'AuthController@refresh');
//    Route::post('me', 'AuthController@me');
//
//});

$api = app(\Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {
    $api->get('users', function () {
       return \App\User::all();
    });
});


$api->version('v1', function ($api) {
    $api->get('test', function () {
        return "This  is a test";
    });
});

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt-auth'], function ($api) {
        $api->get('categories', 'App\Api\Controllers\CategoryController@index');
        $api->get('categories/{id}', 'App\Api\Controllers\CategoryController@show');
        $api->post('categories/', 'App\Api\Controllers\CategoryController@store');
        $api->put('categories/', 'App\Api\Controllers\CategoryController@store');
        $api->delete('categories/{id}', 'App\Api\Controllers\CategoryController@destroy');
    });
});
