<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('registro', 'Auth\AuthenticatorController@register');
Route::post('login', 'Auth\AuthenticatorController@login');
Route::post('logout', 'Auth\AuthenticatorController@logout');

Route::prefix('movies')->group(function() {
    Route::get('/titles-start/{channel}/{pp}', 'MovieController@titlesStart');
    Route::get('/titles-page/{channel}/{page}/{pp}', 'MovieController@titlesPage');

    Route::get('/cast/{id}', 'MovieController@castTitle');
    Route::get('/producers/{id}', 'MovieController@producers');
    Route::get('/media/{id}', 'MovieController@mediaTitle');

    Route::post('/store', 'MovieController@store')->middleware('can:isAdmin');
});

Route::prefix('series')->group(function() {
    Route::get('/titles-start/{channel}/{pp}', 'SeriesController@titlesStart');
    Route::get('/titles-page/{channel}/{page}/{pp}', 'SeriesController@titlesPage');

    Route::get('/cast/{id}', 'SeriesController@castTitle');
    Route::get('/producers/{id}', 'SeriesController@producers');
    Route::get('/media/{id}', 'SeriesController@mediaTitle');

    Route::post('/store', 'SeriesController@store')->middleware('can:isAdmin');
});

Route::prefix('admin')->group(function() {
    Route::get('/movies/titles-start/{channel}/{pp}', 'MovieController@titlesStart')->middleware('can:isAdmin');
    Route::get('/movies/titles-page/{channel}/{page}/{pp}', 'MovieController@titlesPage')->middleware('can:isAdmin');

    Route::get('/movies/cast/{id}', 'MovieController@cast')->middleware('can:isAdmin');
    Route::get('/movies/producers/{id}', 'MovieController@producers')->middleware('can:isAdmin');
});

Route::prefix('admin')->group(function() {
    Route::get('/series/titles-start/{channel}/{pp}', 'SeriesController@titlesStart')->middleware('can:isAdmin');
    Route::get('/series/titles-page/{channel}/{page}/{pp}', 'SeriesController@titlesPage')->middleware('can:isAdmin');

    Route::get('/series/cast/{id}', 'SeriesController@cast')->middleware('can:isAdmin');
    Route::get('/series/producers/{id}', 'SeriesController@producers')->middleware('can:isAdmin');
});

Route::prefix('media')->group(function() {
    Route::get('', 'Qualifiers\MediaController@index') ;
});

Route::prefix('categories')->group(function() {
    Route::get('', 'Qualifiers\CategoryController@index') ;
});

Route::prefix('cast')->group(function() {
    Route::post('/movie/store', 'Cast\CastController@castMovie')->middleware('can:isAdmin');
    Route::post('/series/store', 'Cast\CastController@castSeries')->middleware('can:isAdmin');
});

Route::prefix('directors')->group(function() {
    Route::post('/store', 'Producers\DirectorController@store')->middleware('can:isAdmin');
});

Route::prefix('creators')->group(function() {
    Route::post('/store', 'Producers\CreatorController@store')->middleware('can:isAdmin');
});
