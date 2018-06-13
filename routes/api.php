<?php



$api = app(\Dingo\Api\Routing\Router::class);


//$categories=factory(App\Category::class,3)
//    ->create()
//    ->each(function ($u) {
//        $u->secrets()->saveMany(factory(App\Secret::class, 5)->make());
//    });


$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\AuthController@authenticate');

    $api->post('register', 'App\Http\Controllers\AuthController@register');

});
$api->version('v1', ['middleware' => ['api.auth'], 'namespace' => 'App\Http\Controllers'], function ($api) {
//    $api->get('user', 'AuthController@user');
    $api->post('logout', 'App\Http\Controllers\AuthController@logout');
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

    $api->get('roles', 'RoleController@index');
    $api->get('roles/{id}', 'RoleController@show');
    $api->post('roles', 'RoleController@store');
    $api->put('roles/{id}', 'RoleController@store');
    $api->delete('roles/{id}', 'RoleController@destroy');


});


