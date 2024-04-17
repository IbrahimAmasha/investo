<?php

namespace App\Http\Controllers\Api\V1;

use DateTime;
use Carbon\Carbon;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function App\Helpers\Successful;
use App\Http\Requests\SessionRequest;

class SessionController extends Controller
{
    public function bookSession(Request $request)
    {    
        
        $user_id = auth()->user()->id;

        $validatedData = $request->validate([
            'date' => ['required', 'date', new \App\Rules\no_session_conflicts($request->mentor_id,$user_id)],
            'time' => ['required', 'date_format:H:i:s' ],
            'mentor_id' => ['required', 'exists:users,id' ],
        ]); 
        
        $session = new Session();
    
        $session->user_id = $user_id;
        $session->mentor_id = $validatedData['mentor_id'];
        $session->date = $validatedData['date'];
    
        $session->save();
    
        return Successful(200, 'Session booked successfully', '2024-04-16 12:11:00'  <= Carbon::now());
    }


}
