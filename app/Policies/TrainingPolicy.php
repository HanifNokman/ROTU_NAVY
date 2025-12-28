<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Training;

class TrainingPolicy
{
    /**
     * Determine if the user can view any trainings.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view trainings
        return $user->status === 'accepted';
    }

    /**
     * Determine if the user can view the training.
     */
    public function view(User $user, Training $training): bool
    {
        // All accepted users can view training details
        return $user->status === 'accepted';
    }

    /**
     * Determine if the user can create trainings.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine if the user can update the training.
     */
    public function update(User $user, Training $training): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine if the user can delete the training.
     */
    public function delete(User $user, Training $training): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can mark attendance for the training.
     */
    public function markAttendance(User $user, Training $training): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine if the user can view attendance for the training.
     */
    public function viewAttendance(User $user, Training $training): bool
    {
        // Instructors and admin can view all attendance
        if (in_array($user->role, ['admin', 'instructor'])) {
            return true;
        }

        // Cadets can view attendance for trainings they're enrolled in
        if ($user->role === 'cadet' && $user->cadet) {
            return $training->attendances()
                ->where('cadet_id', $user->cadet->id)
                ->exists();
        }

        return false;
    }
}
