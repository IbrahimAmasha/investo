<?php

namespace App\Http\Controllers\Api\V1\model_ai;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Predict;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
         $user = Auth::user();

         if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

         $userId = $user->id;

         $url = 'https://7ce3-197-162-39-220.ngrok-free.app/predict';

         $client = new Client();

         $params = [
            'user_id' => $userId,
            'user_budget' => $request->input('user_budget'),
            'user_time' => $request->input('user_time'),
            'user_risk' => $request->input('user_risk'),
        ];

        try {
             $response = $client->post($url, [
                'json' => $params,
            ]);

             $data = json_decode($response->getBody(), true);

             if ($data) {
                 $store = Predict::create([
                    'user_budget' => $request->input('user_budget'),
                    'user_time' => $request->input('user_time'),
                    'user_risk' => $request->input('user_risk'),
                    'user_id' => $userId,
                ]);
            }

             return response()->json($data);
        } catch (\Exception $e) {
             Log::error('Error fetching prediction', [
                'url' => $url,
                'params' => $params,
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : 'No response body'
            ]);

             return response()->json([
                'error' => 'Unable to fetch prediction',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
