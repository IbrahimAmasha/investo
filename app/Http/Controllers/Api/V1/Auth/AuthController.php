<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use function App\Helpers\Error;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\Api\V1\UserResource;

class AuthController extends Controller
{
 
    public function register(StoreRegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create([
            'f_name' => $validatedData['f_name'],
            'l_name' => $validatedData['l_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Remember to hash the password
            'national_id' => $validatedData['national_id'],
            'gender' => $validatedData['gender'],
            'dob' => $validatedData['dob'],
        ]);

        return Successful(200, trans('api.register_success') , $user);
    }





    public function login(StoreLoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return Error(401, trans('api.login_error'));
        }

        $user = $request->user();

        $token = $user->createToken('authToken')->plainTextToken;

        $userData = new UserResource($user);

        return Successful(200, trans('api.login_success'), ['user' => $userData, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return Successful(200, trans('api.logout'));
    }
}
