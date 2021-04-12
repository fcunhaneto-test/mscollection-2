<?php

namespace App\Models\Qualifiers;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    public $timestamps = false;

    protected $fillable = ['name'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function series()
    {
        return $this->belongsToMany(Series::class);
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }

    public function streams()
    {
        return $this->where('stream', '=', true)->select()->get();
    }

    public function actives()
    {
        return $this->where('active', '=', true)->get();
    }
}
