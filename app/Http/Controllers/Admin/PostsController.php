<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    
    public function index()
    {
      
     
        return view ('admin.posts.index');
    }

    public function status($status)
    {
        $posts = Post::where('status', '=', $status)->get();
        return view('admin.posts.status', compact('posts'));
    }
    

}
