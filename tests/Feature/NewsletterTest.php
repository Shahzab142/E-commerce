<?php

use App\Models\NewsletterSubscriber;

test('a visitor can subscribe to the newsletter', function () {
    $response = $this->post(route('newsletter.subscribe'), ['email' => 'reader@example.com']);

    $response->assertRedirect();
    $response->assertSessionHas('newsletter_success');

    $subscriber = NewsletterSubscriber::where('email', 'reader@example.com')->first();
    expect($subscriber)->not->toBeNull()
        ->and($subscriber->is_active)->toBeTrue();
});

test('newsletter subscription requires a valid email', function () {
    $response = $this->post(route('newsletter.subscribe'), ['email' => 'not-an-email']);

    $response->assertSessionHasErrors(['email'], null, 'newsletter');
    expect(NewsletterSubscriber::count())->toBe(0);
});

test('resubscribing an unsubscribed email reactivates it', function () {
    NewsletterSubscriber::create([
        'email' => 'reader@example.com',
        'is_active' => false,
        'unsubscribed_at' => now(),
    ]);

    $this->post(route('newsletter.subscribe'), ['email' => 'reader@example.com']);

    $subscriber = NewsletterSubscriber::where('email', 'reader@example.com')->first();
    expect($subscriber->is_active)->toBeTrue()
        ->and($subscriber->unsubscribed_at)->toBeNull();
});
