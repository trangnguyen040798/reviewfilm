<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageSlider extends Model
{
    protected $table = "manage_sliders";
    protected $fillable = [
        "tag",
        "film_id", 
        "image",
        "title",
        "content"
    ];

    public function film()
    {
    	return $this->belongsTo(Film::class);
    }
}
