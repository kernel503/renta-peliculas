<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_name'];

    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function movie()
    {
        return $this->belongsTo('movie');
    }
}
