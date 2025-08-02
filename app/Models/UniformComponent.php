<?php

// app/Models/UniformComponent.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniformComponent extends Model
{
    protected $fillable = [
        'uniform_id',
        'component_name'
    ];

    public function cadetSizes(): HasMany
    {
        return $this->hasMany(CadetSize::class, 'component_id');
    }
}