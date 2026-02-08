<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDesignation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'designation_id', 'achieved_at', 
        'achievement_data', 'is_current'
    ];

    protected function casts(): array
    {
        return [
            'achieved_at' => 'datetime',
            'achievement_data' => 'array',
            'is_current' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
