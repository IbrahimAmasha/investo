<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Notification;
use Illuminate\Http\Request;
use function App\Helpers\Error;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use function App\Helpers\Successful;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function userNotifications($id) 
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid user ID', 400);
        }
        
        $notifications = Notification::where('user_id',$id)->get();

        return Successful(200,'Notifications retrieved successfully',NotificationResource::collection($notifications));
    }

   
}
