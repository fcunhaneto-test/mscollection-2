<?php

namespace App\Http\Controllers\Cast;

use App\Http\Controllers\Controller;
use App\Models\Cast\Actor;
use App\Models\Cast\Cast;
use App\Models\Cast\Character;
use Illuminate\Http\Request;

class CastController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function castMovie(Request $request)
    {
        $actor = Actor::firstOrCreate(['name' => $request->actor]);
        $character = Character::firstOrCreate(['name' => $request->character]);
        $cast = Cast::firstOrCreate(['actor_id' => $actor->id], ['character_id' => $character->id]);
        $cast->movies()->attach($request->movie_id, ['order' => $request->order, 'star' => $request->star]);

        return response()->json('', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function castSeries(Request $request)
    {
        $actor = Actor::firstOrCreate(['name' => $request->actor]);
        $character = Character::firstOrCreate(['name' => $request->character]);
        $cast = Cast::firstOrCreate(['actor_id' => $actor->id], ['character_id' => $character->id]);
        $cast->series()->attach($request->series_id, ['order' => $request->order, 'star' => $request->star]);

        return response()->json('', 200);
    }
}
