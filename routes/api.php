<?php



$api = app(\Dingo\Api\Routing\Router::class);

//$factory->define(App\Post::class, function ($faker) {
//    return [
//        'title' => $faker->title,
//        'content' => $faker->paragraph,
//        'user_id' => function () {
//            return factory(App\User::class)->create()->id;
//        },
//    });

$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\AuthController@authenticate');
    $api->post('logout', 'App\Http\Controllers\AuthController@logout');
    $api->post('token', 'App\Http\Controllers\AuthController@getToken');
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
    $api->put('secrets', 'SecretController@store');
    $api->delete('secrets/{id}', 'SecretController@destroy');

    $api->get('roles', 'RoleController@index');
    $api->get('roles/{id}', 'RoleController@show');
    $api->post('roles', 'RoleController@store');
    $api->put('roles', 'RoleController@store');
    $api->delete('roles/{id}', 'RoleController@destroy');


});


