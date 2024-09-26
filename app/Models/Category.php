<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use RalphJSmit\Laravel\SEO\Facades\SEO;

class Category extends Model
{
    use HasFactory, HasSeo;

    protected $fillable = ['name', 'slug'];

    // Each category has many articles
    public function articles()
    {
        return $this->hasMany(Article::class);
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
}