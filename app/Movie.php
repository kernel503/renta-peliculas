<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'movie_name',
        'release_date',
        'category_id',
        'img_url',
        'quantity_stock',
        'sale_price',
        'rent_price',
        'available'
    ];
    protected $table = 'movies';
    protected $primaryKey = 'id';
}
