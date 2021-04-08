<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';
    public $timestamps = false;

    protected $fillable = ['season_id', 'episode', 'title', 'original_title', 'summary'];

    public function seasons()
    {
        return $this->belongsTo(Season::class);
    }
}
