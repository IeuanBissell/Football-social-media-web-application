<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

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

            // Initialize empty arrays for safety
            $posts = collect([]);
            $notifications = collect([]);

            // Retrieve user's recent posts (limit to 5)
            // Wrap in try-catch to handle any potential errors
            try {
                $posts = Post::where('user_id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();
            } catch (\Exception $e) {
                // Log the error but don't crash
                \Log::error('Error fetching posts: ' . $e->getMessage());
            }

            // Get recent notifications (limit to 5)
            try {
                $notifications = $user->notifications()
                                    ->latest()
                                    ->take(5)
                                    ->get();
            } catch (\Exception $e) {
                // Log the error but don't crash
                \Log::error('Error fetching notifications: ' . $e->getMessage());
            }

            return view('dashboard', compact('posts', 'notifications'));

        } catch (\Exception $e) {
            // Log any unexpected errors
            \Log::error('Dashboard error: ' . $e->getMessage());

            // Return view with empty collections to prevent errors
            return view('dashboard', [
                'posts' => collect([]),
                'notifications' => collect([])
            ]);
        }
    }
}
