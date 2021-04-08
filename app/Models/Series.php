<?php

namespace App\Models;

use App\Models\Cast\Cast;
use App\Models\Qualifiers\Media;
use App\Models\Producers\Creator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Series extends Model
{
    protected $table = 'series';
    public $timestamps = false;

    protected $fillable = [
        'title', 'original_title', 'year', 'category_1', 'category_2','our_rating', 'imdb_rating',
        'poster', 'summary'
    ];

    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot('active');
    }

    public function creators()
    {
        return $this->belongsToMany(Creator::class)->withPivot('order');
    }

    public function cast()
    {
        return $this->belongsToMany(Cast::class, 'cast_series')->withPivot('order', 'star');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function titlesStart($channel, $pp)
    {
        $media = new Media();
        $id = $media->where('slug', $channel)->first()->id;
        $media = Media::find($id);
        $total = ceil($media->series->count()/$pp);
        $series = $media->series()->orderBy('series.title')->limit($pp)->get();
        return [$total, $series];
    }

    public function titlesPage($channel, $page, $pp)
    {
        $media = new Media();
        $id = $media->where('slug', $channel)->first()->id;
        $media = Media::find($id);
        $offset = ($page - 1) * $pp;
        $series = $media->series()->orderBy('series.title')->offset($offset)->limit($pp)->get();
        return $series;
    }

    public function castTitle($id)
    {
        return DB::table('cast_series')
            ->leftJoin('cast', 'cast_series.cast_id', '=', 'cast.id')
            ->leftJoin('actors', 'cast.actor_id', '=', 'actors.id')
            ->leftJoin('characters', 'cast.character_id', '=', 'characters.id')
            ->where('cast_series.series_id', '=', $id)
            ->where('cast_series.order', '<', 6)
            ->select('cast_series.*', 'actors.name as actor', 'characters.name as character',
                'cast.actor_id', 'cast.character_id')
            ->get();
    }

    public function producers($id)
    {
        $series = Series::findOrFail($id);
        return $series->creators;
    }

}
