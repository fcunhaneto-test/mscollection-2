<?php

namespace App\Models\Qualifiers;

use App\Models\Movie;
use App\Models\Series;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = false;

    protected $fillable = ['name'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_tag');
    }

    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_tag');
    }
}
