<?php

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

// $app->get('/', function () use ($app) {
//     return $app->version();
// });

$app->get('/', function () use ($app) {
	return $app->version();
});

$app->group(['prefix' => 'api/v1'], function ($app) {
	$app->post('auth', 'AuthController@auth');
	$app->group(['middleware' => 'auth'], function ($app) {
		$app->get('user', 'UserController@index');
		$app->get('user/{id}', 'UserController@show');
		$app->post('user', 'UserController@store');
		$app->patch('user/{id}', 'UserController@update');
		$app->delete('user/{id}', 'UserController@destroy');

		$app->get('todo', 'TodoController@index');
		$app->get('todo/{id}', 'TodoController@show');
		$app->post('todo', 'TodoController@store');
		$app->patch('todo/{id}', 'TodoController@update');
		$app->delete('todo/{id}', 'TodoController@destroy');
	});
});
