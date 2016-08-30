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

Route::group(['middleware' => 'auth' ], function () {
    Route::get('/tasks', 'TaskController@view');
    Route::put('/tasks', 'TaskController@updateAll');
    Route::get('/projects/{id}/confirmdelete', 'ProjectController@confirmDelete');

    Route::group(['prefix' => 'api'], function(){
        Route::resource('tasks', 'TaskController');
        Route::resource('projects', 'ProjectController');
    });
} );

Route::auth();

Route::get('/home', 'HomeController@index');
