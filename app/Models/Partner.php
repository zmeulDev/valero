<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'link',
        'image',
        'text',
        'position',
        'start_date',
        'expiration_date',
        'seo',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiration_date' => 'date',
        'seo' => 'array',
    ];

    public function getTargetAttributeAttribute()
    {
        return $this->seo['target'] ?? '_blank';
    }

    public function getRelAttributeAttribute()
    {
        return is_array($this->seo['rel'] ?? null) 
            ? implode(' ', $this->seo['rel']) 
            : ($this->seo['rel'] ?? 'nofollow sponsored noopener');
    }

    public function getFullUrlAttribute()
    {
        if (!$this->link) {
            return null;
        }

        $utmParams = array_filter([
            'utm_source' => $this->seo['utm_source'] ?? null,
            'utm_medium' => $this->seo['utm_medium'] ?? null,
            'utm_campaign' => $this->seo['utm_campaign'] ?? null,
            'utm_term' => $this->seo['utm_term'] ?? null,
        ]);

        if (empty($utmParams)) {
            return $this->link;
        }

        $separator = parse_url($this->link, PHP_URL_QUERY) ? '&' : '?';
        return $this->link . $separator . http_build_query($utmParams);
    }
}