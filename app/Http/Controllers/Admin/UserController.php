<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Predict;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = new User();

         $users = $user->userBlock();  
        
        return view('admin.users.index', compact('users'));
    }
    

public function blockOfUser($id)
{
    $user = User::find($id);

    if ($user) {
        if ($user->stutas == 1) {
            return redirect()->back()->with('error', 'User already blocked');
        }

        $user->stutas = 1;
        $user->save();
        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    return redirect()->back()->with('error', 'User not found.');
}

    public function History($id)
    {
        $user=User::find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

         $predicts = Predict::where('user_id', $id)->get();

         return view('admin.users.investo_prediect', compact('predicts', 'user'));
    }


    public function Post($id)
    {
        $user=User::find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

         $posts = Post::where('user_id', $id)->get();

         return view('admin.users.posts', compact('posts', 'user'));
    }

    public function RemovePosts($id)
    {
        $post = Post::find($id);
    
      if($post)
      {
        $post->delete();
            return redirect()->back()->with('success', 'Posts Remove successfully.');
      }
        
    
        return redirect()->back()->with('error', 'Posts not found.');
    }
    
    }
 