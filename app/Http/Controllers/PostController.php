<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user', 'fixture')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to post.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'fixture_id' => 'required|exists:fixtures,id',
        ]);

        $post = Post::create([
            'content' => $validated['content'],
            'fixture_id' => $validated['fixture_id'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Post created successfully.');
    }

    /**
     * Fetch comments for a post (AJAX).
     */
    public function show(Post $post)
    {
        $post->load('comments.user');

        $comments = $post->comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'user_name' => $comment->user->name ?? 'Anonymous',
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ];
        });

        return response()->json(['comments' => $comments]);
    }
}
