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
     * Check if the file_url is a YouTube link
     */
    public function isYouTubeLink(): bool
    {
        if (!$this->file_url) {
            return false;
        }

        return preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/', $this->file_url);
    }

    /**
     * Extract YouTube video ID from URL
     */
    public function getYouTubeVideoId(): ?string
    {
        if (!$this->isYouTubeLink()) {
            return null;
        }

        $url = $this->file_url;

        // Handle youtu.be format
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Handle youtube.com/watch?v= format
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        // Handle youtube.com/embed/ format
        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getYouTubeEmbedUrl(): ?string
    {
        $videoId = $this->getYouTubeVideoId();

        if (!$videoId) {
            return null;
        }

        return "https://www.youtube.com/embed/{$videoId}?enablejsapi=1";
    }

    /**
     * Get material type based on file extension
     */
    public function getMaterialTypeAttribute()
    {
        // Check if it's a YouTube link first
        if ($this->isYouTubeLink()) {
            return 'youtube';
        }

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