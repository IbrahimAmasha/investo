<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\UserRelationship;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'email',
        'password',
        'national_id',
        'gender',
        'dob',
        'bio',
        'image',
        'email_verified_at',
    ];

    public function followers()
    {
        return $this->hasMany(UserRelationship::class, 'followee_id');
    }

    // Define relationship with UserRelationship model for followees
    public function followees()
    {
        return $this->hasMany(UserRelationship::class, 'follower_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function notofications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sessionsAsUser()
    {
        return $this->hasMany(Session::class,'user_id');
    }
    
    public function sessionsAsMentor()
    {
        return $this->hasMany(Session::class,'mentor_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
