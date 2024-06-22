<?php

namespace App\Http\Controllers\Api\V1;

use Error;
use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Session;
use App\Models\Notification;

use Illuminate\Http\Request;
use App\Events\SessionBooked;
use function App\Helpers\Error;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;
use App\Http\Requests\SessionRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\V1\SessionResource;

class SessionController extends Controller
{
    public function bookSession(Request $request)
    {

        $user_id = auth()->user()->id;

        $validatedData = $request->validate([
            'date' => ['required', 'date', new \App\Rules\no_session_conflicts($request->mentor_id, $user_id)],
            'time' => ['required', 'date_format:H:i:s'],
            'mentor_id' => ['required', 'exists:users,id'],
        ]);

        $session = new Session();

        $session->user_id = $user_id;
        $session->mentor_id = $validatedData['mentor_id'];
        $session->date = $validatedData['date'];

        $session->save();

        // Fetch user and mentor names
        $user = User::find($user_id);
        $mentor = User::find($validatedData['mentor_id']);
        $message = ' .قام  بتقديم طلب لحجز جلسة معك ' . "{$user->f_name} {$user->l_name}";

        // Fire the SessionBooked event
        event(new SessionBooked($user_id, $validatedData['mentor_id'], $session->id, $message));

        // Create a notification
        Notification::create([
            'user_id' => $validatedData['mentor_id'],
            'type' => 'session_booked',
            'actor_id' => $user_id,
            'actor_name' => "{$user->f_name} {$user->l_name}",
            'data' => $message
        ]);


        return Successful(200, 'Session booked successfully', '2024-04-16 12:11:00'  <= Carbon::now());
    }

    public function mentorPendingSessions($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid session ID', 400);
        }

        $sessions =  User::find($id)->sessionsAsMentor()->where('is_booked', 0)->get();

        return Successful(200, 'User sessions  :', SessionResource::collection($sessions));
    }

    public function acceptSession($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sessions,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid session ID', 400);
        }


        $session =  Session::find($id)->first();

        if ($session->is_booked) {
            return Error('This Session is already booked', 400);
        }

        $session->is_booked = true;
        $session->save();

        return Successful(200, 'Session has been accepteed.');
    }

    public function declineSession($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:sessions,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid session ID', 400);
        }

        $session = Session::destroy($id);
        return Successful(200, 'Session has been declined.');
    }
}
