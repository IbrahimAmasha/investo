<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User_Realtionships_Controller extends Controller
{
      // retrieve followers of a given user
    public function followers($userId)
    {
        $user = User::findOrFail($userId);
        $followers = $user->followers()->with('follower')->get();

        return response()->json($followers);
    }

    // retrieve followees of a given user
    public function followees($userId)
    {
        $user = User::findOrFail($userId);
        $followees = $user->followees()->with('followee')->get();

        return response()->json($followees);
    }
}
