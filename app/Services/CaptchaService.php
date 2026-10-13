<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CaptchaService
{
    /**
     * Generate a new math CAPTCHA puzzle.
     */
    public function generate(): array
    {
        $num1 = random_int(1, 15);
        $num2 = random_int(1, 15);

        // Ensure the answer is positive and reasonable
        if ($num1 < $num2) {
            [$num1, $num2] = [$num2, $num1];
        }

        $answer = $num1 + $num2;

        // Store hashed answer in session
        Session::put('captcha_answer', hash('sha256', (string) $answer));
        Session::put('captcha_time', now()->timestamp);

        return [
            'question' => "What is {$num1} + {$num2}?",
            'num1' => $num1,
            'num2' => $num2,
        ];
    }

    /**
     * Validate the CAPTCHA answer.
     */
    public function validate(?string $userAnswer): bool
    {
        if (empty($userAnswer)) {
            return false;
        }

        $storedAnswer = Session::get('captcha_answer');
        $captchaTime = Session::get('captcha_time');

        if (!$storedAnswer || !$captchaTime) {
            return false;
        }

        // Check if CAPTCHA has expired (5 minutes)
        if (now()->timestamp - $captchaTime > 300) {
            $this->clear();
            return false;
        }

        $isValid = hash_equals($storedAnswer, hash('sha256', $userAnswer));

        // Clear CAPTCHA after validation attempt
        $this->clear();

        return $isValid;
    }

    /**
     * Clear CAPTCHA from session.
     */
    public function clear(): void
    {
        Session::forget(['captcha_answer', 'captcha_time']);
    }
}
