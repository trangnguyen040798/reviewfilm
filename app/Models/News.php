<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'image', 'views', 'category_id', 'content'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
