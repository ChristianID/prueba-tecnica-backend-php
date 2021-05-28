<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('movies/recommended',                'MoviesController@recommended');

Route::post('auth/login',                       'AuthController@login');
Route::post('auth/logout',                      'AuthController@logout');

Route::get('movies',                            'MoviesController@list');
Route::post('movies/store',                     'MoviesController@store');
Route::patch('movies/{id}/update',              'MoviesController@update');
Route::patch('movies/{id}/schedule/update',     'MoviesController@syncSchedules');
Route::delete('movies/{id}/delete',             'MoviesController@delete');

Route::get('schedules',                         'SchedulesController@list');
Route::post('schedules/store',                  'SchedulesController@store');
Route::patch('schedules/{id}/update',           'SchedulesController@update');
Route::delete('schedules/{id}/delete',          'SchedulesController@delete');
