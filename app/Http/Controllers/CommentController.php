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
        $comments = $post->comments;
        return view('comments.index', ['post' => $post, 'comments'=> $comments]);
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

        $comment = $post->comments()->create([
            'content' => $validated['content'],
        ]);
    
        // Return the newly created comment as JSON
        return response()->json([
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(), // Format the timestamp
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