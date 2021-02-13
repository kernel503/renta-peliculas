<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'initial_date',
    ];
    protected $table = 'rental';
    protected $primaryKey = 'id';
}
