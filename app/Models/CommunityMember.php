<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'role',
        'joined_at',
        'is_active'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
