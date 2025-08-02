<?php

// app/Models/UniformType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UniformType extends Model
{
    protected $fillable = [
        'type_name',
        'description'
    ];

    public function uniformComponents(): HasMany
    {
        return $this->hasMany(UniformComponent::class);
    }
}