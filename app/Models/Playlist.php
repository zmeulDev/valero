<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\User;

class Playlist extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class)
            ->withPivot('order')
            ->orderBy('article_playlist.order');
    }
}
