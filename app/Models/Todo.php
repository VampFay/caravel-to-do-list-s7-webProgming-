<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'priority',
        'due_date',
        'category',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
    ];

    public function isOverdue(): bool
    {
        if ($this->completed || ! $this->due_date) {
            return false;
        }

        return $this->due_date->isPast() && ! $this->due_date->isToday();
    }

    public function isDueToday(): bool
    {
        if ($this->completed || ! $this->due_date) {
            return false;
        }

        return $this->due_date->isToday();
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return match ($status) {
            'active' => $query->where('completed', false),
            'done', 'completed' => $query->where('completed', true),
            'today' => $query->whereDate('due_date', Carbon::today()),
            'important' => $query->where('priority', 'high'),
            default => $query,
        };
    }

    public function scopePriority(Builder $query, ?string $priority): Builder
    {
        if (in_array($priority, ['low', 'medium', 'high'], true)) {
            return $query->where('priority', $priority);
        }

        return $query;
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        if (! empty($category) && $category !== 'all') {
            return $query->where('category', $category);
        }

        return $query;
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (filled($search)) {
            return $query->where(function (Builder $q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
