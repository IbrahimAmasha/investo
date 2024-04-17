<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRelationship extends Model
{
    use HasFactory;
    protected $fillable = [
        'follower_id',
        'followee_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
