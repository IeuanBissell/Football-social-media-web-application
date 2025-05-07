<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Fixture;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request, Fixture $fixture)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|max:10240',
        ]);

        // Handle image upload if there is one
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Create the post
        $post = new Post([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'fixture_id' => $fixture->id,
            'image' => $imagePath,
        ]);

        $post->save();

        if ($request->ajax()) {
            return response()->json([
                'id' => $post->id,
                'content' => $post->content,
                'image' => $imagePath,
                'created_at' => $post->created_at->diffForHumans(),
                'user' => [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name
                ]
            ]);
        }

        // Flash success message
        session()->flash('success', 'Post created successfully!');

        // Always redirect back to the fixture show page
        return redirect()->route('fixtures.show', $fixture);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Fixture $fixture, Post $post)
    {
        $this->authorize('update', $post);

        // Ensure post belongs to this fixture
        if ($post->fixture_id != $fixture->id) {
            abort(404);
        }

        return view('posts.edit', compact('post', 'fixture'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, Fixture $fixture, Post $post)
    {
        // Authorize the request
        $this->authorize('update', $post);

        // Validate request data
        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|max:10240',
        ]);

        // Ensure post belongs to this fixture
        if ($post->fixture_id != $fixture->id) {
            abort(404);
        }

        // Update post content
        $post->content = $request->content;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        // Flash success message
        session()->flash('success', 'Post updated successfully!');

        // Redirect back to fixture
        return redirect()->route('fixtures.show', $fixture->id);
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Fixture $fixture, Post $post)
    {
        // Authorize the request
        $this->authorize('delete', $post);

        // Ensure post belongs to this fixture
        if ($post->fixture_id != $fixture->id) {
            abort(404);
        }

        // Delete associated image
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        // Delete the post
        $post->delete();

        // Flash success message
        session()->flash('success', 'Post deleted successfully!');

        // Redirect back to fixture
        return redirect()->route('fixtures.show', $fixture->id);
    }
}
