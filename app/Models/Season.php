<?php

namespace App\Models;

use App\Models\Qualifiers\Media;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'seasons';
    public $timestamps = false;

    protected $fillable = ['series_id', 'season', 'year'];

    public function media()
    {
        return $this->belongsToMany(Media::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
