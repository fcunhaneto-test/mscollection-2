<?php

namespace App\Http\Controllers;

use App\Models\Movie;
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
        $movie->title = $request->title;
        $movie->original_title = $request->original_title;
        $movie->year = $request->year;
        $movie->time = $request->time;
        $movie->category_1 = $request->category_1;
        $movie->category_2 = $request->category_2;
        $movie->keyword = $request->keyword;
        $movie->poster = str_replace(' ', '', $request->title) . '-'. $request->year . '.jpg';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch,CURLOPT_URL, $request->img_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        curl_close($ch);
        Storage::disk('posters')->put($movie->poster, $result);

        return response()->json($movie->poster, 200);
    }
}
