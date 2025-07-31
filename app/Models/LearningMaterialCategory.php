<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Changed from 'category' to 'name' to match your form

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class, 'learning_material_category_id');
    }
}