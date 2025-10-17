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

    /**
     * Category relationship
     */
    public function category()
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'learning_material_category_id');
    }

    /**
     * Instructor relationship
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * Cadet progress for this material
     */
    public function cadetProgress()
    {
        return $this->hasMany(CadetLearningMaterialProgress::class, 'learning_material_id');
    }

    /**
     * Check if a specific cadet has completed this material
     */
    public function isCompletedBy($cadetId)
    {
        return $this->cadetProgress()
            ->where('cadet_id', $cadetId)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Get progress for a specific cadet
     */
    public function getProgressFor($cadetId)
    {
        return $this->cadetProgress()
            ->where('cadet_id', $cadetId)
            ->first();
    }

    /**
     * Check if a specific cadet has started this material
     */
    public function isStartedBy($cadetId)
    {
        return $this->cadetProgress()
            ->where('cadet_id', $cadetId)
            ->exists();
    }

    /**
     * Get material type based on file extension
     */
    public function getMaterialTypeAttribute()
    {
        if (!$this->file_url) {
            return 'text';
        }

        $extension = strtolower(pathinfo($this->file_url, PATHINFO_EXTENSION));

        if (in_array($extension, ['mp4', 'webm', 'avi', 'mov'])) {
            return 'video';
        } elseif (in_array($extension, ['mp3', 'wav', 'ogg', 'm4a'])) {
            return 'audio';
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            return 'image';
        } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'ppt', 'pptx'])) {
            return 'document';
        }

        return 'text';
    }

    /**
     * Scope to get materials by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('learning_material_category_id', $categoryId);
    }

    /**
     * Scope to get materials with progress for a specific cadet
     */
    public function scopeWithProgressFor($query, $cadetId)
    {
        return $query->with(['cadetProgress' => function ($q) use ($cadetId) {
            $q->where('cadet_id', $cadetId);
        }]);
    }
}