<?php


$api = app(\Dingo\Api\Routing\Router::class);


//$categories=factory(App\Category::class,3)
//    ->create()
//    ->each(function ($u) {
//        $u->secrets()->saveMany(factory(App\Secret::class, 5)->make());
//    });


$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\AuthController@login');
//    $api->get('users', 'App\Http\Controllers\UserController@index');
//    $api->post('register', 'App\Http\Controllers\UserController@register');




});
$api->version('v1', ['middleware' => ['api.auth'], 'namespace' => 'App\Http\Controllers'], function ($api) {
    $api->post('logout', 'AuthController@logout');
    $api->get('users', 'UserController@index');

    $api->post('share/{id}', 'ShareSecretController@share');
    $api->post('revert/{id}', 'ShareSecretController@revert');

    $api->post('/search', 'SearchController@search');


});

$api->version('v1',[ 'namespace' => 'App\Http\Controllers'], function ($api) {
    $api->get('token', 'AuthController@refresh');
});


$api->version('v1', ['middleware' => ['api.auth'], 'namespace' => 'App\Http\Controllers'], function ($api) {
    $api->get('categories', 'CategoryController@index');
    $api->get('categories/{id}', 'CategoryController@show');
    $api->post('categories', 'CategoryController@store');
    $api->put('categories/{id}', 'CategoryController@update');
    $api->delete('categories/{id}', 'CategoryController@destroy');


    $api->get('secrets', 'SecretController@index');
    $api->get('secrets/{id}', 'SecretController@show');
    $api->post('secrets', 'SecretController@store');
    $api->put('secrets/{id}', 'SecretController@update');
    $api->delete('secrets/{id}', 'SecretController@destroy');




});


