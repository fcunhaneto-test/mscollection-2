<?php

namespace App\Http\Controllers\Cast;

use App\Http\Controllers\Controller;
use App\Models\Cast\Actor;
use App\Models\Cast\Cast;
use App\Models\Cast\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CastController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $actor = null;
        $character = null;
        $movie_id = intval($request->movie_id);
        $values = json_decode($request->cast);
        foreach ($values as $item) {
            if(Actor::where('name', '=', $item->actor)->count() == 0) {
                $actor = new Actor();
                $actor->name = $item->actor;
                $actor->save();
            } else {
                $actor = Actor::where('name', $item->actor)->first();
            }
            if(Character::where('name', '=', $item->character)->count() == 0) {
                $character = new Character();
                $character->name = $item->character;
                $character->save();
            } else {
                $character = Character::where('name', $item->character)->first();
            }

            $cast = new Cast();
            $c = $cast->where('actor_id', $actor->id)->where('character_id', $character->id)->count();
            if ($c == 0) {
                $cast->actor_id = $actor->id;
                $cast->character_id = $character->id;
                $cast->save();
                DB::table('cast_movie')->insert(['cast_id' => $cast->id, 'movie_id' => $movie_id]);
                DB::commit();
            } else {
                $cast_id = $cast->where('actor_id', $actor->id)->where('character_id', $character->id)->first()->id;
                DB::table('cast_movie')->insert(['cast_id' => $cast_id, 'movie_id' => $movie_id]);
                DB::commit();
            }
        }
        return response()->json('Elenco inserido com sucesso', 200);
    }
}
