<?php

namespace App\Services;

use App\Models\User;
use App\Mail\VerificationCodeEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VerificationCodeService
{
    /**
     * Generate a secure 6-digit verification code.
     */
    public function generate(string $email): array
    {
        // Generate cryptographically secure 6-digit code
        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Store hashed code with expiration
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
                'expires_at' => now()->addMinutes(10),
                'attempts' => 0,
                'verified' => false,
            ]
        );

        return [
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ];
    }

    /**
     * Validate the verification code.
     */
    public function validate(string $email, string $code): array
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired verification code.',
            ];
        }

        // Check if already verified/used
        if ($record->verified) {
            return [
                'valid' => false,
                'message' => 'This code has already been used. Please request a new one.',
            ];
        }

        // Check expiration
        if (now()->greaterThan($record->expires_at)) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return [
                'valid' => false,
                'message' => 'Verification code has expired. Please request a new one.',
            ];
        }

        // Check max attempts (5 attempts)
        if ($record->attempts >= 5) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return [
                'valid' => false,
                'message' => 'Too many failed attempts. Please request a new code.',
            ];
        }

        // Verify code
        if (! Hash::check($code, $record->token)) {
            // Increment attempts
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->increment('attempts');

            $remainingAttempts = 5 - ($record->attempts + 1);

            return [
                'valid' => false,
                'message' => "Invalid code. {$remainingAttempts} attempts remaining.",
            ];
        }

        return [
            'valid' => true,
            'message' => 'Code verified successfully.',
        ];
    }

    /**
     * Mark code as verified.
     */
    public function markVerified(string $email): void
    {
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->update(['verified' => true]);
    }

    /**
     * Delete verification code.
     */
    public function delete(string $email): void
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }

    /**
      * Check if user exists.
      */
    public function userExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    /**
      * Generate a code and send it via email.
      */
    public static function generateAndSend(string $email): void
    {
        $service = new static();
        $result = $service->generate($email);

        try {
            Mail::to($email)->send(
                new VerificationCodeEmail(
                    $result['code'],
                    $result['expires_at']->format('g:i A'),
                    'signup'
                )
            );
        } catch (\Exception $e) {
            // Swallow mail errors; caller can surface a friendly message.
        }
    }
}