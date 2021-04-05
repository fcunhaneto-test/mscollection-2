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
        $movie = new Movie();
        $exist = $movie->where('title', '=', $request->title)->where('year', '=', $request->year)->count();
        if($exist) {
            return response()->json(['title' => $request->title], 202);
        }
        $movie->title = $request->title;
        $movie->original_title = $request->original_title;
        $movie->year = $request->year;
        $movie->time = $request->time;
        $movie->rating = $request->rating;
        $movie->category_1 = $request->category_1;
        $movie->category_2 = $request->category_2;
        $movie->keyword = $request->keyword;
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

        $media = Media::findOrFail($request->media);
        $movie->media()->attach($media->id, ['active' => true, 'slug' => $media->slug]);

        return response()->json(['title' => $request->title], 200);
    }
}
