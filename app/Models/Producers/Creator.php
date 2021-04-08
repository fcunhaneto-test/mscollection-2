<?php

namespace App\Models\Producers;

use App\Models\Series;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    protected $table = 'creators';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function series()
    {
        return $this->belongsToMany(Series::class)->withPivot('order');
    }
}
