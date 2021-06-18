<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistFilm extends Model
{
    protected $table = "artist_films";
    protected $fillable = [
        "artist_id",
        "film_id"
    ];
}
