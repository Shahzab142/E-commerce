<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeEmail;
use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VerificationController
{
    /**
     * Resend a fresh 6-digit verification code to the authenticated user.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'You must be logged in to resend the code.',
            ], 401);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Your email is already verified.',
            ], 422);
        }

        $throttleKey = 'verify-resend:' . md5($user->email);

        if (Cache::has($throttleKey) && Cache::get($throttleKey) >= 5) {
            return response()->json([
                'message' => 'Too many resend requests. Please wait before trying again.',
            ], 429);
        }

        $service = app(VerificationCodeService::class);
        $service->delete($user->email);

        $result = $service->generate($user->email);

        try {
            Mail::to($user->email)->send(
                new VerificationCodeEmail(
                    $result['code'],
                    $result['expires_at']->format('g:i A'),
                    'signup'
                )
            );

            Cache::increment($throttleKey);
            if (! Cache::has($throttleKey)) {
                Cache::put($throttleKey, 1, now()->addMinutes(15));
            }

            return response()->json([
                'message' => 'A new verification code has been sent to your email.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send verification code. Please try again.',
            ], 500);
        }
    }
}
