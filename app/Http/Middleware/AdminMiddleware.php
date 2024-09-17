<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated.
        if (Auth::check()) {
            // Debug log to check the authenticated user and current URL.
            Log::info('AdminMiddleware triggered', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'url' => $request->url()
            ]);

            // Check if the authenticated user is an admin.
            if (Auth::user()->is_admin) {
                return $next($request); // User is admin, proceed with the request.
            }

            // If the user is authenticated but not an admin, log and redirect.
            Log::warning('User is not an admin, redirecting...', ['user_id' => Auth::id()]);
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // If the user is not authenticated, log and redirect.
        Log::warning('Unauthenticated access attempt, redirecting to login...', ['url' => $request->url()]);
        return redirect()->route('login')->with('error', 'Please login to access the admin area.');
    }
}
