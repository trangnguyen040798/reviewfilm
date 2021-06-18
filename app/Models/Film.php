<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'name',
        'othername',
        'director_id',
        'year',
        'type',
        'release_date',
        'country_id',
        'image',
        'status',
        'user_id',
        'complete',
        'total_episodes',
        'views',
        'rating',
        'description'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_films');
    }

    public function actors()
    {
        return $this->belongsToMany(Artist::class, 'artist_films');
    }

    public function director()
    {
        return $this->belongsTo(Artist::class, 'director_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
         return $this->hasMany(Comment::class);
    }
}
