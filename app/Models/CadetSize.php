<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadetSize extends Model
{
    protected $fillable = [
        'cadet_id',
        'component_id',
        'size',
        'is_issued'
    ];

    protected $casts = [
        'is_issued' => 'boolean'
    ];

    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function uniformComponent(): BelongsTo
    {
        return $this->belongsTo(UniformComponent::class, 'component_id');
    }

    /**
     * Automatically convert size to uppercase before saving.
     */
    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = strtoupper(trim($value));
    }
}
