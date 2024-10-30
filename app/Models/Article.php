<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class Article extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'scheduled_at', 'views', 'category_id', 'likes_count'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'scheduled_at' => 'datetime:Y-m-d H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function scopePublished($query)
    {
        return $query->where(function($q) {
            $q->where('scheduled_at', '<=', now())
            ->orWhereNull('scheduled_at');
        });
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getDynamicSEOData(): SEOData
    {
        \Log::info('getDynamicSEOData called for Article ID: ' . $this->id);
        
        return new SEOData(
            description: $this->excerpt,
            title: $this->title,
            image: $this->featured_image,
            author: $this->user->name,
            robots: 'index, follow',
            canonical_url: route('articles.index', $this->slug),
            schema: SchemaCollection::make()->addArticle(),
        );
    } 

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

}