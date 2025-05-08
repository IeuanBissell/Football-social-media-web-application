<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Get all notifications for display, not just unread ones
        // We don't need to query this separately since the logged-in user already has the notifications relation
        // This is just for clarity
        $notifications = $user->notifications()->latest()->limit(5)->get();

        // Debug: Log notification details
        Log::info('User notifications', [
            'user_id' => $user->id,
            'notification_count' => count($notifications),
            'notification_details' => $notifications->map(function($n) {
                return [
                    'id' => $n->id,
                    'type' => $n->type,
                    'read_at' => $n->read_at,
                    'data' => $n->data,
                ];
            })
        ]);

        return view('dashboard', compact('notifications'));
    }
}
