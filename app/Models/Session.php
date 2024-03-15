<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    /**
     * Define the relationships with the User model.
     *
     * Each session involves two users: a participant and a mentor.
     * Both users are retrieved from the "users" table.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'is_booked',
        'user_id',
        'mentor_id',
    ];

    /**
     * Get the participant user associated with the session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the mentor user associated with the session.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor()
    {
        return $this->belongsTo(User::class,'mentor_id');
    }
}
