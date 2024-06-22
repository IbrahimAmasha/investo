<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use function App\Helpers\Error;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\Api\V1\PostResource;
use App\Http\Resources\Api\V1\UserResource;

class AuthController extends Controller
{
 
    public function register(StoreRegisterRequest $request)
    {
        $validatedData = $request->validated();
    
        try {
            // Debugging: Dump validated data to verify
            // dd($validatedData);
    
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/users', $imageName, 'public'); // Store image in 'public/images/users'
            }
    
            // Create user record
            $user = User::create([
                'f_name' => $validatedData['f_name'],
                'l_name' => $validatedData['l_name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'national_id' => $validatedData['national_id'],
                'gender' => $validatedData['gender'],
                'dob' => $validatedData['dob'],
                'image' => $imagePath, // Save the image path in the user record
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'User Registered Successfully',
                'data' => $user, // Optional: Return user data if needed
            ]);
    
        } catch (\Exception $e) {
            // Debugging: Log the exception for further investigation
            // Log::error('Failed to register user: ' . $e->getMessage());
    
            return response()->json([
                'status' => 500,
                'message' => 'Failed to register user. ' . $e->getMessage(),
            ]);
        }
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
