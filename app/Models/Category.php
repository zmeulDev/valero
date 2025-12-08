<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use Illuminate\Support\Str;

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
        $articleCount = $this->articles()->published()->count();
        $articleWord = $articleCount === 1 ? 'article' : 'articles';
        $description = "Browse {$articleCount} {$articleWord} in {$this->name} category. " . 
                      "Discover the latest content, insights, and updates on " . strtolower($this->name) . ".";
        
        $categoryUrl = url(route('category.index', $this->slug));

        return new SEOData(
            title: $this->name . ' - ' . config('app.name'),
            description: Str::limit($description, 160),
            url: $categoryUrl,
            schema: SchemaCollection::make()
                ->addBreadcrumbs(function($breadcrumbs) {
                    return $breadcrumbs
                        ->prependBreadcrumbs([
                            'Home' => route('home'),
                            $this->name => route('category.index', $this->slug)
                        ]);
                })
        );
    }
}