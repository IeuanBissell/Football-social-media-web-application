<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



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
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fixture_id' => 'required|exists:fixtures,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'content' => $validated['content'],
            'fixture_id' => $validated['fixture_id'],
            'user_id' => Auth::id(),
            'image' => $imagePath,
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

    public function edit(Post $post)
    {
        $this->authorize('edit', $post); // Ensure the user has permission to edit
        return view('posts.edit', compact('post'));
    }

    // Update the post
    public function update(Request $request, Post $post)
    {
        $this->authorize('edit', $post); // Ensure the user has permission to edit

        // Validate the data
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the content
        $post->update(['content' => $request->content]);

        // Handle image update if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }

            // Store new image
            $newImagePath = $request->file('image')->store('images', 'public');
            $post->image = $newImagePath;
            $post->save();
        }

        return redirect()->route('fixtures.show', $post->fixture_id)
                         ->with('success', 'Post updated successfully!');
    }
}