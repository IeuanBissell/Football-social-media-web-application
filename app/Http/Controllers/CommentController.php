<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
{
    return response()->json([
        'comments' => $post->comments->map(function ($comment) {
            return [
                'content' => $comment->content,
                'user_name' => $comment->user->name ?? 'Anonymous',
                'created_at' => $comment->created_at->diffForHumans(),
            ];
        }),
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        
        $validated = $request->validate([
            'content' =>'required|string|max:1000',
        ]);

        // Ensure the user is authenticated
        if (Auth::check()) {
        // Create the comment using the relationship
            $comment = $post->comments()->create([
                'user_id' => Auth::id(),
                'content' => $validated['content'],
            ]);

        // Optionally return the new comment as a response
            return response()->json([
                'user_name' => $comment->user->name,  // User's name associated with the comment
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),  // Human-readable time
                'comment_count' => $post->comments()->count(),  // Update the comment count on the post
            ]);
        } else {
            // Handle case where the user is not authenticated
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', $id); // Check if the user can update the comment

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
    
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
    
        $comment->update($validated);
    
        return redirect()->route('comments.index', ['post' => $comment->post_id])->with('success', 'Comment updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getComments(Post $post)
    {
        // Fetch the comments for the post
        $comments = $post->comments()->with('user')->get();
        // Format the comments in a way that the JavaScript can display
        $formattedComments = $comments->map(function($comment) {
            return [
                'user_name' => $comment->user ? $comment->user->name : 'Anonymous',
                'created_at' => $comment->created_at->diffForHumans(),
                'content' => $comment->content
            ];
        });
        return response()->json(['comments' => $formattedComments]);
    }
}