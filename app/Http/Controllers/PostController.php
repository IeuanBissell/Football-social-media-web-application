<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Fixture;
use App\Notifications\NewPostNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        try {
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

            // Log the post creation
            Log::info('Post created', ['post_id' => $post->id, 'user_id' => Auth::id()]);

            // Find users to notify about the new post
            // This notifies users who have posted in the same fixture
            $usersToNotify = User::whereHas('posts', function($query) use ($fixture) {
                    $query->where('fixture_id', $fixture->id);
                })
                ->where('id', '!=', Auth::id()) // Don't notify the post creator
                ->get();

            // Send notifications to these users
            foreach ($usersToNotify as $user) {
                try {
                    $user->notify(new NewPostNotification($post));
                    Log::info('New post notification sent', [
                        'post_id' => $post->id,
                        'notified_user_id' => $user->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send new post notification', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id,
                        'post_id' => $post->id
                    ]);
                }
            }

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

            session()->flash('success', 'Post created successfully!');

            return redirect()->route('fixtures.show', $fixture);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to create post', [
                'error' => $e->getMessage(),
                'fixture_id' => $fixture->id
            ]);

            // Clean up image if it was uploaded
            if (isset($imagePath) && $imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to create post. Please try again.'
                ], 500);
            }

            session()->flash('error', 'Failed to create post. Please try again.');
            return redirect()->route('fixtures.show', $fixture);
        }
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Fixture $fixture, Post $post)
    {
        $this->authorize('update', $post);

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
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|max:10240',
        ]);

        if ($post->fixture_id != $fixture->id) {
            abort(404);
        }

        try {
            $post->content = $request->content;

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::delete('public/' . $post->image);
                }
                $post->image = $request->file('image')->store('posts', 'public');
            }

            $post->save();

            session()->flash('success', 'Post updated successfully!');

            return redirect()->route('fixtures.show', $fixture->id);

        } catch (\Exception $e) {
            Log::error('Failed to update post', [
                'error' => $e->getMessage(),
                'post_id' => $post->id
            ]);

            session()->flash('error', 'Failed to update post. Please try again.');
            return redirect()->route('fixtures.show', $fixture->id);
        }
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Fixture $fixture, Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->fixture_id != $fixture->id) {
            abort(404);
        }

        try {
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }

            $post->delete();

            session()->flash('success', 'Post deleted successfully!');

            return redirect()->route('fixtures.show', $fixture->id);

        } catch (\Exception $e) {
            Log::error('Failed to delete post', [
                'error' => $e->getMessage(),
                'post_id' => $post->id
            ]);

            session()->flash('error', 'Failed to delete post. Please try again.');
            return redirect()->route('fixtures.show', $fixture->id);
        }
    }
}
