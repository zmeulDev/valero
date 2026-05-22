<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Media;



class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'meta_robots',
        'canonical_url',
        'excerpt',
        'content',
        'is_featured',
        'scheduled_at',
        'views',
        'category_id',
        'likes_count',
        'youtube_link',
        'instagram_link',
        'local_store_link'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'scheduled_at' => 'datetime:Y-m-d H:i',
    ];

    protected $appends = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)
            ->withPivot('order')
            ->orderBy('article_playlist.order');
    }

    public function coverImage()
    {
        return $this->hasOne(Media::class)->where('is_cover', true);
    }

    public function getCoverImageAttribute()
    {
        return $this->media()->where('is_cover', true)->first();
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('scheduled_at', '<=', now())
                ->orWhereNull('scheduled_at');
        });
    }

    /**
     * Get the reading time for the article.
     *
     * @return string
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200);

        return $minutes . ' ' . __('frontend.common.minutes');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($article) {
            increment_cache_version();
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::updated(function ($article) {
            increment_cache_version();
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });

        static::deleted(function ($article) {
            increment_cache_version();
            \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
        });
    }
}
