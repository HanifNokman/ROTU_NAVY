<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'learning_material_category_id', // Fixed field name
        'file_url',
    ];

    // Fixed relationship
    public function category()
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'learning_material_category_id');
    }
}