<?php

use Illuminate\Support\Facades\Route;
use App\Models\Qualifiers\Media;

Route::get('/', function () {
    $media = new Media();
    $slug = $media->streams()->first()->slug;

    return redirect('/filmes/' . $slug);
});

Route::get('/filmes/{channel}', 'MovieController@start')->name('movies');

Route::get('/series/{channel}', 'SeriesController@start')->name('series');
