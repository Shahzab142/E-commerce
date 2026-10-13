<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * Usage:
     * ->middleware('role:admin')
     * ->middleware('role:vendor')
     * ->middleware('role:user')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | User must be authenticated
        |--------------------------------------------------------------------------
        */

        if (! $user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Suspended accounts cannot access anything
        |--------------------------------------------------------------------------
        */

        if ($user->isSuspended()) {
            abort(403, 'Your account has been suspended.');
        }

        /*
        |--------------------------------------------------------------------------
        | Check role
        |--------------------------------------------------------------------------
        */

        $authorized = match ($role) {

            User::ROLE_ADMIN => $user->isAdmin(),

            User::ROLE_EMPLOYEE => $user->isEmployee() || $user->isAdmin(),

            User::ROLE_USER => $user->isUser(),

            default => false,

        };

        if (! $authorized) {
            if ($user->isEmployee()) {
                return redirect()->route('employee.dashboard')->with('error', 'Access denied: Employees are not authorized to access the Admin Dashboard.');
            }

            if ($user->isUser()) {
                return redirect()->route('user.dashboard')->with('error', 'Access denied: You are not authorized to access this area.');
            }

            abort(403, 'You are not authorized to access this page.');
        }


        /*
        |--------------------------------------------------------------------------
        | Continue Request
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}