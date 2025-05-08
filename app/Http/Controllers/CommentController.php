<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // Create the comment
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'comment' => $comment,
                'user' => $comment->user,
                'created_at' => $comment->created_at->diffForHumans(),
            ]);
        }

        return redirect()->route('fixtures.show', $post->fixture_id);
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->content = $request->content;
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'comment' => $comment,
                'updated_at' => $comment->updated_at->diffForHumans(),
            ]);
        }

        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Comment deleted successfully.',
            ]);
        }

        return back();
    }
}
