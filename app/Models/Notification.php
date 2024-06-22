<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'actor_id',
        'actor_name',
        'data',
        'read',
    ];

    // protected $casts = [
    //     'data' => 'array', // Automatically cast the data field to an array
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
