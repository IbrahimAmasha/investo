<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'likes',
        'dislikes',
    ];

    public function post() 
    {
        return $this->belongsTo(Post::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }


}
