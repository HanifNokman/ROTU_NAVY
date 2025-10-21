<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the galleries for the user (instructor).
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'instructor_id');
    }

    /**
     * Get the gallery categories for the user (instructor).
     */
    public function galleryCategories()
    {
        return $this->hasMany(GalleryCategory::class, 'instructor_id');
    }

    /**
     * Get the cadet record associated with the user.
     */
    public function cadet()
    {
        return $this->hasOne(Cadet::class, 'user_id');
    }

    /**
     * Get the instructor record associated with the user.
     */
    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'user_id');
    }
}
