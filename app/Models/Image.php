<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'image_path',
        'filename',
        'mime_type',
        'size',
        'variants',
        'dimensions',
        'alt_text'
    ];

    protected $casts = [
        'variants' => 'array',
        'dimensions' => 'array'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
