<?php

// app/Models/EquipmentLoan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'quantity' => 'integer'
    ];

    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'Returned') {
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
}
