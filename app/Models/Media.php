<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'image_path',
        'is_cover',
        'filename',
        'mime_type',
        'size',
        'dimensions',
        'alt_text'
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'dimensions' => 'array'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeCover($query)
    {
        return $query->where('is_cover', true);
    }

    public function scopeNotCover($query)
    {
        return $query->where('is_cover', false);
    }
}
