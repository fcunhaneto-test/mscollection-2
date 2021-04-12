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
    public function storeCastMovie(Request $request)
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
    public function storeCastSeries(Request $request)
    {
        $actor = Actor::firstOrCreate(['name' => $request->actor]);
        $character = Character::firstOrCreate(['name' => $request->character]);
        $cast = Cast::firstOrCreate(['actor_id' => $actor->id], ['character_id' => $character->id]);
        $cast->series()->attach($request->series_id, ['order' => $request->order, 'star' => $request->star]);

        return response()->json('', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCastMovie(Request $request)
    {
        $actor = Actor::firstOrCreate(['name' => $request->actor]);
        $character = Character::firstOrCreate(['name' => $request->character]);
        $cast = new Cast();
        if($cast->where('id', $request->cast_id)->count() > 0) {
            $up_cast = Cast::findOrFail($request->cast_id);
            $up_cast->actor_id = $actor->id;
            $up_cast->character_id = $character->id;
            $up_cast->save();
        } else {
            $cast = Cast::firstOrCreate(['actor_id' => $actor->id], ['character_id' => $character->id]);
            $cast->movies()->attach($request->movie_id, ['order' => $request->order, 'star' => $request->star]);
        }

        return response()->json('', 200);
    }
}
