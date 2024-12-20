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
        $posts = Post::with('user', 'comments')->latest()->get();
        return view('fixtures.show', compact('posts'));
    }

    public function store(Request $request, Fixture $fixture)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|max:10240',  // Optional image validation
        ]);

        // Handle image upload if there is one
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = new Post([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'fixture_id' => $fixture->id,
            'image' => $imagePath,
        ]);

        $post->save();

        // Redirect to the fixture's page
        return redirect()->route('fixtures.show', $fixture->id);
    }

    public function edit($fixture_id, Post $post)
    {
        $this->authorize('update', $post);
        if ($post->fixture_id != $fixture_id) {
            abort(404);
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

        if ($request->ajax()) {
            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'post' => $post,
                'message' => 'Post updated successfully!'
            ]);
        }

        // Redirect to the fixture's show page if not an AJAX request
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

        if (request()->ajax()) {
            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully!'
            ]);
        }

        // Redirect to the fixture's show page if not an AJAX request
        return redirect()->route('fixtures.show', $fixture_id);
    }

    public function show(Post $post)
    {
        // Show the single post's details (no need for fixture_id here)
        return view('posts.show', compact('post'));
    }
}
