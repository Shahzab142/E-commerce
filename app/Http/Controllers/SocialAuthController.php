<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use RuntimeException;
use Throwable;

class SocialAuthController
{
    /** Providers that are supported and have a Socialite driver. */
    private const SUPPORTED = ['google', 'facebook', 'linkedin', 'x'];

    /**
     * Map a provider to its Socialite driver. LinkedIn's modern
     * "Sign In with LinkedIn using OpenID Connect" product uses the
     * linkedin-openid driver — the legacy 'linkedin' driver can no longer
     * return the user's email address.
     */
    private const DRIVER_MAP = ['linkedin' => 'linkedin-openid'];

    /**
     * Redirect the user to the provider's OAuth page.
     */
    public function redirect(string $provider): RedirectResponse
    {
        if (! in_array($provider, self::SUPPORTED, true)) {
            abort(404);
        }

        if (! $this->isConfigured($provider)) {
            Log::warning("Social login requested for unconfigured provider: {$provider}");

            return redirect()->route('register')
                ->with('error', ucfirst($provider) . ' authentication is not configured yet. Please register using the form below.');
        }

        return Socialite::driver($this->driverFor($provider))->redirect();
    }

    /**
     * Handle the provider callback.
     */
    public function callback(string $provider): RedirectResponse
    {
        if (! in_array($provider, self::SUPPORTED, true)) {
            abort(404);
        }

        $socialUser = null;

        try {
            $socialUser = Socialite::driver($this->driverFor($provider))->user();
        } catch (InvalidStateException $e) {
            // User cancelled, or the OAuth state/token did not match.
            Log::warning("Social auth state invalid for {$provider}: " . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'Authentication was not completed. Please try again.');
        } catch (RuntimeException $e) {
            Log::error("Social auth provider error for {$provider}: " . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'We could not authenticate with ' . ucfirst($provider) . '. Please try again.');
        } catch (Throwable $e) {
            Log::error("Social auth API failure for {$provider}: " . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')
                ->with('error', 'Something went wrong while signing you in with ' . ucfirst($provider) . '. Please try again.');
        }

        // A provider id is required to uniquely identify the social account.
        $providerId = trim((string) ($socialUser->getId() ?? ''));

        if ($providerId === '') {
            Log::warning("Provider {$provider} did not return an id.");

            return redirect()->route('login')
                ->with('error', 'Sign-in with ' . ucfirst($provider) . ' failed. Please try again.');
        }

        // Some providers (e.g. X) may not always return an email address.
        $email = trim((string) ($socialUser->getEmail() ?? ''));

        if ($email === '') {
            return redirect()->route('login')
                ->with('error', 'We could not retrieve your email from ' . ucfirst($provider) . '. Please register using the form below.');
        }

        $user = $this->findOrCreateUser($provider, $providerId, $socialUser, $email);

        if (! $user) {
            return redirect()->route('login')
                ->with('error', 'We could not sign you in with ' . ucfirst($provider) . '. Please try again.');
        }

        // A suspended account cannot sign in (safe even for a fresh social login).
        if ($user->isSuspended()) {
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact support.');
        }

        // A social login implies ownership of the email address.
        if ($user->email_verified_at === null) {
            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user, true);
        Session::regenerate();

        return redirect()->intended(route($user->dashboardRoute()))
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Find an existing user by provider account or email, otherwise create a
     * normal "user" account. Social registration never creates admins/vendors.
     */
    private function findOrCreateUser(string $provider, string $providerId, $socialUser, string $email): ?User
    {
        // 1. Already connected to a local user via this (provider, provider_id)?
        $account = SocialAccount::with('user')
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if ($account && $account->user) {
            return $account->user;
        }

        // 2. Local user already exists with the same email → attach the social
        //    account to it instead of creating a duplicate.
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->attachSocialAccount($user, $provider, $providerId);

            return $user;
        }

        // 3. Brand-new normal customer account.
        $user = User::create([
            'name' => $this->sanitizeName($socialUser->getName() ?: $socialUser->getNickname()),
            'email' => $email,
            'email_verified_at' => now(),
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
            'password' => Hash::make(Str::random(32)),
        ]);

        $this->attachSocialAccount($user, $provider, $providerId);

        return $user;
    }

    /**
     * Create a social_accounts row, skipping it when it already exists.
     */
    private function attachSocialAccount(User $user, string $provider, string $providerId): void
    {
        $exists = SocialAccount::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->exists();

        if ($exists) {
            return;
        }

        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $providerId,
        ]);
    }

    /**
     * Truncate the name to fit the database column.
     */
    private function sanitizeName(?string $name): string
    {
        $name = trim($name ?? '');

        if ($name === '') {
            $name = 'User';
        }

        return Str::limit($name, 255, '');
    }

    /**
     * Determine whether a provider has the minimum required credentials.
     */
    private function isConfigured(string $provider): bool
    {
        $config = config("services.{$provider}");

        return is_array($config)
            && ! empty($config['client_id'])
            && ! empty($config['client_secret'])
            && ! empty($config['redirect']);
    }

    /**
     * Resolve the Socialite driver for a provider.
     */
    private function driverFor(string $provider): string
    {
        return self::DRIVER_MAP[$provider] ?? $provider;
    }
}