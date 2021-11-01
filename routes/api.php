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

Route::get('/animals', 'AnimalsController@animalsAvailable');
Route::get('/animals/{user_id}', 'AnimalsController@userAnimals');
Route::post('/animals/add', 'AnimalsController@addAnimal');
Route::post('/animals/age', 'AnimalsController@growAnimal');
