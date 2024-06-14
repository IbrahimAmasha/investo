<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'content',
        'image',
        'status',
        'likes_count',
        'user_id',
    ];    
    public function User()
    {
         
            return $this->belongsTo(User::class,'user_id' );
        
    }

    public function likedByUsers() 
    {
        return $this->belongsToMany(User::class,'post_like','post_id','user_id')->withTimestamps();
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }
}