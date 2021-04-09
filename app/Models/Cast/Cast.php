<?php

namespace App\Models\Cast;

use App\Models\Movie;
use App\Models\Series;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $table = 'cast';
    public $timestamps = false;

    protected $fillable = ['actor_id',  'character_id'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'cast_movie')->withPivot('order', 'star');
    }

    public function series()
    {
        return $this->belongsToMany(Series::class, 'cast_series')->withPivot('order', 'star');
    }
}
