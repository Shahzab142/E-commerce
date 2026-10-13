<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirect authenticated users who have not yet verified their email
 * address to the 6-digit verification-code page.
 *
 * Applied alongside 'auth' on all dashboard / privileged route groups.
 */
class EnsureEmailVerified
{
    /**
     * Routes that are always allowed regardless of verification state.
     */
    private const ALLOWED = [
        'verification.verify-code',
        'verification.resend',
        'logout',
        'auth.social.redirect',
        'auth.social.callback',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs(self::ALLOWED)) {
            return $next($request);
        }

        $user = $request->user();

        if ($user && $user->email_verified_at === null) {
            // Remember where the user was trying to go.
            session(['url.intended' => $request->fullUrl()]);

            return redirect()->route('verification.verify-code')
                ->with('warning', 'Please verify your email address before continuing.');
        }

        return $next($request);
    }
}
