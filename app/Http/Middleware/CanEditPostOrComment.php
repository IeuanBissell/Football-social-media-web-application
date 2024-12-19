<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CanEditPostOrComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $item = $request->route('item'); // Fetch the post or comment from route parameter

        // Check if the user is the owner or has an admin role
        if ($item->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('home')->with('error', 'You are not authorized to edit this item.');
        }
        return $next($request);
    }
}
