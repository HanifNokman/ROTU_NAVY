<?php

// app/Models/EquipmentLoan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class EquipmentLoan extends Model
{
    protected $fillable = [
        'cadet_id',
        'item_id',
        'quantity',
        'borrow_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'quantity' => 'integer',
        'cadet_id' => 'integer',
        'item_id' => 'integer'
    ];

    // Relationships
    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    // Helper methods for loan status
    public function isOverdue(): bool
    {
        if ($this->status === 'Returned' || $this->status === 'Pending Return') {
            return false;
        }

        // Consider items overdue if borrowed for more than 30 days without return
        return $this->borrow_date->addDays(30)->isPast();
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        
        return $this->borrow_date->addDays(30)->diffInDays(now());
    }

    public function getDaysBorrowedAttribute(): int
    {
        if ($this->status === 'Returned' && $this->return_date) {
            return $this->borrow_date->diffInDays($this->return_date);
        }
        
        return $this->borrow_date->diffInDays(now());
    }

    public function getDueDateAttribute(): Carbon
    {
        return $this->borrow_date->addDays(30);
    }

    // Helper methods for item categories
    public function isEquipment(): bool
    {
        return $this->inventoryItem?->category === 'equipment';
    }

    public function isUniform(): bool
    {
        return $this->inventoryItem?->category === 'uniform';
    }

    public function getCategoryBadgeColorAttribute(): string
    {
        return match($this->inventoryItem?->category) {
            'equipment' => 'blue',
            'uniform' => 'purple',
            default => 'gray'
        };
    }

    public function getItemCategoryAttribute(): string
    {
        return $this->inventoryItem?->category ?? 'Unknown';
    }

    // Status helper methods
    public function isActive(): bool
    {
        return $this->status === 'Borrowed' || $this->status === 'Pending Return';
    }

    public function isReturned(): bool
    {
        return $this->status === 'Returned';
    }

    public function isPendingReturn(): bool
    {
        return $this->status === 'Pending Return';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'Borrowed' => $this->isOverdue() ? 'red' : 'yellow',
            'Pending Return' => 'orange',
            'Returned' => 'green',
            'Overdue' => 'red',
            default => 'gray'
        };
    }

    // Query scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['Borrowed', 'Pending Return']);
    }

    public function scopeReturned(Builder $query): Builder
    {
        return $query->where('status', 'Returned');
    }

    public function scopePendingReturn(Builder $query): Builder
    {
        return $query->where('status', 'Pending Return');
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'Borrowed')
                    ->where('borrow_date', '<', now()->subDays(30));
    }

    public function scopeEquipmentOnly(Builder $query): Builder
    {
        return $query->whereHas('inventoryItem', function($q) {
            $q->where('category', 'equipment');
        });
    }

    public function scopeUniformOnly(Builder $query): Builder
    {
        return $query->whereHas('inventoryItem', function($q) {
            $q->where('category', 'uniform');
        });
    }

    public function scopeForCadet(Builder $query, int $cadetId): Builder
    {
        return $query->where('cadet_id', $cadetId);
    }

    public function scopeForItem(Builder $query, int $itemId): Builder
    {
        return $query->where('item_id', $itemId);
    }

    // Utility methods
    public function canBeReturned(): bool
    {
        return $this->status === 'Borrowed';
    }

    public function canRequestReturn(): bool
    {
        return $this->status === 'Borrowed';
    }

    public function requestReturn(): bool
    {
        if (!$this->canRequestReturn()) {
            return false;
        }

        $this->update([
            'status' => 'Pending Return'
        ]);

        return true;
    }

    public function approveReturn(string $returnDate = null): bool
    {
        if ($this->status !== 'Pending Return') {
            return false;
        }

        $this->update([
            'status' => 'Returned',
            'return_date' => $returnDate ?? now()->toDateString()
        ]);

        // Update inventory quantity
        $this->inventoryItem->increment('available_quantity', $this->quantity);

        return true;
    }

    public function rejectReturn(): bool
    {
        if ($this->status !== 'Pending Return') {
            return false;
        }

        $this->update([
            'status' => 'Borrowed'
        ]);

        return true;
    }

    public function markAsReturned(string $returnDate = null): bool
    {
        if (!$this->canBeReturned()) {
            return false;
        }

        $this->update([
            'status' => 'Returned',
            'return_date' => $returnDate ?? now()->toDateString()
        ]);

        // Update inventory quantity
        $this->inventoryItem->increment('available_quantity', $this->quantity);

        return true;
    }

    public function getFormattedBorrowDateAttribute(): string
    {
        return $this->borrow_date->format('d/m/Y');
    }

    public function getFormattedReturnDateAttribute(): string
    {
        return $this->return_date ? $this->return_date->format('d/m/Y') : 'Not returned';
    }

    public function getFormattedDueDateAttribute(): string
    {
        return $this->due_date->format('d/m/Y');
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        // Automatically update status to overdue when checking
        static::retrieved(function ($loan) {
            if ($loan->status === 'Borrowed' && $loan->isOverdue()) {
                $loan->update(['status' => 'Overdue']);
            }
        });
    }
}