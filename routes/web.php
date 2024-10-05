<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
//login
$router->post('/login', [
    'as' => 'login', 'uses' => 'UserController@login'
]);
//user
$router->get('/getUsers', [
    'as' => 'getUsers', 'uses' => 'UserController@getUsers'
]);
$router->get('/usuarios/{id}', [
    'as' => 'usuarioId', 'uses' => 'UserController@show'
]);
$router->post('/usuarios/edit', [
    'as' => 'usuarioEdit', 'uses' => 'UserController@edit'
]);
$router->delete('/usuarios/{id}', [
    'as' => 'usuarioDelete', 'uses' => 'UserController@destroy'
]);
/*$router->post('/usuario/new', [
    'as' => 'usuarioCrear', 'uses' => 'UserController@create'
]);*/

//profesionales
$router->get('/getProfesionales', [
    'as' => 'getProfesionales', 'uses' => 'UserController@getProfesionales'
]);
// pacientes
$router->get('/getPacientes', [
    'as' => 'getPacientes', 'uses' => 'UserController@getPacientes'
]);
//recetas
$router->get('/getAllRecetas', [
    'as' => 'getAllRecetas', 'uses' => 'RecetasController@getAll'
]);
$router->get('/recetas/{id}', [
    'as' => 'recetaId', 'uses' => 'RecetasController@show'
]);
$router->put('/recetas/{id}', [
    'as' => 'recetaEdit', 'uses' => 'RecetasController@edit'
]);
$router->delete('/recetas/{id}', [
    'as' => 'recetaDelete', 'uses' => 'RecetasController@destroy'
]);

// Perfiles
$router->get('/perfiles/{id}', [
    'as' => 'perfilId', 'uses' => 'PerfilesController@show'
]);
/// Google
$router->get('/google', [
    'as' => 'google', 'uses' => 'GoogleController@redirectToGoogle'
]);
$router->get('/google-login', [
    'as' => 'google', 'uses' => 'GoogleController@redirectToGoogleLogin'
]);
$router->get('/calendar/create-event', [
    'as' => 'calendar', 'uses' => 'GoogleController@createEvent'
]);
$router->get('/google/callback', [
    'as' => 'google', 'uses' => 'GoogleController@handleGoogleCallback'
]);
$router->get('/google/callback-login', [
    'as' => 'google', 'uses' => 'GoogleController@handleGoogleLoginCallback'
]);

$router->options('/{any:.*}', function () {
    return response('', 200)
    ->header('Access-Control-Allow-Origin', '*')
    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
});


$router->group(['middleware' => 'App\Http\Middleware\CorsMiddleware'], function () use ($router) {
    $router->post('/usuario/new', [
        'as' => 'usuarioCrear', 'uses' => 'UserController@create'
    ]);
});
