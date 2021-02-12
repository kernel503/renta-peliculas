<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //
    protected $table = 'movies';
    protected $primaryKey = 'movie_id';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';
}
