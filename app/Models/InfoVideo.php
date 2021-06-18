<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoVideo extends Model
{
    protected $table = 'info_videos';

    protected $fillable = [
        'column_name', 'column_value', 'film_id', 'episode', 'position', 'capacity', 'duration'
    ];
}
