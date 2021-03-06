<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Qualifiers\Media;
use App\Traits\TitlesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    use TitlesController;

    protected $table;

    public function __construct()
    {
        $this->table = new Movie();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required_with|String',
            'year' => 'required',
        ]);
        $movie = new Movie();
        $exist = $movie->where('title', '=', $request->title)->where('year', '=', $request->year)->count();
        if($exist) {
            return response()->json(['title' => $request->title], 202);
        }
        $movie->title = $request->title;
        $movie->original_title = $request->original_title;
        $movie->year = $request->year;
        $movie->time = $request->time;
        $movie->our_rating = $request->our_rating;
        $movie->imdb_rating = $request->imdb_rating;
        $movie->category_1 = $request->category_1;
        $movie->category_2 = $request->category_2;
        $movie->poster = str_replace(' ', '', $request->title) . '-'. $request->year . '.jpg';
        $movie->summary = $request->summary;

        $movie->save();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL, $request->img_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        Storage::disk('posters')->put($movie->poster, $result);

        $movie->media()->sync($request->media);

        return response()->json($movie->id, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required_with|String',
            'year' => 'required',
        ]);

        $movie = Movie::findOrFail($request->id);
        $movie->title = $request->title;
        $movie->original_title = $request->original_title;
        $movie->year = $request->year;
        $movie->time = $request->time;
        $movie->our_rating = $request->our_rating;
        $movie->imdb_rating = $request->imdb_rating;
        $movie->category_1 = $request->category_1;
        $movie->category_2 = $request->category_2;
        $movie->poster = $request->poster;
        $movie->summary = $request->summary;

        $movie->save();

        $movie->media()->sync($request->media);

        return response()->json($movie->id, 200);
    }
}
