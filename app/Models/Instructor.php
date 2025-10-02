<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'phone_number',
        'rank',
        'profile_pic',
        'position',
        'expertise',
        'time_in_service',
        'ttp',
        'status',
        'service_number',
        'past_unit',
    ];

    protected $hidden = [
        // For hidden fields
    ];

    protected function casts(): array
    {
        return [
            // For any type casting
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
