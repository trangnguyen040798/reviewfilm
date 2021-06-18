<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Artist extends Model
{
    protected $fillable = [
        'name', 'height', 'occupation', 'weight', 'story', 'country_id', 'image', 'birthday'
    ];

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    public function filmsFActor()
    {
        return $this->belongsToMany(Film::class, 'artist_films');
    }

    public function filmsFDirector()
    {
        return $this->hasMany(Film::class, 'director_id');
    }
}
