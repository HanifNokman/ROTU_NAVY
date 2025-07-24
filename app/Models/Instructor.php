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
    ];

    protected $hidden = [
        // Add any fields you want hidden, e.g. ''
    ];

    protected function casts(): array
    {
        return [
            // Add any casts needed, e.g. 'created_at' => 'datetime'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
