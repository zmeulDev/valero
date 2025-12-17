<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'link',
        'notes',
        'category',
    ];

    /**
     * Get the user that owns the bookmark.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
