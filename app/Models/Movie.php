<?php

namespace App\Models;

use App\Models\Cast\Cast;
use App\Models\Producers\Director;
use App\Models\Qualifiers\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $table = 'movies';
    public $timestamps = false;

    protected $fillable = [
        'title', 'original_title', 'year', 'time', 'category_1', 'category_2','our_rating', 'imdb_rating',
        'poster', 'summary'
    ];
    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot('active', 'slug');
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class)->withPivot('order');
    }

    public function cast()
    {
        return $this->belongsToMany(Cast::class, 'cast_movie')->withPivot('order', 'star');
    }

    public function titlesStart($channel, $pp)
    {
        $media = new Media();
        $id = $media->where('slug', $channel)->first()->id;
        $media = Media::find($id);
        $total = ceil($media->movies->count()/$pp);
        $movies = $media->movies()->orderBy('movies.title')->limit($pp)->get();
        return [$total, $movies];
    }

    public function titlesPage($channel, $page, $pp)
    {
        $media = new Media();
        $id = $media->where('slug', $channel)->first()->id;
        $media = Media::find($id);
        $offset = ($page - 1) * $pp;
        $movies = $media->movies()->orderBy('movies.title')->offset($offset)->limit($pp)->get();
        return $movies;
    }

    public function castTitle($id)
    {
        return DB::table('cast_movie')
            ->leftJoin('cast', 'cast_movie.cast_id', '=', 'cast.id')
            ->leftJoin('actors', 'cast.actor_id', '=', 'actors.id')
            ->leftJoin('characters', 'cast.character_id', '=', 'characters.id')
            ->where('cast_movie.movie_id', '=', $id)
            ->where('cast_movie.star', '=', true)
            ->select('cast_movie.*', 'actors.name as actor', 'characters.name as character',
                'cast.actor_id', 'cast.character_id')
            ->get();
    }

    public function producers($id)
    {
        $movies = Movie::findOrFail($id);
        return $movies->directors;
    }
}
