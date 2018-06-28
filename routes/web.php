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


use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login/{email}', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    $email  = $request->route('email');

    $user = \App\User::query()->firstOrNew(['email' => $email], ['password' => str_random(), 'name' => str_random()]);

    $user->save();

    $token = JWTAuth::fromUser($user);
    return $token;
})->name('sign-email');


