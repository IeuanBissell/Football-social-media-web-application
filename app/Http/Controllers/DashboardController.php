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
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve user's recent posts (if you have a Post model)
        $posts = Post::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

        // The notifications will be accessed directly from the authenticated user
        // in the view using Auth::user()->notifications

        return view('dashboard', compact('posts'));
    }
}
