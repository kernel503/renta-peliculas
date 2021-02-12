<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'updated_date';
}
