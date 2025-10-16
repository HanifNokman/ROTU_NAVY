<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'gender',
        'ic_number',
        'matric_no',
        'faculty',
        'course',
        'profile_pic',
        'attendance',
        'drill_test',
        'physical_test',
        'medical_test',
        'interview',
        'final_evaluation',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}