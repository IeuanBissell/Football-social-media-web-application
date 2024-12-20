<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Get all posts, comments, and users associated with the posts
        $posts = Post::with('user', 'comments')->latest()->get();
        return view('fixtures.show', compact('posts'));
    }

    public function create($fixture_id)
    {
        // Ensure the fixture exists
        $fixture = Fixture::findOrFail($fixture_id);
        return view('posts.create', compact('fixture'));
    }

    public function store(Request $request, $fixture_id)
    {
        // Validate request
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Create a new post associated with the fixture
        $post = new Post([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'fixture_id' => $fixture_id,
        ]);

        // Handle file upload if an image is provided
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'public');
        }

        // Save the post
        $post->save();

        // Redirect to the fixture's show page
        return redirect()->route('fixtures.show', $fixture_id);
    }

    public function edit($fixture_id, Post $post)
    {
        // Ensure the post belongs to the authenticated user and authorize
        $this->authorize('update', $post);

        // Ensure fixture ID matches the post's fixture ID
        if ($post->fixture_id != $fixture_id) {
            abort(404); // If fixture_id mismatch, throw error
        }

        return view('posts.edit', compact('post', 'fixture_id'));
    }

    public function update(Request $request, $fixture_id, Post $post)
    {
        // Authorize and validate
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ensure fixture ID matches the post's fixture ID
        if ($post->fixture_id != $fixture_id) {
            abort(404);
        }

        // Update post content
        $post->content = $request->content;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            Storage::delete('public/' . $post->image);
            $post->image = $request->file('image')->store('images', 'public');
        }

        // Save the updated post
        $post->save();

        return redirect()->route('fixtures.show', $fixture_id);
    }

    public function destroy($fixture_id, Post $post)
    {
        // Authorize and ensure post belongs to the authenticated user
        $this->authorize('delete', $post);

        // Ensure fixture ID matches the post's fixture ID
        if ($post->fixture_id != $fixture_id) {
            abort(404); // If fixture_id mismatch, throw error
        }

        // Delete associated image from storage
        Storage::delete('public/' . $post->image);

        // Delete the post
        $post->delete();

        return redirect()->route('fixtures.show', $fixture_id);
    }

    public function show(Post $post)
    {
        // Show the single post's details (no need for fixture_id here)
        return view('posts.show', compact('post'));
    }
}
