<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predict extends Model
{
    protected $table='predicts';
    use HasFactory;
    protected $fillable = [
        'user_budget',
        'user_time',
        'user_risk',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
