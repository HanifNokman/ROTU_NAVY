<?php
// app/Models/InventoryItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'name',
        'category',
        'total_quantity',
        'available_quantity'
    ];

    protected $casts = [
        'total_quantity' => 'integer',
        'available_quantity' => 'integer'
    ];

    public function equipmentLoans(): HasMany
    {
        return $this->hasMany(EquipmentLoan::class, 'item_id');
    }

    public function activeLoans(): HasMany
    {
        return $this->hasMany(EquipmentLoan::class, 'item_id')
                   ->where('status', 'Borrowed');
    }
}