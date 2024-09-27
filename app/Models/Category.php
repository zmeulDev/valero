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
            title: $this->name,
            description: $this->slug,
            author: $this->name,
            published_time: $this->created_at,
            schema: SchemaCollection::make()->addArticle(),
        );
    }
}