<?php

namespace App\Models\Cast;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Cast extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $table = 'cast';
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['cast_movie'];
}
