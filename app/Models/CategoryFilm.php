<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFilm extends Model
{
    protected $table = 'category_films';

    protected $fillable = [
     	'category_id',
     	'film_id'
    ];
}
