<?php

namespace App\Models\Cast;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actors';
    public $timestamps = false;

    protected $fillable = ['name'];
}
