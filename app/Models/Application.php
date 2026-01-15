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
        'height',
        'weight',
        'bmi',
        'profile_pic',
        'attendance',
        'attendance_reason',
        'drill_test',
        'drill_test_reason',
        'physical_test',
        'physical_test_reason',
        'medical_test',
        'medical_test_reason',
        'interview',
        'interview_reason',
        'final_evaluation',
        'final_evaluation_reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}