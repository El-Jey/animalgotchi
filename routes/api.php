<?php

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

Route::get('/animals', 'AnimalKindsController@allAvailable');
Route::get('/animals/{user_id}', 'UserAnimalsController@all');
Route::post('/animals/add', 'UserAnimalsController@new');
Route::post('/animals/age', 'UserAnimalsController@grow');
