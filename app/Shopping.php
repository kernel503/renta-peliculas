<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
    ];
    protected $table = 'shopping';
    protected $primaryKey = 'id';
}
