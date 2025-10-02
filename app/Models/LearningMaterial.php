<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instructor_id',
        'description',
        'learning_material_category_id',
        'file_url',
    ];

    public function category()
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'learning_material_category_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }
}