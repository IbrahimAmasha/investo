<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use function App\Helpers\Error;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\V1\PostResource;
use App\Http\Resources\Api\V1\UserResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        if ($posts->isEmpty()) {
            return Error('No posts available');
        }

        return Successful(200, 'Posts retrieved successfully', PostResource::collection($posts));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Add image validation
        ]);
    
        try {
            $post = new Post();
            $post->content = $validated['content'];
            $post->user_id = $validated['user_id'];
    
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/posts', $imageName, 'public'); // Store image in 'public/images/posts'
                $post->image = $imagePath; // Save the image path in the post
            }
    
            $post->save();
    
            return Successful(200, 'Post updated successfully', new PostResource($post));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create post. An exception occurred: ' . $e->getMessage(),
            ]);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $post = new PostResource(Post::find($id));

        return  Successful(200, 'Post Retrieved Successfully', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer|exists:posts,id']
        );

        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $validated = $request->validate([
            'content' => 'sometimes|required|string', // Add any additional validation rules here
            'user_id' => 'sometimes|integer|exists:users,id',
        ]);


        $post =  Post::where('id', $id)->update([
            'content' => $validated['content'],
            'user_id' => $validated['user_id'],
        ]);

        $post = new PostResource(Post::find($id));

        return Successful(200, 'Post updated successfully', $post);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:posts,id',
        ]);
        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $post = Post::destroy($id);
        return Successful(200, 'Post deleted successfully');
    }

    public function like(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $post = Post::find($id);
        $user = auth()->user();
        if ($user->likedPosts->contains('id', $id)) {
            return Error('The user already liked this post', 400);
        }
        $post->likes_count++;
        $post->save();
        $user->likedPosts()->attach($id);
        return Successful(200, 'Post liked', ['Total likes' => $post->likes_count]);
    }

    public function unlike(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $post = Post::find($id);
        $user = auth()->user();
        if (!$user->likedPosts->contains('id', $id)) {
            return Error('The user didn\'t like this post', 400);
        }

        $post->likes_count--;
        $post->save();
        $user->likedPosts()->detach($id);
        return Successful(200, 'Post unliked', ['Total likes' => $post->likes_count]);
    }

    public function postLikedBy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid post ID', 400);
        }

        $post = Post::find($id);
        $users =  $post->likedByUsers->map(function ($user) {
            return $user->only(['id']);
        });

        return Successful(200, 'Users Who Liked This Post :', $users);
    }

    public function userPosts($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Error('Invalid user ID', 400);
        }

        $posts =  User::find($id)->posts()->get();

        return Successful(200, 'User Posts :', PostResource::collection($posts));
    }


    public function followeesPosts($id)
    {

        $user = User::find($id);

        $followeeIds = $user->followees->pluck('followee_id');

        $followeesPosts = Post::whereIn('user_id', $followeeIds)
                              ->orderBy('created_at', 'desc')
                              ->get();
        
        return Successful(200, ' Posts :', PostResource::collection($followeesPosts) );
    }


}
