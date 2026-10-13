<?php

use App\Services\CaptchaService;
use Tests\TestCase;

uses(TestCase::class);


test('it generates a math puzzle and stores a hashed answer', function () {
    $service = new CaptchaService;

    $captcha = $service->generate();

    expect($captcha['question'])->toMatch('/^What is \d+ \+ \d+\?$/')
        ->and($captcha['num1'])->toBeInt()
        ->and($captcha['num2'])->toBeInt();

    $answer = $captcha['num1'] + $captcha['num2'];

    // The answer must never be stored in plain text.
    expect(session('captcha_answer'))->toBe(hash('sha256', (string) $answer))
        ->and(session('captcha_answer'))->not->toBe((string) $answer);
});

test('it accepts the correct answer and clears the puzzle', function () {
    $service = new CaptchaService;

    $captcha = $service->generate();

    expect($service->validate((string) ($captcha['num1'] + $captcha['num2'])))->toBeTrue()
        ->and(session('captcha_answer'))->toBeNull();
});

test('it rejects a wrong answer', function () {
    $service = new CaptchaService;

    $service->generate();

    expect($service->validate('999999'))->toBeFalse();
});

test('it rejects an empty answer', function () {
    $service = new CaptchaService;

    $service->generate();

    expect($service->validate(null))->toBeFalse()
        ->and($service->validate(''))->toBeFalse();
});

test('it rejects an answer when no puzzle exists', function () {
    $service = new CaptchaService;

    $service->clear();

    expect($service->validate('42'))->toBeFalse();
});

test('it expires the puzzle after five minutes', function () {
    $service = new CaptchaService;

    $captcha = $service->generate();

    $this->travel(6)->minutes();

    expect($service->validate((string) ($captcha['num1'] + $captcha['num2'])))->toBeFalse()
        ->and(session('captcha_answer'))->toBeNull();
});
