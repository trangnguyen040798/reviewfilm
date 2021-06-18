<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'video_id', 'news_id', 'film_id', 'rating'];

    public function video()
    {
    	return $this->belongsTo(Video::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function news()
    {
    	return $this->belongsTo(News::class);
    }
}
