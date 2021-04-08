<?php

namespace App\Models\Cast;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';
    public $timestamps = false;

    protected $fillable = ['name'];
}
