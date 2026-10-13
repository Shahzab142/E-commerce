<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin wrapper around the Stripe REST API.
 *
 * Used instead of the stripe/stripe-php SDK so we don't depend on an extra
 * Composer package. All requests are made with Laravel's HTTP client using
 * the server-side secret key.
 */
class Stripe
{
    protected string $key;

    protected string $secret;

    public function __construct()
    {
        $this->key = (string) config('stripe.key');
        $this->secret = (string) config('stripe.secret');
    }

    public function configured(): bool
    {
        return $this->key !== '' && $this->secret !== '';
    }

    /**
     * Create a hosted Checkout Session.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function createCheckoutSession(array $payload): array
    {
        $response = Http::withToken($this->secret, 'Basic')
            ->asForm()
            ->post('https://api.stripe.com/v1/checkout/sessions', $payload);

        if ($response->failed()) {
            throw new ConnectionException(sprintf(
                'Stripe checkout session could not be created: %s',
                $response->body()
            ));
        }

        return $response->json();
    }

    /**
     * Retrieve an existing Checkout Session (used to verify payment status).
     *
     * @return array<string, mixed>
     */
    public function retrieveCheckoutSession(string $sessionId): array
    {
        $response = Http::withToken($this->secret, 'Basic')
            ->get('https://api.stripe.com/v1/checkout/sessions/'.$sessionId);

        if ($response->failed()) {
            throw new RuntimeException(sprintf(
                'Stripe session could not be retrieved: %s',
                $response->body()
            ));
        }

        return $response->json();
    }
}