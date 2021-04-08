<?php

namespace App\Models\Producers;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $table = 'directors';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('order');
    }
}
