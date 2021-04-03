<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Traits\TitlesController;
use Illuminate\Http\Request;

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

        $poster = str_replace(' ', '', $request->title) . '-'. $request->year . '.jpg';

        return response()->json($poster, 200);
    }
}
