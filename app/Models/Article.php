<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;

class Article extends Model
{
    use HasFactory, HasSEO;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'scheduled_at', 'views', 'category_id'
    ];

    protected $dates = ['scheduled_at'];

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
        return new SEOData(
            title: $this->title,
            description: $this->excerpt,
            image: $this->featured_image,
            published_time: $this->created_at,
            author: $this->user->name,
            schema: SchemaCollection::make()->addArticle(),
        );
    }

    public function isAdmin()
    {
        return $this->is_admin === true;
    }

}