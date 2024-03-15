<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use function App\Helpers\Error;
use function App\Helpers\Successful;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function createPosts(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return Error(trans('api.error'), 401);  
        }
  
        $content = $request->input('content');

        $post = Post::create([
            'content' => $content,
            'user_id' => $user->id,  
        ]);

        return Successful(200, trans('api.success'), $post);  
    }
    public function myPosts()
    {  

        $user=Auth::user();

        if(!$user)
        {
            return  Error(trans('api.error'), 404);
        }

        $myPosts = $user->Post()->get();
 
        if ($myPosts->isEmpty()) {
            return Error(trans('api.posts_empty'), 401); 
        }
    
         return Successful(200, trans('api.success'), $myPosts);
    }
    }


