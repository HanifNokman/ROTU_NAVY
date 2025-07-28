<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class);
    }
}
