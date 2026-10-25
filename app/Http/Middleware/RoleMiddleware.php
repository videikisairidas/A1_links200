<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // 1. Fixed the relationship call: $user->role is a Model object based on your earlier User model.
        // We use optional() or ?-> to prevent errors if the user has no role assigned.
        $userRoleName = $user?->role?->name; 

        if (! $user || ! in_array($userRoleName, $roles, true)) {
            
            // 2. Return a JSON response if explicitly expected, or if it's an API route
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'You dont have permission to do this action',
                ], 403);
            }

            // 3. For Web requests, flash a message so the user knows WHY they were redirected
            return redirect()->route('login')
                ->with('error', 'You do not have permission to access that area.');
        }

        return $next($request);
    }
}