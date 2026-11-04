<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;

    protected $attributes = [
        'title' => 'Untitled Note',
        'color' => 'default',
        'is_pinned' => false,
    ];

    protected $fillable = [
        'title',
        'content',
        'color',
        'is_pinned',
        'category',
        'todo_id',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    protected $appends = [
        'snippet',
        'word_count',
        'updated_ago',
    ];

    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }

    public function getSnippetAttribute(): string
    {
        if (blank($this->content)) {
            return 'Empty note…';
        }

        $clean = preg_replace('/[#*`_\-\[\]]/', '', $this->content);
        $clean = preg_replace('/\s+/', ' ', trim($clean));

        return Str::limit($clean, 95);
    }

    public function getWordCountAttribute(): int
    {
        if (blank($this->content)) {
            return 0;
        }

        return str_word_count(strip_tags($this->content));
    }

    public function getUpdatedAgoAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->diffForHumans(short: true) : '';
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (blank($search)) {
            return $query;
        }

        $term = '%'.trim($search).'%';

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', $term)
                ->orWhere('content', 'like', $term)
                ->orWhere('category', 'like', $term);
        });
    }

    public function scopePinned(Builder $query, bool $pinned = true): Builder
    {
        return $query->where('is_pinned', $pinned);
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        if (blank($category) || $category === 'all') {
            return $query;
        }

        return $query->where('category', $category);
    }

    public function scopeColor(Builder $query, ?string $color): Builder
    {
        if (blank($color) || $color === 'all') {
            return $query;
        }

        return $query->where('color', $color);
    }
}
