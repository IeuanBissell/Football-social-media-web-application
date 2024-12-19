<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
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

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add a comment.');
        }
        
        $validated = $request->validate([
            'content' =>'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);
    
        // Return the newly created comment as JSON
        return response()->json([
            'user_name' => $comment->user->name ?? 'Anonymous',
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
            'comment_count' => $post->comments->count(),
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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