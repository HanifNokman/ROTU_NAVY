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
        'category_id',
        'file_url',
        // Add other fields if needed
    ];

    // Relationship (if you have a Category model)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
