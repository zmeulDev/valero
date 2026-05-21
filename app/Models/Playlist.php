<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Playlist extends Model
{
    use HasSEO;

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

    public function getDynamicSEOData(): SEOData
    {
        $seoModel = $this->seo;
        $title = $seoModel?->title ?: $this->title;

        $description = $seoModel?->description ?: (
            $this->description
                ? Str::limit(strip_tags($this->description), 160)
                : "Explore the '{$this->title}' series featuring {$this->articles->count()} curated articles."
        );

        $canonicalUrl = $seoModel?->canonical_url ?: url(route('frontend.playlists.show', $this->slug));

        // Use first article cover image, SEO image, or default logo
        $imageUrl = null;
        if ($seoModel?->image) {
            $imageUrl = url(Storage::url($seoModel->image));
        } else {
            $firstArticle = $this->articles->first();
            $coverMedia = $firstArticle?->media->firstWhere('is_cover', true);
            $imageUrl = $coverMedia?->image_path
                ? url(Storage::url($coverMedia->image_path))
                : url(asset('storage/brand/logo.png'));
        }

        return new SEOData(
            title: $title,
            description: $description,
            url: $canonicalUrl,
            image: $imageUrl,
            author: $this->user?->name,
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            schema: SchemaCollection::make()
                ->addBreadcrumbs(function ($breadcrumbs) {
                    return $breadcrumbs
                        ->prependBreadcrumbs([
                            'Home' => route('home'),
                            'Playlists' => route('frontend.playlists.index'),
                            $this->title => route('frontend.playlists.show', $this->slug)
                        ]);
                })
        );
    }
}
