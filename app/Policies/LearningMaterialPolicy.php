<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LearningMaterial;

class LearningMaterialPolicy
{
    /**
     * Determine if the user can view any learning materials.
     */
    public function viewAny(User $user): bool
    {
        return $user->status === 'accepted';
    }

    /**
     * Determine if the user can view the learning material.
     */
    public function view(User $user, LearningMaterial $material): bool
    {
        // All accepted users can view learning materials
        return $user->status === 'accepted';
    }

    /**
     * Determine if the user can create learning materials.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine if the user can update the learning material.
     */
    public function update(User $user, LearningMaterial $material): bool
    {
        // Admin can update any material
        if ($user->role === 'admin') {
            return true;
        }

        // Instructors can update their own materials
        if ($user->role === 'instructor' && $user->instructor) {
            return $material->instructor_id === $user->instructor->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the learning material.
     */
    public function delete(User $user, LearningMaterial $material): bool
    {
        // Admin can delete any material
        if ($user->role === 'admin') {
            return true;
        }

        // Instructors can delete their own materials
        if ($user->role === 'instructor' && $user->instructor) {
            return $material->instructor_id === $user->instructor->id;
        }

        return false;
    }

    /**
     * Determine if the user can track progress on the learning material.
     */
    public function trackProgress(User $user, LearningMaterial $material): bool
    {
        return $user->role === 'cadet' && $user->status === 'accepted';
    }
}
