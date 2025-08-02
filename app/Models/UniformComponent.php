<?php

// app/Models/UniformComponent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniformComponent extends Model
{
    protected $fillable = [
        'uniform_type_id',
        'component_name'
    ];

    public function uniformType(): BelongsTo
    {
        return $this->belongsTo(UniformType::class);
    }

    public function cadetSizes(): HasMany
    {
        return $this->hasMany(CadetSize::class, 'component_id');
    }
}