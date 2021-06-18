<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedVideo extends Model
{
	protected $table = 'saved_videos';

    protected $fillable = [
    	'id',
        'name_cate',
        'video_id',
        'user_id'
    ];

    public function video()
    {
    	return $this->belongsTo(Video::class);
    }
}
