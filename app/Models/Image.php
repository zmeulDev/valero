<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'image_path'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
