<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Review;
use App\Models\User;

function createPublishedProduct(): AdminProduct
{
    $category = AdminCategory::create([
        'name' => 'Test Electronics',
        'slug' => 'test-electronics-'.uniqid(),
        'status' => 'published',
    ]);

    return AdminProduct::create([
        'name' => 'Test Headphones',
        'sku' => 'TEST-'.uniqid(),
        'regular_price' => 100,
        'quantity' => 5,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'status' => 'published',
    ]);
}

test('a guest can submit a review for a published product', function () {
    $product = createPublishedProduct();

    $response = $this->post(route('review.store', $product), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'rating' => 5,
        'comment' => 'Great product, highly recommended!',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect(Review::where('product_id', $product->id)->count())->toBe(1);
    $review = Review::first();
    expect($review->status)->toBe('pending')
        ->and($review->rating)->toBe(5);
});

test('review submission requires a valid rating between 1 and 5', function () {
    $product = createPublishedProduct();

    $this->post(route('review.store', $product), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'rating' => 0,
        'comment' => 'Bad rating value',
    ])->assertSessionHasErrors('rating');

    $this->post(route('review.store', $product), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'rating' => 6,
        'comment' => 'Too high',
    ])->assertSessionHasErrors('rating');
});

test('review submission requires name and email', function () {
    $product = createPublishedProduct();

    $this->post(route('review.store', $product), [
        'rating' => 4,
        'comment' => 'Missing contact info',
    ])->assertSessionHasErrors(['name', 'email']);
});

test('an admin can reply to a review', function () {
    $product = createPublishedProduct();
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]);
    $review = Review::create([
        'product_id' => $product->id,
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'rating' => 4,
        'comment' => 'Pretty good.',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)
        ->patch(route('review.reply', $review), ['reply' => 'Thanks for your feedback!']);

    $response->assertRedirect();
    expect($review->refresh()->reply)->toBe('Thanks for your feedback!')
        ->and($review->replied_by)->toBe($admin->id);
});

test('product average rating and review count are calculated correctly', function () {
    $product = createPublishedProduct();
    Review::create(['product_id' => $product->id, 'name' => 'A', 'email' => 'a@example.com', 'rating' => 5, 'comment' => 'x', 'status' => 'approved']);
    Review::create(['product_id' => $product->id, 'name' => 'B', 'email' => 'b@example.com', 'rating' => 3, 'comment' => 'y', 'status' => 'approved']);
    Review::create(['product_id' => $product->id, 'name' => 'C', 'email' => 'c@example.com', 'rating' => 1, 'comment' => 'z', 'status' => 'rejected']);

    expect($product->reviews()->where('status', 'approved')->count())->toBe(2);
    expect($product->reviews()->where('status', 'approved')->avg('rating'))->toEqual(4.0);
});
