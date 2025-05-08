<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Initialize empty collections for safety
            $notifications = collect([]);
            $recentActivity = collect([]);

            // Get recent notifications (limit to 5)
            try {
                $notifications = $user->notifications()
                                    ->latest()
                                    ->take(5)
                                    ->get();
            } catch (\Exception $e) {
                Log::error('Error fetching notifications', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id
                ]);
            }

            // Get recent activity (posts and comments) from the database
            try {
                // Get recent posts
                $recentPosts = Post::with(['user', 'fixture'])
                                ->latest()
                                ->take(10)
                                ->get()
                                ->map(function($post) {
                                    return [
                                        'id' => $post->id,
                                        'type' => 'post',
                                        'content' => $post->content,
                                        'user_id' => $post->user_id,
                                        'user_name' => $post->user->name,
                                        'fixture_id' => $post->fixture_id,
                                        'fixture_name' => $post->fixture->homeTeam->name . ' vs ' . $post->fixture->awayTeam->name,
                                        'created_at' => $post->created_at,
                                        'url' => route('fixtures.show', $post->fixture_id)
                                    ];
                                });

                // Get recent comments
                $recentComments = Comment::with(['user', 'post', 'post.fixture'])
                                    ->latest()
                                    ->take(10)
                                    ->get()
                                    ->map(function($comment) {
                                        return [
                                            'id' => $comment->id,
                                            'type' => 'comment',
                                            'content' => $comment->content,
                                            'user_id' => $comment->user_id,
                                            'user_name' => $comment->user->name,
                                            'post_id' => $comment->post_id,
                                            'fixture_id' => $comment->post->fixture_id,
                                            'fixture_name' => $comment->post->fixture->homeTeam->name . ' vs ' . $comment->post->fixture->awayTeam->name,
                                            'created_at' => $comment->created_at,
                                            'url' => route('fixtures.show', $comment->post->fixture_id)
                                        ];
                                    });

                // Combine posts and comments, sort by created_at, and take only 5
                $recentActivity = $recentPosts->concat($recentComments)
                                    ->sortByDesc('created_at')
                                    ->take(5);

            } catch (\Exception $e) {
                Log::error('Error fetching recent activity', [
                    'error' => $e->getMessage(),
                    'user_id' => $user->id
                ]);
            }

            return view('dashboard', compact('notifications', 'recentActivity'));

        } catch (\Exception $e) {
            // Log any unexpected errors
            Log::error('Dashboard error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return view with empty collections to prevent errors
            return view('dashboard', [
                'notifications' => collect([]),
                'recentActivity' => collect([])
            ]);
        }
    }
}
