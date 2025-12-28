<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cadet;

class CadetPolicy
{
    /**
     * Determine if the user can view any cadets.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }

    /**
     * Determine if the user can view the cadet.
     */
    public function view(User $user, Cadet $cadet): bool
    {
        // Admin and instructors can view any cadet
        if (in_array($user->role, ['admin', 'instructor'])) {
            return true;
        }

        // Cadets can only view their own profile
        if ($user->role === 'cadet' && $user->cadet) {
            return $user->cadet->id === $cadet->id;
        }

        return false;
    }

    /**
     * Determine if the user can create cadets.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can update the cadet.
     */
    public function update(User $user, Cadet $cadet): bool
    {
        // Admin can update any cadet
        if ($user->role === 'admin') {
            return true;
        }

        // Instructors can update cadet details
        if ($user->role === 'instructor') {
            return true;
        }

        // Cadets can update their own profile (limited fields)
        if ($user->role === 'cadet' && $user->cadet) {
            return $user->cadet->id === $cadet->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the cadet.
     */
    public function delete(User $user, Cadet $cadet): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can view cadet performance ratings.
     */
    public function viewPerformance(User $user, Cadet $cadet): bool
    {
        // Admin and instructors can view any cadet's performance
        if (in_array($user->role, ['admin', 'instructor'])) {
            return true;
        }

        // Cadets can view their own performance
        if ($user->role === 'cadet' && $user->cadet) {
            return $user->cadet->id === $cadet->id;
        }

        return false;
    }

    /**
     * Determine if the user can update cadet performance ratings.
     */
    public function updatePerformance(User $user, Cadet $cadet): bool
    {
        return in_array($user->role, ['admin', 'instructor']);
    }
}
