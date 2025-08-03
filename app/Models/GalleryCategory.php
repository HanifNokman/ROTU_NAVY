<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instructor_id',
    ];

    /**
     * Get the gallery items for the category.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'gallery_category_id');
    }

    /**
     * Get the instructor that owns the category.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}