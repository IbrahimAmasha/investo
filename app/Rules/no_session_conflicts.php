<?php

namespace App\Rules;

use App\Models\Session;
use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class no_session_conflicts implements ValidationRule
{
    protected $mentorId;
    protected $userId;

    public function __construct($mentorId,$userId)
    {
        $this->mentorId = $mentorId;
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->userId === $this->mentorId) {
            $fail('The user cannot book a session with themselves.');
            return;
        }

        //make the time gap between each session for the same mentor = 60 minutes
        $minimumDate = Carbon::parse($value)->subMinutes(59);
        $maximumDate = Carbon::parse($value)->addMinutes(59);
 
        $conflictingSessionExists = Session::where('mentor_id', $this->mentorId)
            ->whereBetween('date', [$minimumDate, $maximumDate])
            ->exists();

        if ($conflictingSessionExists) {
             $fail('A conflicting session exists for the mentor.');
        }

        $conflictingSessionExists = Session::where('user_id', $this->userId)
            ->whereBetween('date', [$minimumDate, $maximumDate])
            ->exists();

        if ($conflictingSessionExists) {
             $fail('A conflicting session exists for the user.');
        }
    }
}