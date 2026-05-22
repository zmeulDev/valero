<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($playlist) {
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::updated(function ($playlist) {
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::deleted(function ($playlist) {
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });
    }
}
