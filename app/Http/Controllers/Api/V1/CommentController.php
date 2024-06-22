<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

use function App\Helpers\Error;
use App\Http\Controllers\Controller;
use function App\Helpers\Successful;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\V1\CommentResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = CommentResource::collection(Comment::all());

        if ($comments->isNotEmpty()) {
            return Successful(200, 'Comments retrieved Successfully', $comments);
        }
        else {
            return Error('No comments available');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->save();

        $comment = new CommentResource($comment);
        return Successful(200, 'Comment added successfully', $comment);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::Find($id);
        $comment = new CommentResource($comment);
        return Successful(200, 'Comment retrieved successfully',$comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::where('id', $id)->update(['content' => $request->content]);
        $comment = new CommentResource(Comment::find($id));
        return Successful(200, 'Comment updated successfully', $comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::destroy($id);
        return Successful(200, 'Comment deleted successfully');
    }

    public function postComments($post_id)
    {
        $post =  Post::find($post_id);
        $comments = $post->comments;
        $comments = CommentResource::collection($comments);
        return Successful(200, 'Post comments retrieved Successfully', $comments);

    }

    public function likeComment($id)
    {
        try {
            // Find the comment by its ID
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:comments,id',
            ]);
    
            if ($validator->fails()) {
                return Error('Invalid comment ID', 400);
            }
    
            $comment = Comment::find($id);

            $comment->likes++;
            $comment->save();
    
            // Return a successful response
            return Successful(200, 'Comment liked successfully', $comment);
    
        } catch (\Exception $e) {
            // Handle any exceptions
            return Error('An error occurred while liking the comment. ' . $e->getMessage(), 500);
        }
    }
    
}
