<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'unique_code',
        'author',
        'isbn',
        'publisher',
        'published_year',
        'pages',
        'description',
        'cover_image',
        'total_copies',
        'available_copies',
        'rating',
        'is_featured',
    ];

    protected $casts = [
        'published_year' => 'integer',
        'pages' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function bookCopies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }

    public function getAvailableCopiesCount(): int
    {
        return $this->bookCopies()->where('status', 'available')->count();
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0);
    }
}
