<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;

class Country extends Model
{
    protected $fillable = [
        'title', 'slug'
    ];

    public function artists()
    {
    	return $this->hasMany(Artist::class, 'country_id');
    }
}
