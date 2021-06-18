<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'link',
        'film_id',
        'episode',
        'image',
        'views'
    ];

    public function film()
    {
    	return $this->belongsTo(Film::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
