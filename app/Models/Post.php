<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
    ];

    public function excerpt(): Attribute
    {
        $maxLengthExcerpt = 50;

        return Attribute::make(
            get: fn () => str($this->content)->length() < $maxLengthExcerpt
                            ? $this->content
                            : substr($this->content, 0, $maxLengthExcerpt).'...'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
