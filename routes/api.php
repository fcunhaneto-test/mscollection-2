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

    Route::get('/cast/{id}', 'MovieController@cast');
    Route::get('/producers/{id}', 'MovieController@producers');
    Route::post('/scrapping', 'ScrapingController@imdbScrapping');
});

Route::prefix('series')->group(function() {
    Route::get('/titles-start/{channel}/{pp}', 'SeriesController@titlesStart');
    Route::get('/titles-page/{channel}/{page}/{pp}', 'SeriesController@titlesPage');

    Route::get('/cast/{id}', 'SeriesController@cast');
    Route::get('/producers/{id}', 'SeriesController@producers');
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

Route::prefix('keywords')->group(function() {
    Route::get('', 'Qualifiers\KeywordController@index') ;
});
