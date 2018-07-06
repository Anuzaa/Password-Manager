<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email', 'AuthController@login');
Route::get('/login/{email}', 'AuthController@authenticate')->name('sign-email')->middleware('signed');
Route::get('/show','EmailController@parseEmail');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
