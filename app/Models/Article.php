<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'scheduled_at', 'views'
    ];

    protected $dates = ['scheduled_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
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

}
