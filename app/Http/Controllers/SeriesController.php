<?php

namespace App\Http\Controllers;

use App\Models\Qualifiers\Media;
use App\Models\Series;
use App\Traits\TitlesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    use TitlesController;

    protected $table;

    public function __construct()
    {
        $this->table = new Series();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $series = new Series();
        $exist = $series->where('title', '=', $request->title)->where('year', '=', $request->year)->count();
        if($exist) {
            return response()->json(['title' => $request->title], 202);
        }
        $series->title = $request->title;
        $series->original_title = $request->original_title;
        $series->year = $request->year;
        $series->our_rating = $request->our_rating;
        $series->imdb_rating = $request->imdb_rating;
        $series->category_1 = $request->category_1;
        $series->category_2 = $request->category_2;
        $series->poster = str_replace(' ', '', $request->title) . '-'. $request->year . '.jpg';
        $series->summary = $request->summary;

        $series->save();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL, $request->img_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        Storage::disk('posters')->put($series->poster, $result);

        $media_id = $request->media;

        for($i = 0; $i < count($media_id); $i++) {
            $media = Media::findOrFail($media_id[$i]);
            $series->media()->attach($media->id, ['active' => true, 'slug' => $media->slug]);
        }

        return response()->json($series->id, 200);
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

        $movie = Series::findOrFail($request->id);
        $movie->title = $request->title;
        $movie->original_title = $request->original_title;
        $movie->year = $request->year;
        $movie->our_rating = $request->our_rating;
        $movie->imdb_rating = $request->imdb_rating;
        $movie->category_1 = $request->category_1;
        $movie->category_2 = $request->category_2;
        $movie->poster = $request->poster;
        $movie->summary = $request->summary;

        $movie->save();

        return response()->json('', 200);
    }
}
