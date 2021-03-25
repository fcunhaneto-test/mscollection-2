<?php

use Illuminate\Support\Facades\Route;
use App\Models\Qualifiers\Media;
use \Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $media = new Media();
    $slug = $media->streams()->first()->slug;

    return redirect('/filmes/' . $slug);
});

Route::get('/filmes/{channel}', 'MovieController@start')->name('movies');
Route::get('/series/{channel}', 'SeriesController@start')->name('series');

Route::get('/login', function () {
    $c_media = new Media();
    $media = $c_media->streams();

    return view('auth.login', compact('media'));
})->name('login');

Route::get('/logout', function () {
    $c_media = new Media();
    $media = $c_media->streams();

    return view('auth.logout', compact('media'));
})->name('logout');

Route::get('/admin', function () {
    $media = Media::all();
    $slug = $media->first()->slug;

    return redirect('/admin/filmes/' . $slug);
});

Route::get('/admin/filmes/{channel}', 'MovieController@startAdmin')->name('admin-movies');
Route::get('/admin/series/{channel}', 'MovieController@startAdmin')->name('admin-series');

