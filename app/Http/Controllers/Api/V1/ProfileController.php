<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
 use App\Models\User;
use App\Http\Resources\Api\V1\ProfileResource;
use function App\Helpers\Error;
use function App\Helpers\Successful;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myProfile()
    {
        
        $user = Auth::user();

        if ($user) {
            $transformedData = new ProfileResource($user);

            return  Successful(200, trans('api.success'), $transformedData);
        } else {
            return  Error(trans('api.error'), 401);
        }
    }

   
}
