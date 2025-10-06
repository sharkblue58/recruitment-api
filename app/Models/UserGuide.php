<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserGuide extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'heading',
        'content',
        'content_type',
        'target_audience',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'heading' => 'array',
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the target audience for this guide.
     */
    public function getTargetAudienceAttribute(): string
    {
        return $this->attributes['target_audience'];
    }

    /**
     * Scope a query to only include active guides.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by content type.
     */
    public function scopeByContentType($query, string $contentType)
    {
        return $query->where('content_type', $contentType);
    }

    /**
     * Scope a query to filter by target audience.
     */
    public function scopeForAudience($query, string $audience)
    {
        return $query->where('target_audience', $audience);
    }

    /**
     * Get the heading in a specific language.
     */
    public function getHeading(string $locale = 'en'): ?string
    {
        return $this->heading[$locale] ?? $this->heading['en'] ?? null;
    }

    /**
     * Get the content in a specific language.
     */
    public function getContent(string $locale = 'en'): ?string
    {
        return $this->content[$locale] ?? $this->content['en'] ?? null;
    }
}
