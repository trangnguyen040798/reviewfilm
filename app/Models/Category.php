<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'slug', 'type'
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'category_films');
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
